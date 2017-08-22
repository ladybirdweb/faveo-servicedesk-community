<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Agent\helpdesk\TicketController as CoreTicketController;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Request as Value;
use App\Http\Requests\helpdesk\TicketRequest;
use App\Model\helpdesk\Agent\Department;
use App\Model\helpdesk\Agent\Teams;
use App\Model\helpdesk\Manage\Help_topic;
use App\Model\helpdesk\Manage\Sla_plan;
use App\Model\helpdesk\Settings\System;
use App\Model\helpdesk\Ticket\Ticket_attachments;
use App\Model\helpdesk\Ticket\Ticket_source;
use App\Model\helpdesk\Ticket\Ticket_Thread;
use App\Model\helpdesk\Ticket\Tickets;
use App\Model\helpdesk\Utility\Priority;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * -----------------------------------------------------------------------------
 * Api Controller
 * -----------------------------------------------------------------------------.
 *
 *
 * @author Vijay Sebastian <vijay.sebastian@ladybirdweb.com>
 * @copyright (c) 2016, Ladybird Web Solution
 * @name Faveo HELPDESK
 *
 * @version v1
 */
class ApiController extends Controller
{
    public $user;
    public $request;
    public $ticket;
    public $model;
    public $thread;
    public $attach;
    public $ticketRequest;
    public $faveoUser;
    public $team;
    public $setting;
    public $helptopic;
    public $slaPlan;
    public $department;
    public $priority;
    public $source;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->middleware('jwt.auth');
        $this->middleware('api', ['except' => 'GenerateApiKey']);

        try {
            $user = \JWTAuth::parseToken()->authenticate();
            $this->user = $user;
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
        }

        $ticket = new TicketController();
        $this->ticket = $ticket;

        $model = new Tickets();
        $this->model = $model;

        $thread = new Ticket_Thread();
        $this->thread = $thread;

        $attach = new Ticket_attachments();
        $this->attach = $attach;

        $ticketRequest = new TicketRequest();
        $this->ticketRequest = $ticketRequest;

        $faveoUser = new User();
        $this->faveoUser = $faveoUser;

        $faveoUser = new User();
        $this->user = $faveoUser;

        $team = new Teams();
        $this->team = $team;

        $setting = new System();
        $this->setting = $setting;

        $helptopic = new Help_topic();
        $this->helptopic = $helptopic;

        $slaPlan = new Sla_plan();
        $this->slaPlan = $slaPlan;

        $priority = new Priority();
        $this->priority = $priority;

        $department = new Department();
        $this->department = $department;

        $source = new Ticket_source();
        $this->source = $source;
    }

    /**
     * Create Tickets.
     *
     * @method POST
     *
     * @param user_id,subject,body,helptopic,sla,priority,dept
     *
     * @return json
     */
    public function createTicket(\App\Http\Requests\helpdesk\CreateTicketRequest $request, \App\Model\helpdesk\Utility\CountryCode $code)
    {
        try {
            $user_id = $this->request->input('user_id');

            $subject = $this->request->input('subject');
            $body = $this->request->input('body');
            $helptopic = $this->request->input('helptopic');
            $sla = $this->request->input('sla');
            $priority = $this->request->input('priority');
            $header = $this->request->input('cc');
            $dept = $this->request->input('dept');

            $assignto = $this->request->input('assignto');
            $form_data = $this->request->input('form_data');
            $source = $this->request->input('source');
            $attach = $this->request->input('attachments');
            $headers = [];
            if ($header) {
                $headers = explode(',', $header);
            }
            //return $headers;
            /*
             * return s ticket number
             */
            $PhpMailController = new \App\Http\Controllers\Common\PhpMailController();
            $NotificationController = new \App\Http\Controllers\Common\NotificationController();
            $core = new CoreTicketController($PhpMailController, $NotificationController);
            $response = $core->post_newticket($request, $code, true);
            //$response = $this->ticket->createTicket($user_id, $subject, $body, $helptopic, $sla, $priority, $source, $headers, $dept, $assignto, $form_data, $attach);
            //return $response;
            /*
             * return ticket details
             */
            //dd($response);
            //$result = $this->thread->where('id', $response)->first();
            //$result = $this->attach($result->id,$file);
            return response()->json(compact('response'));
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'))
                            ->header('Authenticate: xBasic realm', 'fake');
        }
    }

    /**
     * Reply for the ticket.
     *
     * @param TicketRequest $request
     *
     * @return json
     */
    public function ticketReply()
    {
        //dd($this->request->all());
        try {
            $v = \Validator::make($this->request->all(), [
                        'ticket_ID'     => 'required|exists:tickets,id',
                        'reply_content' => 'required',
            ]);
            if ($v->fails()) {
                $error = $v->errors();

                return response()->json(compact('error'));
            }
            $attach = $this->request->input('attachments');
            $result = $this->ticket->reply($this->thread, $this->request, $this->attach, $attach);
            $result = $result->join('users', 'ticket_thread.user_id', '=', 'users.id')
                    ->select('ticket_thread.*', 'users.first_name as first_name')
                    ->first();

            return response()->json(compact('result'));
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    /**
     * Edit a ticket.
     *
     * @return json
     */
    public function editTicket()
    {
        try {
            $v = \Validator::make($this->request->all(), [
                        'ticket_id'       => 'required|exists:tickets,id',
                        'subject'         => 'required',
                        'sla_plan'        => 'required|exists:sla_plan,id',
                        'help_topic'      => 'required|exists:help_topic,id',
                        'ticket_source'   => 'required|exists:ticket_source,id',
                        'ticket_priority' => 'required|exists:ticket_priority,priority_id',
            ]);
            if ($v->fails()) {
                $error = $v->errors();

                return response()->json(compact('error'));
            }
            $ticket_id = $this->request->input('ticket_id');
            $result = $this->ticket->ticketEditPost($ticket_id, $this->thread, $this->model);

            return response()->json(compact('result'));
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    /**
     * Delete The Ticket.
     *
     * @return json
     */
    public function deleteTicket()
    {
        try {
            $v = \Validator::make($this->request->all(), [
                        'ticket_id' => 'required|exists:tickets,id',
            ]);
            if ($v->fails()) {
                $error = $v->errors();

                return response()->json(compact('error'));
            }
            $id = $this->request->input('ticket_id');

            $result = $this->ticket->delete($id, $this->model);

            return response()->json(compact('result'));
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    /**
     * Get all opened tickets.
     *
     * @return json
     */
    public function openedTickets()
    {
        try {
            //            $result = $this->model->where('status', '=', 1)->where('isanswered', '=', 0)->where('assigned_to', '=', null)->orderBy('id', 'DESC')->get();
            //            return response()->json(compact('result'));

            $result = $this->user->join('tickets', function ($join) {
                $join->on('users.id', '=', 'tickets.user_id')
                        ->where('isanswered', '=', 0)->where('status', '=', 1)->whereNull('assigned_to');
            })
                    ->join('department', 'department.id', '=', 'tickets.dept_id')
                    ->join('ticket_priority', 'ticket_priority.priority_id', '=', 'tickets.priority_id')
                    ->join('sla_plan', 'sla_plan.id', '=', 'tickets.sla')
                    ->join('help_topic', 'help_topic.id', '=', 'tickets.help_topic_id')
                    ->join('ticket_status', 'ticket_status.id', '=', 'tickets.status')
                    ->join('ticket_thread', function ($join) {
                        $join->on('tickets.id', '=', 'ticket_thread.ticket_id')
                        ->whereNotNull('title');
                    })
                    ->select('first_name', 'last_name', 'email', 'profile_pic', 'ticket_number', 'tickets.id', 'title', 'tickets.created_at', 'department.name as department_name', 'ticket_priority.priority as priotity_name', 'sla_plan.name as sla_plan_name', 'help_topic.topic as help_topic_name', 'ticket_status.name as ticket_status_name')
                    ->orderBy('ticket_thread.updated_at', 'desc')
                    ->groupby('tickets.id')
                    ->distinct()
                    ->paginate(10)
                    ->toJson();

            return $result;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    /**
     * Get Unsigned Tickets.
     *
     * @return json
     */
    public function unassignedTickets()
    {
        try {
            //dd('sdhjbc');
            //            $result = $this->model->where('assigned_to', '=', null)->where('status', '1')->orderBy('id', 'DESC')->get();
            //            return response()->json(compact('result'));
            $user = \JWTAuth::parseToken()->authenticate();
            $unassigned = $this->user->join('tickets', function ($join) {
                $join->on('users.id', '=', 'tickets.user_id')
                        ->whereNull('assigned_to')->where('status', '=', 1);
            })
                    ->join('department', 'department.id', '=', 'tickets.dept_id')
                    ->join('ticket_priority', 'ticket_priority.priority_id', '=', 'tickets.priority_id')
                    ->join('sla_plan', 'sla_plan.id', '=', 'tickets.sla')
                    ->join('help_topic', 'help_topic.id', '=', 'tickets.help_topic_id')
                    ->join('ticket_status', 'ticket_status.id', '=', 'tickets.status')
                    ->join('ticket_thread', function ($join) {
                        $join->on('tickets.id', '=', 'ticket_thread.ticket_id')
                        ->whereNotNull('title');
                    })
                    ->select(\DB::raw('max(ticket_thread.updated_at) as updated_at'), 'user_name', 'first_name', 'last_name', 'email', 'profile_pic', 'ticket_number', 'tickets.id', 'title', 'tickets.created_at', 'department.name as department_name', 'ticket_priority.priority as priotity_name', 'sla_plan.name as sla_plan_name', 'help_topic.topic as help_topic_name', 'ticket_status.name as ticket_status_name')
                    ->where(function ($query) use ($user) {
                        if ($user->role != 'admin') {
                            $query->where('tickets.dept_id', '=', $user->primary_dpt);
                        }
                    })
                    ->orderBy('updated_at', 'desc')
                    ->groupby('tickets.id')
                    ->distinct()
                    ->paginate(10)
                    ->toJson();

            return $unassigned;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    /**
     * Get closed Tickets.
     *
     * @return json
     */
    public function closeTickets()
    {
        try {
            //            $result = $this->model->where('status', '>', 1)->where('status', '<', 4)->orderBy('id', 'DESC')->get();
            //            return response()->json(compact('result'));
            $user = \JWTAuth::parseToken()->authenticate();
            $result = $this->user->join('tickets', function ($join) {
                $join->on('users.id', '=', 'tickets.user_id')
                        ->where('status', '=', 3)->orWhere('status', '=', 2);
            })
                    ->join('department', 'department.id', '=', 'tickets.dept_id')
                    ->join('ticket_priority', 'ticket_priority.priority_id', '=', 'tickets.priority_id')
                    ->join('sla_plan', 'sla_plan.id', '=', 'tickets.sla')
                    ->join('help_topic', 'help_topic.id', '=', 'tickets.help_topic_id')
                    ->join('ticket_status', 'ticket_status.id', '=', 'tickets.status')
                    ->join('ticket_thread', function ($join) {
                        $join->on('tickets.id', '=', 'ticket_thread.ticket_id')
                        ->whereNotNull('title');
                    })
                    ->select(\DB::raw('max(ticket_thread.updated_at) as updated_at'), 'user_name', 'first_name', 'last_name', 'email', 'profile_pic', 'ticket_number', 'tickets.id', 'title', 'tickets.created_at', 'department.name as department_name', 'ticket_priority.priority as priotity_name', 'sla_plan.name as sla_plan_name', 'help_topic.topic as help_topic_name', 'ticket_status.name as ticket_status_name')
                    ->where(function ($query) use ($user) {
                        if ($user->role != 'admin') {
                            $query->where('tickets.dept_id', '=', $user->primary_dpt);
                        }
                    })
                    ->orderBy('updated_at', 'desc')
                    ->groupby('tickets.id')
                    ->distinct()
                    ->paginate(10)
                    ->toJson();

            return $result;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    /**
     * Get All agents.
     *
     * @return json
     */
    public function getAgents()
    {
        try {
            $result = $this->faveoUser->where('role', 'agent')->orWhere('role', 'admin')->where('active', 1)->get();

            return response()->json(compact('result'));
        } catch (Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    /**
     * Get All Teams.
     *
     * @return json
     */
    public function getTeams()
    {
        try {
            $result = $this->team->get();

            return response()->json(compact('result'));
        } catch (Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    /**
     * To assign a ticket.
     *
     * @return json
     */
    public function assignTicket()
    {
        try {
            $v = \Validator::make($this->request->all(), [
                        'ticket_id' => 'required',
                        'user'      => 'required',
            ]);
            if ($v->fails()) {
                $error = $v->errors();

                return response()->json(compact('error'));
            }
            $id = $this->request->input('ticket_id');
            $response = $this->ticket->assign($id);
            if ($response == 1) {
                $result = 'success';

                return response()->json(compact('result'));
            } else {
                return response()->json(compact('response'));
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    /**
     * Get all customers.
     *
     * @return json
     */
    public function getCustomers()
    {
        try {
            $v = \Validator::make($this->request->all(), [
                        'search' => 'required',
            ]);
            if ($v->fails()) {
                $error = $v->errors();

                return response()->json(compact('error'));
            }
            $search = $this->request->input('search');
            $result = $this->faveoUser->where('first_name', 'like', '%'.$search.'%')->orWhere('last_name', 'like', '%'.$search.'%')->orWhere('user_name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%')->get();

            return response()->json(compact('result'))
                            ->header('X-Header-One', 'Header Value');
        } catch (Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'))
                            ->header('X-Header-One', 'Header Value');
        }
    }

    /**
     * Get all customers having client_id, client_picture, client_name, client_email, client_phone.
     *
     * @return json
     */
    public function getCustomersWith()
    {
        try {
            $users = $this->user
                    ->leftJoin('user_assign_organization', 'user_assign_organization.user_id', '=', 'users.id')
                    ->leftJoin('organization', 'organization.id', '=', 'user_assign_organization.org_id')
                    ->where('role', 'user')
                    ->select('users.id', 'user_name', 'first_name', 'last_name', 'email', 'phone_number', 'users.profile_pic', 'organization.name AS company', 'users.active')
                    ->paginate(10)
                    ->toJson();

            //dd($users);
            return $users;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'))
                            ->header('Authenticate: xBasic realm', 'fake');
        }
    }

    /**
     * Get a customer by id.
     *
     * @return json
     */
    public function getCustomer()
    {
        try {
            $v = \Validator::make($this->request->all(), [
                        'user_id' => 'required',
            ]);
            if ($v->fails()) {
                $error = $v->errors();

                return response()->json(compact('error'));
            }
            $id = $this->request->input('user_id');
            $result = $this->faveoUser->where('id', $id)->where('role', 'user')->first();

            return response()->json(compact('result'));
        } catch (Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    /**
     * Search tickets.
     *
     * @return json
     */
    public function searchTicket()
    {
        try {
            $v = \Validator::make($this->request->all(), [
                        'search' => 'required',
            ]);
            if ($v->fails()) {
                $error = $v->errors();

                return response()->json(compact('error'));
            }
            $search = $this->request->input('search');
            $result = $this->thread->select('ticket_id')->where('title', 'like', '%'.$search.'%')->orWhere('body', 'like', '%'.$search.'%')->get();

            return response()->json(compact('result'));
        } catch (Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    /**
     * Get threads of a ticket.
     *
     * @return json
     */
    public function ticketThreads()
    {
        try {
            $v = \Validator::make($this->request->all(), [
                        'id' => 'required',
            ]);
            if ($v->fails()) {
                $error = $v->errors();

                return response()->json(compact('error'));
            }
            $id = $this->request->input('id');
            $result = $this->user
                    ->leftjoin('ticket_thread', 'ticket_thread.user_id', '=', 'users.id')
                    ->select('ticket_thread.id', 'ticket_id', 'user_id', 'poster', 'source', 'title', 'body', 'is_internal', 'format', 'ip_address', 'ticket_thread.created_at', 'ticket_thread.updated_at', 'users.first_name', 'users.last_name', 'users.user_name', 'users.email', 'users.profile_pic')
                    ->where('ticket_id', $id)
                    ->get()
                    ->toJson();

            return $result;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    /**
     * Check the url is valid or not.
     *
     * @return json
     */
    public function checkUrl()
    {
        //dd($this->request);
        try {
            $v = \Validator::make($this->request->all(), [
                        'url' => 'required|url',
            ]);
            if ($v->fails()) {
                $error = $v->errors();

                return response()->json(compact('error'));
            }

            $url = $this->request->input('url');
            if (!str_is('*/', $url)) {
                $url = str_finish($url, '/');
            }

            $url = $url.'/api/v1/helpdesk/check-url?api_key='.$this->request->input('api_key').'&token='.\Config::get('app.token');
            $result = $this->CallGetApi($url);
            //dd($result);
            return response()->json(compact('result'));
        } catch (\Exception $ex) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    /**
     * Success for currect url.
     *
     * @return string
     */
    public function urlResult()
    {
        return 'success';
    }

    /**
     * Call curl function for Get Method.
     *
     * @param type $url
     *
     * @return type int|string|json
     */
    public function callGetApi($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            echo 'error:'.curl_error($curl);
        }

        return $response;
        curl_close($curl);
    }

    /**
     * Call curl function for POST Method.
     *
     * @param type $url
     * @param type $data
     *
     * @return type int|string|json
     */
    public function callPostApi($url, $data)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            echo 'error:'.curl_error($curl);
        }

        return $response;
        curl_close($curl);
    }

    /**
     * To generate api string.
     *
     * @return type | json
     */
    public function generateApiKey()
    {
        try {
            $set = $this->setting->where('id', '1')->first();
            //dd($set);
            if ($set->api_enable == 1) {
                $key = str_random(32);
                $set->api_key = $key;
                $set->save();
                $result = $set->api_key;

                return response()->json(compact('result'));
            } else {
                $result = 'please enable api';

                return response()->json(compact('result'));
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    /**
     * Get help topics.
     *
     * @return json
     */
    public function getHelpTopic()
    {
        try {
            $result = $this->helptopic->get();

            return response()->json(compact('result'));
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    /**
     * Get Sla plans.
     *
     * @return json
     */
    public function getSlaPlan()
    {
        try {
            $result = $this->slaPlan->get();

            return response()->json(compact('result'));
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    /**
     * Get priorities.
     *
     * @return json
     */
    public function getPriority()
    {
        try {
            $result = $this->priority->get();

            return response()->json(compact('result'));
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    /**
     * Get departments.
     *
     * @return json
     */
    public function getDepartment()
    {
        try {
            $result = $this->department->get();

            return response()->json(compact('result'));
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    /**
     * Getting the tickets.
     *
     * @return type json
     */
    public function getTickets()
    {
        try {
            $tickets = $this->model->orderBy('created_at', 'desc')->paginate(10);
            $tickets->toJson();

            return $tickets;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    /**
     * Fetching the Inbox details.
     *
     * @return type json
     */
    public function inbox()
    {
        try {
            $user = \JWTAuth::parseToken()->authenticate();
            $inbox = $this->user->join('tickets', function ($join) {
                $join->on('users.id', '=', 'tickets.user_id')
                        ->where('status', '=', 1);
            })
                    ->join('department', 'department.id', '=', 'tickets.dept_id')
                    ->join('ticket_priority', 'ticket_priority.priority_id', '=', 'tickets.priority_id')
                    ->join('sla_plan', 'sla_plan.id', '=', 'tickets.sla')
                    ->join('help_topic', 'help_topic.id', '=', 'tickets.help_topic_id')
                    ->join('ticket_status', 'ticket_status.id', '=', 'tickets.status')
                    ->join('ticket_thread', function ($join) {
                        $join->on('tickets.id', '=', 'ticket_thread.ticket_id')
                        ->whereNotNull('ticket_thread.title');
                    })
                    ->select(\DB::raw('max(ticket_thread.updated_at) as updated_at'), 'user_name', 'first_name', 'last_name', 'email', 'profile_pic', 'ticket_number', 'tickets.id', 'ticket_thread.title', 'tickets.created_at', 'department.name as department_name', 'ticket_priority.priority as priotity_name', 'sla_plan.name as sla_plan_name', 'help_topic.topic as help_topic_name', 'ticket_status.name as ticket_status_name', 'department.id as department_id', 'users.primary_dpt as user_dpt')
                    ->where(function ($query) use ($user) {
                        if ($user->role != 'admin') {
                            $query->where('tickets.dept_id', '=', $user->primary_dpt);
                        }
                    })
                    ->orderBy('updated_at', 'desc')
                    ->groupby('tickets.id')
                    ->distinct()
                    ->paginate(10)
                    ->toJson();

            return $inbox;
        } catch (\Exception $ex) {
            $error = $ex->getMessage();
            $line = $ex->getLine();
            $file = $ex->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    /**
     * Create internal note.
     *
     * @return type json
     */
    public function internalNote()
    {
        try {
            $v = \Validator::make($this->request->all(), [
                        'userid'   => 'required|exists:users,id',
                        'ticketid' => 'required|exists:tickets,id',
                        'body'     => 'required',
            ]);
            if ($v->fails()) {
                $error = $v->errors();

                return response()->json(compact('error'));
            }
            $userid = $this->request->input('userid');
            $ticketid = $this->request->input('ticketid');

            $body = $this->request->input('body');
            $thread = $this->thread->create(['ticket_id' => $ticketid, 'user_id' => $userid, 'is_internal' => 1, 'body' => $body]);

            return response()->json(compact('thread'));
        } catch (\Exception $ex) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    public function getTrash()
    {
        try {
            $user = \JWTAuth::parseToken()->authenticate();
            $trash = $this->user->join('tickets', function ($join) {
                $join->on('users.id', '=', 'tickets.user_id')
                        ->where('status', '=', 5);
            })
                    ->join('department', 'department.id', '=', 'tickets.dept_id')
                    ->join('ticket_priority', 'ticket_priority.priority_id', '=', 'tickets.priority_id')
                    ->join('sla_plan', 'sla_plan.id', '=', 'tickets.sla')
                    ->join('help_topic', 'help_topic.id', '=', 'tickets.help_topic_id')
                    ->join('ticket_status', 'ticket_status.id', '=', 'tickets.status')
                    ->join('ticket_thread', function ($join) {
                        $join->on('tickets.id', '=', 'ticket_thread.ticket_id')
                        ->whereNotNull('title');
                    })
                    ->select(\DB::raw('max(ticket_thread.updated_at) as updated_at'), 'user_name', 'first_name', 'last_name', 'email', 'profile_pic', 'ticket_number', 'tickets.id', 'title', 'tickets.created_at', 'department.name as department_name', 'ticket_priority.priority as priotity_name', 'sla_plan.name as sla_plan_name', 'help_topic.topic as help_topic_name', 'ticket_status.name as ticket_status_name')
                    ->where(function ($query) use ($user) {
                        if ($user->role != 'admin') {
                            $query->where('tickets.dept_id', '=', $user->primary_dpt);
                        }
                    })
                    ->orderBy('updated_at', 'desc')
                    ->groupby('tickets.id')
                    ->distinct()
                    ->paginate(10)
                    ->toJson();

            return $trash;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    public function getMyTicketsAgent()
    {
        try {
            $v = \Validator::make($this->request->all(), [
                        'user_id' => 'required|exists:users,id',
            ]);
            if ($v->fails()) {
                $error = $v->errors();

                return response()->json(compact('error'));
            }
            $id = $this->request->input('user_id');
            if ($this->user->where('id', $id)->first()->role == 'user') {
                $error = 'This user is not an Agent or Admin';

                return response()->json(compact('error'));
            }
            //$user = \JWTAuth::parseToken()->authenticate();
            $result = $this->user->join('tickets', function ($join) use ($id) {
                $join->on('users.id', '=', 'tickets.assigned_to')
                        ->where('status', '=', 1);
                //->where('user_id', '=', $id);
            })
                    ->join('department', 'department.id', '=', 'tickets.dept_id')
                    ->join('ticket_priority', 'ticket_priority.priority_id', '=', 'tickets.priority_id')
                    ->join('sla_plan', 'sla_plan.id', '=', 'tickets.sla')
                    ->join('help_topic', 'help_topic.id', '=', 'tickets.help_topic_id')
                    ->join('ticket_status', 'ticket_status.id', '=', 'tickets.status')
                    ->join('ticket_thread', function ($join) {
                        $join->on('tickets.id', '=', 'ticket_thread.ticket_id')
                        ->whereNotNull('title');
                    })
                    ->where('users.id', $id)
                    ->select(\DB::raw('max(ticket_thread.updated_at) as updated_at'), 'user_name', 'first_name', 'last_name', 'email', 'profile_pic', 'ticket_number', 'tickets.id', 'title', 'tickets.created_at', 'department.name as department_name', 'ticket_priority.priority as priotity_name', 'sla_plan.name as sla_plan_name', 'help_topic.topic as help_topic_name', 'ticket_status.name as ticket_status_name')
//                    ->where(function($query) use($user) {
//                        if ($user->role != 'admin') {
//                            $query->where('tickets.dept_id', '=', $user->primary_dpt);
//                        }
//                    })
                    ->orderBy('updated_at', 'desc')
                    ->groupby('tickets.id')
                    ->distinct()
                    ->paginate(10)
                    ->toJson();

            return $result;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    public function getMyTicketsUser()
    {
        try {
            $v = \Validator::make($this->request->all(), [
                        'user_id' => 'required|exists:users,id',
            ]);
            if ($v->fails()) {
                $error = $v->errors();

                return response()->json(compact('error'));
            }
            $id = $this->request->input('user_id');
            if ($this->user->where('id', $id)->first()->role == 'admin' || $this->user->where('id', $id)->first()->role == 'agent') {
                $error = 'This is not a client';

                return response()->json(compact('error'));
            }
            $result = $this->user->join('tickets', function ($join) use ($id) {
                $join->on('users.id', '=', 'tickets.user_id')
                        ->where('user_id', '=', $id);
            })
                    ->join('department', 'department.id', '=', 'tickets.dept_id')
                    ->join('ticket_priority', 'ticket_priority.priority_id', '=', 'tickets.priority_id')
                    ->join('sla_plan', 'sla_plan.id', '=', 'tickets.sla')
                    ->join('help_topic', 'help_topic.id', '=', 'tickets.help_topic_id')
                    ->join('ticket_status', 'ticket_status.id', '=', 'tickets.status')
                    ->join('ticket_thread', function ($join) {
                        $join->on('tickets.id', '=', 'ticket_thread.ticket_id')
                        ->whereNotNull('title');
                    })
                    ->select('ticket_number', 'tickets.id', 'title', 'ticket_status.name as ticket_status_name')
                    ->orderBy('ticket_thread.updated_at', 'desc')
                    ->groupby('tickets.id')
                    ->distinct()
                    ->get()
                    // ->paginate(10)
                    ->toJson();

            return $result;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    public function getTicketById()
    {
        try {
            $v = \Validator::make($this->request->all(), [
                        'id' => 'required|exists:tickets,id',
            ]);
            if ($v->fails()) {
                $error = $v->errors();

                return response()->json(compact('error'));
            }
            $id = $this->request->input('id');
            if (!$this->model->where('id', $id)->first()) {
                $error = 'There is no Ticket as ticket id: '.$id;

                return response()->json(compact('error'));
            }
            $query = $this->user->join('tickets', function ($join) use ($id) {
                $join->on('users.id', '=', 'tickets.user_id')
                        ->where('tickets.id', '=', $id);
            });

            $response = $this->differenciateHelpTopic($query)
            ->leftJoin('department', 'tickets.dept_id', '=', 'department.id')
            ->leftJoin('ticket_priority', 'tickets.priority_id', '=', 'ticket_priority.priority_id')
            ->leftJoin('ticket_status', 'tickets.status', '=', 'ticket_status.id')
            ->leftJoin('sla_plan', 'tickets.sla', '=', 'sla_plan.id')
            ->leftJoin('ticket_source', 'tickets.source', '=', 'ticket_source.id');
            //$select = 'users.email','users.user_name','users.first_name','users.last_name','tickets.id','ticket_number','num_sequence','user_id','priority_id','sla','max_open_ticket','captcha','status','lock_by','lock_at','source','isoverdue','reopened','isanswered','is_deleted', 'closed','is_transfer','transfer_at','reopened_at','duedate','closed_at','last_message_at';

            $result = $response->addSelect(
                    'users.email',
                    'users.user_name',
                    'users.first_name',
                    'users.last_name',
                    'tickets.id',
                    'ticket_number',
                    'user_id',
                    'ticket_priority.priority_id',
                    'ticket_priority.priority as priority_name',
                    'department.name as dept_name',
                    'ticket_status.name as status_name',
                    'sla_plan.name as sla_name',
                    'ticket_source.name as source_name',
                    'sla_plan.id as sla',
                    'ticket_status.id as status',
                    'lock_by',
                    'lock_at',
                    'ticket_source.id as source',
                    'isoverdue',
                    'reopened',
                    'isanswered',
                    'is_deleted',
                    'closed',
                    'reopened_at',
                    'duedate',
                    'closed_at',
                    'tickets.created_at',
                    'tickets.updated_at')->first();

            return response()->json(compact('result'));
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    public function createPagination($array, $perPage)
    {
        try {
            //Get current page form url e.g. &page=6
            $currentPage = LengthAwarePaginator::resolveCurrentPage();

            //Create a new Laravel collection from the array data
            $collection = new Collection($array);

            //Slice the collection to get the items to display in current page
            $currentPageSearchResults = $collection->slice($currentPage * $perPage, $perPage)->all();

            //Create our paginator and pass it to the view
            $paginatedResults = new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);

            return $paginatedResults;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (\TokenExpiredException $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    public function collaboratorSearch()
    {
        $this->validate($this->request, ['term' => 'required']);

        try {
            $emails = $this->ticket->autosearch();
            //return $emails;
            $user = new User();
            if (count($emails) > 0) {
                foreach ($emails as $key => $email) {
                    $user_model = $user->where('email', $email)->first();
                    //return $user_model;
                    $users[$key]['name'] = $user_model->first_name.' '.$user_model->last_name;
                    $users[$key]['email'] = $email;
                    $users[$key]['avatar'] = $this->avatarUrl($email);
                }
            }
            //return $users;

            return response()->json(compact('users'));
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        }
    }

    public function avatarUrl($email)
    {
        try {
            $user = new User();
            $user = $user->where('email', $email)->first();
            if ($user->profile_pic) {
                $url = url('uploads/profilepic/'.$user->profile_pic);
            } else {
                $url = \Gravatar::src($email);
            }

            return $url;
        } catch (\Exception $ex) {
            //return $ex->getMessage();
            throw new \Exception($ex->getMessage());
        }
    }

    public function addCollaboratorForTicket()
    {
        try {
            $v = \Validator::make(\Input::get(), [
                        'email'     => 'required|email|unique:users',
                        'ticket_id' => 'required',
                            ]
            );
            if ($v->fails()) {
                $error = $v->messages();

                return response()->json(compact('error'));
            }
            $collaborator = $this->ticket->useradd();

            return response()->json(compact('collaborator'));
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $ex) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        }
    }

    public function getCollaboratorForTicket()
    {
        try {
            $v = \Validator::make(\Input::get(), [
                        'ticket_id' => 'required',
                            ]
            );
            if ($v->fails()) {
                $error = $v->messages();

                return response()->json(compact('error'));
            }
            $collaborator = $this->ticket->getCollaboratorForTicket();

            return response()->json(compact('collaborator'));
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $ex) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        }
    }

    public function deleteCollaborator()
    {
        try {
            $v = \Validator::make(\Input::get(), [
                        'ticketid' => 'required',
                        'email'    => 'required',
                            ]
            );
            if ($v->fails()) {
                $result = $v->messages();

                return response()->json(compact('result'));
            }
            $collaborator = $this->ticket->userremove();

            return response()->json(compact('collaborator'));
        } catch (\Exception $ex) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        }
    }

    public function dependency()
    {
        try {
            $department = $this->department->select('name', 'id')->get()->toArray();
            $sla = $this->slaPlan->select('name', 'id')->get()->toArray();
            $staff = $this->user->where('role', 'agent')->select('email', 'id')->get()->toArray();
            $team = $this->team->select('name', 'id')->get()->toArray();
            $priority = \DB::table('ticket_priority')->select('priority', 'priority_id')->get();
            $helptopic = $this->helptopic->select('topic', 'id')->get()->toArray();
            $status = \DB::table('ticket_status')->select('name', 'id')->get();
            $source = \DB::table('ticket_source')->select('name', 'id')->get();
            $result = ['departments' => $department, 'sla' => $sla, 'staffs' => $staff, 'teams' => $team,
                'priorities'         => $priority, 'helptopics' => $helptopic, 'status' => $status, 'sources' => $source, ];

            return response()->json(compact('result'));
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();

            return response()->json(compact('error', 'file', 'line'));
        }
    }

    public function differenciateHelpTopic($query)
    {
        $ticket = $query->first();
        $check = 'department';
        if ($ticket) {
            if ($ticket->dept_id && $ticket->help_topic_id) {
                return $this->getSystem($check, $query);
            }
            if (!$ticket->dept_id && $ticket->help_topic_id) {
                return $query->select('tickets.help_topic_id');
            }
            if ($ticket->dept_id && !$ticket->help_topic_id) {
                return $query->select('tickets.dept_id');
            }
        }

        return $query;
    }

    public function getSystem($check, $query)
    {
        switch ($check) {
            case 'department':
                return $query->select('tickets.dept_id');
            case 'helpTopic':
                return $query->select('tickets.help_topic_id');
            default:
                return $query->select('tickets.dept_id');
        }
    }

    /**
     * Register a user with username and password.
     *
     * @param Request $request
     *
     * @return type json
     */
    public function register(Request $request)
    {
        try {
            $v = \Validator::make($request->all(), [
                        'email'    => 'required|email|unique:users',
                        'password' => 'required|min:6',
            ]);
            if ($v->fails()) {
                $error = $v->errors();

                return response()->json(compact('error'));
            }
            $auth = $this->user;
            $email = $request->input('email');
            $username = $request->input('email');
            $password = \Hash::make($request->input('password'));
            $role = $request->input('role');
            if ($auth->role == 'agent') {
                $role = 'user';
            }
            $user = new User();
            $user->password = $password;
            $user->user_name = $username;
            $user->email = $email;
            $user->role = $role;
            $user->save();

            return response()->json(compact('user'));
        } catch (\Exception $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }
}
