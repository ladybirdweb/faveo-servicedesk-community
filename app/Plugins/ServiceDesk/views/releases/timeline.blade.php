<?php
$build = "";
$test = "";
$table = $release->table();
$owner = "$table:$release->id";
if ($release->getGeneralByIdentifier('build-plan')) {
    $build = $release->getGeneralByIdentifier('build-plan')->value;

    $delete_reason_url = url('service-desk/general/' . $owner . '/build-plan/delete');
    $popid = "build-plan$release->id";
    $title = "Delete Build Plan";
    $delete_build_popup = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::deletePopUp($popid, $delete_reason_url, $title, "fa fa-remove", " ");
}
if ($release->getGeneralByIdentifier('test-plan')) {
    $test = $release->getGeneralByIdentifier('test-plan')->value;
    $delete_impact_url = url('service-desk/general/' . $owner . '/test-plan/delete');
    $popid = "test-plan$release->id";
    $title = "Delete Test Plan";
    $delete_test_popup = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::deletePopUp($popid, $delete_impact_url, $title, "fa fa-remove", " ");
}
?>
<div class="row">

    <div class="col-md-12">
        <!-- The time line -->
        <ul class="timeline">

            @if($build!=="")
            <!--root-cause-->
            <li class="time-label">
                <p> &nbsp; </p>
                <span class="bg-green">
                    Build Plan
                </span> 

            </li>

            <li>

                <i class="fa fa-cubes bg-purple" title="Build Paln"></i>
                <div class="timeline-item">
                    <div class="timeline-header">
                        @if($release->getGeneralByIdentifier('build-plan'))
                        {{$release->getGeneralByIdentifier('build-plan')->created_at}}
                        @endif
                        <div class="row">
                            <div class="col-md-offset-11">
                                {!! $delete_build_popup !!}
                                &nbsp;<a href="#delete" data-toggle="modal" data-target="#build-plan{{$release->id}}"><i class="fa fa-pencil"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="timeline-body" style="padding-left:30px;margin-bottom:-20px">

                        {!! ucfirst($build) !!}
                    </div>
                    @if($release->generalAttachments('build-plan')->count()>0)
                    <br><br>
                    <div class="timeline-footer" style="margin-bottom:-5px">
                        <div class="row">
                            @foreach($release->generalAttachments('build-plan') as $attachment)
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
            @if($test!=="")
            <!--impact-->
            <li class="time-label">
                <p> &nbsp; </p>
                <span class="bg-green">
                    Test Plan
                </span>     
            </li>
            <li>

                <i class="fa fa-adjust bg-purple" title="Test Plan"></i>
                <div class="timeline-item">
                    <div class="timeline-header">
                        @if($release->getGeneralByIdentifier('test-plan'))
                        {{$release->getGeneralByIdentifier('test-plan')->created_at}}
                        @endif
                        <div class="row">
                            <div class="col-md-offset-11">
                                {!! $delete_test_popup !!}
                                &nbsp;<a href="#delete" data-toggle="modal" data-target="#test-plan{{$release->id}}"><i class="fa fa-pencil"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-body" style="padding-left:30px;margin-bottom:-20px">

                        {!! ucfirst($test) !!}
                    </div>
                
                @if($release->generalAttachments('test-plan')->count()>0)
                <br><br>
                <div class="timeline-footer" style="margin-bottom:-5px">
                    <div class="row">
                        @foreach($release->generalAttachments('test-plan') as $attachment)
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
        </ul>
    </div>
</div>