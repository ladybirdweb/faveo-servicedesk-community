<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Additional Information of {{ucfirst($asset->name)}}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-condensed">

                    <?php $i = 1; ?>
                    @forelse($asset->additionalData() as $index=>$data)
                    <?php
                    if ($i/2 == 0) {
                        echo "<tr>";
                    }
                    ?>
                    <td>{{$index}}</td>
                    <td>
                        {!!$data!!}
                    </td>
                    <?php
                    if ($i % 2 == 0) {
                        echo "</tr>";
                    }
                    $i++;
                    ?>
                    @empty 
                    <td>No Additional Informations</td>
                    @endforelse

                    </tr>

                </table>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>