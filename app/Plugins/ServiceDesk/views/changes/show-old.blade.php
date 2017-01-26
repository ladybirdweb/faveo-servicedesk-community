@extends('themes.default1.agent.layout.agent')
@section('content')

<section class="content-heading-anchor">
    <h2>
        {{Lang::get('service::lang.show-change')}}  


    </h2>

</section>


<!-- Main content -->

<div class="box box-primary">
    <div class="box-header with-border">
        <h4> 
            {{str_limit($change->subject,20)}}  
            <a href="{{url('service-desk/changes/'.$change->id.'/edit')}}" class="btn btn-default">{{Lang::get('service::lang.edit')}}</a>
        </h4>
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
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">


                <!-- /.box-header -->

                <table class="table table-condensed">

                    <tr>

                        <td>{{Lang::get('service::lang.subject')}}</td>
                        <td>
                            {!!$change->subject!!}
                        </td>

                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.requester')}}</td>
                        <td>
                            {!!$change->requesters()!!}
                        </td>
                    </tr>

                    <tr>
                        <td>{{Lang::get('service::lang.reason')}}</td>
                        <td>
                            {!!$change->reason!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.approval')}}</td>
                        <td>
                            {!!$change->approvers()!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.backout_plan')}}</td>
                        <td>
                            {!!$change->backout_plan!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.release_type')}}</td>
                        <td>
                            {!!$change->rollout_plan!!}
                        </td>
                    </tr>
                    
                    <tr>
                        <td>{{Lang::get('service::lang.status')}}</td>
                        <td>
                            {!!$change->statuses()!!}
                        </td>
                    </tr>

                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.priority')}}</td>
                        <td>
                            {!!$change->priorities()!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.change_type')}}</td>
                        <td>
                            {!!$change->changeTypes()!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.location')}}</td>
                        <td>
                            {!!$change->locations()!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.impact_type')}}</td>
                        <td>
                            {!!$change->impacts()!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.asset')}}</td>
                        <td>
                            {!!$change->getAssets()!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.description')}}</td>
                        <td>
                            {!!$change->descriptions()!!}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-12">
                <h3>{{Lang::get('service::lang.attachment')}}</h3>
            </div>
            @forelse($change->attachments() as $attachment)
            <div class="col-md-3">
                {{$attachment->value}}
            </div>
            @empty 
            <div class="col-md-12">
                <p>No Attachments</p>
            </div>
            @endforelse

        </div>
        <!-- /.box -->
    </div>
</div>


@stop
