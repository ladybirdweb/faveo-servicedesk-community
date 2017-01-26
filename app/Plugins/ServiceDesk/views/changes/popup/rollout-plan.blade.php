<?php 
$rollout ="";
if ($change->getGeneralByIdentifier('rollout-plan')) {
    $rollout = $change->getGeneralByIdentifier('rollout-plan')->value;
}

?>
<div class="modal fade" id="rollout{{$change->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Rollout Plan</h4>
                {!! Form::open(['url'=>'service-desk/general/'.$change->id.'/sd_changes','files'=>true]) !!}
            </div>
            <div class="modal-body">
                <!-- Form  -->
                <div class="row">
                    
                    <div class="col-md-12">
                       {!! Form::label('rollout-plan','Rollout Plan') !!}
                       {!! Form::textarea('rollout-plan',$rollout,['class'=>'form-control','id'=>'rollout-plan']) !!}
                       {!! Form::hidden('identifier','rollout-plan') !!}
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
        $("#rollout-plan").wysihtml5();
    });
</script>