@extends('themes.default1.agent.layout.agent')
@section('content')

<section class="content-heading-anchor">
    <h2>
        {{Lang::get('service::lang.show-problem')}}  


    </h2>

</section>


<!-- Main content -->

<div class="box box-primary">
    <div class="box-header with-border">
        <h4> 
            {{str_limit($problem->subject,20)}}  
            <a href="{{url('service-desk/problem/'.$problem->id.'/edit')}}" class="btn btn-default">{{Lang::get('service::lang.edit')}}</a>
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

                        <td>{{Lang::get('service::lang.requester')}}</td>
                        <td>
                            {!!$problem->requesters()!!}
                        </td>

                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.status')}}</td>
                        <td>
                            {!!$problem->statuses()!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.department')}}</td>
                        <td>
                            {!!$problem->departments()!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.impact')}}</td>
                        <td>
                            {!!$problem->impacts()!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.location')}}</td>
                        <td>
                            {!!$problem->locations()!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.priority')}}</td>
                        <td>
                            {!!$problem->prioritys()!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.group')}}</td>
                        <td>
                            {!!$problem->groups()!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.assigned_id')}}</td>
                        <td>
                            {!!$problem->assigneds()!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.asset')}}</td>
                        <td>
                            {!!$problem->assets()!!}
                        </td>
                    </tr>
<!--                    <tr>
                        <td>{{Lang::get('service::lang.description')}}</td>
                        <td id="description">
                            {!!$problem->descriptions()!!}
                        </td>
                    </tr>-->
                </table>
            </div>
            <div class="col-md-12">
                <h3>{{Lang::get('service::lang.description')}}</h3>
                <p id="description"> {!!$problem->descriptions()!!}</p>
            </div>
            <div class="col-md-12">
                <h3>{{Lang::get('service::lang.attachment')}}</h3>
            </div>
            @forelse($problem->attachments() as $attachment)
            <div class="col-md-3">
                {{$attachment->value}}
            </div>
            @empty 
            <div class="col-md-12">
                <p>No Attachments</p>
            </div>
            @endforelse
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
@stop
@section('FooterInclude')
<script>
$(document).ready(function(){
    $("#show-description").on('click',function(){
       $("#description").html("{!! $problem->description !!}");
    });
});
</script>
@stop
