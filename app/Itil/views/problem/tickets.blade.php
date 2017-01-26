<div class="row">
    <div class="col-md-12">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Tickets</a></li>

            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="box box-primary">
<!--                        <div class="box-header">
                            <h3 class="box-title">Condensed Full Width Table</h3>
                        </div>-->
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-condensed">
                                <tr>
                                    <th>#</th>
                                    <th>Ticket Number</th>
                                    <th>Subject</th>
                                    <th>Action</th>
                                </tr>
                               
                                <?php 
                                $i = 1; 
                                ?>
                                @forelse($problem->tickets() as $ticket)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$ticket->ticket_number}}</td>
                                    <td>{{str_limit($ticket->title,20)}}</td>
                                    <td><a href="{{url('thread/'.$ticket->id)}}" class="btn btn-info">View</a></td>
                                </tr>
                                <?php $i++;?>
                                @empty 
                                <tr><td>No Tickets Associated</td></tr>
                                @endforelse
                               
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->