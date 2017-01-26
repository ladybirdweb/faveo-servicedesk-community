@if(Auth::user()->role=="admin")
@extends('themes.default1.admin.layout.admin')
@else 
@extends('themes.default1.agent.layout.agent')
@endif
@section('content')
<section class="content-header">
    
</section>
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">
            {{str_limit(ucfirst($contract->name),20)}}  

        </h3>
        <div class="pull-right">
            <div class="btn-group">
                <a href="{{url('service-desk/contracts/'.$contract->id.'/edit')}}" class="btn btn-primary">{{Lang::get('service::lang.edit')}}</a>
            </div>
            <div class="btn-group">
                <?php
                $url = url('service-desk/contracts/' . $contract->id . '/delete');
                $delete = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::deletePopUp($contract->id, $url, "Delete $contract->name", "btn btn-danger");
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

                            <div class="col-md-3">
                                <b>{{Lang::get('service::lang.name')}}:</b> 
                                {!!$contract->name!!}
                            </div>
                            <div class="col-md-4">
                                <b>{{Lang::get('service::lang.contract_type')}}: </b>
                                {!!$contract->contractTypes()!!}
                            </div>
                            <div class="col-md-3">
                                <b>{{Lang::get('service::lang.license_type')}}: </b> 
                                 {!!$contract->licenseTypes()!!}
                            </div>
                            <div class="col-md-2">
                                <b>{{Lang::get('service::lang.cost')}}: </b> 
                                 {!!$contract->cost!!}
                            </div>
                        </div>
                    </div>
                </div>

                <div id="hide2">
                    <div class="col-md-6">
                        <table class="table table-hover">
                            <tbody>

                                
                                <tr>
                                    <td>{{Lang::get('service::lang.license_count')}}</td>
                                    <td>
                                        {!!$contract->licensce_count!!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{Lang::get('service::lang.approver')}}</td>
                                    <td>
                                        {!!$contract->approvers()!!}
                                    </td>
                                </tr>

                                <tr>
                                    <td>{{Lang::get('service::lang.vendor')}}</td>
                                    <td>
                                        {!!$contract->vendors()!!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{Lang::get('service::lang.product')}}</td>
                                    <td>
                                        {!!$contract->products()!!}
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">

                        <table class="table table-hover">
                            <tbody>    
                                
                                <tr>
                                    <td>{{Lang::get('service::lang.contract_start_date')}}</td>
                                    <td>
                                        {!!$contract->contract_start_date!!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{Lang::get('service::lang.contract_end_date')}}</td>
                                    <td>
                                        {!!$contract->contract_end_date!!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{Lang::get('service::lang.notify_expiry')}}</td>
                                    <td>
                                        {!!$contract->notify_expiry!!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{Lang::get('service::lang.description')}}</td>
                                    <td>
                                        {!!$contract->descriptions()!!}
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

@stop