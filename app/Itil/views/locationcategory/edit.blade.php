@extends('themes.default1.admin.layout.admin')
@section('content')
<section class="content-heading-anchor">
    <h2>
        {{Lang::get('itil::lang.edit_location_category')}}  


    </h2>

</section>


<!-- Main content -->

<div class="box box-primary">
    <div class="box-header with-border">
        <h4> {{$sd_location_catagory->name}}  </h4>
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
        {!! Form::model($sd_location_catagory,['url'=>'service-desk/location-category-types/'.$sd_location_catagory->id,'method'=>'patch','files'=>true]) !!}
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">

        <div class="row">
            <!--<div class="col-md-6">-->

            <div class="form-group col-md-6 {{ $errors->has('subject') ? 'has-error' : '' }} ">
                <label class="control-label">{{Lang::get('itil::lang.name')}}</label>
                {!! Form::text('name',null,['class'=>'form-control']) !!}
                <!--<input type="text" class="form-control" name="subject" id="inputPassword3" value="From">-->
            </div>
        </div>
    </div>
    <div class="box box-footer">
        {!! Form::submit(Lang::get('itil::lang.update-location-category'),['class'=>'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
</div>




@stop