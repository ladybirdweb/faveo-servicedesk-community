<?php

namespace App\Plugins\ServiceDesk\Controllers\Problem;

use App\Model\helpdesk\Agent\Department;
use App\Model\helpdesk\Agent\Groups as Group;
use App\Model\helpdesk\Ticket\Ticket_Priority as Priority;
use App\Model\helpdesk\Ticket\Ticket_Status as TicketType;
use App\Plugins\ServiceDesk\Controllers\BaseServiceDeskController;
use App\Plugins\ServiceDesk\Model\Assets\SdAssets;
use App\Plugins\ServiceDesk\Model\Problem\Impact;
use App\Plugins\ServiceDesk\Model\Problem\Location;
use App\Plugins\ServiceDesk\Model\Problem\SdProblem;
use App\Plugins\ServiceDesk\Requests\CreateChangesRequest;
use App\Plugins\ServiceDesk\Requests\CreateProblemRequest;
use App\User;
use Illuminate\Http\Request;

class ProblemController extends BaseServiceDeskController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            return view('service::problem.index');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function getProblems()
    {
        try {
            $problem = new SdProblem();
            $problems = $problem->select('id', 'department', 'status_type_id', 'from', 'subject')->get();

            return \Datatable::Collection($problems)
                            ->showColumns('from')
                            ->addColumn('subject', function ($model) {
                                return str_limit($model->subject, 10);
                            })
                            ->addColumn('department', function ($model) {
                                $depertment_type_name = 'Common';
                                $depertment_types = new Department();
                                $depertment_type = $depertment_types->where('id', $model->department)->first();
                                if ($depertment_type) {
                                    $depertment_type_name = $depertment_type->name;
                                }

                                return $depertment_type_name;
                            })
                            ->addColumn('ticket_type', function ($model) {
                                $ticket_status_name = '';
                                $ticket_statuses = new TicketType();
                                $ticket_status = $ticket_statuses->where('id', $model->status_type_id)->first();
                                if ($ticket_status) {
                                    $ticket_status_name = $ticket_status->name;
                                }

                                return $ticket_status_name;
                            })
                            ->addColumn('Action', function ($model) {
                                $url = url('service-desk/problem/'.$model->id.'/delete');
                                $delete = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::deletePopUp($model->id, $url, "Delete $model->subject");

                                return '<a href='.url('service-desk/problem/'.$model->id.'/edit')." class='btn btn-info btn-sm'>Edit</a> "
                                        .$delete
                                        .' <a href='.url('service-desk/problem/'.$model->id.'/show')." class='btn btn-primary btn-sm'>View</a>";
                            })
                            ->searchColumns('description')
                            ->orderColumns('department', 'ticket_type', 'priority_id', 'location_type_id', 'agent_id')
                            ->make();
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function create()
    {
        try {
            $assigned_ids = User::where('role', '!=', 'user')->lists('email', 'id')->toArray();
            $group_ids = Group::lists('name', 'id')->toArray();
            $impact_ids = Impact::lists('name', 'id')->toArray();
            $location_type_ids = Location::lists('title', 'id')->toArray();
            $priority_ids = Priority::lists('priority', 'priority_id')->toArray();
            $status_type_ids = TicketType::lists('name', 'id')->toArray();
            $departments = Department::lists('name', 'id')->toArray();
            $assets = SdAssets::lists('name', 'id')->toArray();
            $from = User::lists('email', 'email')->toArray();

            return view('service::problem.create', compact('assets', 'departments', 'assigned_ids', 'group_ids', 'impact_ids', 'location_type_ids', 'priority_ids', 'status_type_ids', 'from'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function handleCreate(CreateProblemRequest $request)
    {
        // dd($request);

        try {
            $this->store($request);

            return \Redirect::route('service-desk.problem.index')->with('success', 'Problem Created Successfully');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function edit($id)
    {
        // dd($id);
        try {
            $problem = SdProblem::findOrFail($id);
            $assigned_ids = User::where('role', '!=', 'user')->lists('email', 'id')->toArray();
            $group_ids = Group::lists('name', 'id')->toArray();
            $impact_ids = Impact::lists('name', 'id')->toArray();
            $location_type_ids = Location::lists('title', 'id')->toArray();
            $priority_ids = Priority::lists('priority', 'priority_id')->toArray();
            $status_type_ids = TicketType::lists('name', 'id')->toArray();
            $departments = Department::lists('name', 'id')->toArray();
            $assets = SdAssets::lists('name', 'id')->toArray();
            $from = User::lists('email', 'email')->toArray();

            return view('service::problem.edit', compact('assets', 'problem', 'assigned_ids', 'group_ids', 'impact_ids', 'location_type_ids', 'priority_ids', 'status_type_ids', 'departments', 'from'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function handleEdit($id, CreateProblemRequest $request)
    {
        try {
            $this->update($id, $request);

            return \Redirect::route('service-desk.problem.index')->with('success', 'Problem Updated Successfully');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $sdproblems = SdProblem::findOrFail($id);
            $sdproblems->delete();

            return \Redirect::route('service-desk.problem.index')->with('success', 'Problem Deleted Successfully');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function attachNewProblemToTicket(Request $request)
    {
        try {
            $ticketid = $request->input('ticketid');
            $store = $this->store($request, $ticketid);
            if ($store) {
                \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::saveTicketRelation($ticketid, 'sd_problem', $store->id);
                if (is_array($store->assets())) {
                    $assetid = $store->assets();

                    \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::saveTicketRelation($ticketid, 'sd_assets', $assetid);
                }

                return redirect()->back()->with('success', 'Created new Problem and attached to this ticket');
            }

            return redirect()->back()->with('fails', 'Sorry! We can not processs your request');
        } catch (\Exception $ex) {
            dd($ex);

            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function attachExistingProblemToTicket(Request $request)
    {
        try {
            $ticketid = $request->input('ticketid');
            $problemid = $request->input('problemid');
            \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::saveTicketRelation($ticketid, 'sd_problem', $problemid);

            return redirect()->back()->with('success', 'Problem attached to this ticket');
        } catch (Exception $ex) {
            dd($ex);
        }
    }

    public function store($request)
    {
        try {
            $sd_problems = new SdProblem();
            $assetid = $request->input('asset');
            $attachments = $request->file('attachment');
            $sd_problems->fill($request->input())->save();
            \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::attachment($sd_problems->id, 'sd_problem', $attachments);
            \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::storeAssetRelation('sd_problem', $sd_problems->id, $assetid);

            return $sd_problems;
        } catch (Exception $ex) {
            dd($ex);

            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function update($id, $request)
    {
        try {
            $sd_problems = new SdProblem();
            $sd_problem = $sd_problems->find($id);
            $assetid = $request->input('asset');
            $attachments = $request->file('attachment');
            $sd_problem->fill($request->input())->save();
            \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::attachment($sd_problem->id, 'sd_problem', $attachments);
            \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::storeAssetRelation('sd_problem', $sd_problems->id, $assetid);

            return 'success';
        } catch (Exception $ex) {
            dd($ex);

            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function getAttachableProblem()
    {
        $model = new SdProblem();
        $select = ['id', 'subject'];
        $problems = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::getModelWithSelect($model, $select);

        return \Datatable::Collection($problems->get())
                        ->addColumn('id', function ($model) {
                            return \Form::radio('problemid', $model->id);
                        })
                        ->addColumn('subject', function ($model) {
                            $subject = str_limit($model->subject, 20, '...');

                            return "<p title=$model->subject>$subject<p>";
                        })
                        ->addColumn('status', function ($model) {
                            $status = '';
                            $statusid = $model->status_type_id;
                            $ticket_statuses = new \App\Model\helpdesk\Ticket\Ticket_Status();
                            $ticket_status = $ticket_statuses->find($statusid);
                            if ($ticket_status) {
                                $status = $ticket_status->name;
                            }

                            return $status;
                        })
                        ->searchColumns('subject')
                        ->orderColumns('subject')
                        ->make();
    }

    public function timelineMarble($problem, $ticketid)
    {
        if ($problem) {
            echo $this->marble($problem, $ticketid);
        }
        echo '';
    }

    public function marble($problem, $ticketid)
    {
        $subject = $problem->subject;
        $content = $problem->description;
        $problemid = $problem->id;

        return $this->marbleHtml($ticketid, $problemid, $subject, $content);
    }

    public function marbleHtml($ticketid, $problemid, $subject, $content)
    {
        $subject_trim = str_limit($subject, 20);
        $content_trim = str_limit($content, 20);
        $url = url('service-desk/problem/detach/'.$ticketid);
        $detach_popup = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::deletePopUp($ticketid, $url, 'Delete', ' ', 'Delete', true);

        return "<div class='box box-primary'>"
                ."<div class='box-header'>"
                ."<h3 class='box-title'>Associated Problems</h3>"
                .'</div>'
                ."<div class='box-body row'>"
                ."<div class='col-md-12'>"
                ."<table class='table'>"
                .'<tr>'
                .'<th>'.ucfirst($subject_trim).'</th>'
                .'<th>'.ucfirst($content_trim).'</th>'
                .'<th>'.$detach_popup
                .'  | <a href='.url('service-desk/problem/'.$problemid.'/show').'>View</a></th>'
                .'</table>'
                .'</div>'
                .'</div>'
                .'</div>';
    }

    public function detach($ticketid)
    {
        $relation = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::getRelationOfTicketByTable($ticketid, 'sd_problem');
        if ($relation) {
            $relation->delete();
        }

        return redirect()->back()->with('success', 'Detached successfully');
    }

    public function show($id)
    {
        try {
            $problems = new SdProblem();
            $problem = $problems->find($id);
            if ($problem) {
                return view('service::problem.show', compact('problem'));
            } else {
                throw new \Exception('Sorry we can not find your request');
            }
        } catch (\Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function close($id)
    {
        try {
            $problems = new SdProblem();
            $problem = $problems->find($id);
            if ($problem) {
                $problem->status_type_id = 3;
                $problem->save();

                return redirect()->back()->with('success', 'Updated');
            } else {
                throw new \Exception('Sorry we can not find your request');
            }
        } catch (\Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function getChanges()
    {
        $change = new \App\Plugins\ServiceDesk\Model\Changes\SdChanges();
        $changes = $change->select('id', 'subject')->get();

        return \Datatable::Collection($changes)
                        ->addColumn('id', function ($model) {
                            return "<input type='radio' name='change' value='".$model->id."'>";
                        })
                        ->addColumn('subject', function ($model) {
                            return str_limit($model->subject, 20);
                        })
                        ->orderColumns('subject')
                        ->searchColumns('subject')
                        ->make();
    }

    public function attachNewChange($id, CreateChangesRequest $request)
    {
        try {
            $change_controller = new \App\Plugins\ServiceDesk\Controllers\Changes\ChangesController();
            $change = $change_controller->changeshandleCreate($request, true);

            $this->changeAttach($id, $change->id);
            if ($change) {
                return redirect()->back()->with('success', 'Updated');
            }
        } catch (\Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function attachExistingChange($id, Request $request)
    {
        try {
            $changeid = $request->input('change');
            $store = $this->changeAttach($id, $changeid);
            if ($store) {
                return redirect()->back()->with('success', 'Updated');
            }
        } catch (\Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function changeAttach($problemid, $changeid)
    {
        $relation = new \App\Plugins\ServiceDesk\Model\Problem\ProblemChangeRelation();

        return $relation->create([
                    'problem_id' => $problemid,
                    'change_id'  => $changeid,
        ]);
    }

    public function detachChange($problemid)
    {
        try {
            $relations = new \App\Plugins\ServiceDesk\Model\Problem\ProblemChangeRelation();
            $relation = $relations->where('problem_id', $problemid)->first();
            if ($relation) {
                $relation->delete();
            }

            return redirect()->back()->with('success', 'Updated');
        } catch (\Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }
}
