@extends('themes.default1.admin.layout.admin')
@section('content')
<section class="content-header">
    <h1> {{Lang::get('itil::lang.cabs')}} </h1>

</section>
<div class="box box-primary">

    <div class="box-header with-border">
        <h4> {{Lang::get('itil::lang.open_new_changes')}} </h4>
        <a href="{{url('service-desk/cabs/create')}}" class="btn btn-primary pull-right">{{Lang::get('itil::lang.new_cab')}} </a>
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

    </div><!-- /.box-header -->
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                {!! Datatable::table()
                ->addColumn(

                Lang::get('itil::lang.name'),
                Lang::get('itil::lang.head'),
                Lang::get('itil::lang.action'))

                ->setUrl('cab/get-cab')  
                ->render() !!}
            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>



@stop