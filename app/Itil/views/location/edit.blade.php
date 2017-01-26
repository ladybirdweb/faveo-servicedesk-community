@extends('themes.default1.admin.layout.admin')

@section('content')
@if ( $errors->count() > 0 )
<div class="alert alert-danger" aria-hidden="true">
    <i class="fa fa-ban"></i>
    <b>{!! Lang::get('lang.alert') !!} !</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <ul>
        @foreach( $errors->all() as $message )</p>
        <li class="error-message-padding">{{ $message }} </li>
        @endforeach
    </ul>
</div>
@endif

<section class="content-header">
    <h1>
        {{Lang::get('itil::lang.edit_location')}}

    </h1>

</section>
<div class="box box-primary">
    <div class="box-header with-border">
        <h4> 
            {{ucfirst($sd_location->title)}}  
            <a href="{{url('service-desk/location-types/'.$sd_location->id.'/show')}}" class="btn btn-default">{{Lang::get('itil::lang.show')}}</a>
        </h4>
    </div>

    <!-- form start -->
    <form action="{!!URL::route('service-desk.location.postedit')!!}" method="post" role="form">
        <input type="hidden" name="location_id" value="{{$sd_location->id}}">
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <label for="name" class="control-label">{{Lang::get('itil::lang.title')}}</label> 
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        <input type="text" class="form-control" name="title" value="{{$sd_location->title}}" id="name">
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="name" class="control-label">{{Lang::get('itil::lang.email')}}</label> 
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <input type="text" class="form-control" name="email" value="{{$sd_location->email}}" id="name">
                    </div>
                </div>
                <div class="col-md-4 form-group {{ $errors->has('organization') ? 'has-error' : '' }}">
                    {!! Form::label('organization',Lang::get('itil::lang.organization')) !!}
                    {!! Form::select('organization',[''=>'Select','Organizations'=>$organizations],$sd_location->organization,['class'=>'form-control']) !!}
                </div>
            </div> 
            <div class="row">
                <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6 form-group">
                    <label for="name" class="control-label">{{Lang::get('itil::lang.phone')}}</label> 
                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                        <input type="text" class="form-control" name="phone" value="{{$sd_location->phone}}" id="name">
                    </div>
                </div>
                <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6 form-group">
                    <label for="name" class="control-label">{{Lang::get('itil::lang.address')}}</label> 
                    <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                        <input type="text" class="form-control" name="address" value="{{$sd_location->address}}" id="name">
                    </div>
                </div>
            </div> 
            <div class="row">
                <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6">
                    <label for="name" class="control-label">{{Lang::get('itil::lang.location_category')}}</label> 
                    <div class="form-group {{ $errors->has('location_category') ? 'has-error' : '' }}">
                        {!! Form::select('location_category',[''=>'Select','Categories'=>$location_category->lists('name','id')->toArray()],$sd_location->location_category_id,['class'=>'form-control']) !!}
                       
                        
                    </div>
                </div>
                <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6">
                    <label for="team_lead" class="control-label">{{Lang::get('itil::lang.department')}}</label>
                    <div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">
                        {!! Form::select('department',[''=>'Select','Departments'=>$departments->lists('name','id')->toArray()],$sd_location->departments,['class'=>'form-control']) !!}
                        
                    </div>
                </div>
            </div> 
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">{{Lang::get('itil::lang.updte_location')}}</button>
            </div>

    </form>
</div>

@stop
