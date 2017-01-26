@if(Auth::user()->role=="admin")
@extends('themes.default1.admin.layout.admin')
@else 
@extends('themes.default1.agent.layout.agent')
@endif
@section('content')
<section class="content-header">
    <h1> {{Lang::get('itil::lang.voting')}} </h1>

</section>
<div class="box box-primary">

    <div class="box-header with-border">
        <h4> {{Lang::get('itil::lang.mark_your_vote')}} </h4>
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
        {!! Form::open(['url'=>'service-desk/cabs/vote/'.$cabid.'/'.$owner,'method'=>'post']) !!}
    </div><!-- /.box-header -->
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
      
            <div class="form-group {{ $errors->has('vote') ? 'has-error' : '' }}">
                <div class="col-md-12">
                    {!! Form::label('vote',Lang::get('itil::lang.vote')) !!}
                </div>
                <div class="col-md-12">
                    
                    <div class="col-md-3">
                        <p> {!! Form::radio('vote',1) !!} Yes</p>
                    </div>
                    <div class="col-md-3">
                        <p> {!! Form::radio('vote',0) !!} No</p>
                    </div>
                </div>             
            </div>
            <div class="form-group col-md-12 {{ $errors->has('comment') ? 'has-error' : '' }}">
                {!! Form::label('comment',Lang::get('itil::lang.comment')) !!}
                {!! Form::textarea('comment',null,['class'=>'form-control']) !!}             
            </div>

        </div>
        <!-- /.box-body -->
    </div>
    <div class="box-footer">
        {!! Form::submit('Save',['class'=>'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
    <!-- /.box -->
</div>



@stop