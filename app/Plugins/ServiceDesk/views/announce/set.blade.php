@extends('themes.default1.admin.layout.admin')
@section('content')
<section class="content-header">
    <h1> Announcement </h1>

</section>
<div class="box box-primary">

    <div class="box-header with-border">
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
        {!! Form::open(['url'=>'service-desk/announcement','method'=>'post','id'=>'from']) !!}
    </div><!-- /.box-header -->
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">

            <div class="col-md-6">
                <p>{!! Form::label('option','Choose any option') !!}</p>
                <div class="col-md-3">
                    <p> {!! Form::radio('option','organization',['class'=>'option']) !!} Organization</p>
                </div>
                <div class="col-md-3">
                    <p> {!! Form::radio('option','department',['class'=>'option']) !!} Department</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" id="organization">
                {!! Form::label('organization','Organization') !!}
                {!! Form::select('organization',[''=>'Select','Organizations'=>$organization],null,['class'=>'form-control']) !!}
            </div>
            <div class="col-md-6" id="department">
                {!! Form::label('department','Department') !!}
                {!! Form::select('department',[''=>'Select','Department'=>$departments],null,['class'=>'form-control']) !!}
            </div>

        </div>

        <div>
            {!! Form::label('announcement','Announcement') !!}
            {!! Form::textarea('announcement',null,['class'=>'form-control']) !!}
        </div>
        <!-- /.box-body -->
    </div>
    <div class="box-footer">
        {!! Form::submit('Send',['class'=>'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
    <!-- /.box -->
</div>
@stop
