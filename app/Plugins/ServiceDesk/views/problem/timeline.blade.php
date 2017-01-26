<?php
//$info = $problem->general();
//dd($info);
$root = "";
$symptom = "";
$impact = "";
$solution_title = "";
$solution = "";
$table = $problem->table();
$owner = "$table:$problem->id";
if ($problem->getGeneralByIdentifier('root-cause')) {
    $root = $problem->getGeneralByIdentifier('root-cause')->value;

    $delete_root_url = url('service-desk/general/' . $owner . '/root-cause/delete');
    $popid = "root-cause$problem->id";
    $title = "Delete Root Cause";
    $delete_root_popup = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::deletePopUp($popid, $delete_root_url, $title, "fa fa-remove", " ");
}
if ($problem->getGeneralByIdentifier('symptoms')) {
    $symptom = $problem->getGeneralByIdentifier('symptoms')->value;
    $delete_symptoms_url = url('service-desk/general/' . $owner . '/symptoms/delete');
    $popid = "symptoms$problem->id";
    $title = "Delete symptoms";
    $delete_symptoms_popup = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::deletePopUp($popid, $delete_symptoms_url, $title, "fa fa-remove", " ");
}
if ($problem->getGeneralByIdentifier('solution-title')) {
    $solution_title = $problem->getGeneralByIdentifier('solution-title')->value;
    //$delete_root_url = url('service-desk/general/'.$problem->id.'root-cause/delete');
}
if ($problem->getGeneralByIdentifier('solution')) {
    $solution = $problem->getGeneralByIdentifier('solution')->value;
    $delete_solution_url = url('service-desk/general/' . $owner . '/solution/delete');
    $popid = "solution$problem->id";
    $title = "Delete solution";
    $delete_solution_popup = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::deletePopUp($popid, $delete_solution_url, $title, "fa fa-remove", " ");
}
if ($problem->getGeneralByIdentifier('impact')) {
    $impact = $problem->getGeneralByIdentifier('impact')->value;
    $delete_impact_url = url('service-desk/general/' . $owner . '/impact/delete');
    $popid = "impact$problem->id";
    $title = "Delete impact";
    $delete_impact_popup = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::deletePopUp($popid, $delete_impact_url, $title, "fa fa-remove", " ");
}
?>
<div class="row">

    <div class="col-md-12">
        <!-- The time line -->
        <ul class="timeline">
            @if($root!=="")
            <!--root-cause-->
            <li class="time-label">
                <p> &nbsp; </p>
                <span class="bg-green">
                    Root Cause 
                </span> 

            </li>

            <li>

                <i class="fa fa-ambulance bg-purple" title="Root Cause"></i>
                <div class="timeline-item">
                    <div class="timeline-header">
                        @if($problem->getGeneralByIdentifier('root-cause'))
                        {{$problem->getGeneralByIdentifier('root-cause')->created_at}}
                        @endif
                        <div class="row">
                            <div class="col-md-offset-11">
                                {!! $delete_root_popup !!}
                                &nbsp;<a href="#delete" data-toggle="modal" data-target="#rootcause{{$problem->id}}"><i class="fa fa-pencil"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="timeline-body" style="padding-left:30px;margin-bottom:-20px">

                        {!! ucfirst($root) !!}
                    </div>
                    @if($problem->generalAttachments('root-cause')->count()>0)
                    <br><br>
                    <div class="timeline-footer" style="margin-bottom:-5px">
                        <div class="row">
                            @foreach($problem->generalAttachments('root-cause') as $attachment)
                            <?php
                            $deleteid = $attachment->id;
                            $deleteurl = url('service-desk/delete/' . $attachment->id . '/' . $attachment->owner . '/attachment');
                            ?>
                            @include('service::interface.agent.popup.delete')
                            <div class="col-md-3">
                                <ul class="list-unstyled clearfix mailbox-attachments">
                                    <li>
                                        <a href="{{url('service-desk/download/'.$attachment->id.'/'.$attachment->owner.'/attachment')}}">
                                            <span class="mailbox-attachment-icon" style="background-color:#fff;">{!!strtoupper($attachment->type)!!}</span>
                                            <div class="mailbox-attachment-info">
                                                <span>
                                                    <b style="word-wrap: break-word;">{!!$attachment->value!!}</b>
                                                    <br/>
                                                    <p>{{\App\Plugins\ServiceDesk\Controllers\Library\UtilityController::getAttachmentSize($attachment->size)}}</p>
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
                        @if($problem->getGeneralByIdentifier('impact'))
                        {{$problem->getGeneralByIdentifier('impact')->created_at}}
                        @endif
                        <div class="row">
                            <div class="col-md-offset-11">
                                {!! $delete_impact_popup !!}
                                &nbsp;<a href="#delete" data-toggle="modal" data-target="#impact{{$problem->id}}"><i class="fa fa-pencil"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-body" style="padding-left:30px;margin-bottom:-20px">

                        {!! ucfirst($impact) !!}
                    </div>
                </div>
                @if($problem->generalAttachments('impact')->count()>0)
                <br><br>
                <div class="timeline-footer" style="margin-bottom:-5px">
                    <div class="row">
                        @foreach($problem->generalAttachments('impact') as $attachment)
                        <?php
                        $deleteid = $attachment->id;
                        $deleteurl = url('service-desk/delete/' . $attachment->id . '/' . $attachment->owner . '/attachment');
                        ?>
                        @include('service::interface.agent.popup.delete')
                        <div class="col-md-3">
                            <ul class="list-unstyled clearfix mailbox-attachments">
                                    <li>
                                        <a href="{{url('service-desk/download/'.$attachment->id.'/'.$attachment->owner.'/attachment')}}">
                                            <span class="mailbox-attachment-icon" style="background-color:#fff;">{!!strtoupper($attachment->type)!!}</span>
                                            <div class="mailbox-attachment-info">
                                                <span>
                                                    <b style="word-wrap: break-word;">{!!$attachment->value!!}</b>
                                                    <br/>
                                                    <p>{{\App\Plugins\ServiceDesk\Controllers\Library\UtilityController::getAttachmentSize($attachment->size)}}</p>
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
            @if($symptom!=="")
            <!--symptoms-->
            <li class="time-label">
                <p> &nbsp; </p>
                <span class="bg-green">
                    Symptoms
                </span>     
            </li>
            <li>

                <i class="fa fa-battery-0 bg-purple" title="Symptoms"></i>
                <div class="timeline-item">
                    <div class="timeline-header">
                        @if($problem->getGeneralByIdentifier('symptoms'))
                        {{$problem->getGeneralByIdentifier('symptoms')->created_at}}
                        @endif
                        <div class="row">

                            <div class="col-md-offset-11">
                                {!! $delete_symptoms_popup !!}
                                &nbsp;<a href="#delete" data-toggle="modal" data-target="#symptoms{{$problem->id}}"><i class="fa fa-pencil"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-body" style="padding-left:30px;margin-bottom:-20px">

                        {!! ucfirst($symptom) !!}
                    </div>
                    @if($problem->generalAttachments('symptom')->count()>0)
                    <br><br>
                    <div class="timeline-footer" style="margin-bottom:-5px">
                        <div class="row">
                            @foreach($problem->generalAttachments('symptom') as $attachment)
                            <?php
                            $deleteid = $attachment->id;
                            $deleteurl = url('service-desk/delete/' . $attachment->id . '/' . $attachment->owner . '/attachment');
                            ?>
                            @include('service::interface.agent.popup.delete')
                            <div class="col-md-3">
                                <ul class="list-unstyled clearfix mailbox-attachments">
                                    <li>
                                        <a href="{{url('service-desk/download/'.$attachment->id.'/'.$attachment->owner.'/attachment')}}">
                                            <span class="mailbox-attachment-icon" style="background-color:#fff;">{!!strtoupper($attachment->type)!!}</span>
                                            <div class="mailbox-attachment-info">
                                                <span>
                                                    <b style="word-wrap: break-word;">{!!$attachment->value!!}</b>
                                                    <br/>
                                                    <p>{{\App\Plugins\ServiceDesk\Controllers\Library\UtilityController::getAttachmentSize($attachment->size)}}</p>
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
            @if($solution)
            <!--solution-->
            <li class="time-label">
                <p> &nbsp; </p>
                <span class="bg-green">
                    Solution

                </span>     
            </li>
            <li>

                <i class="fa fa-thumbs-up bg-purple" title="Solution"></i>
                <div class="timeline-item">
                    <!--<span  class="time" style="color:#fff;"><i class="fa fa-clock-o"> </i> 25.05.2016 11:01:01</span>-->
                    <div class="timeline-header">
                        <h3>{!! ucfirst($solution_title) !!}</h3>
                        @if($problem->getGeneralByIdentifier('solution'))
                        {{$problem->getGeneralByIdentifier('solution')->created_at}}
                        @endif
                        <div class="row">
                            <div class="col-md-offset-11">
                                {!! $delete_solution_popup !!}
                                &nbsp;<a href="#delete" data-toggle="modal" data-target="#solution{{$problem->id}}"><i class="fa fa-pencil"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="timeline-body" style="padding-left:30px;margin-bottom:-20px">
                        {!! ucfirst($solution) !!}


                    </div>
                    @if($problem->generalAttachments('solution')->count()>0)
                    <br><br>
                    <div class="timeline-footer" style="margin-bottom:-5px">
                        <div class="row">
                            @foreach($problem->generalAttachments('solution') as $attachment)
                            <?php
                            $deleteid = $attachment->id;
                            $deleteurl = url('service-desk/delete/' . $attachment->id . '/' . $attachment->owner . '/attachment');
                            ?>
                            @include('service::interface.agent.popup.delete')
                            <div class="col-md-3">
                                <ul class="list-unstyled clearfix mailbox-attachments">
                                    <li>
                                        <a href="{{url('service-desk/download/'.$attachment->id.'/'.$attachment->owner.'/attachment')}}">
                                            <span class="mailbox-attachment-icon" style="background-color:#fff;">{!!strtoupper($attachment->type)!!}</span>
                                            <div class="mailbox-attachment-info">
                                                <span>
                                                    <b style="word-wrap: break-word;">{!!$attachment->value!!}</b>
                                                    <br/>
                                                    <p>{{\App\Plugins\ServiceDesk\Controllers\Library\UtilityController::getAttachmentSize($attachment->size)}}</p>
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
            @if($problem->change())
            <!--solution-->
            <li class="time-label">
                <p> &nbsp; </p>
                <span class="bg-green">
                    Change
                </span>     
            </li>
            <li>

                <i class="fa fa-refresh bg-purple" title="change"></i>
                <div class="timeline-item">
                    <!--<span  class="time" style="color:#fff;"><i class="fa fa-clock-o"> </i> 25.05.2016 11:01:01</span>-->


                    <div class="timeline-body" style="padding-left:30px;margin-bottom:-20px">
                        <a href="{{url('service-desk/changes/'.$problem->change()->id.'/show')}}">{!! ucfirst(str_limit($problem->change()->subject,20)) !!}</a>
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