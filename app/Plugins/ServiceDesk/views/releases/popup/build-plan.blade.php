<?php
$build="";
if ($release->getGeneralByIdentifier('build-plan')) {
    $build = $release->getGeneralByIdentifier('build-plan')->value;
}
?>
<div class="modal fade" id="build-plan{{$release->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Build Plan</h4>
                {!! Form::open(['url'=>'service-desk/general/'.$release->id.'/sd_releases','files'=>true]) !!}
            </div>
            <div class="modal-body">
                <!-- Form  -->
                <div class="row">
                    
                    <div class="col-md-12">
                       {!! Form::hidden('identifier','build-plan') !!}
                       {!! Form::label('build-plan','Build Plan') !!}
                       {!! Form::textarea('build-plan',$build,['class'=>'form-control','id'=>'build-plan']) !!}
                    </div>
                     <div class="col-md-12">
                       {!! Form::label('attachment','Attachment') !!}
                       {!! Form::file('attachment[]') !!}
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
        $("#build-plan").wysihtml5();
    });
</script>