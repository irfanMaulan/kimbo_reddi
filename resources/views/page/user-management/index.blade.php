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
                    <h3 class="card-title">List Users</h3>
                </div>
                <div class="col-md-6 text-right">
                    <button type="button" class="btn add-user" data-toggle="modal" data-target=".bd-example-modal-lg" style="color: #ffff;background-color: #DC3C4D;border-radius: 10px;"><i class="fa fa-plus"></i> &nbsp; Add New Users</button>
                </div>
            </div>

            <form action="{{ url('/user-management/delete') }}" method="POST" id="user-delete-form">
                @csrf
                <input type="hidden" name="id" id="user-id-delete">
            </form>

            <!-- modal -->
            <form action="{{ url('/user-management/store') }}" method="POST" id="user-form">
                <div id="user-modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-title-user">Add New User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <!-- data-dismiss="modal" aria-label="Close" -->
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @csrf
                                <input type="hidden" name="id" id="user-id-input">
                                <div class="form-group">
                                    <label for="name">Username</label>
                                    <input type="text" class="form-control require_name"  id="disabled_update" name="username" placeholder="Enter Username" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Name</label>
                                    <input type="text" class="form-control require_name" name="name" placeholder="Enter name" required>
                                </div>
                                <div class="form-group pass_area">
                                    <label for="password">Password</label>
                                    <input id="password-field" type="password" class="form-control require_pass validate_pass" name="password" placeholder="Enter Password">
                                    <!-- <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span> -->
                                </div>
                                <div id="password_strength"></div>
                                <div class="role-area" style="margin-bottom: -8px;">
                                    <label for="">Role</label><br>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input superadmin" type="radio" name="role" id="inlineRadio1" value="superadmin">
                                                <label class="form-check-label" for="inlineRadio1">Superadmin</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input admin" type="radio" name="role" id="inlineRadio2" value="admin">
                                                <label class="form-check-label" for="inlineRadio2">Admin</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                            <div class="modal-footer">
                                <button type="button" style="border-radius: 10px;" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>
                                <!-- data-dismiss="modal" -->
                                <button type="submit" style="border-radius: 10px;" class="btn btn-danger">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <form action="{{ url('/user-management') }}" method="get" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-9 text-right"><input type="text" class="form-control" name="username" id=""  autocomplete="off"></div>
                            <div class="col-md-2"><button type="submit" class="btn btn-primary "><i class="fa fa-search"></i></button></div>
                        </div>
                    </div>
                </div><br>
            </form>
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Role </th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($response as $res)
                        <tr>
                            <td>{{ $res->username ? $res->username : "" }}</td>
                            <td>{{ $res->name ? $res->name : "" }}</td>
                            <td>{{ $res->role ? $res->role : "" }}</td>
                            <td>
                                <button type="button" class="btn edit-user" data-row='{{ json_encode($res) }}'><i class="fa fa-edit" ></i> </button>
                                <button type="button" class="btn delete-user" data-id='{{ $res->id }}'><i class="fa fa-trash" ></i> </button>
                            </td>
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
                        <a href="{{ url('/user-management?page=' .$minus )}}" class="btn btn-primary"><</a>
                        <a href="{{ url('/user-management?page=1') }}" class="btn btn-primary">1</a>
                        ...
                    @endif
                    @for ($page = $hal_awal; $page <= $hal_akhir; $page++)
                        @if($page == $current)
                            <a class="btn btn-default">{{ $page }}</a>
                        @else
                            <a href="{{ url('/user-management?page='.$page) }}" class="btn btn-primary">{{ $page }}</a>
                        @endif
                    @endfor

                    @if($lastP == 1)
                        ...
                        <a href="{{ url('/user-management?page='.$last) }}" class="btn btn-primary">{{ $last }}</a>
                        <a href="{{ url('/user-management?page=' .$plus )}}" class="btn btn-primary">></a>
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

    $('.edit-user').click(function() {
        $('#user-form').attr('action', "{{ url('/user-management/put') }}")
        var row = JSON.parse($(this).attr('data-row'))
        console.log('row = ', row)
        // $('.pass_area').hide()
        $('#user-modal').modal('show')
        $('#user-id-input').val(row.id)
        $('[name="username"]').val(row.username)
        $('[name="name"]').val(row.name)
        $('[name="role"]').filter('[value="' + row.role + '"]').prop('checked', true);
        $('[name="role"]').change();
        $('#modal-title-user').text('Edit User')
        console.log(row);
        document.getElementById("disabled_update").readOnly = true;
    })


    $('.add-user').click(function() {
        document.querySelector('#user-form .require_pass').setAttribute('required', true)
        $('#user-form').attr('action', "{{ url('/user-management/store') }}")
        $('.pass_area').show()
        $('#user-id-input').val(0)
        $('[name="username"]').val('')
        $('[name="name"]').val('')
        $('[name="role"]').prop('checked', false);
    })

    $('.delete-user').click(function() {
        var id = $(this).attr('data-id')
        $('#user-id-delete').val(id);
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                swal("Data Has Been Deleted", {
                    icon: "success",
                });
            }
            $('#user-delete-form').submit();
        });
    })
</script>















<!-- <script>
    $(document).ready(function() {

        $('input[type=password]').keyup(function() {
            // keyup code here
            var pswd = $(this).val();
            // alert(pswd)
            //validate the length
            if (pswd.length < 8) {
                $('#length').removeClass('valid').addClass('invalid');
            } else {
                $('#length').removeClass('invalid').addClass('valid');
            }

            //validate letter
            if (pswd.match(/[A-z]/)) {
                $('#letter').removeClass('invalid').addClass('valid');
            } else {
                $('#letter').removeClass('valid').addClass('invalid');
            }

            //validate capital letter
            if (pswd.match(/[A-Z]/)) {
                $('#capital').removeClass('invalid').addClass('valid');
            } else {
                $('#capital').removeClass('valid').addClass('invalid');
            }

            //validate number
            if (pswd.match(/\d/)) {
                $('#number').removeClass('invalid').addClass('valid');
            } else {
                $('#number').removeClass('valid').addClass('invalid');
            }
        }).focus(function() {
            $('#pswd_info').show();
        }).blur(function() {
            $('#pswd_info').hide();
        });

    });
</script> -->
@endsection
