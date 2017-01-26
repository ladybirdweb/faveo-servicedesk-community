<!--<a href="#impact" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#impact{{$problem->id}}">Impact</a>-->
<?php
$statuses = \App\Plugins\ServiceDesk\Model\Changes\SdChangestatus::lists('name', 'id')->toArray();
$sd_changes_priorities = \App\Plugins\ServiceDesk\Model\Changes\SdChangepriorities::lists('name', 'id')->toArray();
$sd_changes_types = App\Plugins\ServiceDesk\Model\Changes\SdChangetypes::lists('name', 'id')->toArray();
$sd_impact_types = \App\Plugins\ServiceDesk\Model\Changes\SdImpacttypes::lists('name', 'id')->toArray();
$sd_locations = \App\Plugins\ServiceDesk\Model\Releases\SdLocations::lists('title', 'id')->toArray();
$users = \App\Plugins\ServiceDesk\Model\Cab\Cab::lists('name', 'id')->toArray();
$assets = \App\Plugins\ServiceDesk\Model\Assets\SdAssets::lists('name', 'id')->toArray();
$requester = App\User::where('role', 'agent')->orWhere('role', 'admin')->lists('email', 'id')->toArray();
?>
<div class="modal fade" id="changenew{{$problem->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Change</h4>
                {!! Form::open(['url'=>'service-desk/problem/change/'.$problem->id,'method'=>'post','files'=>true]) !!}
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6 {{ $errors->has('subject') ? 'has-error' : '' }}">
                        <label for="inputPassword3" class="control-label">{{Lang::get('service::lang.subject')}} </label>
                        {!! Form::text('subject',null,['class'=>'form-control']) !!}
                        <!--<input type="text" class="form-control" name="subject" id="inputPassword3" placeholder="Subject">-->
                    </div>
                    <div class="form-group col-md-6 {{ $errors->has('requester') ? 'has-error' : '' }}">
                        <label for="inputPassword3" class="control-label">{{Lang::get('service::lang.requester')}} </label>
                        {!! Form::select('requester',$requester,null,['class'=>'form-control']) !!}
                        <!--<input type="text" class="form-control" name="subject" id="inputPassword3" placeholder="Subject">-->
                    </div>


                    <div class="form-group col-md-6 {{ $errors->has('approval_id') ? 'has-error' : '' }}">
                        <label class="control-label">{{Lang::get('service::lang.approval')}}</label>
                        {!! Form::select('approval_id',$users,null,['class'=>'form-control']) !!}

                    </div>

                    <div class="form-group col-md-12 {{ $errors->has('description') ? 'has-error' : '' }}">
                        <label for="internal_notes" class="control-label" >Description</label>
                        {!! Form::textarea('description',null,['class'=>'form-control']) !!}
                        <!--<textarea class="form-control textarea" name="description" rows="7" id="internal_notes"></textarea>-->
                    </div>
                    <div class="form-group col-md-6 {{ $errors->has('status_id') ? 'has-error' : '' }}">
                        <label class=" control-label">{{Lang::get('service::lang.status')}}</label>
                        {!! Form::select('status_id',$statuses,null,['class'=>'form-control'])!!}
                    </div>
                    <div class="form-group col-md-6 {{ $errors->has('priority_id') ? 'has-error' : '' }}">
                        <label class="control-label">{{Lang::get('service::lang.priority')}}</label>
                        {!! Form::select('priority_id',$sd_changes_priorities,null,['class'=>'form-control']) !!}

                    </div> 
                    <div class="form-group col-md-6 {{ $errors->has('change_type_id') ? 'has-error' : '' }}">
                        <label class=" control-label">{{Lang::get('service::lang.change_type')}}</label>
                        {!! Form::select('change_type_id',$sd_changes_types,null,['class'=>'form-control']) !!}

                    </div>
                    <div class="form-group col-md-6 {{ $errors->has('location_id') ? 'has-error' : '' }}">
                        <label class="control-label">{{Lang::get('service::lang.location')}}</label>
                        {!! Form::select('location_id',$sd_locations,null,['class'=>'form-control']) !!}

                    </div>
                    <div class="form-group col-md-6 {{ $errors->has('impact_id') ? 'has-error' : '' }}">
                        <label class=" control-label" >Impact Type</label>
                        {!! Form::select('impact_id',$sd_impact_types,null,['class'=>'form-control']) !!}

                    </div>
                    <div class="form-group col-md-6 {{ $errors->has('asset') ? 'has-error' : '' }}">
                        <label class=" control-label" >Asset</label>
                        {!! Form::select('asset[]',$assets,null,['class'=>'form-control','multiple'=>true]) !!}

                    </div>
                    <div class="form-group col-md-6 {{ $errors->has('attachments') ? 'has-error' : '' }}">
                        <label class=" control-label" >Attachments</label>
                        {!! Form::file('attachments[]',null,['multiple'=>true]) !!}

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

