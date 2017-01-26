@extends('themes.default1.admin.layout.admin')
@section('content')
<link rel="stylesheet" type="text/css" media="screen" href="http://formbuilder.online/assets/css/form-builder.min.css">
<section class="content-header">
    <h1> {{Lang::get('service::lang.forms')}} </h1>
    
</section>
<div class="box box-primary">

    <div class="box-header with-border">
        <h4> {{Lang::get('service::lang.new_form')}} 
            <a href="{{url('service-desk/form-builder/create')}}" class="btn btn-primary pull-right">{{Lang::get('service::lang.new_form')}} </a>
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
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                {!! Datatable::table()
                ->addColumn(

                Lang::get('service::lang.title'),
                Lang::get('service::lang.action'))

                ->setUrl(url('service-desk/form-builder/get-form'))  
                ->render() !!}
            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>



@stop