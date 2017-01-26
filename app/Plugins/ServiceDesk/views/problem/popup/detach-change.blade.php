<div class="modal fade" id="change-detach{{$problem->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete {{str_limit(ucfirst($problem->change()->subject),20)}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <p>Are you sure ?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="close" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <a href="{{url('service-desk/problem/'.$problem->id.'/detach')}}" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div>