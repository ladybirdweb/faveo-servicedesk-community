@extends('themes.default1.agent.layout.agent')
@section('content')
<section class="content-header">
    
</section>
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">
            {{str_limit(ucfirst($problem->subject),20)}}  

        </h3>
        <div class="pull-right">
            <!-- <button type="button" class="btn btn-default"><i class="fa fa-edit" style="color:green;"> </i> Edit</button> -->

            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-spinner fa-spin" style="color:teal; display:none;" id="spin"></i>
                    Update <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="#rootcause"  data-toggle="modal" data-target="#rootcause{{$problem->id}}">Root Cause</a></li>
                    <li><a href="#impact"  data-toggle="modal" data-target="#impact{{$problem->id}}">Impact</a></li>
                    <li><a href="#symptoms" data-toggle="modal" data-target="#symptoms{{$problem->id}}">Symptoms</a></li>
                    <li><a href="#solution" data-toggle="modal" data-target="#solution{{$problem->id}}">Solution</a></li>
                </ul>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-spinner fa-spin" style="color:teal; display:none;" id="spin"></i>
                    Change <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    @if(!$problem->change())
                    <li><a href="#changenew"  data-toggle="modal" data-target="#changenew{{$problem->id}}">New Change</a></li>
                    <li><a href="#changeold"  data-toggle="modal" data-target="#changeold{{$problem->id}}">Existing Change</a></li>
                    @else 
                    <li><a href="#change-detach"  data-toggle="modal" data-target="#change-detach{{$problem->id}}">Deatach {{str_limit($problem->change()->subject,5)}}</a></li>
                    @endif
                </ul>
            </div>


            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-spinner fa-spin" style="color:teal; display:none;" ></i>

                    More <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="{{url('service-desk/problem/'.$problem->id.'/edit')}}">{{Lang::get('service::lang.edit')}}</a></li>
                    <li><a href="#delete" data-toggle="modal" data-target="#delete{{$problem->id}}">Delete</a></li>
                    @if($problem->status_type_id=='1')
                    <li><a href="{{url('service-desk/problem/'.$problem->id.'/close')}}">Close </a></li>
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
                
                @include('service::problem.popup.rootcause')
                @include('service::problem.popup.impact')
                @include('service::problem.popup.symptoms')
                @include('service::problem.popup.solution')
                @include('service::problem.popup.delete')
                @include('service::problem.popup.change')
                @include('service::problem.popup.change-list')
                @if($problem->change())
                @include('service::problem.popup.detach-change')
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
                                {!! $problem->created_at->format('Y-m-d') !!}
                            </div>
                            <div class="col-md-3">
                                <b>Status: </b>
                                {!!$problem->statuses()!!} 
                            </div>
                            <div class="col-md-3">
                                <b>Requester: </b> 
                                {!!$problem->requesters()!!}
                            </div>
                            <div class="col-md-3">
                                <b>{{Lang::get('service::lang.assigned_id')}}:</b> 
                                {!!$problem->assigneds()!!}
                            </div>
                        </div>
                    </div>
                </div>

                <div id="hide2">
                    <div class="col-md-6">
                        <table class="table table-hover">
                            <tbody>

                                <tr>
                                    <td><b>Priority:</b></td>   
                                    <td>{!!$problem->prioritys()!!}</td>
                                </tr>
                                <tr>
                                    <td><b>Department:</b></td> 
                                    <td>{!!$problem->departments()!!}</td>
                                </tr>

                                <tr>
                                    <td><b>{{Lang::get('service::lang.asset')}}</b></td>
                                    <td>
                                        {!!$problem->getAssets()!!}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>{{Lang::get('lang.organization')}}</b></td>
                                    <td>
                                        {!!$problem->organization()!!}
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">

                        <table class="table table-hover">
                            <tbody>    
                                <tr>
                                    <td><b>{{Lang::get('service::lang.location')}}:</b></td>
                                    <td>
                                        {!!$problem->locations()!!}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Impact:</b></td>  
                                    <td>{!!$problem->impacts()!!}</td>
                                </tr>
                                <tr>
                                    <td><b>{{Lang::get('service::lang.group')}}:</b></td>
                                    <td>
                                        {!!$problem->groups()!!}
                                    </td>
                                </tr>



                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@if($problem->tickets()->count()>0)
@include('service::problem.tickets')
@endif
@include('service::problem.timeline')


@stop