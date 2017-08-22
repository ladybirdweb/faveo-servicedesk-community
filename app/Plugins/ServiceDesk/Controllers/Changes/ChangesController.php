<?php

namespace App\Plugins\ServiceDesk\Controllers\Changes;

use App\Plugins\ServiceDesk\Controllers\BaseServiceDeskController;
use App\Plugins\ServiceDesk\Model\Assets\SdAssets;
use App\Plugins\ServiceDesk\Model\Cab\Cab;
use App\Plugins\ServiceDesk\Model\Changes\SdChangepriorities;
use App\Plugins\ServiceDesk\Model\Changes\SdChanges;
use App\Plugins\ServiceDesk\Model\Changes\SdChangestatus;
use App\Plugins\ServiceDesk\Model\Changes\SdChangetypes;
use App\Plugins\ServiceDesk\Model\Changes\SdImpacttypes;
use App\Plugins\ServiceDesk\Model\Releases\SdLocations;
use App\Plugins\ServiceDesk\Requests\CreateChangesRequest;
use App\Plugins\ServiceDesk\Requests\CreateReleaseRequest;
use App\User;
use Exception;
use Illuminate\Http\Request;

class ChangesController extends BaseServiceDeskController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function changesindex()
    {
        try {
            return view('service::changes.index');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function getChanges()
    {
        try {
            $change = new SdChanges();
            $changes = $change->select('id', 'description', 'subject', 'status_id', 'priority_id', 'change_type_id', 'impact_id', 'location_id', 'approval_id')->get();

            return \Datatable::Collection($changes)
                            ->showColumns('subject', 'reason')
                            ->addColumn('action', function ($model) {
                                $url = url('service-desk/changes/'.$model->id.'/delete');
                                $delete = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::deletePopUp($model->id, $url, "Delete $model->subject");
                                //dd($delete);
                                return '<a href='.url('service-desk/changes/'.$model->id.'/edit')." class='btn btn-info btn-sm'>Edit</a> "
                                        .$delete
                                        .' <a href='.url('service-desk/changes/'.$model->id.'/show')." class='btn btn-primary btn-sm'>View</a>";
                            })
                            ->searchColumns('description')
                            ->orderColumns('description', 'subject', 'reason', 'status_id', 'priority_id', 'change_type_id', 'impact_id', 'location_id', 'approval_id')
                            ->make();
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function changescreate()
    {
        try {
            $statuses = SdChangestatus::lists('name', 'id')->toArray();
            $sd_changes_priorities = SdChangepriorities::lists('name', 'id')->toArray();
            $sd_changes_types = SdChangetypes::lists('name', 'id')->toArray();
            $sd_impact_types = SdImpacttypes::lists('name', 'id')->toArray();
            $sd_locations = SdLocations::lists('title', 'id')->toArray();
            $users = Cab::lists('name', 'id')->toArray();
            $assets = SdAssets::lists('name', 'id')->toArray();
            $requester = User::where('role', 'agent')->orWhere('role', 'admin')->lists('email', 'id')->toArray();

            return view('service::changes.create', compact('statuses', 'assets', 'sd_changes_priorities', 'sd_changes_types', 'sd_impact_types', 'sd_locations', 'users', 'requester'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function changeshandleCreate(CreateChangesRequest $request, $attach = false)
    {
        //  dd($request->all());
        try {
            $sd_changes = new SdChanges();
            $sd_changes->fill($request->input())->save();
            \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::attachment($sd_changes->id, 'sd_changes', $request->file('attachments'));
            \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::storeAssetRelation('sd_changes', $sd_changes->id, $request->input('asset'));
            if ($attach == false) {
                return \Redirect::route('service-desk.changes.index')->with('message', 'Changes successfull !!!');
            }

            return $sd_changes;
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function changesedit($id)
    {
        try {
            $change = SdChanges::findOrFail($id);
            $statuses = SdChangestatus::lists('name', 'id')->toArray();
            $sd_changes_status = '';
            $sd_changes_priorities = SdChangepriorities::lists('name', 'id')->toArray();
            $sd_changes_types = SdChangetypes::lists('name', 'id')->toArray();
            $sd_impact_types = SdImpacttypes::lists('name', 'id')->toArray();
            $sd_locations = SdLocations::lists('title', 'id')->toArray();
            $users = Cab::lists('name', 'id')->toArray();
            $assets = SdAssets::lists('name', 'id')->toArray();
            $requester = User::where('role', 'agent')->orWhere('role', 'admin')->lists('email', 'id')->toArray();

            return view('service::changes.edit', compact('sd_changes_status', 'assets', 'change', 'statuses', 'sd_changes_priorities', 'sd_changes_types', 'sd_impact_types', 'sd_locations', 'users', 'requester'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function changeshandleEdit($id, CreateChangesRequest $request)
    {
        try {
            $sd_changes = SdChanges::findOrFail($id);
            $sd_changes->fill($request->input())->save();
            \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::attachment($sd_changes->id, 'sd_changes', $request->file('attachments'));
            \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::storeAssetRelation('sd_changes', $sd_changes->id, $request->input('asset'));

            return \Redirect::route('service-desk.changes.index')->with('message', 'Changes successfully Edit !!!');
        } catch (Exception $ex) {
            dd($ex);

            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function changesHandledelete($id)
    {
        try {
            $sd_changes = SdChanges::findOrFail($id);
            $sd_changes->delete();

            return \Redirect::route('service-desk.changes.index')->with('message', 'Changes successfully Delete !!!');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $changes = new SdChanges();
            $change = $changes->find($id);
            if ($change) {
                return view('service::changes.show', compact('change'));
            } else {
                throw new \Exception('Sorry we can not find your request');
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function close($id)
    {
        try {
            $changes = new SdChanges();
            $change = $changes->find($id);
            if ($change) {
                $change->status_id = 6;
                $change->save();

                return redirect()->back()->with('success', 'Updated');
            } else {
                throw new \Exception('Sorry we can not find your request');
            }
        } catch (\Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function getReleases()
    {
        $release = new \App\Plugins\ServiceDesk\Model\Releases\SdReleases();
        $releases = $release->select('id', 'subject')->get();

        return \Datatable::Collection($releases)
                ->addColumn('id', function ($model) {
                    return "<input type='radio' name='release' value='".$model->id."'>";
                })
                ->addColumn('subject', function ($model) {
                    return str_limit($model->subject, 20);
                })
                ->orderColumns('subject')
                ->searchColumns('subject')
                ->make();
    }

    public function attachNewRelease($id, CreateReleaseRequest $request)
    {
        try {
            $release_controller = new \App\Plugins\ServiceDesk\Controllers\Releses\RelesesController();
            $release = $release_controller->releaseshandleCreate($request, true);
            $this->releaseAttach($id, $release->id);
            if ($release) {
                return redirect()->back()->with('success', 'Updated');
            }
        } catch (\Exception $ex) {
            dd($ex);

            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function attachExistingRelease($id, Request $request)
    {
        try {
            $releaseid = $request->input('release');
            $store = $this->releaseAttach($id, $releaseid);
            if ($store) {
                return redirect()->back()->with('success', 'Updated');
            }
        } catch (\Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function releaseAttach($changeid, $releaseid)
    {
        $relation = new \App\Plugins\ServiceDesk\Model\Changes\ChangeReleaseRelation();
        $relations = $relation->where('change_id', $changeid)->first();
        if ($relations) {
            $relations->delete();
        }

        return $relation->create([
            'release_id'=> $releaseid,
            'change_id' => $changeid,
        ]);
    }

    public function detachRelease($changeid)
    {
        try {
            $relations = new \App\Plugins\ServiceDesk\Model\Changes\ChangeReleaseRelation();
            $relation = $relations->where('change_id', $changeid)->first();
            if ($relation) {
                $relation->delete();
            }

            return redirect()->back()->with('success', 'Updated');
        } catch (\Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }
}
