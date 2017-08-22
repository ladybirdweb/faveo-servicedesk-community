<?php

namespace App\Plugins\ServiceDesk\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Plugins\ServiceDesk\Model\Assets\SdAssets;
use App\Plugins\ServiceDesk\Model\Common\AssetRelation;
use App\Plugins\ServiceDesk\Model\Common\Attachments;
use App\Plugins\ServiceDesk\Model\Common\GeneralInfo;
use Auth;
use Exception;

class UtilityController extends Controller
{
    public static function assetSearch($query, $format = 'json')
    {
        $assets = new SdAssets();
        $asset = $assets->where('name', 'LIKE', '%'.$query.'%')->select('name as label', 'id as value');

        if ($format == 'json') {
            $asset = $asset->get()->toJson();
        }

        return $asset;
    }

    public static function assetByTypeId($typeid)
    {
        $assets = new SdAssets();
        $asset = $assets->where('asset_type_id', $typeid);

        return $asset;
    }

    public static function getModelWithSelect($model, $select = [])
    {
        try {
            if (count($select) > 0) {
                $model = $model->select($select);
            }

            return $model;
        } catch (Exception $ex) {
        }
    }

    public static function saveTicketRelation($ticketid, $table, $id)
    {
        $relation = new \App\Plugins\ServiceDesk\Model\Common\TicketRelation();
        $relations = $relation->where('ticket_id', $ticketid)->where('owner', 'LIKE', $table.'%')->get();
        if ($relations->count() > 0) {
            foreach ($relations as $del) {
                $del->delete();
            }
        }
        if (is_array($id)) {
            foreach ($id as $i) {
                $relation->create([
                    'ticket_id' => $ticketid,
                    'owner'     => "$table:$i",
                ]);
            }
        } else {
            $owner = "$table:$id";
            $relation->create([
                'ticket_id' => $ticketid,
                'owner'     => $owner,
            ]);
        }
    }

    public static function saveAssetRelation($assetid, $table, $id)
    {
        if (is_array($assetid)) {
            $assetid = implode(',', $assetid);
        }
        $owner = "$table:$id";
        $relation = new \App\Plugins\ServiceDesk\Model\Common\AssetRelation();
        $relations = $relation->where('owner', $owner)->get();
        if ($relations->count() > 0) {
            foreach ($relations as $del) {
                $del->delete();
            }
        }
        $relation->create([
            'asset_ids' => $assetid,
            'owner'     => $owner,
        ]);
    }

    public static function getAssetByTicketid($ticketid)
    {
        $relation = new \App\Plugins\ServiceDesk\Model\Common\AssetRelation();
        $model = $relation->where('owner', "tickets:$ticketid")->first();
        $asset = false;
        if ($model) {
            if ($model->asset_id) {
                $assets = new SdAssets();
                $asset = $assets->where('id', $model->asset_id)->first();
            }
        }

        return $asset;
    }

    public static function getRelationOfTicketByTable($ticketid, $table)
    {
        $realtions = new \App\Plugins\ServiceDesk\Model\Common\TicketRelation();
        $realtion = $realtions->where('ticket_id', $ticketid)->where('owner', 'LIKE', $table.'%')->first();
        if ($realtion) {
            return $realtion;
        }
    }

    public static function getTicketByThreadId($threadid)
    {
        $thread = \App\Model\helpdesk\Ticket\Ticket_Thread::where('id', $threadid)->first();
        $tickets = new \App\Plugins\ServiceDesk\Model\Common\Ticket();
        $ticket = $tickets->where('id', $thread->ticket_id)->first();

        return $ticket;
    }

    public static function getUserByAssetId($assetid)
    {
        $assets = new SdAssets();
        $asset = $assets->find($assetid);
        $userid = $asset->used_by;
        $users = new \App\User();
        $user = $users->find($userid);

        return $user;
    }

    public static function getManagedByAssetId($assetid)
    {
        $assets = new SdAssets();
        $asset = $assets->find($assetid);
        $userid = $asset->managed_by;
        $users = new \App\User();
        $user = $users->find($userid);

        return $user;
    }

    public static function getRelationOfTicket($id)
    {
        $relations = new \App\Plugins\ServiceDesk\Model\Common\TicketRelation();
        $relation = $relations->where('ticket_id', $id)->get();

        return $relation;
    }

    public static function getRelationOfAsset($table, $id)
    {
        $relations = new \App\Plugins\ServiceDesk\Model\Common\AssetRelation();
        $owner = "$table:$id";
        $relation = $relations->where('owner', $owner)->first();

        return $relation;
    }

    public static function getSubjectByThreadId($threadid)
    {
        $threads = new \App\Model\helpdesk\Ticket\Ticket_Thread();
        $thread = $threads->find($threadid);
        $ticketid = $thread->ticket_id;
        $thread_first = $threads->where('ticket_id', $ticketid)->first();

        return $thread_first->title;
    }

    public static function getBodyByThreadId($threadid)
    {
        $threads = new \App\Model\helpdesk\Ticket\Ticket_Thread();
        $thread = $threads->find($threadid);
        $ticketid = $thread->ticket_id;
        $thread_first = $threads->where('ticket_id', $ticketid)->first();

        return $thread_first->body;
    }

    public static function getBodyByThreadMaxId($threadid)
    {
        $threads = new \App\Model\helpdesk\Ticket\Ticket_Thread();
        $thread = $threads->find($threadid);

        return $thread->body;
    }

    public static function attachment($id, $table, $attachments, $saved = 2)
    {
        //dd($id);
        $owner = "$table:$id";
        $value = '';
        $type = '';
        $size = '';

        if (count($attachments) > 0) {
            foreach ($attachments as $attachment) {
                if ($attachment) {
                    $name = $attachment->getClientOriginalName();
                    $destinationPath = 'uploads/service-desk/attachments';
                    $value = rand(0000, 9999).'.'.$name;
                    $type = $attachment->getClientOriginalExtension();
                    $size = $attachment->getSize();
                    if ($saved == 2) {
                        $attachment->move($destinationPath, $value);
                    } else {
                        $value = file_get_contents($attachment->getRealPath());
                    }
                    self::storeAttachment($saved, $owner, $value, $type, $size);
                }
            }
        }
    }

    public static function storeAttachment($saved, $owner, $value, $type, $size)
    {
        $attachments = new Attachments();
        $attachments->create([
            'saved' => $saved,
            'owner' => $owner,
            'value' => $value,
            'type'  => $type,
            'size'  => $size,
        ]);
    }

    public static function deleteAttachments($id, $table)
    {
        $owner = "$table:$id";
        $attachments = new Attachments();
        $attachment = $attachments->where('owner', $owner)->first();

        if ($attachment) {
            self::removeAttachment($attachment);
        }
    }

    public static function removeAttachment($attachment)
    {
        $saved = $attachment->saved;
        if ($saved == 2) {
            $file = $attachment->value;
            $path = public_path('uploads'.DIRECTORY_SEPARATOR.'service-desk'.DIRECTORY_SEPARATOR.'attachments'.DIRECTORY_SEPARATOR.$file);
            unlink($path);
        }
        $attachment->delete();
    }

    public static function downloadAttachment($attachment)
    {
        $saved = $attachment->saved;
        if ($saved == 2) {
            $file = $attachment->value;
            $attach = public_path('uploads'.DIRECTORY_SEPARATOR.'service-desk'.DIRECTORY_SEPARATOR.'attachments'.DIRECTORY_SEPARATOR.$file);
        } else {
            $attach = $attachment->value;
        }

        return $attach;
    }

    public static function storeAssetRelation($table, $id, $asset_ids = [], $update = false)
    {
        $relations = new AssetRelation();
        $owner = "$table:$id";
        $relationses = $relations->where('owner', $owner)->get();
        if ($relationses->count() > 0) {
            foreach ($relationses as $relationse) {
                $relationse->delete();
            }
        }
        if (count($asset_ids) > 0) {
            if (is_array($asset_ids)) {
                $asset_ids = implode(',', $asset_ids);
            }

            $relations->asset_ids = $asset_ids;
            $relations->owner = $owner;
            $relations->save();
        }
    }

    public static function deleteAssetRelation($id)
    {
        $relations = new AssetRelation();
        $relation = $relations->where('asset_ids', '!=', '')->get();
        $asset_ids = '';
        //dd($relation->asset_ids);
        foreach ($relation as $del) {
            $array = $del->asset_ids;
            $array = array_diff($array, [$id]);
            if (count($array) > 0) {
                $asset_ids = implode(',', $array);
                $del->asset_ids = $asset_ids;
                $del->save();
            } else {
                $del->delete();
            }
        }
    }

    public static function xmlToArray($xml, $options = [])
    {
        $defaults = [
            'namespaceSeparator' => ':', //you may want this to be something other than a colon
            'attributePrefix'    => '', //to distinguish between attributes and nodes with the same name
            'alwaysArray'        => [], //array of xml tag names which should always become arrays
            'autoArray'          => true, //only create arrays for tags which appear more than once
            'textContent'        => 'option-name', //key used for the text content of elements
            'autoText'           => true, //skip textContent key if node has no attributes or child nodes
            'keySearch'          => false, //optional search and replace on tag and attribute names
            'keyReplace'         => false,       //replace values for above search values (as passed to str_replace())
        ];
        $options = array_merge($defaults, $options);
        $namespaces = $xml->getDocNamespaces();
        $namespaces[''] = null; //add base (empty) namespace
        //get attributes from all namespaces
        $attributesArray = [];
        foreach ($namespaces as $prefix => $namespace) {
            foreach ($xml->attributes($namespace) as $attributeName => $attribute) {
                //replace characters in attribute name
                if ($options['keySearch']) {
                    $attributeName = str_replace($options['keySearch'], $options['keyReplace'], $attributeName);
                }
                $attributeKey = $options['attributePrefix']
                        .($prefix ? $prefix.$options['namespaceSeparator'] : '')
                        .$attributeName;
                $attributesArray[$attributeKey] = (string) $attribute;
            }
        }

        //get child nodes from all namespaces
        $tagsArray = [];
        foreach ($namespaces as $prefix => $namespace) {
            foreach ($xml->children($namespace) as $childXml) {
                //recurse into child nodes
                $childArray = self::xmlToArray($childXml, $options);
                list($childTagName, $childProperties) = each($childArray);

                //replace characters in tag name
                if ($options['keySearch']) {
                    $childTagName = str_replace($options['keySearch'], $options['keyReplace'], $childTagName);
                }
                //add namespace prefix, if any
                if ($prefix) {
                    $childTagName = $prefix.$options['namespaceSeparator'].$childTagName;
                }

                if (!isset($tagsArray[$childTagName])) {
                    //only entry with this key
                    //test if tags of this type should always be arrays, no matter the element count
                    $tagsArray[$childTagName] = in_array($childTagName, $options['alwaysArray']) || !$options['autoArray'] ? [$childProperties] : $childProperties;
                } elseif (
                        is_array($tagsArray[$childTagName]) && array_keys($tagsArray[$childTagName]) === range(0, count($tagsArray[$childTagName]) - 1)
                ) {
                    //key already exists and is integer indexed array
                    $tagsArray[$childTagName][] = $childProperties;
                } else {
                    //key exists so convert to integer indexed array with previous value in position 0
                    $tagsArray[$childTagName] = [$tagsArray[$childTagName], $childProperties];
                }
            }
        }

        //get text content of node
        $textContentArray = [];
        $plainText = trim((string) $xml);
        if ($plainText !== '') {
            $textContentArray[$options['textContent']] = $plainText;
        }

        //stick it all together
        $propertiesArray = !$options['autoText'] || $attributesArray || $tagsArray || ($plainText === '') ? array_merge($attributesArray, $tagsArray, $textContentArray) : $plainText;

        //return node as array
        return [
            $xml->getName() => $propertiesArray,
        ];
    }

    public static function arrayToXml($array, $key = '', $options = false)
    {
        $field = '';
        $value = '';
        //$options = false;
        if (is_int($key)) {
            $field = '<field ';
            foreach ($array as $index => $item) {
                if (is_array($item)) {
                    $value = self::value($item);
                    $options = true;
                } elseif ($options == false) {
                    $it = '='.'"'.$item.'" ';
                    $field .= $index.$it;
                }
            }

            $field .= ">$value</field>";
        }

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $field .= self::arrayToXml($value, $key, $options);
            }
        }

        return $field;
    }

    public static function value($item)
    {
        $result = '';
        foreach ($item as $k => $v) {
            $result .= '<option value='.'"'.$k.'"'.'>'.$v.'</option>';
        }

        return $result;
    }

    public static function deletePopUp($id, $url, $title = 'Delete', $class = 'btn btn-sm btn-danger', $btn_name = 'Delete', $button_check = true)
    {
        $button = '';
        if ($button_check == true) {
            $button = '<a href="#delete" class="'.$class.'" data-toggle="modal" data-target="#delete'.$id.'">'.$btn_name.'</a>';
        }

        return $button.'<div class="modal fade" id="delete'.$id.'">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">'.$title.'</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                <div class="col-md-12">
                                <p>Are you sure ?</p>
                                </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="close" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                <a href="'.$url.'" class="btn btn-danger">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>';
    }

    public static function checkCabUser($cabid)
    {
        $authid = Auth::user()->id;
        $result = false;
        $cabs = new \App\Plugins\ServiceDesk\Model\Cab\Cab();
        $cab = $cabs->find($cabid);
        if ($cab) {
            $members = $cab->approvers;
            if (is_array($members)) {
                if (in_array($authid, $members)) {
                    $result = true;
                }
            } elseif (is_int($members)) {
                if ($authid == $members) {
                    $result = true;
                }
            } elseif ($cab->head) {
                if ($authid == $cab->head) {
                    $result = true;
                }
            }
        }

        return $result;
    }

    public static function cabMessage($cabid, $activity, $url)
    {
        $cabs = new \App\Plugins\ServiceDesk\Model\Cab\Cab();
        $cab = $cabs->find($cabid);
        if ($cab) {
            $members = $cab->approvers;
            $head = $cab->head;
            if (is_array($members)) {
                if (count($members) > 0) {
                    foreach ($members as $userid) {
                        self::sendCabMessage($userid, $head, $activity, $url);
                    }
                }
            }
        }
    }

    public static function sendCabMessage($userid, $head, $activity, $url)
    {
        $users = new \App\User();
        $user = $users->find($userid);
        $leader = $users->find($head);
        $heads = '';
        //dd($url);
        if ($user) {
            $email = $user->email;
            $name = $user->first_name.' '.$user->last_name;
            if ($leader) {
                $heads = $leader->first_name.' '.$leader->last_name;
            }
            //dd([$email,$name,$heads,$url]);
            $php_mailer = new \App\Http\Controllers\Common\PhpMailController();
            $php_mailer->sendmail(
                    $from = $php_mailer->mailfrom('1', '0'), $to = ['name' => $name, 'email' => $email], $message = [
                'subject'  => 'Requesting For CAB Approval',
                'scenario' => 'sd-cab-vote',
                    ], $template_variables = [
                'user'         => $name,
                'system_link'  => $url,
                '$system_from' => $heads,
                    ]
            );
        }
    }

    public static function storeGeneralInfo($modelid, $table, $requests)
    {
        $owner = "$table:$modelid";
        $request = $requests->except('_token', 'attachment', 'identifier');
        // dd($request);
        $general = new GeneralInfo();

        if (count($request) > 0) {
            foreach ($request as $key => $value) {
                $generals = $general->where('owner', $owner)->where('key', $key)->first();
                if ($generals) {
                    $generals->delete();
                }
                if ($value !== '') {
                    $general->create([
                        'owner' => $owner,
                        'key'   => $key,
                        'value' => $value,
                    ]);
                }
            }
        }

        $attachments = $requests->file('attachment');
        $identifier = $requests->input('identifier');
        $attach_table = "$table:$identifier";
        self::attachment($modelid, $attach_table, $attachments);

        return 'success';
    }

    public static function getAttachmentSize($size)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        $value = number_format($size / pow(1024, $power), 2, '.', ',').' '.$units[$power];

        return $value;
    }
}
