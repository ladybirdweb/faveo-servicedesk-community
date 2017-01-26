@if(Auth::user()->role=="admin")
@extends('themes.default1.admin.layout.admin')
@else 
@extends('themes.default1.agent.layout.agent')
@endif
@section('content')

<section class="content-heading-anchor">
    <h2>
        {{Lang::get('service::lang.show-vote')}}  


    </h2>

</section>


<!-- Main content -->

<div class="box box-primary">
    <div class="box-header with-border">
        <h4> 


        </h4>
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
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">


                <!-- /.box-header -->

                <table class="table table-condensed">
                    <tr>
                        <th>Agent</th>
                        <th>Vote</th>
                        <th>Comment</th>
                    </tr>
                    @forelse($votes as $vote)
                    <tr>

                        <td>
                            {!! App\Plugins\ServiceDesk\Controllers\Cab\CabController::votedUser($vote->user_id) !!}
                        </td>
                        <td>
                            {!! App\Plugins\ServiceDesk\Controllers\Cab\CabController::checkVote($vote->vote) !!}
                        </td>
                        <td>
                            {!! ucfirst($vote->comment) !!}
                        </td>

                    </tr>
                    @empty 
                    <tr>

                        <td>No one voted so far</td>


                    </tr>
                    @endforelse
                </table>
            </div>

        </div>
        <!-- /.box -->
    </div>
</div>


@stop
