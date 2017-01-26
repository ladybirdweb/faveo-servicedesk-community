<?php
$sd_release_status = \App\Plugins\ServiceDesk\Model\Releases\SdReleasestatus::lists('name', 'id')->toArray();
$sd_release_priorities = \App\Plugins\ServiceDesk\Model\Releases\SdReleasepriorities::lists('name', 'id')->toArray();
$sd_release_types = App\Plugins\ServiceDesk\Model\Releases\SdReleasetypes::lists('name', 'id')->toArray();
$sd_locations = App\Plugins\ServiceDesk\Model\Releases\SdLocations::lists('title', 'id')->toArray();
$assets = \App\Plugins\ServiceDesk\Model\Assets\SdAssets::lists('name', 'id')->toArray();
?>
<div class="modal fade" id="releasenew{{$change->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Release</h4>
                {!! Form::open(['url'=>'service-desk/changes/release/'.$change->id,'method'=>'post','files'=>true]) !!}
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6 {{ $errors->has('subject') ? 'has-error' : '' }}">
                        <label for="Subject" class="control-label">{{Lang::get('service::lang.subject')}}</label>
                        {!! Form::text('subject',null,['class'=>'form-control']) !!}
                        <!--<input type="text" name="subject" class="form-control" id="" placeholder="Subject....">-->

                    </div>
                    <div class="form-group col-md-6 {{ $errors->has('plan_start_date') ? 'has-error' : '' }}">

                        <label for="inputEmail3" class="control-label">{{Lang::get('service::lang.planed_start_date')}}</label>
                        {!! Form::text('planned_start_date',null,['class'=>'form-control','id'=>'plan_start_date']) !!}
                        <!--<input type="text" name="plan_start_date" class="form-control" id="startdate" placeholder="Startdate">-->
                    </div>
                    <div class="form-group col-md-6 {{ $errors->has('plan_end_date') ? 'has-error' : '' }}">
                        <label for="inputEmail3" class="control-label">{{Lang::get('service::lang.planed_end_date')}}</label>
                        {!! Form::text('planned_end_date',null,['class'=>'form-control','id'=>'plan_end_date']) !!}
                        <!--<input type="text"  name="plan_end_date" class="form-control" id="enddate" placeholder="Enddate">-->
                    </div>
                    <div class="form-group col-md-6 {{ $errors->has('status') ? 'has-error' : '' }}">
                        <label class=" control-label">{{Lang::get('service::lang.status')}}</label>
                        {!! Form::select('status_id',$sd_release_status,null,['class'=>'form-control']) !!}

                    </div>
                    <div class="form-group col-md-6 {{ $errors->has('priority') ? 'has-error' : '' }}">
                        <label class=" control-label">{{Lang::get('service::lang.priority')}}</label>
                        {!! Form::select('priority_id',$sd_release_priorities,null,['class'=>'form-control']) !!}

                    </div>
                    <div class="form-group col-md-6 {{ $errors->has('releasetype') ? 'has-error' : '' }}">
                        <label class=" control-label">{{Lang::get('service::lang.type')}}</label>
                        {!! Form::select('release_type_id',$sd_release_types,null,['class'=>'form-control']) !!}

                    </div>
                    <div class="form-group col-md-6 {{ $errors->has('location') ? 'has-error' : '' }}">
                        <label class="control-label">{{Lang::get('service::lang.location')}}</label>
                        {!! Form::select('location_id',$sd_locations,null,['class'=>'form-control']) !!}

                    </div>
                    <div class="form-group col-md-6 {{ $errors->has('asset') ? 'has-error' : '' }}">
                        <label for="inputEmail3" class="control-label">{{Lang::get('service::lang.assets')}}</label>
                        {!! Form::select('asset[]',$assets,null,['class'=>'form-control','multiple'=>true]) !!}
                        <!--<input type="text" name="build_plan" class="form-control" placeholder="Build plan" id="provider-json">-->
                    </div>
                    <div class="form-group col-md-12 {{ $errors->has('description') ? 'has-error' : '' }}">
                        <label for="description" class="control-label">{{Lang::get('service::lang.description')}}</label>
                        {!! Form::textarea('description',null,['class'=>'form-control']) !!}
                        <!--<textarea class="form-control textarea" name="description" placeholder="Description....."  id="description"></textarea>-->
                    </div>
                    

                    <div class="form-group col-md-6 {{ $errors->has('attachments') ? 'has-error' : '' }}">
                        <label for="inputEmail3" class="control-label">{{Lang::get('service::lang.attachment')}}</label>
                        {!! Form::file('attachments[]',null,['multiple'=>true]) !!}
                        <!--<input type="text" name="build_plan" class="form-control" placeholder="Build plan" id="provider-json">-->
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