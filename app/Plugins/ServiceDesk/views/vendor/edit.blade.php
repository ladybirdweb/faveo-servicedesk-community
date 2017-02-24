@extends('themes.default1.admin.layout.admin')
@section('content')
<section class="content-heading-anchor">
    <h2>
        {{Lang::get('service::lang.edit-vendor')}}  

    </h2>

</section>
<!-- Info boxes -->

<div class="box box-primary">
    <div class="box-header with-border">
         <h4>{{ucfirst($vendor->name)}}  
            <a href="{{url('service-desk/vendor/'.$vendor->id.'/show')}}" class="btn btn-default">{{Lang::get('service::lang.show')}}</a> </h4>
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

        {!! Form::model($vendor,['url'=>'service-desk/vendor/'.$vendor->id,'method'=>'patch']) !!}


        <div class="form-group">


            <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6 form-group">
                <label for="name" class="control-label">{{Lang::get('service::lang.name')}}</label>
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    {!! Form::text('name',null,['class'=>'form-control']) !!}
                    <!--<input type="text" name="name" class="form-control" id="inputPassword3" placeholder="Name">-->
                </div>
            </div>

            <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6 form-group">
                <label for="inputEmail3" class="control-label">{{Lang::get('service::lang.email')}}</label>
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    {!! Form::email('email',null,['class'=>'form-control']) !!}
                    <!--<input type="email" class="form-control" name="email" placeholder="Email">-->
                </div>
            </div>
        </div>


        <div class="form-group">


            <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6 form-group">
                <label for="name" class="control-label">{{Lang::get('service::lang.primary_contact')}}</label>
                <div class="form-group {{ $errors->has('primary_contact') ? 'has-error' : '' }}">
                    {!! Form::text('primary_contact',null,['class'=>'form-control']) !!}
                    <!--<input type="text" name="primary_contact" class="form-control" id="inputPassword3" placeholder="Primary Contact">-->
                </div>
            </div>

            <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6 form-group">
                <label for="inputEmail3" class="control-label">{{Lang::get('service::lang.address')}}</label>
                <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                    {!! Form::text('address',null,['class'=>'form-control']) !!}
                    <!--<input type="text" class="form-control" name="address" placeholder="Address">-->
                </div>
            </div>
        </div>


        <!--<div class="form-group">-->
        <div class="form-group col-xs-6 col-md-6 col-sm-6 col-lg-6 form-group">
            <label for="name" class="control-label">{{Lang::get('service::lang.status')}}</label>
            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                <div class="row">
                    <div class="col-md-6">
                        <p>{!! Form::radio('status',0) !!} Inactive</p>
                    </div>
                    <div class="col-md-6">
                        <p>{!! Form::radio('status',1,true) !!} Active</p>
                    </div>
                </div>
                <!--<input type="text" name="status" class="form-control" id="inputPassword3" placeholder="Status">-->
            </div>
        </div>
        <!--           <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6 form-group">
                        <label for="inputEmail3" class="control-label">{{Lang::get('service::lang.all_department')}}</label>
                        <div class="form-group {{ $errors->has('all_department') ? 'has-error' : '' }}">
                            {!! Form::text('all_department',null,['class'=>'form-control']) !!}
                            <input type="text" class="form-control" name="all_department" placeholder="All Department">
                        </div>
                    </div>-->
        <!--</div>-->

        <div class="row">
            <div class="col-md-12">
                <!--<div class="form-group">-->
                <!--<div class="col-xs-11 col-md-11 col-sm-11 col-lg-11">-->
                <label for="internal_notes" class="control-label">{{Lang::get('service::lang.description')}}</label>
                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                    {!! Form::textarea('description',null,['class'=>'form-control']) !!}
                    <!--<textarea class="form-control textarea" name="description" rows="7" id="" placeholder="description"></textarea>-->
                </div>
                <!--</div>-->
            </div>
            <!--</div>-->

            <div class="col-md-12">
                <div class="box-footer">

                    <button type="submit" class="btn btn-success">{{Lang::get('service::lang.edit-vendor')}}</button>

                </div><!-- /.box-footer -->
            </div>
        </div>
        {!! Form::close() !!}
        <!-- /.content-wrapper -->
    </div> 

</section>        

@stop