@extends('page.template.master')
@section('content')
<br>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Ringkasan Hadiah</h3>
        <div class="card-tools">
            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-plus"></i> &nbsp; Input Manual</button> -->
        </div>
    </div>
    <div class="card-body">
    <div class="col-md-12">
        <table class="table tablr-striped table-bordered" id="example">
            <thead>
                <!-- <th>No</th> -->
                <th>Hadiah</th>
                <th>Total hadiah</th>
                <th>Terpakai</th>
                <th>Sisa Hadiah</th>
            </thead>
            <tbody>
                <tr>
                    <!-- <td></td> -->
                    <td>{{ $response->reward }}</td>
                    <td>{{ $response->total }}</td>
                    <td>{{ $response->used }}</td>
                    <td>{{ $response->remaining }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- Large modal -->
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
</script>
@endsection
