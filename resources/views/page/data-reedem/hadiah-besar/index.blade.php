@extends('page.template.master')
@section('content')
<br>
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" id="success-notif" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
@elseif (session('failed'))
    <div class="alert alert-danger alert-dismissible fade show" id="error-notif" role="alert">
            {{ session('failed') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
@endif
<style>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Reedem - Hadiah Besar</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-plus"></i> &nbsp; Input Manual</button>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ url('/data-reedem-hadiah-besar') }}" method="get">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <input type="date" class="form-control" name="start_date" id="" value="{{ !empty(request()->get('start_date')) ? request()->get('start_date'): '' }}">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" name="end_date" id="" value="{{ !empty(request()->get('end_date')) ? request()->get('end_date'): '' }}">
                </div>
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" id="" placeholder="Search" value="{{ !empty(request()->get('search')) ? request()->get('search'): '' }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>&nbsp; Search</button>
                </div>
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
                <th>Push Notif</th>
                <th>Aksi</th>
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
                                <td>{{ $res->push_notif_date ? date('d-M-y', strtotime($res->push_notif_date)) : '' }}</td>
                                <td><button class="btn btn-success btn-sm"><i class="fa fa-share" aria-hidden="true"></i>&nbsp; Push WA</button></td>
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
                <h5 class="modal-title">Tambah Hadiah Besar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('data-reedem-hadiah-besar/store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">MSISDN</div>
                        <div class="col-md-9"><input type="number" class="form-control" name="msisdn" placeholder="MSISDN"></div>
                    </div><br>

                    <div class="row">
                        <div class="col-md-3">Nama</div>
                        <div class="col-md-9"><input type="text" class="form-control" name="name" placeholder="Nama"></div>
                    </div><br>

                    <div class="row">
                        <div class="col-md-3">NIK</div>
                        <div class="col-md-9"><input type="number" id="nik" onkeyup="validation()" class="form-control" name="nik" placeholder="NIK"></div>
                    </div><br>

                    <div class="row">
                        <div class="col-md-3">Kota</div>
                        <div class="col-md-9"><input type="text" class="form-control" name="city" placeholder="Kota"></div>
                    </div><br>

                    <div class="row">
                        <div class="col-md-3">Hadiah</div>
                        <div class="col-md-9">
                            <select class="form-control" name="reward_type_detail_id" aria-label="Default select example">
                                <option value="1" selected>Umroh</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btn_disabled" disabled>Save changes</button>
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
    function validation(){
        let x = document.getElementById("nik");
        console.log(x.value.length)
        if(x.value.length == 16){
            $('#btn_disabled').prop('disabled', false);
        } else {
            $('#btn_disabled').prop('disabled', true);
        }
    }



</script>
@endsection
