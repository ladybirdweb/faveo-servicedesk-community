@extends('themes.default1.agent.layout.agent')
@section('content')

<section class="content-heading-anchor">
    <h2>
        {{Lang::get('service::lang.show-asset')}}  


    </h2>

</section>


<!-- Main content -->

<div class="box box-primary">
    <div class="box-header with-border">
        <h4> 
            {{str_limit($asset->name,20)}}  
            <a href="{{url('service-desk/assets/'.$asset->id.'/edit')}}" class="btn btn-default">{{Lang::get('service::lang.edit')}}</a>
        </h4>
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
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">


                <!-- /.box-header -->

                <table class="table table-condensed">

                    <tr>

                        <td>{{Lang::get('service::lang.name')}}</td>
                        <td>
                            {!!$asset->name!!}
                        </td>

                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.department')}}</td>
                        <td>
                            {!!$asset->departments()!!}
                        </td>
                    </tr>

                    <tr>
                        <td>{{Lang::get('service::lang.impact')}}</td>
                        <td>
                            {!!$asset->impacts()!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.location')}}</td>
                        <td>
                            {!!$asset->locations()!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.used_by')}}</td>
                        <td>
                            {!!$asset->used()!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.product')}}</td>
                        <td>
                            {!!$asset->products()!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.managed_by')}}</td>
                        <td>
                            {!!$asset->managed()!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.asset_type')}}</td>
                        <td>
                            {!!$asset->assetTypes()!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.assigned_on')}}</td>
                        <td>
                            {!!$asset->assignedOn()!!}
                        </td>
                    </tr>

                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.description')}}</td>
                        <td>
                            {!!$asset->description!!}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-12">
                <h3>{{Lang::get('service::lang.additional-details')}}</h3>
            </div>
            <div class="col-md-12">
                <table class="table table-condensed">
                    @forelse($asset->additionalData() as $index=>$data)

                    <tr>

                        <td>{{$index}}</td>
                        <td>
                            {!!$data!!}
                        </td>

                    </tr>
                    @empty 
                    <tr><td>No Additional Informations</td></tr>
                    @endforelse
                </table>
            </div>
           

            


        </div>
        <!-- /.box -->
    </div>
</div>


@stop
