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
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Kode Uniq</h3>
        <div class="card-tools">

        </div>
    </div>
    <div class="card-body">
        <form action="{{ url('/kode-unik') }}" method="get">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <select class="form-control" name="reward_type_detail_id" aria-label="Default select example">
                        <option value="" selected>Hadiah</option>
                        <option value="1" {{ request()->get('reward_type_detail_id') == 1 ? "selected":"" }}>Umroh</option>
                        <option value="2" {{ request()->get('reward_type_detail_id') == 2 ? "selected":"" }}>Pulsa</option>
                        <option value="3" {{ request()->get('reward_type_detail_id') == 3 ? "selected":"" }}>Belum Beruntung</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control" name="status" aria-label="Default select example">
                        <option value="" selected>Status</option>
                        <option value="used" {{ request()->get('status') == 'used' ? "selected":"" }}>Terpakai</option>
                        <option value="available" {{ request()->get('status') == 'available' ? "selected":"" }}>Tersedia</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="code" class="form-control" id="" placeholder="Search" value="{{ !empty(request()->get('code')) ? request()->get('code'): "" }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" id="btn_search" class="btn btn-primary">Search</button>
                </div>
            </div>
            <br>
            <div class="col-md-10"></div>
        </form>
        <!-- <form action="{{ url('/kode-unik') }}" method="get">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <select class="form-control" name="page" id="total_page" aria-label="Default select example" style="width: 25%;">
                        <option value="20" selected>20</option>
                        <option value="40">40</option>
                        <option value="60">60</option>
                        <option value="80">80</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <div class="col-md-3 text-end">
                    <div class="search-container">
                        <div class="row">
                            <div class="col-md-2"><button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button></div>
                        </div>
                    </div>
                </div>
            </div>
        </form> -->
    </div>

    <div class="col-md-12">
        <table class="table tablr-striped table-bordered" id="example">
            <thead>
                <th>No</th>
                <th>Kode Unik</th>
                <th>Hadiah</th>
                <th>Status</th>
                <th>Aksi</th>
            </thead>
            <tbody>
                @foreach($response as $res)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $res->code ? $res->code : '' }}</td>
                        <td>{{ $res->reward ? $res->reward : '' }}</td>
                        <td>{{ $res->status ? $res->status : '' }}</td>
                        <!-- <td><button type="button" class="btn btn-success" id="btn_update" data-toggle="modal" data-json="{{json_encode($res)}}" data-target=".bd-example-modal-lg"><i class="fas fa-edit"></i> &nbsp; Edit</button></td> -->
                        <td>
                            <button type="button" class="btn show-modal-data" data-json='{{ json_encode($res) }}' data-toggle="modal" data-target="#exampleModalCenter">
                                <i class="fa fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
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

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <form action="{{ url('kode-unik/update') }}" method="post">
        @csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">Kode Uniq</div>
                        <div class="col-md-9"><input type="text" class="form-control" id="kode_uniq" name="kode_uniq" value="" disabled></div>
                        <input type="hidden" name="id_uniq" id="id_uniq">
                    </div><br>

                    <div class="row">
                        <div class="col-md-3">Hadiah</div>
                        <div class="col-md-9">
                            <select class="form-control" name="reward_type_detail_id" aria-label="Default select example">
                                <!-- <option selected disabl>Hadiah</option> -->
                                <option value="1">Umroh</option>
                                <option value="2">Pulsa</option>
                                <option value="3">Belum Beruntung</option>
                            </select>
                        </div>
                    </div><br>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('script')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script>

    // $(document).ready(function() {
    //     var table = $('#example').DataTable({
    //         "ordering": false,
    //         "processing": true,
    //     });

    // })

    $("#forn_search").keyup(function () {
        code = $(this).val();
        $.ajax({
            url: "{{url('/kode-unik')}}",
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
            },
            cache: false,
            success: function(data) {
                console.log(data)
            },
        });
    });

    $('.show-modal-data').click(function() {
        var datas = JSON.parse($(this).attr('data-json'))
        console.log('asdasda =', datas)

        $('[name="kode_uniq"]').val(datas.code);
        $('[name="id_uniq"]').val(datas.id);
        $('[name="reward_type_detail_id"]').val(datas.reward_type_detail_id).change()
        // $('#code_prod').html(row.product_code)
        // document.getElementById('code_prod').innerText = datas.product_code;
        // document.getElementById('prod_name').innerText = datas.product_name;


    })
</script>
@endsection
