@extends('themes.default1.agent.layout.agent')
@section('content')

<section class="content-heading-anchor">
    <h2>
        {{Lang::get('service::lang.new_changes')}}  


    </h2>

</section>

<!-- Main content -->

<div class="box box-primary">
    <div class="box-header with-border">
        <h4> {{Lang::get('service::lang.open_new_changes')}} </h4>
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
        {!! Form::open(['url'=>'service-desk/changes/create','method'=>'post','files'=>true]) !!}
    </div><!-- /.box-header -->
    <!-- form start -->

    <!--<form action="{!!URL::route('service-desk.post.changes')!!}" method="post" role="form">-->
    <div class="box-body">
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


        <div class="box-footer">
            <div class="from-group">
                <input type="submit" value="{{Lang::get('service::lang.add_change')}}" class="btn btn-success">
                {!! Form::close() !!}
            </div>
        </div>

    </div>
</div>



@stop

