@extends('layouts.app')

@section('title', 'User List')

<style>
    #userrole {
        display: inline-grid;
        gap: 10px;
        /* text-align: center; */
        /* justify-content: center; */
    }

    .role-card-1 {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        transition: all 0.3s cubic-bezier(.25, .8, .25, 1);
        width: 135px;
        height: 35px;
        background-color: #ff8510;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        text-align: center;

    }

    .role-card-1 h5 {
        color: hsl(0deg 25.67% 97.53%);
    }

    .role-card-1:hover {
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
    }

    .close-button {
        position: absolute;
        top: -5px;
        right: -5px;
        cursor: pointer;
        color: #ff8510;
        background-color: #f1eaea;
        width: 15px;
        height: 15px;
        transition: top 0.3s ease;

    }

    .close-button:hover {
        top: -10px;
        /* Adjust to move the button inside on hover */
    }
</style>

@section('content')

    @include('components.status', [
        'modal_id' => 'userstatuschange',
    ])

    @include('components.loader')




    @include('user.userlist.create')

    <div id="edituserformid" class="modal fade" tabindex="-1" role="dialog">

    </div>





    <div class="page-header">
        <h3 class="fw-bold mb-3">Users</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="{{ url('admin/dashboard') }}">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Users</a>
            </li>

            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">User List</a>
            </li>
        </ul>
    </div>

    <div class="page-header">
        <button type="button" id="openadduserform" class="btn btn-primary">Add Users</button>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Users List</h4>
                </div>
                <div class="card-body">

                    <div id="customertable" class="table-responsive">
                        <table style="--bs-table-bg: #ede7e7;"
                            class=" user-data-table   table table-striped table-bordered w-100 text-sm text-left rtl:text-right text-black-500">
                            <thead class="bg-light border-bottom">
                                <tr>
                                    <th class="px-4 py-2 border-end">Sr No.</th>
                                    <th class="px-4 py-2 border-end">Name</th>
                                    <th class="px-4 py-2 border-end">Email</th>
                                    <th class="px-4 py-2">Assign Role</th>
                                    <th class="px-4 py-2">Created At</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dynamic rows will be inserted here -->
                            </tbody>
                        </table>
                    </div>



                </div>
            </div>
        </div>


    </div>

@endsection


@section('page-script')

    <script>
        $(document).ready(function() {
            $("#roles").select2({
                dropdownParent: $("#adduserformid")
            });
            userListdataTable();

        });

        function userListdataTable() {
            var table = $('.user-data-table').DataTable({
                dom: '<"top"lfB>rt<"bottom"ip><"clear">', // Customize the dom to remove default search input
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    }
                ],
                stateSave: true,
                processing: true,
                serverSide: true,
                fixedHeader: true,
                "bDestroy": true,

                ajax: {
                    url: "{{ route('admin.user-list') }}",
                    type: "get",
                    data: {
                        _token: "{{ csrf_token() }}"
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'serial_number',
                        orderable: false,
                        searchable: false,


                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        searchable: true,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('id', 'name' + rowData.id);
                        }


                    },
                    {
                        data: 'email',
                        name: 'email',
                        orderable: true,
                        searchable: true,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('id', 'email' + rowData.id);
                        }

                    },

                    {
                        data: 'role',
                        name: 'role',
                        orderable: true,
                        searchable: true,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('id', 'role' + rowData.id);
                        }


                    },
                    {
                        data: 'created_date',
                        name: 'created_date',
                        orderable: true,
                        searchable: false,

                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        searchable: false,

                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: false,

                    }
                ],
                language: {
                    lengthMenu: "Show _MENU_ Entries per Page",
                }

            });


        }



        function changeStatus(id) {
            $("#userstatuschange").modal('show');

            $('#savestauschanges').off('click').on('click', function(e) {
                e.preventDefault();


                var formData = new FormData();
                formData.append('userId', id);
                formData.append('status', $("#status-select").val());
                formData.append('_token', "{{ csrf_token() }}")


                $.ajax({
                    url: "{{ route('admin.user.statusupdate') }}",
                    type: 'POST',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    success: (data) => {
                        $("#userstatuschange").modal('hide');
                        let status = data.status == 1 ? "Active" : "Inactive";
                        let status_btn = data.status == 1 ? 'btn btn-success' : 'btn btn-danger';
                        toastr.success("Status Updated Successfully");
                        $(`#statuschange${data.id}`).html(status).attr("class", status_btn);
                    },
                    error: function(xhr) {
                        if (xhr.status == 422) {
                            var errorMessageBrand = xhr.responseJSON.errormessage;
                            toastr.error("Something went wrong");
                            for (fieldName in errorMessageBrand) {
                                if (errorMessageBrand.hasOwnProperty(fieldName)) {
                                    $(`[id="mesaurement_parameter_error_id"`).html(errorMessageBrand[
                                        fieldName][0]);
                                }
                            }
                        }
                    }
                });
            });


        }


        function editUser(id) {

            formData = new FormData();
            formData.append('id', id);

            formData.append('_token', "{{ csrf_token() }}");

            $.ajax({
                url: "{{ route('admin.user-edit') }}",
                type: 'POST',
                data: formData,
                async: true,
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"),
                },
                beforeSend: function() {

                    $("#spinner-div").show();

                },
                success: function(data) {

                    $("#spinner-div").hide();

                    $("#edituserformid").html(data.editHtml);

                    $("#roles_edit").select2({
                        dropdownParent: $("#edituserformid")
                    });
                    $("#edituserformid").modal('show');

                    updateUserProfile();
                },
                error: function(xhr, status, error) {

                    $("#spinner-div").hide();

                    if (xhr.status == 422) {

                        errorMessage = xhr.responseJSON.errormessage;

                        toastr.error(
                            "Somthing get wroung"
                        );


                    }



                }
            });


        }



        $("#openadduserform").on('click', function() {

            $("#adduserformid").modal('show');
        });





        $("#add-user-button").on('click', function(e) {

            e.preventDefault();

            let formData = new FormData();

            formData.append("name", $("#name").val());

            formData.append("email", $("#email").val());

            formData.append("password", $("#password").val());

            formData.append("password_confirmation", $("#password_confirmation").val());

            formData.append("roles", $("#roles").val());

            formData.append("_token", "{{ csrf_token() }}")



            $.ajax({
                url: "{{ route('admin.user-save') }}",
                type: 'POST',
                data: formData,
                async: true,
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },

                beforeSend: function() {
                    $("#name_error").html(" ");

                    $("#email_error").val(" ");

                    $("#password_error").val(" ");

                    $("#spinner-div").show();


                },
                success: (data) => {
                    $("#spinner-div").hide();
                    $("#adduserformid").modal('hide');


                    toastr.success("New User add Successfully");


                },
                error: function(xhr) {
                    $("#spinner-div").hide();
                    if (xhr.status == 422) {
                        var errorMessage = xhr.responseJSON.errormessage;
                        toastr.error("Something went wrong");
                        for (fieldName in errorMessage) {
                            if (errorMessage.hasOwnProperty(fieldName)) {

                                $(`[id="${fieldName}_error"]`).html(
                                    errorMessage[fieldName][
                                        0
                                    ]);




                            }
                        }
                    }
                }
            });
        });



        function updateUserProfile() {
            $("#update-user-button").on('click', function(e) {
                e.preventDefault();

                let formData = new FormData();

                formData.append("name", $("#name_edit").val());

                formData.append("email", $("#email_edit").val());

                formData.append("password", $("#password_edit").val());

                formData.append("id", $("#user_id").val());

                formData.append("password_confirmation", $("#password_confirmation_edit").val());

                formData.append("roles", $("#roles_edit").val());

                formData.append("_token", "{{ csrf_token() }}")



                $.ajax({
                    url: "{{ route('admin.user-update') }}",
                    type: 'POST',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },

                    beforeSend: function() {
                        $("#name_edit_error").html(" ");

                        $("#email_edit_error").val(" ");

                        $("#password_edit_error").val(" ");




                    },
                    success: (data) => {

                        $("#edituserformid").modal('hide');



                        let userId = data.user.id;

                        let userRoles = data.roles;






                        $(`#name${userId}`).html(data.user.name);
                        $(`#email${userId}`).html(data.user.email);

                        if (userRoles && userRoles != 0) {


                            let roleHtml = `<label for="positiveNumber" id="userrole">`;
                            for (value of userRoles) {

                                roleHtml = roleHtml + `
                                        <div class="role-card-1">
                                        <h5>${value}</h5>
                                        </div>
                                       `;

                            }

                            roleHtml = roleHtml + `</label>`;



                            $(`#role${userId}`).html(roleHtml);
                        }


                        if (userRoles == 0) {

                            let roleHtml = `<label for="positiveNumber" id="userrole">`;


                            roleHtml = roleHtml + `
                                        <div class="role-card-1 btn btn-danger">
                                        <h5>No Roles</h5>
                                        </div>
                                       `;



                            roleHtml = roleHtml + `</label>`;



                            $(`#role${userId}`).html(roleHtml);
                        }


                        toastr.success(" User Updated Successfully");


                    },
                    error: function(xhr) {
                        if (xhr.status == 422) {
                            var errorMessage = xhr.responseJSON.errormessage;
                            toastr.error("Something went wrong");
                            for (fieldName in errorMessage) {
                                if (errorMessage.hasOwnProperty(fieldName)) {

                                    $(`[id="${fieldName}_edit_error"]`).html(
                                        errorMessage[fieldName][
                                            0
                                        ]);




                                }
                            }
                        }
                    }
                });


            });
        }
    </script>

@endsection
