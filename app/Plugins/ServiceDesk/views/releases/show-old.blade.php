@extends('themes.default1.agent.layout.agent')
@section('content')

<section class="content-heading-anchor">
    <h2>
        {{Lang::get('service::lang.show-release')}}  


    </h2>

</section>


<!-- Main content -->

<div class="box box-primary">
    <div class="box-header with-border">
        <h4> 
            {{str_limit($release->subject,20)}}  
            <a href="{{url('service-desk/releases/'.$release->id.'/edit')}}" class="btn btn-default">{{Lang::get('service::lang.edit')}}</a>
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
                            {!!$release->subject!!}
                        </td>

                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.planed_start_date')}}</td>
                        <td>
                            {!!$release->planned_start_date!!}
                        </td>
                    </tr>

                    <tr>
                        <td>{{Lang::get('service::lang.planed_end_date')}}</td>
                        <td>
                            {!!$release->planned_end_date!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.status')}}</td>
                        <td>
                            {!!$release->statuses()!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.priority')}}</td>
                        <td>
                            {!!$release->priorities()!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.release_type')}}</td>
                        <td>
                            {!!$release->releaseTypes()!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.location')}}</td>
                        <td>
                            {!!$release->locations()!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.build_plan')}}</td>
                        <td>
                            {!!$release->build_plan!!}
                        </td>
                    </tr>

                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.test_plan')}}</td>
                        <td>
                            {!!$release->test_plan!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.test_plan')}}</td>
                        <td>
                            {!!$release->test_plan!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.description')}}</td>
                        <td>
                            {!!$release->descriptions()!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.assets')}}</td>
                        <td>
                            {!!$release->getAssets()!!}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-12">
                <h3>{{Lang::get('service::lang.attachment')}}</h3>
            </div>
            @forelse($release->attachments() as $attachment)
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
