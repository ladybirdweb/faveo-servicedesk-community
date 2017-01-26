@extends('themes.default1.admin.layout.admin')

@section('content')

<section class="content-header">
    <h1>{{Lang::get('service::lang.location')}} </h1>

</section>

<!-- Main content -->
<section class="content">
    @if (Session::has('message'))
    <div class="alert alert-success fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <p>{{ Session::get('message') }}</p>
    </div>
    @endif
    <div class="row">
        <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4>{{Lang::get('service::lang.list_of_location')}}</h4>
                    <div class="pull-right">

                        <a href="{!!URL::route('service-desk.location.create')!!}" class="btn btn-primary">{{Lang::get('service::lang.new_location')}}</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    {!! Datatable::table()
                    ->addColumn( 
                    Lang::get('service::lang.location_catagory_name'),
                    Lang::get('service::lang.title'),
                    Lang::get('service::lang.email'),
                    Lang::get('service::lang.phone'),
                    Lang::get('service::lang.address'),
                    Lang::get('service::lang.action'))

                    ->setUrl('get-location-types')  // this is the route where data will be retrieved
                    ->render() !!}



                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
</section>
<!-- /.content -->
</div>

@stop