@extends('themes.default1.agent.layout.agent')
@section('content')

<section class="content-heading-anchor" id="heading">
    <h2>
        {{Lang::get('service::lang.edit_asset')}}  

    </h2>

</section>


<div class="box box-primary">
    <div id="response"></div>
    <div class="box-header with-border">
        <h4>
            {{$asset->name}}
            <a href="{{url('service-desk/assets/'.$asset->id.'/show')}}" class="btn btn-default">{{Lang::get('service::lang.show')}}</a>
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

    </div>
    <div class="box-body">

        <div class="row">
            <!--<form id="asset-type-form" enctype="multipart/form-data">-->
            {!! Form::model($asset,['url'=>'#','method'=>'','files'=>true,'id'=>'asset-type-form']) !!}
            <div class="form-group col-md-6 {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name" class="control-label">{{Lang::get('service::lang.name')}}</label> 
                {!! Form::text('name',null,['class'=>'form-control']) !!}
                <!--<input type="text" class="form-control" name="asset_name" placeholder="name" id="name">-->
            </div>
            <div class="form-group col-md-6 {{ $errors->has('external_id') ? 'has-error' : '' }}">
                <label for="external_id" class="control-label">{{Lang::get('service::lang.identifier')}}</label> 
                {!! Form::text('external_id',null,['class'=>'form-control']) !!}
                <!--<input type="text" class="form-control" name="asset_name" placeholder="name" id="name">-->
            </div>

            <div class="form-group  col-md-6 {{ $errors->has('department_id') ? 'has-error' : '' }}">
                <label for="department_id" class="control-label">{{Lang::get('service::lang.department')}}</label>
                {!! Form::select('department_id',$departments,null,['class'=>'form-control']) !!}

            </div>
            <div class="form-group col-md-6 {{ $errors->has('impact_type_id') ? 'has-error' : '' }}">
                <label class="control-label">{{Lang::get('service::lang.impact_type')}}</label>    
                {!! Form::select('impact_type_id',$sd_impact_types,null,['class'=>'form-control']) !!}

            </div> 
            <div class="col-md-6 form-group {{ $errors->has('organization') ? 'has-error' : '' }}">
                    {!! Form::label('organization',Lang::get('service::lang.organization')) !!}
                    {!! Form::select('organization',[''=>'Select','Organizations'=>$organizations],null,['class'=>'form-control','id'=>'org']) !!}
                </div>
                <div class="form-group col-md-6 {{ $errors->has('location_id') ? 'has-error' : '' }}">
                    <label class="control-label">{{Lang::get('service::lang.location')}}</label>
                    {!! Form::select('location_id',[''=>'Select'],null,['class'=>'form-control','id'=>'location']) !!}

                </div> 
            <div class="form-group col-md-6 {{ $errors->has('managed_by') ? 'has-error' : '' }}">
                <label class="control-label">{{Lang::get('service::lang.managed_by')}}</label>
                {!! Form::select('managed_by',$users,null,['class'=>'form-control']) !!}
            </div>
            <div class="form-group col-md-6 {{ $errors->has('used_by') ? 'has-error' : '' }}">
                <label class="control-label">{{Lang::get('service::lang.used_by')}}</label>    
                {!! Form::select('used_by',$users,null,['class'=>'form-control']) !!}

            </div> 
            <div class="form-group col-md-6 {{ $errors->has('product_id') ? 'has-error' : '' }}">
                <label class="control-label">{{Lang::get('service::lang.product')}}</label>    
                {!! Form::select('product_id',$products,null,['class'=>'form-control']) !!}

            </div> 
            <div class="form-group col-md-6 {{ $errors->has('asset_type_id') ? 'has-error' : '' }}">

                <label class="control-label">{{Lang::get('service::lang.asset_type')}}</label>  
                {!! Form::select('asset_type_id',$sd_asset_types,null,['class'=>'form-control','id'=>'type']) !!}

            </div>
            <div class="form-group col-md-6 {{ $errors->has('assigned_on') ? 'has-error' : '' }}">
                <label class="control-label">{{Lang::get('service::lang.assigned_on')}}</label>
                {!! Form::text('assigned_on',null,['class'=>'form-control','id'=>'date']) !!}
                <!--<input type="text" class="form-control" name="date" id="assignedDate">-->

            </div>
            <div class="form-group col-md-12 {{ $errors->has('description') ? 'has-error' : '' }}">
                <label for="internal_notes" class="control-label">{{Lang::get('service::lang.description')}}</label>
                {!! Form::textarea('description',null,['class'=>'form-control']) !!}
                <!--<textarea class="form-control textarea" placeholder="Description" name="description" rows="7" id=""style="width: 97%; margin-left:14px;"></textarea>-->
            </div>

            <!--asset type form-->

            <div id="asset-form" class="col-md-12 form-group">

            </div>

            <!--asset end-->

            <div class="form-group col-md-12 {{ $errors->has('attachments') ? 'has-error' : '' }}">
                <label for="internal_notes" class="control-label">{{Lang::get('service::lang.attachment')}}</label>
                {!! Form::file('attachments[]',null,['multiple'=>true]) !!}

            </div>
            {!! Form::close() !!}
            <!--</form>-->

            <!--        end row-->

        </div>

        <div class="box-footer">
            <div class="from-group">
                <input type="submit" value="{{Lang::get('service::lang.edit_asset')}}" class="btn btn-success" onclick="submit();">

            </div>
        </div>
    </div>
</div>

@stop
@section('FooterInclude')
<script src="{{asset("lb-faveo/plugins/moment-develop/moment.js")}}" type="text/javascript"></script>
<script src="{{asset("lb-faveo/js/bootstrap-datetimepicker4.7.14.min.js")}}" type="text/javascript"></script>
<script type="text/javascript">
                    $(function () {
                        $('#date').datetimepicker({
                            format: 'YYYY/MM/DD'
                        });
                    });
</script>
<script>
    $(document).ready(function(){
        var org = $("#org").val();
        send(org);
        $("#org").on('change',function(){
            org = $("#org").val();
            send(org);
        });
        function send(org){
            $.ajax({
                dataType : 'html',
                type : 'GET',
                url : "{{url('service-desk/location/org')}}",
                data : {'org':org},
                success : function(response){
                    $("#location").html(response);
                }
            });
        }
    });
    $(document).ready(function () {
        var type = $("#type").val();
        asset_type(type);
        $("#type").on('change', function () {
            type = $("#type").val();
            asset_type(type);
        });

        function asset_type(type) {
            $.ajax({
                url: "{{url('service-desk/asset-types/form/'.$asset->id)}}",
                dataType: "html",
                data: {'asset_type': type},
                success: function (response) {
                    $("#asset-form").html(response);
                },
                error: function (response) {
                    $("#asset-form").html(response);
                }
            });
        }
    });
    function submit() {
        var form = $("#asset-type-form").serialize();
        $.ajax({
            url: "{{url('service-desk/assets/'.$asset->id)}}",
            dataType: "json",
            type: "patch",
            data: form,
            success: function (json) {
                console.log(json.result);
                var res = "";
                $.each(json.result, function (idx, topic) {
                    if (idx === "success") {
                        res = "<div class='alert alert-success'>" + topic + "</div>";
                    }
                    if (idx === "fails") {
                        res = "<div class='alert alert-danger'>" + topic + "</div>";
                    }
                });

                $("#response").html(res);
                $('html, body').animate({scrollTop: $("#heading").offset().top}, 500);
            },
            error: function (json) {
                var res = "";
                $.each(json.responseJSON, function (idx, topic) {
                    res += "<li>" + topic + "</li>";
                });
                $("#response").html("<div class='alert alert-danger'><strong>Whoops!</strong> There were some problems with your input.<br><br><ul>" + res + "</ul></div>");
                $('html, body').animate({scrollTop: $("#heading").offset().top}, 500);
            }
        });
    }
</script>
@stop