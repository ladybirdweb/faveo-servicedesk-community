@extends('themes.default1.admin.layout.admin')
@section('content')
<section class="content-header">
    
</section>
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">
            {{str_limit(ucfirst($location->title),20)}}  

        </h3>
        <div class="pull-right">
            <div class="btn-group">
                <a href="{{url('service-desk/location-types/'.$location->id.'/edit')}}" class="btn btn-primary">{{Lang::get('itil::lang.edit')}}</a>
            </div>
            <div class="btn-group">
                <?php
                $url = url('service-desk/location-types/' . $location->id . '/delete');
                $delete = \App\Itil\Controllers\UtilityController::deletePopUp($location->id, $url, "Delete $location->name", "btn btn-danger");
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
                                <b>{{Lang::get('itil::lang.title')}}:</b> 
                                {!!$location->title!!}
                            </div>
                            <div class="col-md-4">
                                <b>{{Lang::get('itil::lang.email')}}: </b>
                                {!!$location->email!!}
                            </div>
                            <div class="col-md-4">
                                <b>{{Lang::get('itil::lang.organization')}}: </b>
                                {!!$location->getOrgWithLink()!!}
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div id="hide2">
                    <div class="col-md-6">
                        <table class="table table-hover">
                            <tbody>


                                <tr>
                                    <td>{{Lang::get('itil::lang.phone')}}</td>
                                    <td>
                                        {!!$location->phone!!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{Lang::get('itil::lang.address')}}</td>
                                    <td>
                                        {!!$location->address!!}
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">

                        <table class="table table-hover">
                            <tbody>    

                                <tr>
                                    <td>{{Lang::get('itil::lang.location_category')}}</td>
                                    <td>
                                        {!!$location->locationCategory()!!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{Lang::get('itil::lang.department')}}</td>
                                    <td>
                                        {!!$location->departments()!!}
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