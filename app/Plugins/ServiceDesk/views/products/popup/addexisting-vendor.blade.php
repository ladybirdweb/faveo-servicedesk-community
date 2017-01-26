<div class="modal fade" id="existing{{$product->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Vendor</h4>
                {!! Form::open(['url'=>'service-desk/products/add-existing/vendor','method'=>'post']) !!}
                {!! Form::hidden('product',$product->id) !!}
            </div>
            <div class="modal-body">
                <?php 
                    $vendor = new App\Plugins\ServiceDesk\Model\Vendor\SdVendors();
                    $this_vendors  = $product->vendorRelation()->lists('vendor_id')->toArray();;
                    $vendors = $vendor->whereNotIn('id',$this_vendors)->lists('name','id')->toArray();
                ?>
                {!! Form::select('vendor',$vendors,null,['class'=>'form-control']) !!}
            </div>
            <div class="modal-footer">
                <button type="button" id="close" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="{{Lang::get('lang.save')}}">
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>