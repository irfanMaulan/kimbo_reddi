@extends('page.template.master')
@section('content')
<br>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List Download</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-plus"></i> &nbsp; Request Download</button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <input type="date" class="form-control" name="start_date" id="">
            </div>
            <div class="col-md-4">
                <input type="date" class="form-control" name="end_date" id="">
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-primary">Search</button>
            </div>
            <!-- <div class="col-md-3">
                <select class="form-select" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div> -->
        </div>
    </div>
    <div class="col-md-12">
        <table class="table tablr-striped table-bordered" id="example">
            <thead>
                <th>No</th>
                <th>Id Request</th>
                <th>Jenis Data</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Akhir</th>
                <th>Dibuat Oleh</th>
                <th>Dibuat Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </thead>
            <tbody>
                @if(count($response) > 0)
                    @foreach($response as $nores)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $res->program_id }}</td>
                            <td>{{ $res->reward_type_id }}</td>
                            <td>{{ $res->start_date }}</td>
                            <td>{{ $res->end_date }}</td>
                            <td>{{ $res->user_id }}</td>
                            <td>{{ $res->created_at }}</td>
                            <td>{{ $res->status }}</td>
                            <td><button class="btn btn-success btn-sm">Download</button></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9"><center>Data Not Found</center></td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-3"></div>
            <div class="col-md-2"></div>
            <div class="col-md-4 text-right">
                @php
                    $hal_awal = $current - 2;
                    $hal_akhir = $current + 2;
                    $minus=$current-1;
                    $plus=$current+1;
                    $beginning = 1;
                    $lastP = 1;
                    if($hal_awal <= 1 ){
                        $hal_awal=1;
                        $hal_akhir=$hal_awal+4;
                        $beginning=0;
                    }
                    if($hal_akhir >= $last && $hal_awal > 1 ){
                        $hal_awal = $current - 4;
                        $hal_akhir=$last;
                        $lastP=0;
                    }
                    if($last <= $hal_akhir){
                    $hal_akhir=$last;
                    $lastP=0;
                    }
                @endphp
                @if($beginning == 1)
                    <a href="{{ url('/kode-unik?page=' .$minus )}}" class="btn btn-primary"><</a>
                    <a href="{{ url('/kode-unik?page=1') }}" class="btn btn-primary">1</a>
                    ...
                @endif
                @for ($page = $hal_awal; $page <= $hal_akhir; $page++)
                    @if($page == $current)
                        <a class="btn btn-default">{{ $page }}</a>
                    @else
                        <a href="{{ url('/kode-unik?page='.$page) }}" class="btn btn-primary">{{ $page }}</a>
                    @endif
                @endfor

                @if($lastP == 1)
                    ...
                    <a href="{{ url('/kode-unik?page='.$last) }}" class="btn btn-primary">{{ $last }}</a>
                    <a href="{{ url('/kode-unik?page=' .$plus )}}" class="btn btn-primary">></a>
                @endif
            </div>
        </div><br>
    </div>
</div>
<!-- Large modal -->


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Request Download</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('ringkasan-hadiah/store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">Jenis Data</div>
                        <div class="col-md-9">
                            <select class="form-control" name="reward_type_id" aria-label="Default select example">
                                <option value="">Hadiah Besar</option>
                                <option value="">Hadiah Kecil & Blank</option>
                            </select>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-3">Tanggal Mulai</div>
                        <div class="col-md-9"><input type="date" class="form-control" name="start_date"></div>
                    </div><br>

                    <div class="row">
                        <div class="col-md-3">Tanggal Akhir</div>
                        <div class="col-md-9"><input type="date" class="form-control" name="end_date"></div>
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

    // $(document).ready(function() {
    //     var table = $('#example').DataTable({
    //         "ordering": false
    //     });

    // })
</script>
@endsection
