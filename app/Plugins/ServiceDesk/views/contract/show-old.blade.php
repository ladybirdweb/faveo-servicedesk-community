@extends('themes.default1.admin.layout.admin')
@section('content')

<section class="content-heading-anchor">
    <h2>
        {{Lang::get('service::lang.show-contract')}}  


    </h2>

</section>


<!-- Main content -->

<div class="box box-primary">
    <div class="box-header with-border">
        <h4> 
            {{str_limit(ucfirst($contract->name),20)}}  
            <a href="{{url('service-desk/contracts/'.$contract->id.'/edit')}}" class="btn btn-default">{{Lang::get('service::lang.edit')}}</a>
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
                            {!!$contract->name!!}
                        </td>

                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.cost')}}</td>
                        <td>
                            {!!$contract->cost!!}
                        </td>
                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.license_count')}}</td>
                        <td>
                            {!!$contract->licensce_count!!}
                        </td>
                    </tr>

                    <tr>
                        <td>{{Lang::get('service::lang.contract_type')}}</td>
                        <td>
                            {!!$contract->contractTypes()!!}
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
                        <td>{{Lang::get('service::lang.license_type')}}</td>
                        <td>
                            {!!$contract->licenseTypes()!!}
                        </td>
                    </tr>

                    </tr>
                    <tr>
                        <td>{{Lang::get('service::lang.product')}}</td>
                        <td>
                            {!!$contract->products()!!}
                        </td>
                    </tr>
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
                </table>
            </div>
            <div class="col-md-12">
                <h3>{{Lang::get('service::lang.attachment')}}</h3>
            </div>
            @forelse($contract->attachments() as $attachment)
            <div class="col-md-3">
                {{$attachment->value}}
            </div>
            @empty 
            <div class="col-md-12">
                <p>No Attachments</p>
            </div>
            @endforelse
            <!-- /.box-body -->
           
        </div>
        <!-- /.box -->
    </div>
</div>


@stop
