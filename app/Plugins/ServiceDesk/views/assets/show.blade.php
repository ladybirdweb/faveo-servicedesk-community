@extends('themes.default1.agent.layout.agent')
@section('content')
<section class="content-header">
    
</section>
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title" id="refresh2"> {!! ucfirst($asset->name) !!} </h3>
        <div class="pull-right">
            <a href="{{url('service-desk/assets/' . $asset->id . '/edit')}}" class="btn btn-default">Edit</a>

            <?php
            $delid = $asset->id;
            $delurl = url('service-desk/assets/' . $asset->id . '/delete');
            $delete_pop = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::deletePopUp($delid, $delurl, "Delete $asset->subject","btn btn-danger");
            ?>
            {!! $delete_pop !!}
        </div>
    </div>
    <!-- ticket details Table -->
    <div class="box-body">

        <div class="row">
            <section class="content">

                <div class="col-md-12">
                    <div class="callout callout-info">
                        <div class="row">

                            <div class="col-md-3">
                                <b>Created Date: </b> 
                                {!!$asset->created_at!!}
                            </div>
                            <div class="col-md-3">
                                <b>Used By: </b>
                                {!!$asset->used()!!}
                            </div>
                            <div class="col-md-3">
                                <b>Managed By: </b> 
                                {!!$asset->managed()!!}
                            </div>
                            <div class="col-md-3">
                                <b>{{Lang::get('service::lang.organization')}}: </b> 
                                {!!$asset->getOrgWithLink()!!}
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="col-md-6 pull-right">

                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <td><b>{{Lang::get('service::lang.department')}}</b></td>
                                    <td>
                                        {!!$asset->departments()!!}
                                    </td>
                                </tr>

                                <tr>
                                    <td><b>{{Lang::get('service::lang.impact')}}</b></td>
                                    <td>
                                        {!!$asset->impacts()!!}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>{{Lang::get('service::lang.location')}}</b></td>
                                    <td>
                                        {!!$asset->locations()!!}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>{{Lang::get('service::lang.identifier')}}</b></td>
                                    <td>
                                        {!!$asset->external_id!!}
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6 pull-right">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <td><b>Product:</b></td>  
                                    <td>{!!$asset->products()!!}</td>
                                </tr>
                                <tr>
                                    <td><b>{{Lang::get('service::lang.asset_type')}}</b></td>
                                    <td>
                                        {!!$asset->assetTypes()!!}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>{{Lang::get('service::lang.assigned_on')}}</b></td>
                                    <td>
                                        {!!$asset->assignedOn()!!}
                                    </td>
                                </tr>

                                </tr>
                                <tr>
                                    <td><b>{{Lang::get('service::lang.description')}}</b></td>
                                    <td>
                                        {!!$asset->description!!}
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
@if(count($asset->additionalData())>0)
@include('service::assets.additional-info')
@endif 
@if(count($asset->requests())>0)
@include('service::assets.requests')
@endif
@stop