<div class="modal fade" id="add{{$product->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Vendor</h4>
                {!! Form::open(['url'=>'service-desk/products/add/vendor','method'=>'post']) !!}
                {!! Form::hidden('product',$product->id) !!}
            </div>
            <div class="modal-body">
               <div class="row">


            <div class="form-group">


                <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6 form-group">
                    <label for="name" class="control-label">{{Lang::get('service::lang.name')}}</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::text('name',null,['class'=>'form-control']) !!}
                        <!--<input type="text" name="name" class="form-control" id="inputPassword3" placeholder="Name">-->
                    </div>
                </div>

                <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6 form-group">
                    <label for="inputEmail3" class="control-label">{{Lang::get('service::lang.email')}}</label>
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        {!! Form::email('email',null,['class'=>'form-control']) !!}
                        <!--<input type="email" class="form-control" name="email" placeholder="Email">-->
                    </div>
                </div>
            </div>


            <div class="form-group">


                <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6 form-group">
                    <label for="name" class="control-label">{{Lang::get('service::lang.primary_contact')}}</label>
                    <div class="form-group {{ $errors->has('primary_contact') ? 'has-error' : '' }}">
                        {!! Form::text('primary_contact',null,['class'=>'form-control']) !!}
                        <!--<input type="text" name="primary_contact" class="form-control" id="inputPassword3" placeholder="Primary Contact">-->
                    </div>
                </div>

                <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6 form-group">
                    <label for="inputEmail3" class="control-label">{{Lang::get('service::lang.address')}}</label>
                    <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                        {!! Form::text('address',null,['class'=>'form-control']) !!}
                        <!--<input type="text" class="form-control" name="address" placeholder="Address">-->
                    </div>
                </div>
            </div>


            <div class="form-group">
                <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6 form-group">
                    <label for="name" class="control-label">{{Lang::get('service::lang.status')}}</label>
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                        <div class="row">
                            <div class="col-md-6">
                                <p>{!! Form::radio('status',0) !!} Inactive</p>
                            </div>
                            <div class="col-md-6">
                                <p>{!! Form::radio('status',1,true) !!} Active</p>
                            </div>
                        </div>
                        <!--<input type="text" name="status" class="form-control" id="inputPassword3" placeholder="Status">-->
                    </div>
                </div>

                <!--            <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6 form-group">
                                <label for="inputEmail3" class="control-label">{{Lang::get('service::lang.all_department')}}</label>
                                <div class="form-group {{ $errors->has('all_department') ? 'has-error' : '' }}">
                                    {!! Form::text('all_department',null,['class'=>'form-control']) !!}
                                    <input type="text" class="form-control" name="all_department" placeholder="All Department">
                                </div>
                            </div>-->
            </div>

            <div class="form-group">
                <div class="col-xs-11 col-md-11 col-sm-11 col-lg-11">
                    <label for="internal_notes" class="control-label">{{Lang::get('service::lang.description')}}</label>
                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                        {!! Form::textarea('description',null,['class'=>'form-control']) !!}
                        <!--<textarea class="form-control textarea" name="description" rows="7" id="" placeholder="description"></textarea>-->
                    </div>
                </div>
            </div>
        </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="close" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="{{Lang::get('lang.save')}}">
                {!! Form::close() !!}
            </div>
            <!-- /Form -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
    $(function () {
        $("#impact").wysihtml5();
    });
</script>