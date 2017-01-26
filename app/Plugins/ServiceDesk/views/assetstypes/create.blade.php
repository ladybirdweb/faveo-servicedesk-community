@extends('themes.default1.admin.layout.admin')
@section('content')

<section class="content-heading-anchor">
    <h2>
        {{Lang::get('service::lang.new_assetstypes')}}  


    </h2>

</section>

<!-- Main content -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h4> {{Lang::get('service::lang.open_new_assets_type')}} </h4>
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
        {!! Form::open(['url'=>'service-desk/assetstypes/create','method'=>'post','files'=>true]) !!}
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="form-group col-md-6 {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name" class="control-label">{{Lang::get('service::lang.name')}}</label>
                {!! Form::text('name',null,['class'=>'form-control'])  !!}
                <!--<input type="text" class="form-control" id="name" name="assets_type_name" placeholder="Name">-->
            </div>
            <div class="form-group col-md-6 {{ $errors->has('parent_id') ? 'has-error' : '' }}">
                <label for="parent_id" class="control-label">{{Lang::get('service::lang.parent')}}</label>
                {!! Form::select('parent_id',[''=>'Select','Types'=>$types],null,['class'=>'form-control'])  !!}
                <!--<input type="text" class="form-control" id="name" name="assets_type_name" placeholder="Name">-->

            </div>
            <div class="form-group col-md-6 {{ $errors->has('form') ? 'has-error' : '' }}">
                <label for="name" class="control-label">{{Lang::get('service::lang.form')}}</label>
                {!! Form::select('form',[''=>'Select','Custom Form'=>$forms],null,['class'=>'form-control'])  !!}
                <!--<input type="text" class="form-control" id="name" name="assets_type_name" placeholder="Name">-->

            </div> 
        </div>
    </div>
    <div class="box-footer">

        <input type="submit" value="{{Lang::get('service::lang.add_assetstypes')}}" class="btn btn-primary">
        {!! Form::close() !!}
    </div>


</div>


@stop