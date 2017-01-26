<style>
    .table .table-bordered {
        width: 100%     !important;
    }
</style>
<a href="#asset" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#asset{{$id}}">Attach Asset</a>
<div class="modal fade" id="asset{{$id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Assets</h4>
            </div>
            <div class="modal-body">
                <!-- Form  -->
                <div class="row">
                    <div class="col-md-12 ui-widget">
                        <?php
                        $types = App\Plugins\ServiceDesk\Model\Assets\SdAssettypes::lists('name', 'id')->toArray();
                        ?>
                        {!! Form::select('asset_type',$types,null,['class'=>'form-control','id'=>'type']) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::open(['url'=>'service-desk/attach-asset/ticket']) !!}
                        {!! Form::hidden('tiketid',$id) !!}
                        <div id="response"></div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="close" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="{{Lang::get('lang.save')}}">
            </div>

            {!! Form::close() !!}
            <!-- /Form -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  
@section('FooterInclude')
<script>
    $(document).ready(function () {
        var type = $("#type").val();
        asset_type(type);
        $("#type").on('change', function () {
            type = $("#type").val();
            asset_type(type);
        });

        function asset_type(type) {
            $.ajax({
                url: "{{url('service-desk/assets/assettype')}}",
                data: {'asset_type': type},
                type: "post",
                success: function (data) {
                    $("#response").html(data);
                }
            });
        }
    });


</script>
@stop