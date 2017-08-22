<?php

namespace App\Plugins\ServiceDesk\Controllers;

use Exception;
use Illuminate\Http\Request;

class InterfaceController extends BaseServiceDeskController
{
    public function agentSidebar()
    {
        $path = app_path().'/Plugins/ServiceDesk/views/interface';
        \View::addNamespace('plugins', $path);

        return view('plugins::agent.sidebar');
    }

    public function agentTopbar()
    {
        $path = app_path().'/Plugins/ServiceDesk/views/interface';
        \View::addNamespace('plugins', $path);

        return view('plugins::agent.topbar');
    }

    public function agentTopSubbar()
    {
        $path = app_path().'/Plugins/ServiceDesk/views/interface';
        \View::addNamespace('plugins', $path);

        return view('plugins::agent.topsubbar');
    }

    public function adminSidebar()
    {
        $path = app_path().'/Plugins/ServiceDesk/views/interface';
        \View::addNamespace('plugins', $path);

        return view('plugins::admin.sidebar');
    }

    public function adminTopbar()
    {
        $path = app_path().'/Plugins/ServiceDesk/views/interface';
        \View::addNamespace('plugins', $path);

        return view('plugins::admin.topbar');
    }

    public function adminTopSubbar()
    {
        $path = app_path().'/Plugins/ServiceDesk/views/interface';
        \View::addNamespace('plugins', $path);

        return view('plugins::admin.topsubbar');
    }

    public function adminSettings()
    {
        $path = app_path().'/Plugins/ServiceDesk/views/interface';
        \View::addNamespace('plugins', $path);

        return view('plugins::admin.settings');
    }

    public function ticketDetailTable($event)
    {
        $id = $event->para1;

        return view('service::interface.agent.ticket-head', compact('id'));
    }

    public function generalInfo($id, $table, Request $request)
    {
        //dd($request);
        try {
            $store = Library\UtilityController::storeGeneralInfo($id, $table, $request);
            //dd($store);
            if ($store == 'success') {
                return redirect()->back()->with('success', 'Updated');
            }

            throw new Exception('Sorry we can not process your request');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function deleteAttachments($attachid, $owner)
    {
        try {
            $attachments = new \App\Plugins\ServiceDesk\Model\Common\Attachments();
            $attachment = $attachments->where('id', $attachid)->where('owner', $owner)->first();
            if ($attachment) {
                Library\UtilityController::removeAttachment($attachment);
            } else {
                throw new Exception('Sorry we can not find your request');
            }

            return redirect()->back()->with('success', 'Updated');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function downloadAttachments($attachid, $owner)
    {
        try {
            $attachments = new \App\Plugins\ServiceDesk\Model\Common\Attachments();
            $attachment = $attachments->where('id', $attachid)->where('owner', $owner)->first();
            if ($attachment) {
                $attach = Library\UtilityController::downloadAttachment($attachment);
                if ($attachment->saved == 2) {
                    return response()->download($attach);
                }
            } else {
                throw new Exception('Sorry we can not find your request');
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function deleteGeneralByIdentifier($owner, $identifier)
    {
        try {
            $genereals = new \App\Plugins\ServiceDesk\Model\Common\GeneralInfo();
            $genereal = $genereals->where('owner', $owner)->where('key', $identifier)->first();
            if ($genereal) {
                $attachments = new \App\Plugins\ServiceDesk\Model\Common\Attachments();
                $atach_owner = str_replace(':', ":$identifier:", $owner);
                $attachment = $attachments->where('owner', $atach_owner)->first();
                if ($attachment) {
                    Library\UtilityController::removeAttachment($attachment);
                }
                if ($identifier == 'solution') {
                    $title = $genereals->where('owner', $owner)->where('key', 'solution-title')->first();
                    if ($title) {
                        $title->delete();
                    }
                }
                $genereal->delete();
            } else {
                throw new Exception('Sorry we can not find your request');
            }

            return redirect()->back()->with('success', 'Updated');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }
}
