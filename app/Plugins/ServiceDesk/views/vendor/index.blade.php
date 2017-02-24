@extends('themes.default1.admin.layout.admin')
@section('content')



<section class="content-header">
    <h1> Vendor </h1>

</section>
<section class="content">
    @if (Session::has('message'))
    <div class="alert alert-success fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <p>{{ Session::get('message') }}</p>
    </div>
    @endif
    <div class="row">
        <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
            <div class="box">
                <div class="box-header">
                    <!--                                <h3 class="box-title">List of Service Provider</h3>-->
                    <div class="pull-right">
                        <a href="{!!URL::route('service-desk.vendor.create')!!}" class="btn btn-primary">New vendor </a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    {!! Datatable::table()
                    ->addColumn(
                    Lang::get('service::lang.name'),
                    Lang::get('service::lang.primary_contact'),
                    Lang::get('service::lang.email'),

                    Lang::get('service::lang.address'),

                    Lang::get('service::lang.status'),
                    Lang::get('service::lang.action'))
                    ->setUrl('get-vendors')  // this is the route where data will be retrieved
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