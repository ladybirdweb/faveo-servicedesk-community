@extends('themes.default1.admin.layout.admin')
@section('content')

<section class="content-heading-anchor">
    <h1>
        {{Lang::get('service::lang.new_contract')}}  


    </h1>

</section>


<!-- Main content -->

<div class="box box-primary">
    <div class="box-header with-border">
        <h4> {{Lang::get('service::lang.new_contract')}}  </h4>
        <!-- /.box-header -->
        <!-- form start -->
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
        {!! Form::open(['url'=>'service-desk/contracts/create','method'=>'post','files'=>true]) !!}
    </div>
    <div class="box-body">

        <div class="row">
            <div class="form-group col-md-6 {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name" class="control-label">{{Lang::get('service::lang.name')}}</label>
                {!! Form::text('name',null,['class'=>'form-control']) !!}
                <!--<input type="text" name="name" class="form-control" id="inputPassword3" placeholder="Name">-->
            </div>
            <div class="form-group col-md-6 {{ $errors->has('Cost') ? 'has-error' : '' }}">
                <label for="inputEmail3" class="control-label">{{Lang::get('service::lang.cost')}}</label>

                {!! Form::text('cost',null,['class'=>'form-control']) !!}
                    <!--<input type="text" class="form-control" name="cost" placeholder="Cost">-->
            </div>
            <div class="form-group col-md-6 {{ $errors->has('contract_type_id') ? 'has-error' : '' }}">
                <label class=" control-label">{{Lang::get('service::lang.contract_type')}}</label>

                {!! Form::select('contract_type_id',$contract_type_ids,null,['class'=>'form-control']) !!}

            </div>
            <div class="form-group col-md-6 {{ $errors->has('approver_id') ? 'has-error' : '' }}">
                <label class=" control-label">{{Lang::get('service::lang.approver')}}</label>    
                {!! Form::select('approver_id',$approvers,null,['class'=>'form-control']) !!}


            </div>
            <div class="form-group col-md-6 {{ $errors->has('licensce_count') ? 'has-error' : '' }}">
                <label for="count" class="control-label">{{Lang::get('service::lang.license_count')}}</label>

                {!! Form::text('licensce_count',null,['class'=>'form-control']) !!}
                    <!--<input type="text" name="licensce_count" class="form-control" id="licensce">-->
            </div>
            <div class="form-group col-md-6 {{ $errors->has('vendor_id') ? 'has-error' : '' }}">
                <label class=" control-label">{{Lang::get('service::lang.vendor')}}</label>    
                {!! Form::select('vendor_id',$vendor_ids,null,['class'=>'form-control']) !!}

            </div>
            <div class="form-group col-md-12 {{ $errors->has('description') ? 'has-error' : '' }}">
                <label for="internal_notes" class="control-label">{{Lang::get('service::lang.description')}}</label>

                {!! Form::textarea('description',null,['class'=>'form-control']) !!}
                    <!--<textarea class="form-control textarea" placeholder="Description" name="description" id=""></textarea>-->
            </div>
            <div class="form-group col-md-6 {{ $errors->has('license_type_id') ? 'has-error' : '' }}">
                <label class=" control-label">{{Lang::get('service::lang.license_type')}}</label>

                {!! Form::select('license_type_id',$license_type_ids,null,['class'=>'form-control']) !!}


            </div>
            <div class="form-group col-md-6 {{ $errors->has('product_id') ? 'has-error' : '' }}">
                <label class=" control-label">{{Lang::get('service::lang.product')}}</label>

                {!! Form::select('product_id',$product_ids,null,['class'=>'form-control']) !!}


            </div>
            <div class="form-group col-md-6 {{ $errors->has('contract_start_date') ? 'has-error' : '' }}">
                <label for="start" class="control-label">{{Lang::get('service::lang.contract_start_date')}}</label>

                {!! Form::text('contract_start_date',null,['class'=>'form-control','id'=>'start']) !!}
                    <!--<input type="text" name="contract_start_date" class="form-control" id="startdate" placeholder="Srart date">-->
            </div>
            <div class="form-group col-md-6 {{ $errors->has('contract_end_date') ? 'has-error' : '' }}">
                <label for="end date" class="control-label">{{Lang::get('service::lang.contract_end_date')}}</label>

                {!! Form::text('contract_end_date',null,['class'=>'form-control','id'=>'end']) !!}
                    <!--<input type="text" name="contract_end_date" class="form-control" id="enddate" placeholder="End Date">-->


            </div>
            <div class="form-group col-md-6 {{ $errors->has('notify_expiry') ? 'has-error' : '' }}">
                <label for="inputEmail3" class="control-label">{{Lang::get('service::lang.notify_expiry')}}</label>

                {!! Form::text('notify_expiry',null,['class'=>'form-control','id'=>'notify']) !!}

            </div>

            <div class="form-group col-md-6 {{ $errors->has('attachments') ? 'has-error' : '' }}">
                <label for="inputEmail3" class="control-label">{{Lang::get('service::lang.attachment')}}</label>

                {!! Form::file('attachments[]',null,['multiple'=>true]) !!}

            </div>



        </div>

        <div class="box-footer">
            <button type="submit" class="btn btn-success">Add Problem</button>
            {!! Form::close() !!}
        </div>

    </div>

</div>

@stop
@section('FooterInclude')
<script src="{{asset("lb-faveo/plugins/moment-develop/moment.js")}}" type="text/javascript"></script>
<script src="{{asset("lb-faveo/js/bootstrap-datetimepicker4.7.14.min.js")}}" type="text/javascript"></script>

<script type="text/javascript">
$(function () {
    $('#start').datetimepicker({
        format: 'YYYY/MM/DD'
    });
    $('#end').datetimepicker({
        format: 'YYYY/MM/DD'
    });
    $('#notify').datetimepicker({
        format: 'YYYY/MM/DD'
    });
});
</script>
@stop