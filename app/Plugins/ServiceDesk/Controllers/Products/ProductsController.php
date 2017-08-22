<?php

namespace App\Plugins\ServiceDesk\Controllers\Products;

use App\Plugins\ServiceDesk\Controllers\BaseServiceDeskController;
use App\Plugins\ServiceDesk\Model\Assets\Department;
use App\Plugins\ServiceDesk\Model\Assets\SdAssettypes;
use App\Plugins\ServiceDesk\Model\Products\SdProductprocmode;
use App\Plugins\ServiceDesk\Model\Products\SdProducts;
use App\Plugins\ServiceDesk\Model\Products\SdProductstatus;
use App\Plugins\ServiceDesk\Requests\CreateProductsRequest;
use App\Plugins\ServiceDesk\Requests\CreateVendorRequest;
use Exception;
use Illuminate\Http\Request;

class ProductsController extends BaseServiceDeskController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function productsindex()
    {
        try {
            return view('service::products.index', compact('sd_products'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function getProducts()
    {
        try {
            $product = new SdProducts();
            $products = $product->select('id', 'name', 'description', 'manufacturer', 'product_status_id', 'product_mode_procurement_id', 'all_department', 'status')->get();

            return \Datatable::Collection($products)
                            ->showColumns('name', 'manufacturer')
                            ->addColumn('product_status_id', function ($model) {
                                $product_status = new SdProductstatus();
                                $product_status_name = $product_status->where('id', $model->product_status_id)->first()->name;

                                return $product_status_name;
                            })
                            ->addColumn('status', function ($model) {
                                $status = 'Disable';
                                if ($model->status == 1) {
                                    $status = 'Enable';
                                }

                                return $status;
                            })
                            ->addColumn('action', function ($model) {
                                return '<a href='.url('service-desk/products/'.$model->id.'/edit')." class='btn btn-info btn-sm'>Edit</a> <a href=".url('service-desk/products/'.$model->id.'/show')." class='btn btn-primary btn-sm'>View</a>";
                            })
                            ->searchColumns('name', 'manufacturer')
                            ->orderColumns('name', 'manufacturer', 'asset_type_id', 'product_status_id', 'product_mode_procurement_id', 'all_department', 'status')
                            ->make();
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function productscreate()
    {
        try {
            $sd_asset_types = SdAssettypes::lists('name', 'id')->toArray();
            $sd_product_status = SdProductstatus::lists('name', 'id')->toArray();
            $sd_product_proc_modes = SdProductprocmode::lists('name', 'id')->toArray();
            $departments = Department::lists('name', 'id')->toArray();

            return view('service::products.create', compact('sd_asset_types', 'sd_product_status', 'sd_product_proc_modes', 'departments'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function productshandleCreate(CreateProductsRequest $request)
    {
        try {
            $sd_products = new SdProducts();
            $sd_products->name = $request->name;
            $sd_products->description = $request->description;
            $sd_products->manufacturer = $request->manufacturer;
            //$sd_products->asset_type_id = $request->asset_type;
            $sd_products->product_status_id = $request->Product_status;
            $sd_products->product_mode_procurement_id = $request->mode_procurement;
            $sd_products->all_department = $request->department_access;
            $sd_products->status = $request->status;
            $sd_products->save();

            return \Redirect::route('service-desk.products.index')->with('message', 'Product Add Successfull !!!');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function productsedit($id)
    {
        try {
            $product = SdProducts::findOrFail($id);
            $sd_asset_types = SdAssettypes::lists('name', 'id')->toArray();
            $sd_product_status = SdProductstatus::lists('name', 'id')->toArray();
            $sd_product_proc_modes = SdProductprocmode::lists('name', 'id')->toArray();
            $departments = Department::lists('name', 'id')->toArray();

            return view('service::products.edit', compact('product', 'asset_types_name', 'product_status_name', 'mode_procurement_name', 'sd_asset_types', 'sd_product_status', 'sd_product_proc_modes', 'departments'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function productshandleEdit($id, CreateProductsRequest $request)
    {
        try {
            $sd_products = SdProducts::findOrFail($id);
            $sd_products->name = $request->name;
            $sd_products->description = $request->description;
            $sd_products->manufacturer = $request->manufacturer;
            //$sd_products->asset_type_id = $request->asset_type;
            $sd_products->product_status_id = $request->Product_status;
            $sd_products->product_mode_procurement_id = $request->mode_procurement;
            $sd_products->all_department = $request->department_access;
            $sd_products->status = $request->status;
            $sd_products->save();

            return \Redirect::route('service-desk.products.index')->with('message', 'Products Successfully Edit !!!');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function productsHandledelete($id)
    {
        try {
            $sd_products = SdProducts::findOrFail($id);
            $sd_products->delete();

            return \Redirect::route('service-desk.products.index')->with('message', 'products Successfully Delete !!!');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $products = new SdProducts();
            $product = $products->find($id);
            if ($product) {
                return view('service::products.show', compact('product'));
            } else {
                throw new \Exception('Sorry we can not find your request');
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function addVendor(CreateVendorRequest $request)
    {
        try {
            $return = true;
            $vendor_controller = new \App\Plugins\ServiceDesk\Controllers\Vendor\VendorController();
            $vendor = $vendor_controller->handleCreate($request, $return);
            $product_id = $request->input('product');
            if ($vendor) {
                $relation = $this->createVendorRelation($product_id, $vendor->id);
                if ($relation) {
                    return redirect()->back()->with('success', 'Added');
                }
            }

            return redirect()->back()->with('fails', 'Can not process your request');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function addExistingVendor(Request $request)
    {
        $this->validate($request, [
            'vendor' => 'Required',
        ]);

        try {
            $product_id = $request->input('product');
            $vendor_id = $request->input('vendor');
            $relation = $this->createVendorRelation($product_id, $vendor_id);
            if ($relation) {
                return redirect()->back()->with('success', 'Added');
            }

            throw new Exception('Sorry we can not find your request');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function createVendorRelation($product_id, $vendor_id)
    {
        $vendor_relation = new \App\Plugins\ServiceDesk\Model\Common\ProductVendorRelation();

        return $vendor_relation->create([
                    'product_id' => $product_id,
                    'vendor_id'  => $vendor_id,
        ]);
    }

    public function removeVendor($productid, $vendorid)
    {
        try {
            $vendor_relation = new \App\Plugins\ServiceDesk\Model\Common\ProductVendorRelation();
            $relation = $vendor_relation
                    ->where('product_id', $productid)
                    ->where('vendor_id', $vendorid)
                    ->first();
            if ($relation) {
                $relation->delete();

                return redirect()->back()->with('success', 'Deleted');
            }

            throw new Exception('Sorry we can not find your request');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }
}
