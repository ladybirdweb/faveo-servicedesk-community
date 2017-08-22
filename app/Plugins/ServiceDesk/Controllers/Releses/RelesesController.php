<?php

namespace App\Plugins\ServiceDesk\Controllers\Releses;

use App\Plugins\ServiceDesk\Controllers\BaseServiceDeskController;
use App\Plugins\ServiceDesk\Model\Assets\SdAssets;
use App\Plugins\ServiceDesk\Model\Releases\SdLocations;
use App\Plugins\ServiceDesk\Model\Releases\SdReleasepriorities;
use App\Plugins\ServiceDesk\Model\Releases\SdReleases;
use App\Plugins\ServiceDesk\Model\Releases\SdReleasestatus;
use App\Plugins\ServiceDesk\Model\Releases\SdReleasetypes;
use App\Plugins\ServiceDesk\Requests\CreateReleaseRequest;
use Exception;

class RelesesController extends BaseServiceDeskController
{
    public function releasesindex()
    {
        try {
            return view('service::releases.index');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function getReleases()
    {
        try {
            $releses = new SdReleases();
            $relese = $releses->select('id', 'description', 'subject', 'planned_start_date', 'planned_end_date', 'status_id', 'priority_id', 'release_type_id', 'location_id')->get();

            return \Datatable::Collection($relese)
                            ->showColumns('subject', 'planned_start_date', 'planned_end_date')
                            ->addColumn('Action', function ($model) {
                                $url = url('service-desk/releases/'.$model->id.'/delete');
                                $delete = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::deletePopUp($model->id, $url, "Delete $model->subject");

                                return '<a href='.url('service-desk/releases/'.$model->id.'/edit')." class='btn btn-info btn-sm'>Edit</a> "
                                        .$delete
                                        .' <a href='.url('service-desk/releases/'.$model->id.'/show')." class='btn btn-primary btn-sm'>View</a>";
                            })
                            ->searchColumns('subject', 'description')
                            ->orderColumns('subject', 'reason', 'impact', 'rollout_plan', 'backout_plan', 'status_id', 'priority_id', 'change_type_id', 'impact_id', 'location_id', 'approval_id')
                            ->make();
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function view($id)
    {
        try {
            $releases = new SdReleases();
            $release = $releases->find($id);
            //dd($release);
            if ($release) {
                return view('service::releases.show', compact('release'));
            } else {
                throw new \Exception('Sorry we can not find your request');
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function releasescreate()
    {
        try {
            $sd_release_status = SdReleasestatus::lists('name', 'id')->toArray();
            $sd_release_priorities = SdReleasepriorities::lists('name', 'id')->toArray();
            $sd_release_types = SdReleasetypes::lists('name', 'id')->toArray();
            $sd_locations = SdLocations::lists('title', 'id')->toArray();
            $assets = SdAssets::lists('name', 'id')->toArray();

            return view('service::releases.create', compact('assets', 'sd_release_status', 'sd_release_priorities', 'sd_release_types', 'sd_locations'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function releaseshandleCreate(CreateReleaseRequest $request, $return = false)
    {
        //dd($return);
        try {
            // dd($request);
            $sd_releases = new SdReleases();
            $sd_releases->description = $request->description;
            $sd_releases->subject = $request->subject;
            $sd_releases->planned_start_date = $request->plan_start_date;
            $sd_releases->planned_end_date = $request->plan_end_date;
            $sd_releases->status_id = $request->status;
            $sd_releases->priority_id = $request->priority;
            $sd_releases->release_type_id = $request->releasetype;
            $sd_releases->location_id = $request->location;

            $sd_releases->save();
            \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::attachment($sd_releases->id, 'sd_releases', $request->file('attachments'));
            \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::storeAssetRelation('sd_releases', $sd_releases->id, $request->input('asset'));

            if ($return === false) {
                return \Redirect::route('service-desk.releases.index')->with('message', 'Release successfully create !!!');
            }

            return $sd_releases;
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function releasesedit($id)
    {
        try {
            $release = SdReleases::findOrFail($id);
            $sd_release_status = SdReleasestatus::lists('name', 'id')->toArray();
            $sd_release_priorities = SdReleasepriorities::lists('name', 'id')->toArray();
            $sd_release_types = SdReleasetypes::lists('name', 'id')->toArray();
            $sd_locations = SdLocations::lists('title', 'id')->toArray();
            $assets = SdAssets::lists('name', 'id')->toArray();

            return view('service::releases.edit', compact('assets', 'sd_release_status', 'sd_release_priorities', 'sd_release_types', 'sd_locations', 'locations_address', 'release'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function releaseshandleEdit($id, CreateReleaseRequest $request)
    {
        try {
            $sd_releases = SdReleases::findOrFail($id);
            $sd_releases->fill($request->input())->save();
            \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::attachment($sd_releases->id, 'sd_releases', $request->file('attachments'));
            \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::storeAssetRelation('sd_releases', $sd_releases->id, $request->input('asset'));

            return \Redirect::route('service-desk.releases.index')->with('message', 'Release successfully Edit !!!');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function releasesHandledelete($id)
    {
        try {
            $sd_releases = SdReleases::findOrFail($id);
            $sd_releases->delete();

            return \Redirect::route('service-desk.releases.index')->with('message', 'Release successfully Delete !!!');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function sendCab($id, $cabid)
    {
        $activity = 'sd_releases';
        $owner = "$activity:$id";
        $url = url("service-desk/cabs/vote/$cabid/$owner");
        \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::cabMessage($cabid, $activity, $url);
    }

    public function complete($id)
    {
        try {
            $releases = new SdReleases();
            $release = $releases->find($id);
            if ($release) {
                $release->status_id = 5;
                $release->save();
            } else {
                throw new Exception('Sorry we can not find your request');
            }

            return redirect()->back()->with('success', 'updated');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }
}
