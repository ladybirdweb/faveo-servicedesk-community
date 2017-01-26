@extends('themes.default1.agent.layout.agent')
@section('content')

<section class="content-heading-anchor">
    <h2>
        {{Lang::get('service::lang.edit_problem')}} 
    </h2>

</section>


<!-- Main content -->

<div class="box box-primary">
    <div class="box-header with-border">
        <h4> 
            {{str_limit($problem->subject,20)}}  
            <a href="{{url('service-desk/problem/'.$problem->id.'/show')}}" class="btn btn-default">{{Lang::get('service::lang.show')}}</a>
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
        {!! Form::model($problem,['url'=>'service-desk/problem/'.$problem->id,'method'=>'patch','files'=>true]) !!}
    </div><!-- /.box-header -->
    <!-- form start -->

    <!--<form action="{!!URL::route('service-desk.problem.postcreate')!!}"  method="post" role="form">-->
    <div class="box-body">

        <div class="row">
            <!--<div class="col-md-6">-->
            
            <div class="form-group col-md-6 {{ $errors->has('subject') ? 'has-error' : '' }} ">
                <label class="control-label">{{Lang::get('service::lang.subject')}}</label>
                {!! Form::text('subject',null,['class'=>'form-control']) !!}
                <!--<input type="text" class="form-control" name="subject" id="inputPassword3" value="From">-->
            </div>
            
            <div class="form-group col-md-6 {{ $errors->has('from') ? 'has-error' : '' }}">
                <label for="inputPassword3" class="control-label">{{Lang::get('service::lang.from')}}</label>
                {!! Form::select('from',$from,null,['class'=>'form-control','placeholder'=>'Email address']) !!}
                <!--<input type="text" class="form-control" name="from" id="inputPassword3" value="From">-->
            </div>
            
            <div class="form-group col-md-6 {{ $errors->has('department') ? 'has-error' : '' }}">
                <label class="control-label">{{Lang::get('service::lang.department')}}</label>
                {!! Form::select('department',$departments,null,['class'=>'form-control']) !!}
                <!--<input type="text" class="form-control" name="department" id="inputPassword3" value="Department">-->

            </div> 
            
            <div class="form-group col-md-6 {{ $errors->has('impact_id') ? 'has-error' : '' }}">
                <label class="control-label">{{Lang::get('service::lang.impact')}}</label>
                {!! Form::select('impact_id',$impact_ids,null,['class'=>'form-control']) !!}
            </div>

            <div class="form-group col-md-6 {{ $errors->has('status_type_id') ? 'has-error' : '' }}">
                <label class="control-label">{{Lang::get('service::lang.status')}}</label>
                {!! Form::select('status_type_id',$status_type_ids,null,['class'=>'form-control']) !!}
            </div>
            <div class="form-group col-md-6 {{ $errors->has('location_type_id') ? 'has-error' : '' }}">
                <label class="control-label">{{Lang::get('service::lang.location_type_id')}}</label>
                {!! Form::select('location_type_id',$location_type_ids,null,['class'=>'form-control']) !!}
            </div>
            <div class="form-group col-md-6 {{ $errors->has('priority_id') ? 'has-error' : '' }}">
                <label class="control-label">{{Lang::get('service::lang.priority')}}</label>
                {!! Form::select('priority_id',$priority_ids,null,['class'=>'form-control']) !!}
            </div>
            
            <div class="form-group col-md-6 {{ $errors->has('group') ? 'has-error' : '' }}">
                <label class="control-label">{{Lang::get('service::lang.select_group')}}</label>
                {!! Form::select('group',$group_ids,null,['class'=>'form-control']) !!}
            </div>
            
            
            <div class="form-group col-md-6{{ $errors->has('assigned') ? 'has-error' : '' }}">
                <label class="control-label">{{Lang::get('service::lang.assigned-to')}}</label>
                {!! Form::select('assigned',$assigned_ids,null,['class'=>'form-control']) !!}
            </div>
            
            <div class="form-group col-md-6{{ $errors->has('assets') ? 'has-error' : '' }}">
                <label class="control-label">{{Lang::get('service::lang.attach-asset')}}</label>
                {!! Form::select('asset',$assets,null,['class'=>'form-control']) !!}
            </div>
            
            <div class="form-group col-md-12 {{ $errors->has('description') ? 'has-error' : '' }}">
                <label for="internal_notes" class="control-label">{{Lang::get('service::lang.description')}}</label>
                {!! Form::textarea('description',null,['class'=>'form-control','id'=>'description']) !!}
                <!--<textarea class="form-control textarea" placeholder="Description" name="description" rows="7" id="" style="width: 97%; margin-left:14px;"></textarea>-->
            </div>
            
            <div class="form-group col-md-6{{ $errors->has('attachment') ? 'has-error' : '' }}">
                <label class="control-label">{{Lang::get('service::lang.attachment')}}</label>
                {!! Form::file('attachment[]',['multiple'=>true]) !!}
            </div>
            
        </div>   
        <!--</div>-->
        <!--/row-->
    </div>
    <div class="box box-footer">
        {!! Form::submit(Lang::get('service::lang.edit_problem'),['class'=>'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
</div>
<!-- team lead -->
<script>
    $(function () {
        $("#description").wysihtml5();
    });
</script>
@stop
