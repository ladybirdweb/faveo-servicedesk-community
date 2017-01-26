
<a href="#form" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#form{{$id}}">Preview</a>
<div class="modal fade" id="form{{$id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{$title}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                {!! $html !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="close" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
            <!-- /Form -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
