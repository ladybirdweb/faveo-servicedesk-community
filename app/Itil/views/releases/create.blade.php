@extends('themes.default1.agent.layout.agent')
@section('content')

<section class="content-heading-anchor">
    <h2>
        {{Lang::get('itil::lang.new_release')}}  

    </h2>

</section>

<div class="box box-primary">
    <div class="box-header with-border">
        <h4>{{Lang::get('itil::lang.open_new_release')}} </h4>
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
        {!! Form::open(['url'=>'service-desk/releases/create','method'=>'post','files'=>true]) !!}
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="row">

            <div class="form-group col-md-6 {{ $errors->has('subject') ? 'has-error' : '' }}">
                <label for="Subject" class="control-label">{{Lang::get('itil::lang.subject')}}</label>
                {!! Form::text('subject',null,['class'=>'form-control']) !!}
                <!--<input type="text" name="subject" class="form-control" id="" placeholder="Subject....">-->

            </div>
            <div class="form-group col-md-6 {{ $errors->has('plan_start_date') ? 'has-error' : '' }}">

                <label for="inputEmail3" class="control-label">{{Lang::get('itil::lang.planed_start_date')}}</label>
                {!! Form::text('planned_start_date',null,['class'=>'form-control','id'=>'plan_start_date']) !!}
                <!--<input type="text" name="plan_start_date" class="form-control" id="startdate" placeholder="Startdate">-->
            </div>
            <div class="form-group col-md-6 {{ $errors->has('plan_end_date') ? 'has-error' : '' }}">
                <label for="inputEmail3" class="control-label">{{Lang::get('itil::lang.planed_end_date')}}</label>
                {!! Form::text('planned_end_date',null,['class'=>'form-control','id'=>'plan_end_date']) !!}
                <!--<input type="text"  name="plan_end_date" class="form-control" id="enddate" placeholder="Enddate">-->
            </div>
            <div class="form-group col-md-6 {{ $errors->has('status') ? 'has-error' : '' }}">
                <label class=" control-label">{{Lang::get('itil::lang.status')}}</label>
                {!! Form::select('status_id',$sd_release_status,null,['class'=>'form-control']) !!}

            </div>
            <div class="form-group col-md-6 {{ $errors->has('priority') ? 'has-error' : '' }}">
                <label class=" control-label">{{Lang::get('itil::lang.priority')}}</label>
                {!! Form::select('priority_id',$sd_release_priorities,null,['class'=>'form-control']) !!}

            </div>
            <div class="form-group col-md-6 {{ $errors->has('releasetype') ? 'has-error' : '' }}">
                <label class=" control-label">{{Lang::get('itil::lang.type')}}</label>
                {!! Form::select('release_type_id',$sd_release_types,null,['class'=>'form-control']) !!}

            </div>
            <div class="form-group col-md-6 {{ $errors->has('location') ? 'has-error' : '' }}">
                <label class="control-label">{{Lang::get('itil::lang.location')}}</label>
                {!! Form::select('location_id',$sd_locations,null,['class'=>'form-control']) !!}

            </div>
            @if(isAsset()==true)
            <div class="form-group col-md-6 {{ $errors->has('asset') ? 'has-error' : '' }}">
                <label for="inputEmail3" class="control-label">{{Lang::get('itil::lang.assets')}}</label>
                {!! Form::select('asset[]',$assets,null,['class'=>'form-control','multiple'=>true]) !!}
                <!--<input type="text" name="build_plan" class="form-control" placeholder="Build plan" id="provider-json">-->
            </div>
            @endif
            <div class="form-group col-md-12 {{ $errors->has('description') ? 'has-error' : '' }}">
                <label for="description" class="control-label">{{Lang::get('itil::lang.description')}}</label>
                {!! Form::textarea('description',null,['class'=>'form-control']) !!}
                <!--<textarea class="form-control textarea" name="description" placeholder="Description....."  id="description"></textarea>-->
            </div>
            
            <div class="form-group col-md-6 {{ $errors->has('attachments') ? 'has-error' : '' }}">
                <label for="inputEmail3" class="control-label">{{Lang::get('itil::lang.attachment')}}</label>
                {!! Form::file('attachments[]',null,['multiple'=>true]) !!}
                <!--<input type="text" name="build_plan" class="form-control" placeholder="Build plan" id="provider-json">-->
            </div>


        </div>
        <!--            /end-row-->

        <div class="box-footer" >

            <button type="submit" class="btn btn-success">{{Lang::get('itil::lang.add_release')}}</button>
            {!! Form::close() !!}
        </div><!-- /.box-footer -->

    </div>
</div>


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
