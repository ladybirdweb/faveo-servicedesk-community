<?php

namespace App\Plugins\ServiceDesk\Controllers\Cab;

use App\Plugins\ServiceDesk\Controllers\BaseServiceDeskController;
use App\Plugins\ServiceDesk\Model\Cab\Cab;
use App\Plugins\ServiceDesk\Model\Cab\CabVote;
use App\User;
use Datatable;
use Exception;
use Illuminate\Http\Request;

class CabController extends BaseServiceDeskController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            return view('service::cab.index');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function getCab()
    {
        $cabs = new Cab();

        return Datatable::Collection($cabs->select('name', 'head', 'id')->get())
                        ->showColumns('name')
                        ->addColumn('head', function ($model) {
                            $users = new User();
                            $head = '--';
                            $user = $users->find($model->head);
                            if ($user) {
                                $head = $user->email;
                            }

                            return $head;
                        })
                        ->addColumn('action', function ($model) {
                            return '<a href='.url('service-desk/cabs/'.$model->id.'/edit')." class='btn btn-info'>Edit</a>";
                        })
                        ->orderColumns('name', 'head')
                        ->searchColumns('name', 'head')
                        ->make();
    }

    public function edit($id)
    {
        try {
            $cabs = new Cab();
            $agents = User::where('role', 'agent')->orWhere('role', 'admin')->lists('email', 'id')->toArray();
            $cab = $cabs->find($id);

            return view('service::cab.edit', compact('cab', 'agents'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function create()
    {
        try {
            $agents = User::where('role', 'agent')->orWhere('role', 'admin')->lists('email', 'id')->toArray();

            return view('service::cab.create', compact('agents'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        try {
            $cabs = new Cab();
            $cabs->fill($request->input())->save();

            return redirect()->back()->with('success', 'Saved Successfully');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        try {
            $cabs = new Cab();
            $cab = $cabs->find($id);
            $cab->fill($request->input())->save();

            return redirect()->back()->with('success', 'Saved Successfully');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function vote($cabid, $owner)
    {
        try {
            $check = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::checkCabUser($cabid);
            if (!$check) {
                return redirect('/service-desk/problems')->with('fails', 'Unautherized');
            }
            $authid = \Auth::user()->id;
            $votes = new CabVote();
            $vote = $votes->where('cab_id', $cabid)->where('user_id', $authid)->where('owner', $owner)->first();
            if ($vote) {
                return redirect('/service-desk/problems')->with('fails', 'Already voted');
            }

            return view('service::cab.vote', compact('cabid', 'owner'));
        } catch (Exception $ex) {
            dd($ex);

            return redirect('/service-desk/problems')->with('fails', $ex->getMessage());
        }
    }

    public function postVote($cabid, $owner, Request $request)
    {
        try {
            $check = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::checkCabUser($cabid);
            if (!$check) {
                return redirect('/service-desk/problems')->with('fails', 'Unautherized');
            }
            $authid = \Auth::user()->id;
            $votes = new CabVote();
            $vote = $votes->where('cab_id', $cabid)->where('user_id', $authid)->where('owner', $owner)->first();
            if ($vote) {
                return redirect('/service-desk/problems')->with('fails', 'Already voted');
            }
            $votes->create([
                'cab_id'  => $cabid,
                'user_id' => $authid,
                'comment' => $request->input('comment'),
                'vote'    => $request->input('vote'),
                'owner'   => $owner,
            ]);

            return redirect('/service-desk/problems')->with('success', 'Voted successfully');
        } catch (Exception $ex) {
            return redirect('/service-desk/problems')->with('fails', $ex->getMessage());
        }
    }

    public function showVotes($id, $owner)
    {
        try {
            $vote = new CabVote();
            $votes = $vote->where('cab_id', $id)->where('owner', $owner)->get();

            return view('service::cab.show-vote', compact('votes'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public static function votedUser($userid)
    {
        $users = new \App\User();
        $user = $users->find($userid);
        $name = '';
        if ($user) {
            $name = $user->first_name.' '.$user->last_name;
            if ($name == ' ') {
                $name = $user->user_name;
            }
        }

        return ucfirst($name);
    }

    public static function checkVote($vote)
    {
        $value = '';
        if ($vote == 1) {
            $value = 'Voted for proceed';
        } else {
            $value = 'Voted for not proceed';
        }

        return $value;
    }
}
