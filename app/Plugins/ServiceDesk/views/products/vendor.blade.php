<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Vendors</h3>
        <div class="pull-right">
            <div class="btn-group">

                <a href="#add" data-toggle="modal" class="btn btn-primary" data-target="#add{{$product->id}}">Add New</a>

            </div>
            <div class="btn-group">

                <a href="#existing" data-toggle="modal" class="btn btn-primary" data-target="#existing{{$product->id}}">Add Existing</a>

            </div>
        </div>
    </div>
    <!--/.box-header--> 
    <div class="box-body">
        <table class="table table-condensed">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Action</th>
            </tr>

            <?php
            $i = 1;
            ?>
            @forelse($product->vendors() as $vendor)
            <tr>
                <td>{{$i}}</td>
                <td><a href="{{url('service-desk/vendor/'.$vendor->id.'/show')}}">{{$vendor->name}}</a></td>
                <td>{{$vendor->email}}</td>
                <td>{{$vendor->primary_contact}}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{url('service-desk/vendor/'.$vendor->id.'/edit')}}" class="btn btn-info">Edit</a>
                    </div>
                    <div class="btn-group">
                        <?php
                        $url = url('service-desk/products/' . $product->id . '/remove/' . $vendor->id . '/vendor');
                        $delete = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::deletePopUp($vendor->id, $url, "Delete $vendor->name", "btn btn-danger");
                        ?>
                        {!! $delete !!}
                    </div>
                </td>
            </tr>
            <?php $i++; ?>
            @empty 
            <tr><td>No vendor Associated</td></tr>
            @endforelse

        </table>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
@include('service::products.popup.addnew-vendor')
@include('service::products.popup.addexisting-vendor')
