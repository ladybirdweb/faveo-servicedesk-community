<?php

namespace App\Plugins\ServiceDesk\Controllers\Announcement;

use App\Plugins\ServiceDesk\Controllers\BaseServiceDeskController;
use Exception;
use Illuminate\Http\Request;

class AnnouncementController extends BaseServiceDeskController
{
    public function setAnnounce()
    {
        try {
            $organization = \App\Model\helpdesk\Agent_panel\Organization::lists('name', 'id')->toArray();
            $departments = \App\Model\helpdesk\Agent\Department::lists('name', 'id')->toArray();

            return view('service::announce.set', compact('organization', 'departments'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function send(Request $request)
    {
        $this->validate($request, [
            'option'       => 'required',
            'organization' => 'required_if:option,organization',
            'department'   => 'required_if:option,department',
            'announcement' => 'required',
        ]);

        try {
            $option = $request->input('option');
            $organization = $request->input('organization');
            $department = $request->input('department');
            $message = $request->input('announcment');
            switch ($option) {
                case 'organization':
                    $this->sendOrganization($organization, $message);
                    break;
                case 'department':
                    $this->sendDepartment($department, $message);
                    break;
            }

            return redirect()->back()->with('success', 'Announced');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function sendOrganization($organization, $message)
    {
        $orgs = new \App\Model\helpdesk\Agent_panel\Organization();
        $org = $orgs->find($organization);
        if ($org) {
            $users = $org->users();
            $this->sendAnnouncmentToUsers($users, $message);
        }
    }

    public function sendDepartment($department, $message)
    {
        $user = new \App\User();
        $users = $user->where('primary_dpt', $department);
        $this->sendAnnouncmentToUsers($users, $message);
    }

    public function sendAnnouncmentToUsers($users, $message)
    {
        if ($users) {
            $users_emails = $users->whereNotNull('email')->select('email')->get();
            $controller = new \App\Http\Controllers\Common\PhpMailController();
            $from = $controller->mailfrom('1', '0');
            $message = [
                'subject'  => 'Announcment',
                'scenario' => null,
                'body'     => $message,
            ];
            foreach ($users_emails as $user) {
                $to = [
                    'name'  => $user->email,
                    'email' => $user->email,
                ];
                $controller->sendmail($from, $to, $message, $template_variables = '');
            }
        }
    }
}
