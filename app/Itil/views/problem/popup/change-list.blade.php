<style>
    .table{
        width: 100% !important; 
    }
</style>
<div class="modal fade" id="changeold{{$problem->id}}">
    {!! Form::open(['url'=>'service-desk/problem/change/attach/'.$problem->id,'files'=>true]) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Changes</h4>
            </div>
            <div class="modal-body">
                {!! Datatable::table()
                ->addColumn('#','Subject')
                ->setUrl(url('service-desk/problem/change'))
                ->render()
                !!}
                <!--                    </div>
                                </div>-->

            </div>
            <div class="modal-footer">
                <button type="button" id="close" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="{{Lang::get('lang.save')}}">
                
            </div>
            
            <!-- /Form -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    {!! Form::close() !!}
</div><!-- /.modal -->