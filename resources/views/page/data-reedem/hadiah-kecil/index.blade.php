@extends('page.template.master')
@section('content')
<br>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Reedem - Hadiah Kecil</h3>
        <div class="card-tools">
            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-plus"></i> &nbsp; Input Manual</button> -->
        </div>
    </div>
    <div class="card-body">
        <form action="{{ url('/data-reedem-hadiah-kecil') }}" method="get">
            @csrf
            <div class="row">
                <div class="col-md-2">
                    <input type="date" class="form-control" name="start_date" id="" value="{{ !empty(request()->get('start_date')) ? request()->get('start_date'): "" }}">
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" name="end_date" id="" value="{{ !empty(request()->get('end_date')) ? request()->get('end_date'): "" }}">
                </div>
                <div class="col-md-2">
                    <input type="text" name="search" class="form-control" id="" placeholder="Search" value="{{ !empty(request()->get('search')) ? request()->get('search'): "" }}">
                </div>
                <div class="col-md-2">
                    <select class="form-control" aria-label="Default select example" name="filter_hadiah">
                        <option value="" selected>Pilih</option>
                        <option value="2">Pulsa 10.000</option>
                        <option value="3">Belum Beruntung</option>
                    </select>

                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Search</button>
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
        </form>
    </div>
    <div class="col-md-12">
        <table class="table tablr-striped table-bordered" id="example">
            <thead>
                <th>No</th>
                <th>MSISDN</th>
                <th>Nama</th>
                <th>Kode Unik</th>
                <th>NIK</th>
                <th>Kota</th>
                <th>Reedem Tanggal</th>
                <th>Hadiah</th>
            </thead>
            <tbody>
                @if(count($response) > 0)
                    @foreach($response as $res)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $res->msisdn ?$res->msisdn : '' }}</td>
                            <td>{{ $res->name ?$res->name : '' }}</td>
                            <td>{{ $res->code ?$res->code : '' }}</td>
                            <td>{{ $res->nik ?$res->nik : '' }}</td>
                            <td>{{ $res->city ?$res->city : '' }}</td>
                            <td>{{ $res->redeem_date ?  date('d-M-y h:i:s', strtotime($res->redeem_date)) : '' }}</td>
                            <td>{{ $res->reward ? $res->reward : '' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="10"><center>Data Not Found</center></td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="row">
            <div class="col-md-3">Showing <strong>1</strong> to <strong>{{ $last > '20' ? '20' : count($response)  }}</strong> of <strong>{{ $total_record }}</strong> entries</div>
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
                    <a href="{{ url('/data-reedem-hadiah-kecil?page=' .$minus )}}" class="btn btn-primary"><</a>
                    <a href="{{ url('/data-reedem-hadiah-kecil?page=1') }}" class="btn btn-primary">1</a>
                    ...
                @endif
                @for ($page = $hal_awal; $page <= $hal_akhir; $page++)
                    @if($page == $current)
                        <a class="btn btn-default">{{ $page }}</a>
                    @else
                        <a href="{{ url('/data-reedem-hadiah-kecil?page='.$page) }}" class="btn btn-primary">{{ $page }}</a>
                    @endif
                @endfor

                @if($lastP == 1)
                    ...
                    <a href="{{ url('/data-reedem-hadiah-kecil?page='.$last) }}" class="btn btn-primary">{{ $last }}</a>
                    <a href="{{ url('/data-reedem-hadiah-kecil?page=' .$plus )}}" class="btn btn-primary">></a>
                @endif
            </div>
        </div><br>
    </div>
</div>
<!-- Large modal -->
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
