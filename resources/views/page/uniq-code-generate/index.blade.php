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

<div class="container-fluid">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="card-title">List Uniq Code</h3>
                </div>
                <div class="col-md-6 text-right">
                    <button type="button" class="btn add-user" data-toggle="modal" data-target=".bd-example-modal-lg" style="color: #ffff;background-color: #DC3C4D;border-radius: 10px;"><i class="fa fa-plus"></i> &nbsp; Add New Uniq Code</button>
                </div>
            </div>

            <form action="{{ url('/uniq-code-generate/delete') }}" method="POST" id="code-generate-delete-form">
                @csrf
                <input type="hidden" name="id" id="code-id-delete">
            </form>

            <!-- modal -->
            <form action="{{ url('/uniq-code-generate/store') }}" method="POST" id="uniq-form">
                <div id="user-modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-title-user">Add New Uniq Code</h5>
                                <button type="button" class="close" onclick="location.reload()">
                                <!-- data-dismiss="modal" aria-label="Close" -->
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @csrf
                                <input type="hidden" name="id" id="uniq-code-id-input">
                                <div class="form-group">
                                    <label for="name">Description</label>
                                    <input type="text" class="form-control require_name" name="description" placeholder="Enter description" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Total Data</label>
                                    <input type="number" class="form-control require_name" name="total_data" placeholder="Enter Total Data" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Total Umroh</label>
                                    <input type="number" class="form-control require_name" name="total_umroh" placeholder="Enter Total Umroh" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Total pulsa</label>
                                    <input type="number" class="form-control require_name" name="total_pulsa" placeholder="Enter Total pulsa" required>
                                </div>
                                <br>
                            </div>
                            <div class="modal-footer">
                                <button type="button" style="border-radius: 10px;" class="btn btn-outline-danger" onclick="location.reload()">Cancel</button>
                                <!-- data-dismiss="modal" -->
                                <button type="submit" style="border-radius: 10px;" class="btn btn-danger">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <form action="{{ url('/uniq-code-generate') }}" method="get">
                @csrf
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-9 text-right"><input type="text" class="form-control" name="description" id=""></div>
                            <div class="col-md-2"><button type="submit" class="btn btn-primary "><i class="fa fa-search"></i></button></div>
                        </div>
                    </div>
                </div><br>
            </form>
            <table class="table tablr-striped table-bordered" id="example">
                <thead>
                    <th>No</th>
                    <th>description</th>
                    <th>Total Umroh</th>
                    <th>Total Pulsa</th>
                    <th>Total Blank</th>
                    <!-- <th>Total Blank</th> -->
                    <th>Download File</th>
                    <th>Status Generated</th>
                    <th>Date</th>
                </thead>
                <tbody>
                    @foreach($response as $res)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $res->description ? $res->description : '' }}</td>
                            <td>{{ $res->total_umroh ? $res->total_umroh : '' }}</td>
                            <td>{{ $res->total_pulsa ? $res->total_pulsa : '' }}</td>
                            <td>{{ $res->total_blank ? $res->total_blank : '' }}</td>
                            <!-- <td>{{ $url1 }}</td> -->
                            @if($res->is_generating == true)
                                <td><button class="btn btn-success btn-sm" disabled>Download</button> </td>
                            @else
                                <td><a href="{{ $res->file_url }}" class="btn btn-success btn-sm">Download</a> </td>
                            @endif
                            <!-- <td><button type="button" class="btn btn-success" id="btn_update" data-toggle="modal" data-json="{{json_encode($res)}}" data-target=".bd-example-modal-lg"><i class="fas fa-edit"></i> &nbsp; Edit</button></td> -->
                            <td>{{ $res->is_generating == false ? "Finish" : "On Proccess" }}</td>
                            <td>{{ $res->created_at ? date('d M Y H:m', strtotime($res->created_at)) : '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table><br>
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
                        <a href="{{ url('/uniq-code-generate?page=' .$minus )}}" class="btn btn-primary"><</a>
                        <a href="{{ url('/uniq-code-generate?page=1') }}" class="btn btn-primary">1</a>
                        ...
                    @endif
                    @for ($page = $hal_awal; $page <= $hal_akhir; $page++)
                        @if($page == $current)
                            <a class="btn btn-default">{{ $page }}</a>
                        @else
                            <a href="{{ url('/uniq-code-generate?page='.$page) }}" class="btn btn-primary">{{ $page }}</a>
                        @endif
                    @endfor

                    @if($lastP == 1)
                        ...
                        <a href="{{ url('/uniq-code-generate?page='.$last) }}" class="btn btn-primary">{{ $last }}</a>
                        <a href="{{ url('/uniq-code-generate?page=' .$plus )}}" class="btn btn-primary">></a>
                    @endif
                </div>
            </div><br>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">

    function spinner() {
        document.getElementsByClassName("loader").style.display = "block";
    }
</script>

<script>
    $('head').append('<link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet" type="text/css">');

    $('input').focus(function(event) {
        $(this).closest('.float-label-field').addClass('float').addClass('focus');
    })

    $('input').blur(function() {
        $(this).closest('.float-label-field').removeClass('focus');
        if (!$(this).val()) {
            $(this).closest('.float-label-field').removeClass('float');
        }
    });

    // $('.edit-user').click(function() {
    //     $('#uniq-form').attr('action', "{{ url('/uniq-code-generate/put') }}")
    //     var row = JSON.parse($(this).attr('data-row'))
    //     console.log('row = ', row)
    //     $('.pass_area').hide()
    //     $('#user-modal').modal('show')
    //     $('#uniq-code-id-input').val(row.id)
    //     $('[name="username"]').val(row.username)
    //     $('[name="name"]').val(row.name)
    //     $('[name="role"]').filter('[value="' + row.role + '"]').prop('checked', true);
    //     $('[name="role"]').change();
    //     $('#modal-title-user').text('Edit User')
    //     console.log(row);
    // })


    $('.add-user').click(function() {
        document.querySelector('#uniq-form .require_pass').setAttribute('required', true)
        $('#uniq-form').attr('action', "{{ url('/uniq-code-generate/store') }}")
        $('#uniq-code-id-input').val(0)
        $('[name="description"]').val('')
        $('[name="total_data"]').val('')
        $('[name="total_umroh"]').val('')
        $('[name="total_pulsa"]').val('')
    })

    // $('.delete-user').click(function() {
    //     var id = $(this).attr('data-id')
    //     $('#code-id-delete').val(id);
    //     swal({
    //         title: "Are you sure?",
    //         text: "Once deleted, you will not be able to recover this imaginary file!",
    //         icon: "warning",
    //         buttons: true,
    //         dangerMode: true,
    //     })
    //     .then((willDelete) => {
    //         if (willDelete) {
    //             swal("Data Has Been Deleted", {
    //                 icon: "success",
    //             });
    //         }
    //         $('#code-generate-delete-form').submit();
    //     });
    // })
</script>
@endsection
