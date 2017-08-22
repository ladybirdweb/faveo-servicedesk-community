<?php

namespace App\Itil\Controllers;

use Exception;
use Illuminate\Http\Request;

class InterfaceController extends BaseServiceDeskController
{
    public function agentSidebar()
    {
        return view('itil::interface.agent.sidebar');
    }

    public function agentTopbar()
    {
        return view('itil::interface.agent.topbar');
    }

    public function agentTopSubbar()
    {
        return view('itil::interface.agent.topsubbar');
    }

    public function adminSidebar()
    {
        return view('itil::interface.admin.sidebar');
    }

    public function adminTopbar()
    {
        return view('itil::interface.admin.topbar');
    }

    public function adminTopSubbar()
    {
        return view('itil::interface.admin.topsubbar');
    }

    public function adminSettings()
    {
        return view('itil::interface.admin.settings');
    }

    public function ticketDetailTable($event)
    {
        $id = $event->para1;

        return view('itil::interface.agent.ticket-head', compact('id'));
    }

    public function generalInfo($id, $table, Request $request)
    {
        //dd($request);
        try {
            $store = UtilityController::storeGeneralInfo($id, $table, $request);
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
            $attachments = new \App\Itil\Models\Common\Attachments();
            $attachment = $attachments->where('id', $attachid)->where('owner', $owner)->first();
            if ($attachment) {
                UtilityController::removeAttachment($attachment);
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
            $attachments = new \App\Itil\Models\Common\Attachments();
            $attachment = $attachments->where('id', $attachid)->where('owner', $owner)->first();
            if ($attachment) {
                $attach = UtilityController::downloadAttachment($attachment);
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
            $genereals = new \App\Itil\Models\Common\GeneralInfo();
            $genereal = $genereals->where('owner', $owner)->where('key', $identifier)->first();
            if ($genereal) {
                $attachments = new \App\Itil\Models\Common\Attachments();
                $atach_owner = str_replace(':', ":$identifier:", $owner);
                $attachment = $attachments->where('owner', $atach_owner)->first();
                if ($attachment) {
                    UtilityController::removeAttachment($attachment);
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
