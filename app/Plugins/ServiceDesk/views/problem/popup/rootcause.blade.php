<?php 
//$info = $problem->general();
$root ="";
if ($problem->getGeneralByIdentifier('root-cause')) {
    $root = $problem->getGeneralByIdentifier('root-cause')->value;
}
?>
<div class="modal fade" id="rootcause{{$problem->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Root Cause</h4>
                {!! Form::open(['url'=>'service-desk/general/'.$problem->id.'/sd_problem','files'=>true]) !!}
            </div>
            <div class="modal-body">
                <!-- Form  -->
                <div class="row">
                    <div class="col-md-12">
                       {!! Form::label('root-cause','Root Cause') !!}
                       {!! Form::textarea('root-cause',$root,['class'=>'form-control','id'=>'root-cause']) !!}
                       {!! Form::hidden('identifier','root-cause') !!}
                    </div>
                    <div class="col-md-12">
                       {!! Form::label('attachment','Attachment') !!}
                       {!! Form::file('attachment[]',['class'=>'file']) !!}
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="close" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="{{Lang::get('lang.save')}}">
                {!! Form::close() !!}
            </div>
            <!-- /Form -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
    $(function () {
        $("#root-cause").wysihtml5();
    });
</script>