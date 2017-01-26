<?php
$reason = "";
$impact = "";
$rollout = "";
$backout = "";
$table = $change->table();
$owner = "$table:$change->id";
if ($change->getGeneralByIdentifier('reason')) {
    $reason = $change->getGeneralByIdentifier('reason')->value;

    $delete_reason_url = url('service-desk/general/' . $owner . '/reason/delete');
    $popid = "reason$change->id";
    $title = "Delete reason";
    $delete_reason_popup = \App\Itil\Controllers\UtilityController::deletePopUp($popid, $delete_reason_url, $title, "fa fa-remove", " ");
}
if ($change->getGeneralByIdentifier('impact')) {
    $impact = $change->getGeneralByIdentifier('impact')->value;
    $delete_impact_url = url('service-desk/general/' . $owner . '/impact/delete');
    $popid = "impact$change->id";
    $title = "Delete impact";
    $delete_impact_popup = \App\Itil\Controllers\UtilityController::deletePopUp($popid, $delete_impact_url, $title, "fa fa-remove", " ");
}

if ($change->getGeneralByIdentifier('rollout-plan')) {
    $rollout = $change->getGeneralByIdentifier('rollout-plan')->value;
    $delete_rollout_url = url('service-desk/general/' . $owner . '/rollout-plan/delete');
    $popid = "rollout-plan$change->id";
    $title = "Delete Rollout Plan";
    $delete_rollout_popup = \App\Itil\Controllers\UtilityController::deletePopUp($popid, $delete_rollout_url, $title, "fa fa-remove", " ");
}
if ($change->getGeneralByIdentifier('backout-plan')) {
    $backout = $change->getGeneralByIdentifier('backout-plan')->value;
    $delete_backout_url = url('service-desk/general/' . $owner . '/backout-plan/delete');
    $popid = "backout-plan$change->id";
    $title = "Delete Backout Plan";
    $delete_backout_popup = \App\Itil\Controllers\UtilityController::deletePopUp($popid, $delete_backout_url, $title, "fa fa-remove", " ");
}
?>
<div class="row">

    <div class="col-md-12">
        <!-- The time line -->
        <ul class="timeline">
            @if($reason!=="")
            <!--root-cause-->
            <li class="time-label">
                <p> &nbsp; </p>
                <span class="bg-green">
                    Reason for Change
                </span> 

            </li>

            <li>

                <i class="fa fa-ambulance bg-purple" title="reason"></i>
                <div class="timeline-item">
                    <div class="timeline-header">
                        @if($change->getGeneralByIdentifier('reason'))
                        {{$change->getGeneralByIdentifier('reason')->created_at}}
                        @endif
                        <div class="row">
                            <div class="col-md-offset-11">
                                {!! $delete_reason_popup !!}
                                &nbsp;<a href="#delete" data-toggle="modal" data-target="#reason{{$change->id}}"><i class="fa fa-pencil"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="timeline-body" style="padding-left:30px;margin-bottom:-20px">

                        {!! ucfirst($reason) !!}
                    </div>
                    @if($change->generalAttachments('reason')->count()>0)
                    <br><br>
                    <div class="timeline-footer" style="margin-bottom:-5px">
                        <div class="row">
                            @foreach($change->generalAttachments('reason') as $attachment)
                            <?php
                            $deleteid = $attachment->id;
                            $deleteurl = url('service-desk/delete/' . $attachment->id . '/' . $attachment->owner . '/attachment');
                            ?>
                            @include('itil::interface.agent.popup.delete')
                            <div class="col-md-3">
                                <ul class="list-unstyled clearfix mailbox-attachments">
                                    <li>
                                        <a href="{{url('service-desk/download/'.$attachment->id.'/'.$attachment->owner.'/attachment')}}">
                                            <span class="mailbox-attachment-icon" style="background-color:#fff;">{!!strtoupper($attachment->type)!!}</span>
                                            <div class="mailbox-attachment-info">
                                                <span>
                                                    <b style="word-wrap: break-word;">{!!$attachment->value!!}</b>
                                                    <br/>
                                                    <p>{{\App\Itil\Controllers\UtilityController::getAttachmentSize($attachment->size)}}</p>
                                                </span>

                                            </div>
                                        </a>
                                    </li>
                                    <a href="#change-detach" class="col-md-offset-12 fa fa-remove" data-toggle="modal" data-target="#delete{{$deleteid}}"></a>
                                </ul>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>
            </li>
            <!--/root-cause-->
            @endif
            @if($impact!=="")
            <!--impact-->
            <li class="time-label">
                <p> &nbsp; </p>
                <span class="bg-green">
                    Impact
                </span>     
            </li>
            <li>

                <i class="fa fa-anchor bg-purple" title="Impact"></i>
                <div class="timeline-item">
                    <div class="timeline-header">
                        @if($change->getGeneralByIdentifier('impact'))
                        {{$change->getGeneralByIdentifier('impact')->created_at}}
                        @endif
                        <div class="row">
                            <div class="col-md-offset-11">
                                {!! $delete_impact_popup !!}
                                &nbsp;<a href="#delete" data-toggle="modal" data-target="#changeimpact{{$change->id}}"><i class="fa fa-pencil"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-body" style="padding-left:30px;margin-bottom:-20px">

                        {!! ucfirst($impact) !!}
                    </div>
                
                @if($change->generalAttachments('impact')->count()>0)
                <br><br>
                <div class="timeline-footer" style="margin-bottom:-5px">
                    <div class="row">
                        @foreach($change->generalAttachments('impact') as $attachment)
                        <?php
                        $deleteid = $attachment->id;
                        $deleteurl = url('service-desk/delete/' . $attachment->id . '/' . $attachment->owner . '/attachment');
                        ?>
                        @include('itil::interface.agent.popup.delete')
                        <div class="col-md-3">
                            <ul class="list-unstyled clearfix mailbox-attachments">
                                    <li>
                                        <a href="{{url('service-desk/download/'.$attachment->id.'/'.$attachment->owner.'/attachment')}}">
                                            <span class="mailbox-attachment-icon" style="background-color:#fff;">{!!strtoupper($attachment->type)!!}</span>
                                            <div class="mailbox-attachment-info">
                                                <span>
                                                    <b style="word-wrap: break-word;">{!!$attachment->value!!}</b>
                                                    <br/>
                                                    <p>{{\App\Itil\Controllers\UtilityController::getAttachmentSize($attachment->size)}}</p>
                                                </span>

                                            </div>
                                        </a>
                                    </li>
                                    <a href="#delete"  data-toggle="modal" class="col-md-offset-12 fa fa-remove" data-target="#delete{{$deleteid}}"></a>
                            </ul>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </li>
            <!--/impact-->
            @endif
            @if($rollout!=="")
            <!--symptoms-->
            <li class="time-label">
                <p> &nbsp; </p>
                <span class="bg-green">
                    Rollout Plan
                </span>     
            </li>
            <li>

                <i class="fa fa-battery-0 bg-purple" title="Rollout Plan"></i>
                <div class="timeline-item">
                    <div class="timeline-header">
                        @if($change->getGeneralByIdentifier('rollout-plan'))
                        {{$change->getGeneralByIdentifier('rollout-plan')->created_at}}
                        @endif
                        <div class="row">

                            <div class="col-md-offset-11">
                                {!! $delete_rollout_popup !!}
                                &nbsp;<a href="#delete" data-toggle="modal" data-target="#rollout{{$change->id}}"><i class="fa fa-pencil"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-body" style="padding-left:30px;margin-bottom:-20px">

                        {!! ucfirst($rollout) !!}
                    </div>
                    @if($change->generalAttachments('rollout-plan')->count()>0)
                    <br><br>
                    <div class="timeline-footer" style="margin-bottom:-5px">
                        <div class="row">
                            @foreach($change->generalAttachments('rollout-plan') as $attachment)
                            <?php
                            $deleteid = $attachment->id;
                            $deleteurl = url('service-desk/delete/' . $attachment->id . '/' . $attachment->owner . '/attachment');
                            ?>
                            @include('itil::interface.agent.popup.delete')
                            <div class="col-md-3">
                                <ul class="list-unstyled clearfix mailbox-attachments">
                                    <li>
                                        <a href="{{url('service-desk/download/'.$attachment->id.'/'.$attachment->owner.'/attachment')}}">
                                            <span class="mailbox-attachment-icon" style="background-color:#fff;">{!!strtoupper($attachment->type)!!}</span>
                                            <div class="mailbox-attachment-info">
                                                <span>
                                                    <b style="word-wrap: break-word;">{!!$attachment->value!!}</b>
                                                    <br/>
                                                    <p>{{\App\Itil\Controllers\UtilityController::getAttachmentSize($attachment->size)}}</p>
                                                </span>

                                            </div>
                                        </a>
                                    </li>
                                    <a href="#change-detach" class="col-md-offset-12 fa fa-remove"  data-toggle="modal" data-target="#delete{{$deleteid}}"></a>
                                </ul>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>
            </li>
            <!--/sympton-->
            @endif
            @if($backout!=="")
            <!--solution-->
            <li class="time-label">
                <p> &nbsp; </p>
                <span class="bg-green">
                    Backout Plan

                </span>     
            </li>
            <li>

                <i class="fa fa-thumbs-up bg-purple" title="Backout Plan"></i>
                <div class="timeline-item">
                    <!--<span  class="time" style="color:#fff;"><i class="fa fa-clock-o"> </i> 25.05.2016 11:01:01</span>-->
                    <div class="timeline-header">
                        
                        @if($change->getGeneralByIdentifier('backout-plan'))
                        {{$change->getGeneralByIdentifier('backout-plan')->created_at}}
                        @endif
                        <div class="row">
                            <div class="col-md-offset-11">
                                {!! $delete_backout_popup !!}
                                &nbsp;<a href="#delete" data-toggle="modal" data-target="#backout{{$change->id}}"><i class="fa fa-pencil"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="timeline-body" style="padding-left:30px;margin-bottom:-20px">
                        {!! ucfirst($backout) !!}


                    </div>
                    @if($change->generalAttachments('backout-plan')->count()>0)
                    <br><br>
                    <div class="timeline-footer" style="margin-bottom:-5px">
                        <div class="row">
                            @foreach($change->generalAttachments('backout-plan') as $attachment)
                            <?php
                            $deleteid = $attachment->id;
                            $deleteurl = url('service-desk/delete/' . $attachment->id . '/' . $attachment->owner . '/attachment');
                            ?>
                            @include('itil::interface.agent.popup.delete')
                            <div class="col-md-3">
                                <ul class="list-unstyled clearfix mailbox-attachments">
                                    <li>
                                        <a href="{{url('service-desk/download/'.$attachment->id.'/'.$attachment->owner.'/attachment')}}">
                                            <span class="mailbox-attachment-icon" style="background-color:#fff;">{!!strtoupper($attachment->type)!!}</span>
                                            <div class="mailbox-attachment-info">
                                                <span>
                                                    <b style="word-wrap: break-word;">{!!$attachment->value!!}</b>
                                                    <br/>
                                                    <p>{{\App\Itil\Controllers\UtilityController::getAttachmentSize($attachment->size)}}</p>
                                                </span>

                                            </div>
                                        </a>
                                    </li>
                                    <a href="#change-detach" class="col-md-offset-12 fa fa-remove"  data-toggle="modal" data-target="#delete{{$deleteid}}"></a>
                                </ul>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </li>
            <!--/solution-->
            @endif
            @if($change->release())
            <!--solution-->
            <li class="time-label">
                <p> &nbsp; </p>
                <span class="bg-green">
                    Release
                </span>     
            </li>
            <li>

                <i class="fa fa-newspaper-o bg-purple" title="release"></i>
                <div class="timeline-item">
                    <!--<span  class="time" style="color:#fff;"><i class="fa fa-clock-o"> </i> 25.05.2016 11:01:01</span>-->


                    <div class="timeline-body" style="padding-left:30px;margin-bottom:-20px">
                        <a href="{{url('service-desk/releases/'.$change->release()->id.'/show')}}">{!! ucfirst(str_limit($change->release()->subject,20)) !!}</a>
                    </div>
                    <br><br>
                    <div class="timeline-footer" style="margin-bottom:-5px">
                        <ul class="mailbox-attachments clearfix">
                        </ul>
                    </div>
                </div>
            </li>
            <!--/solution-->
            @endif
        </ul>
    </div>
</div>