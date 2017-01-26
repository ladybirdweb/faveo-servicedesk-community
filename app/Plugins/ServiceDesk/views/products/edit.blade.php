@extends('themes.default1.admin.layout.admin')

@section('content')
@if ( $errors->count() > 0 )
<div class="alert alert-danger" aria-hidden="true">
    <i class="fa fa-ban"></i>
    <b>{!! Lang::get('lang.alert') !!}</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <ul>
        @foreach( $errors->all() as $message )</p>
        <li class="error-message-padding">{{ $message }} </li>
        @endforeach
    </ul>
</div>
@endif
<head>
    <style>
        .control-label:after {
            content:"*";color:red;
        }
    </style>
</head>


<section class="content-header">
    <h1>{{Lang::get('service::lang.edit_product')}}</h1>

</section>

<!-- Main content -->
<div class="box box-primary">
    <div class="box-header with-border">
       <h4> 
            {{ucfirst($product->name)}}  
            <a href="{{url('service-desk/products/'.$product->id.'/show')}}" class="btn btn-default">{{Lang::get('service::lang.show')}}</a>
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
    <!-- form start -->
    <div class="box-body">
        {!! Form::model($product,['url'=>'service-desk/products/'.$product->id,'method'=>'patch']) !!}
        <!--<form action="{!!URL::route('service-desk.post.products')!!}" method="post" role="form"  class="form-horizontal">-->

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
                <label for="name" class="control-label">{{Lang::get('service::lang.name')}}</label>
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    {!! Form::text('name',null,['class'=>'form-control']) !!}
                    <!--<input type="text" class="form-control" name="name" id="" placeholder="{{Lang::get('service::lang.name')}}" >-->
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
                <label class="control-label">{{Lang::get('service::lang.status')}}</label>
                <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                    <!--<div class="row">-->
                    <div class="col-md-6">
                        <p>{!! Form::radio('status',0) !!} Disable</p>
                    </div>
                    <div class="col-md-6">
                        <p>{!! Form::radio('status',1,true) !!} Enable</p>
                    </div>

                    <!--</div>-->
                </div> 
            </div>  

<!--            <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
                <label class=" control-label">{{Lang::get('service::lang.asset_type')}}</label>
                <div class="form-group {{ $errors->has('asset_type') ? 'has-error' : '' }}">
                    {!! Form::select('asset_type',$sd_asset_types,null,['class'=>'form-control']) !!}

                </div>
            </div>-->

        </div> 

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
                <label for="manufacturer" class="control-label">{{Lang::get('service::lang.manufacturer')}}</label>

                <div class="form-group {{ $errors->has('manufacturer') ? 'has-error' : '' }}" >
                    {!! Form::text('manufacturer',null,['class'=>'form-control']) !!}
                    <!--<input type="text" class="form-control"  name="manufacturer" placeholder="{{Lang::get('service::lang.manufacturer')}}">-->
                </div>
            </div>



            <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
                <label class="control-label">{{Lang::get('service::lang.product_status')}}</label>
                <div class="form-group {{ $errors->has('Product_status') ? 'has-error' : '' }}">
                    {!! Form::select('Product_status',$sd_product_status,null,['class'=>'form-control']) !!}

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
                <label class=" control-label">{{Lang::get('service::lang.product_mode_procurement')}}</label>
                <div class="form-group {{ $errors->has('mode_procurement') ? 'has-error' : '' }}">
                    {!! Form::select('mode_procurement',$sd_product_proc_modes,null,['class'=>'form-control']) !!}

                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
                <label for="department_access" class="control-label">{{Lang::get('service::lang.department_access')}}</label>
                <div class="form-group {{ $errors->has('department_access') ? 'has-error' : '' }}">
                    {!! Form::select('department_access',$departments,null,['class'=>'form-control']) !!}

                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
                <label for="description" class="control-label">{{Lang::get('service::lang.description')}}</label>
                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}" >
                    {!! Form::textarea('description',null,['class'=>'form-control']) !!}
                    <!--<textarea class="form-control" name="description"></textarea>--> 
                </div>
            </div>
        </div>

        



        <div class="box-footer">
            <button type="submit" class="btn btn-success">{{Lang::get('service::lang.edit_product')}}</button>
        </div>


        <!-- /.box-footer -->
        {!! Form::close() !!}

    </div>
</div>




@stop

