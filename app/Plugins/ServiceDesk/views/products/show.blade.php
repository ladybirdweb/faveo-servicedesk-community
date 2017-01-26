@extends('themes.default1.agent.layout.agent')
@section('content')
<section class="content-header">
    
</section>
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">
            {{str_limit(ucfirst($product->name),20)}}  

        </h3>
        <div class="pull-right">
            <div class="btn-group">
                <a href="{{url('service-desk/products/'.$product->id.'/edit')}}" class="btn btn-primary">{{Lang::get('service::lang.edit')}}</a>
            </div>
            <div class="btn-group">
                <?php
                $url = url('service-desk/products/'.$product->id.'/delete');
                $delete = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::deletePopUp($product->id, $url, "Delete $product->name", "btn btn-danger");
                ?>
                {!! $delete !!}
            </div>
        </div>
    </div>

    <!-- ticket details Table -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
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

            </div>
        </div>

        <div class="row">
            <section class="content">
                <div class="col-md-12">
                    <div class="callout callout-info">
                        <div class="row">

                            <div class="col-md-4">
                                <b>{{Lang::get('service::lang.name')}}:</b> 
                                {!!$product->name!!}
                            </div>
                            <div class="col-md-4">
                                <b>{{Lang::get('service::lang.status')}}: </b>
                                {!!$product->statuses()!!}
                            </div>
                            <div class="col-md-4">
                                <b>{{Lang::get('service::lang.manufacturer')}}: </b> 
                                {!!$product->manufacturer!!}
                            </div>

                        </div>
                    </div>
                </div>

                <div id="hide2">
                    <div class="col-md-6">
                        <table class="table table-hover">
                            <tbody>

                                <tr>
                                    <td><b>{{Lang::get('service::lang.product_status')}}:</b></td>
                                    <td>
                                        {!!$product->productStatuses()!!}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>{{Lang::get('service::lang.product_mode_procurement')}}:</b></td>
                                    <td>
                                        {!!$product->procurements()!!}
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">

                        <table class="table table-hover">
                            <tbody>    
                                <tr>
                                    <td><b>{{Lang::get('service::lang.department_access')}}:</b></td>
                                    <td>
                                        {!!$product->departments()!!}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>{{Lang::get('service::lang.description')}}:</b></td>
                                    <td>
                                        {!!$product->descriptions()!!}
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@if($product->assets()->count()>0)
@include('service::products.asset')
@endif
@include('service::products.vendor')


@stop