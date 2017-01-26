@extends('themes.default1.agent.layout.agent')
@section('content')

<section class="content-header">
    <h1> {{Lang::get('itil::lang.problems')}} </h1>

</section>
<section class="content">
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
    <div class="row">
        <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
            <div class="box">
                <div class="box-header">
                    <h4>{{Lang::get('itil::lang.list_of_problems')}} </h4>
                    <div class="pull-right">
                        
                        <a href="{!!URL::route('service-desk.problem.create')!!}" class="btn btn-primary">{{Lang::get('itil::lang.open_new_problem')}}</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    {!! Datatable::table()
                    ->addColumn(
                    Lang::get('itil::lang.from'),
                    Lang::get('itil::lang.subject'),
                    Lang::get('itil::lang.department'),
                    Lang::get('itil::lang.ticket_type'),

                    Lang::get('itil::lang.action'))  // these are the column headings to be shown
                    ->setUrl('get-problems')  // this is the route where data will be retrieved
                        
                    ->render() !!}




                </div>
            </div>
        </div>
    </div>
</section>
@stop

