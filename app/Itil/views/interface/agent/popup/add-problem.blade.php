
<style>
    .table .table-bordered {
        width: 100%     !important;
    }
</style>
<div class="btn-group">
    <button type="button" class="btn btn-sm btn-primary">Problems</button>
    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="#problem" data-toggle="modal" data-target="#problemnew{{$id}}">Attach New Problem</a></li>
        <li><a href="#problem"  data-toggle="modal" data-target="#problemexisting{{$id}}">Attach Existing Problem</a></li>
    </ul>
</div>
<div class="modal fade" id="problemnew{{$id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">New Problems</h4>
            </div>
            <div class="modal-body">
                <?php
                $subject = \App\Itil\Controllers\UtilityController::getSubjectByThreadId($id);
                $content = \App\Itil\Controllers\UtilityController::getBodyByThreadMaxId($id);
                $requester = \App\User::lists('email', 'email')->toArray();
                $status = \App\Model\helpdesk\Ticket\Ticket_Status::lists('name', 'id')->toArray();
                $priority = \App\Model\helpdesk\Ticket\Ticket_Priority::lists('priority', 'priority_id')->toArray();
                $impact = App\Itil\Models\Problem\Impact::lists('name', 'id')->toArray();
                $group = \App\Model\helpdesk\Agent\Groups::lists('name', 'id')->toArray();
                $agent = \App\User::where('role', '!=', 'user')->lists('email', 'id')->toArray();
                if(isAsset()==true){
                    $assets = \App\Itil\Models\Assets\SdAssets::lists('name', 'id')->toArray();
                }
                $location = App\Itil\Models\Common\Location::lists('title', 'id')->toArray();
                $ticket = App\Itil\Controllers\UtilityController::getTicketByThreadId($id);
                ?>
                <!-- Form  -->
                {!! Form::open(['url'=>'service-desk/attach-problem/ticket/new']) !!}
                {!! Form::hidden('ticketid',$ticket->id) !!}
                <div class="row">


                    <div class="form-group col-md-6 {{ $errors->has('from') ? 'has-error' : '' }}">
                        {!! Form::label('from',Lang::get('itil::lang.from')) !!} 
                        {!! Form::select('from',$requester,null,['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-6 {{ $errors->has('subject') ? 'has-error' : '' }}">
                        {!! Form::label('subject',Lang::get('itil::lang.subject')) !!} 
                        {!! Form::text('subject',$subject,['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-12 {{ $errors->has('description') ? 'has-error' : '' }}">
                        {!! Form::label('description',Lang::get('itil::lang.description')) !!}
                        {!! Form::textarea('description',$content,['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-4 {{ $errors->has('status_type_id') ? 'has-error' : '' }}">
                        {!! Form::label('status_type_id',Lang::get('itil::lang.status')) !!}
                        {!! Form::select('status_type_id',$status,null,['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-4 {{ $errors->has('priority_id') ? 'has-error' : '' }}">
                        {!! Form::label('priority_id',Lang::get('itil::lang.priority')) !!}
                        {!! Form::select('priority_id',$priority,null,['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-4 {{ $errors->has('impact_id') ? 'has-error' : '' }}">
                        {!! Form::label('impact_id',Lang::get('itil::lang.impact')) !!}
                        {!! Form::select('impact_id',$impact,null,['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-6 {{ $errors->has('location_type_id') ? 'has-error' : '' }}">
                        {!! Form::label('location_type_id',Lang::get('itil::lang.location')) !!}
                        {!! Form::select('location_type_id',$location,null,['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-6 {{ $errors->has('group_id') ? 'has-error' : '' }}">
                        {!! Form::label('group_id',Lang::get('itil::lang.group')) !!}
                        {!! Form::select('group_id',$group,null,['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-6 {{ $errors->has('agent_id') ? 'has-error' : '' }}">
                        {!! Form::label('agent_id',Lang::get('itil::lang.agent')) !!}
                        {!! Form::select('agent_id',$agent,null,['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-6 {{ $errors->has('assigned_id') ? 'has-error' : '' }}">
                        {!! Form::label('assigned_id',Lang::get('itil::lang.assigned')) !!}
                        {!! Form::select('assigned_id',$agent,null,['class' => 'form-control']) !!}
                    </div>
                    @if(isAsset()==true)
                    <div class="form-group col-md-6 {{ $errors->has('asset') ? 'has-error' : '' }}">
                        {!! Form::label('asset',Lang::get('itil::lang.asset')) !!}
                        {!! Form::select('asset',$assets,null,['class' => 'form-control']) !!}
                    </div>
                    @endif

                    <div class="form-group col-md-6 {{ $errors->has('attachment') ? 'has-error' : '' }}">
                        {!! Form::label('attachment',Lang::get('itil::lang.attachment')) !!}
                        {!! Form::file('attachment',null,['class' => 'form-control']) !!}
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


<!-- Existing Problem-->
<div class="modal fade" id="problemexisting{{$id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Existing Problems</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Form  -->
                        {!! Form::open(['url'=>'service-desk/attach-problem/ticket/existing']) !!}
                        {!! Form::hidden('ticketid',$ticket->id) !!}

                        {!! Datatable::table()
                        ->addColumn('#', 'Subject','Status')
                        ->setUrl(url('service-desk/problems/attach/existing'))
                        ->render() !!}
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
<script type="text/javascript">
    $(function () {
        $("#description").wysihtml5();
    });

    $(document).ready(function () {
        $('#form').submit(function () {
            var duedate = document.getElementById('datemask').value;
            if (duedate) {
                var pattern = /^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/;
                if (pattern.test(duedate) === true) {
                    $('#duedate').removeClass("has-error");
                    $('#clear-up').remove();
                } else {
                    $('#duedate').addClass("has-error");
                    $('#clear-up').remove();
                    $('#box-header1').append("<div id='clear-up'><br><br><div class='alert alert-danger alert-dismissable'><i class='fa fa-ban'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Invalid Due date</div></div>");
                    return false;
                }
            }
        });
    });
</script>
