@extends('page.template.master')
@section('content')
<br>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Program Management</h3>
        <div class="card-tools">

        </div>
    </div>
    <div class="card-body">
        <div class="col-md-12">
            <table class="table tablr-striped table-bordered" id="example">
                <thead>
                    <th>No</th>
                    <th>Deskripsi</th>
                    <th>Periode</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $response->data->description }}</td>
                        <td>{{ date('d-M-y', strtotime($response->data->start_date)) }} - {{ date('d-M-y', strtotime($response->data->end_date)) }}</td>
                        <td><button type="button" class="btn btn-primary btn-sm" id="btn_update" data-id='{{ json_encode($response->data) }}' data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-edit"></i> &nbsp; Update</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Large modal -->


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Hadiah Besar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('program/update') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2">Detail</div>
                        <div class="col-md-10"><textarea name="description" class="form-control" id="deskripsi"  cols="10" rows="5"></textarea></div>
                    </div><br>

                    <div class="row">
                        <div class="col-md-2">Periode</div>
                        <div class="col-md-5"><input type="date" class="form-control" id="start" name="start_date" value=""></div>
                        <div class="col-md-5"><input type="date" class="form-control" id="end" name="end_date" value=""></div>
                    </div><br>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script>

    $(document).ready(function() {
        var table = $('#example').DataTable({
            "ordering": false
        });

    })

    $('#btn_update').click(function(){
        let getData = JSON.parse($(this).attr("data-id"));
        console.log(getData.id)
        $('#deskripsi').val(getData.description)
        $('#start').val(getData.start_date)
        $('#end').val(getData.end_date)
    })
</script>
@endsection
