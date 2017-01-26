@extends('themes.default1.admin.layout.admin')
@section('content')


<!-- Main content -->
<section class="content-header">
    <h1> Product Procurements </h1>

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
                        <a href="{!!URL::route('service-desk.procurment.create')!!}" class="btn btn-primary">New Product Procurement </a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    {!! Datatable::table()
                    ->addColumn(

                    Lang::get('service::lang.name'),

                    Lang::get('service::lang.action'))  // these are the column headings to be shown
                    ->setUrl('get-procurement')  // this is the route where data will be retrieved
                    ->render() !!}

                </div>
            </div>
        </div>
    </div>
</section>
@stop

