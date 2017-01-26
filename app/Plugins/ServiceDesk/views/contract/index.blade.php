@extends('themes.default1.admin.layout.admin')
@section('content')


<!-- Main content -->
<section class="content-header">
    <h1> Contracts </h1>

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
                        <a href="{!!URL::route('service-desk.contract.create')!!}" class="btn btn-primary">New Contract </a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    {!! Datatable::table()
                    ->addColumn(
                    Lang::get('service::lang.name'),
                    Lang::get('service::lang.cost'),
                    //Lang::get('service::lang.contract_type_id'),
                    //Lang::get('service::lang.vendor_id'),
                    //Lang::get('service::lang.license_type'),
                    //Lang::get('service::lang.licensce_count'),
                    //Lang::get('service::lang.product'),
                    //Lang::get('service::lang.notify_expiry'),
                    //Lang::get('service::lang.contract_start_date'),
                    //Lang::get('service::lang.contract_end_date'),
                    Lang::get('service::lang.action'))  // these are the column headings to be shown
                    ->setUrl('get-contracts')  // this is the route where data will be retrieved
                    ->render() !!}

                </div>
            </div>
        </div>
    </div>
</section>
@stop

