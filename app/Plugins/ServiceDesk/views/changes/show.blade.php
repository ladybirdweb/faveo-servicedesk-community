@extends('themes.default1.agent.layout.agent')
@section('content')
<section class="content-header">
    
</section>
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">
            {{str_limit(ucfirst($change->subject),20)}}  

        </h3>
        <div class="pull-right">
            <!-- <button type="button" class="btn btn-default"><i class="fa fa-edit" style="color:green;"> </i> Edit</button> -->

            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-spinner fa-spin" style="color:teal; display:none;" id="spin"></i>
                    Update <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="#reason"  data-toggle="modal" data-target="#reason{{$change->id}}">Reason for Change</a></li>
                    <li><a href="#changeimpact"  data-toggle="modal" data-target="#changeimpact{{$change->id}}">Impact</a></li>
                    <li><a href="#rollout" data-toggle="modal" data-target="#rollout{{$change->id}}">Rollout Plan</a></li>
                    <li><a href="#backout" data-toggle="modal" data-target="#backout{{$change->id}}">Backout Plan</a></li>
                </ul>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-spinner fa-spin" style="color:teal; display:none;" id="spin"></i>
                    Release <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    @if(!$change->release())
                    <li><a href="#releasenew"  data-toggle="modal" data-target="#releasenew{{$change->id}}">New Release</a></li>
                    <li><a href="#releaseold"  data-toggle="modal" data-target="#releaseold{{$change->id}}">Existing Release</a></li>
                    @else 
                    <li><a href="#release-detach"  data-toggle="modal" data-target="#deleterelease-detach{{$change->id}}">Deatach {{str_limit($change->release()->subject,5)}}</a></li>
                    @endif
                </ul>
            </div>


            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-spinner fa-spin" style="color:teal; display:none;" ></i>

                    More <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="{{url('service-desk/changes/'.$change->id.'/edit')}}">{{Lang::get('service::lang.edit')}}</a></li>
                    <li><a href="#delete" data-toggle="modal" data-target="#delete{{$change->id}}">Delete</a></li>
                    @if($change->status_id=='1')
                    <li><a href="{{url('service-desk/changes/'.$change->id.'/close')}}">Close </a></li>
                    @endif

                </ul>
            </div>


        </div>
    </div>
    <!-- ticket details Table -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{Session::get('success')}}
                </div>
                @endif
                <!-- fail message -->
                @if(Session::has('fails'))
                <div class="alert alert-danger alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <b>{{Lang::get('message.alert')}}!</b> {{Lang::get('message.failed')}}.
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{Session::get('fails')}}
                </div>
                @endif
                
                @include('service::changes.popup.reason')
                @include('service::changes.popup.impact')
                @include('service::changes.popup.rollout-plan')
                @include('service::changes.popup.backout-plan')
                @include('service::changes.popup.release')
                @include('service::changes.popup.release-list')
                @if($change->release())
                <?php 
                $id = "release-detach$change->id";
                $url = url('service-desk/changes/'.$change->id.'/detach');
                $title = "Detach ".str_limit($change->release()->subject,5);
                $detach_pop = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::deletePopUp($id, $url, $title," ","Deatach ".str_limit($change->release()->subject,5),false);
                echo $detach_pop;
                $delete_changeid = "$change->id";
                $delete_change_url = url('service-desk/changes/'.$change->id.'/delete');
                $delete_change_title = "Delete ".str_limit($change->subject,5);
                $delete_pop = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::deletePopUp($delete_changeid, $delete_change_url, $delete_change_title," "," ",false);
                echo $delete_pop;
                ?>
                @endif

            </div>
        </div>

        <div class="row">
            <section class="content">
                <div class="col-md-12">
                    <div class="callout callout-info">
                        <div class="row">

                            <div class="col-md-3">
                                <b>Created Date: </b> 
                                {!! $change->created_at->format('Y-m-d') !!}
                            </div>
                            <div class="col-md-3">
                                <b>Status: </b>
                                {!!$change->statuses()!!} 
                            </div>
                            <div class="col-md-3">
                                <b>Requester: </b> 
                                {!!$change->requesters()!!}
                            </div>
                            <div class="col-md-3">
                                <b>Priority:</b> 
                                {!!$change->priorities()!!}
                            </div>
                        </div>
                    </div>
                </div>

                <div id="hide2">
                    <div class="col-md-6">
                        <table class="table table-hover">
                            <tbody>

                                <tr>
                                    <td><b>Change Type:</b></td>   
                                    <td>{!!$change->changeTypes()!!}</td>
                                </tr>
                                <tr>
                                    <td><b>Location:</b></td> 
                                    <td>{!!$change->locations()!!}</td>
                                </tr>

                                <tr>
                                    <td><b>{{Lang::get('service::lang.asset')}}</b></td>
                                    <td>
                                        {!!$change->getAssets()!!}
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">

                        <table class="table table-hover">
                            <tbody>    
                                <tr>
                                    <td><b>Impact:</b></td>
                                    <td>
                                        {!!$change->impacts()!!}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>CAB:</b></td>  
                                    <td>{!!$change->approvers()!!}</td>
                                </tr>
                                

                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@if($change->tickets()->count()>0)
    @include('service::changes.tickets')
@endif
@include('service::changes.timeline')
@stop
@section('FooterInclude')
<script src="{{asset("lb-faveo/plugins/moment-develop/moment.js")}}" type="text/javascript"></script>
<script src="{{asset("lb-faveo/js/bootstrap-datetimepicker4.7.14.min.js")}}" type="text/javascript"></script>

<script type="text/javascript">
    $(function () {
        $('#plan_start_date').datetimepicker({
            format: 'YYYY/MM/DD'
        });
        $('#plan_end_date').datetimepicker({
            format: 'YYYY/MM/DD'
        });
    });
</script>
@stop