<?php 
//$info = $problem->general();
$symptom ="";
if ($problem->getGeneralByIdentifier('symptoms')) {
    $symptom = $problem->getGeneralByIdentifier('symptoms')->value;
}

?>
<div class="modal fade" id="symptoms{{$problem->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Symptoms</h4>
                {!! Form::open(['url'=>'service-desk/general/'.$problem->id.'/sd_problem','files'=>true]) !!}
            </div>
            <div class="modal-body">
                <!-- Form  -->
                <div class="row">
                    <div class="col-md-12">
                       {!! Form::label('symptoms','Symptoms') !!}
                       {!! Form::textarea('symptoms',$symptom,['class'=>'form-control','id'=>'symptoms']) !!}
                       {!! Form::hidden('identifier','symptom') !!}
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
        $("#symptoms").wysihtml5();
    });
</script>