<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Requests Associated with {{ucfirst($asset->name)}}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {!! Datatable::table()
                    ->addColumn( 
                    Lang::get('service::lang.subject'),
                    Lang::get('service::lang.request'),
                    Lang::get('service::lang.status'),
                    Lang::get('service::lang.created')
                    )
                    ->setUrl(url('service-desk/assets/requesters?assetid='.$asset->id))  // this is the route where data will be retrieved
                    ->setOrder(array(3=>'desc'))
                    ->render() !!}
    </div>
    <!-- /.box-body -->
</div>