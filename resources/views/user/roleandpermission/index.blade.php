@extends('layouts.app')

@section('title', 'Team')

<style>
    .btn-with-plus {
        position: relative;
        padding-left: 2.5rem;
        /* Adjust padding to make space for the plus sign */
    }

    .btn-with-plus::before {
        content: "+";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 2rem;
        /* Adjust width to fit the plus sign */
        background-color: blue;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        font-weight: bold;
    }
</style>



@section('content')
    @include('user.roleandpermission.create')





    <div class="page-header">
        <h3 class="fw-bold mb-3">Role & Permission</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="#">
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
                <a href="#">Role & Permission</a>
            </li>
        </ul>
    </div>

    <div class="page-header">
        <button type="button" id="openrolepermissionform" class="btn btn-primary">Add Role & Permission</button>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Role & Permission</h4>
                </div>
                <div class="card-body">

                    <div id="customertable" class="table-responsive">
                        <table style="--bs-table-bg: #ede7e7;"
                            class=" role-permission-data-table   table table-striped table-bordered w-100 text-sm text-left rtl:text-right text-black-500">
                            <thead class="bg-light border-bottom">
                                <tr>
                                    <th class="px-4 py-2 border-end">Sr No.</th>
                                    <th class="px-4 py-2 border-end">Role</th>
                                    {{-- <th class="px-4 py-2 border-end">Permission</th> --}}
                                    <th class="px-4 py-2">Created Date</th>
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

            rolePermissionList();

            $("#openrolepermissionform").on('click', function() {
                $("#role_name").val(" ");
                 $("#role_id").val(" ");

                $("#rolePermissionModalLabel").html("Add Role & Permission")
               $("#submit-add-role").html("Add Role");

               $('input[name="permissions[]"]').prop("checked",false);

                $("#rolepermissionformId").modal('show');
            });

            $("body").on("click", ".parent-item", function(e) {
                let checked = $(this).prop('checked');
                let child = $(this).data('parent');
                $("input[data-child='" + child + "'").each(function() {
                    $(this).prop('checked', checked);
                });
            });

            $("body").on("click", "#toggle-permissions", function() {
                $(".permissions-list").find("input").prop('checked', $(this).prop('checked'));
            });



        });

        let checkboxpermission = $('input[name="permissions[]"]');

        $("#toggle-permissions").on('change', function() {
            if ($(this).is(':checked')) {


                checkboxpermission.prop("checked", true);


            } else {
                checkboxpermission.prop("checked", false);




            }
        });



        function rolePermissionList() {

            var table = $('.role-permission-data-table').DataTable({
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
                    url: "{{ route('admin.role-permission-list') }}",
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


                    },
                    // {
                    //     data: 'permissions',
                    //     name: 'permissions',
                    //     orderable: true,
                    //     searchable: true,
                    

                    // },

                    {
                        data: 'created_at',
                        name: 'created_at',
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







        $("#submit-add-role").on('click', function(e) {

            e.preventDefault();

            let formData = new FormData();

            var checkedValues = $('input[name="permissions[]"]:checked').map(function() {
                return this.value;
            }).get();

        

            checkedValues.forEach(function(value) {

                formData.append("permissions[]", value);

            });




            if($("#role_id").val()!=""){
                formData.append('id',$("#role_id").val());
            }


            formData.append('role_name', $("#role_name").val());

            formData.append("_token", "{{ csrf_token() }}")



            $.ajax({
                url: "{{ route('admin.role-permission-save') }}",
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
                    rolePermissionList();
                    $("#rolepermissionformId").modal('hide');


                    toastr.success("Role and Permission add Successfully");


                },
                error: function(xhr) {
                    if (xhr.status == 422) {
                        var errorMessageBrand = xhr.responseJSON.errormessage;
                        toastr.error("Something went wrong");
                        for (fieldName in errorMessageBrand) {
                            if (errorMessageBrand.hasOwnProperty(fieldName)) {

                            }
                        }
                    }
                }
            });
        });


        function deleteRolePermission(id) {
            console.log(id);

            var formData = new FormData();
            formData.append('id', id);

            formData.append('_token', "{{ csrf_token() }}")

            Swal.fire({
                title: "Do you want to Delete this Role ?",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Delete",
                denyButtonText: "Don't Delete",

            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: "{{ route('admin.role-permission-delete') }}",
                        type: 'POST',
                        data: formData,
                        async: false,
                        cache: false,
                        contentType: false,
                        processData: false,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"),
                        },
                        beforeSend: function() {



                        },
                        success: function(data) {
                            rolePermissionList();
                            toastr.success(
                                "Role Delete Sucessfully");

                        },
                        error: function(xhr, status, error) {

                            if (xhr.status == 422) {

                                errorMessage = xhr.responseJSON.errormessage;

                                // for (var fieldName in errorMessage) {

                                //     if (errorMessage.hasOwnProperty(fieldName)) {
                                //         $(`[id="${fieldName}_error"]`).html(
                                //             errorMessage[fieldName][
                                //                 0
                                //             ]);


                                //     }

                                // }



                                toastr.error(
                                    "Somthing get wroung"
                                );





                            }



                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire("Role Not Deleted", "", "info");
                }
            });

        }


        function editRolePermission(id) {

           
            var formData = new FormData();
            formData.append('id', id);

            formData.append('_token', "{{ csrf_token() }}");

            $.ajax({
                url: "{{ route('admin.role-permission-edit') }}",
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"),
                },
                beforeSend: function() {

                    $('input[name="permissions[]"]').prop("checked",false);

                },
                success: function(data) {

                    

                   
                    let roleName = data.rolePermission[0].name;

                    let roleId=data.rolePermission[0].id;

                    let permissions = data.rolePermission[0].permissions;

                    permissions.forEach(permission => {
                        $(`input[name='permissions[]'][value='${permission.name}']`).prop('checked',
                            true);
                    });

                    $("#role_name").val(roleName);
                    $("#role_id").val(roleId);

                    $("#rolePermissionModalLabel").html("Edit Role & Permission")
                    $("#submit-add-role").html("Edit Role");

                    $("#rolepermissionformId").modal('show');

                

                    

                },
                error: function(xhr, status, error) {

                    if (xhr.status == 422) {

                        errorMessage = xhr.responseJSON.errormessage;

                        toastr.error(
                            "Somthing get wroung"
                        );


                    }



                }
            });

        }

     



    </script>


@endsection
