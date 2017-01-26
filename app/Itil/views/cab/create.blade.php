@extends('themes.default1.admin.layout.admin')
@section('content')
<section class="content-header">
    <h1> {{Lang::get('itil::lang.new_cab')}} </h1>

</section>
<div class="box box-primary">

    <div class="box-header with-border">
        <h4> {{Lang::get('itil::lang.create_cab')}} </h4>
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
        {!! Form::open(['url'=>'service-desk/cabs','method'=>'post']) !!}
    </div><!-- /.box-header -->
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="form-group col-md-6 {{ $errors->has('name') ? 'has-error' : '' }}">
                {!! Form::label('name',Lang::get('itil::lang.name')) !!}
                {!! Form::text('name',null,['class'=>'form-control']) !!}             
            </div>
            <div class="form-group col-md-6 {{ $errors->has('head') ? 'has-error' : '' }}">
                {!! Form::label('head',Lang::get('itil::lang.head')) !!}
                {!! Form::select('head',[''=>'Select','Agents'=>$agents],null,['class'=>'form-control']) !!}             
            </div>
            <div class="form-group col-md-6 {{ $errors->has('approvers') ? 'has-error' : '' }}">
                {!! Form::label('approvers',Lang::get('itil::lang.members')) !!}
                {!! Form::select('approvers[]',[''=>'Select','Agents'=>$agents],null,['class'=>'form-control','multiple'=>true]) !!}             
            </div>
            <div class="form-group col-md-6 {{ $errors->has('aproval_mandatory') ? 'has-error' : '' }}">
                <div class="col-md-12">
                    {!! Form::label('aproval_mandatory',Lang::get('itil::lang.approval_mandatory')) !!}
                </div>
                <div class="col-md-12">
                    <p>Approve is mandatory from all selected members</p>
                    <div class="col-md-3">
                        <p> {!! Form::radio('aproval_mandatory',1) !!} Yes</p>
                    </div>
                    <div class="col-md-3">
                        <p> {!! Form::radio('aproval_mandatory',0) !!} No</p>
                    </div>
                </div>             
            </div>

        </div>
        <!-- /.box-body -->
    </div>
    <div class="box-footer">
        {!! Form::submit('Save',['class'=>'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
    <!-- /.box -->
</div>



@stop