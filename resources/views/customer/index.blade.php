@extends('layouts.app')

@section('title', 'Customers')

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

    .modal-dialog-aside {
        width: 44% !important;
    }

    .status {
        cursor: pointer;
    }

    @media only screen and (min-width:941px) {
        .export-app-mob {
            display: none;
        }
    }

    @media only screen and (max-width:941px) {
        .export-app-web {
            display: none;
        }
    }

    .dt-search {
        display: flex;
        justify-content: end;
    }

    .dt-search label {
        margin-top: 10px;
    }
</style>



@section('content')
    @include('components.loader')
    @include('components.sidemodal')

    @include('customer.manage')

    @include('components.status')



    <div class="page-header">
        <h3 class="fw-bold mb-3">Customers</h3>
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
                <a href="#">Customers</a>
            </li>

        </ul>
    </div>

    <div class="page-header">
        <button type="button" id="openCustomerModalButton" class="btn btn-primary">Add Customer</button>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Customers List</h4>
                </div>
                <div class="card-body">

                    <div id="customertable" class="table-responsive">
                        <table style="--bs-table-bg: #ede7e7;"
                            class=" customers-data-table   table table-striped table-bordered w-100 text-sm text-left rtl:text-right text-black-500">
                            <thead class="bg-light border-bottom">
                                <tr>
                                    <th class="px-4 py-2 border-end">Sr No.</th>
                                    <th class="px-4 py-2 border-end">Name</th>
                                    <th class="px-4 py-2 border-end">Email</th>
                                    <th class="px-4 py-2 border-end">Image</th>
                                    <th class="px-4 py-2 border-end">Verification</th>
                                    <th class="px-4 py-2 border-end">Status</th>


                                    <th class="px-4 py-2">Created Date</th>
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
        $("#openCustomerModalButton").on('click', function() {

            $("#name_error").html(" ");

            $("#email_error").html(" ");

            $("#password_error").html(" ");



            let imageHtmlContentId = {
                uploadAreaId: 'uploadCustomerId',
                dropZoomId: 'dropZoomCustomerId',
                loadingTextId: 'loadingTextCustomerId',
                previewImageId: 'previewImageCustomerId',
                fileInputId: 'fileInputCustomerId',
                fileDetailsId: 'fileDetailsCustomerId',
                uploadedFileId: 'uploadedFileCustomerId',
                uploadedFileInfoId: 'uploadedFileInfoCustomerId'
            };

            imagePreveiewUpload(imageHtmlContentId);


            $("#addCustomerId").modal('show');
            $("#customer_registration")[0].reset();
        });



        //  function openModalCustomerAdd(){
        //     console.log("csdfdsf");
        //         $("#addcustomerid").modal('show');
        //     }



        $(document).ready(function() {
            customerDetailsDataTable();

            $('#search-form').on('keyup', function(e) {
                e.preventDefault();
                var searchValue = $('#simple-search').val();
                $('.customers-data-table').DataTable().search(searchValue).draw();
            });
        });

        function customerDetailsDataTable() {
            var table = $('.customers-data-table').DataTable({
                dom: '<"top"lfB>rt<"bottom"ip><"clear">',
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: [0, 1, 2]
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 2]
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2]
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'Export to PDF',
                        exportOptions: {
                            columns: [0, 1, 2]
                        },
                        action: function(e, dt, button, config) {
                            generateCustomPDF('customers-data-table', 3, [0, 1, 2, 3], 'customer-list.pdf');
                        }
                    },

                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2]
                        }
                    }
                ],
                stateSave: true,
                processing: true,
                serverSide: true,
                fixedHeader: true,
                "bDestroy": true,
                ajax: {
                    url: "{{ route('admin.customer.detail') }}",
                    type: "GET",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },


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
                    {
                        data: 'email',
                        name: 'email',
                        searchable: true,
                    },
                    {
                        data: 'customer_image',
                        name: 'customer_image',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'verification_status',
                        name: 'verification_status',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'created_date',
                        name: 'created_date',
                        orderable: true,
                        searchable: false,
                    }
                ],
                language: {
                    lengthMenu: "Show _MENU_ Entries per Page",
                },

            });


        }





        $("#add-customer-button").on('click', function(e) {
            e.preventDefault();


            let formData = new FormData($("#customer_registration")[0]);

            $.ajax({
                url: "{{ route('admin.customer.save') }}",
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

                    $("#email_error").html(" ");

                    $("#password_error").html(" ");
                    $("#spinner-div").show();



                },
                success: (data) => {
                    $("#spinner-div").hide();
                    $("#addCustomerId").modal('hide');
                    $("#previewImageCustomerId").attr('src', "{{ asset('defaultimage.png') }}");

                    toastr.success(
                        "Customer Profile Created Successfully,Credential send to  registered email"
                        );
                    customerDetailsDataTable();




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





        })












        // $(document).ready(function() {
        //     customerDetailsDataTable();
        // });


        function changePage(page) {
            $('.customers-data-table').DataTable().page(page - 1).draw('page');
        }




        function changeStatus(id) {
            let customerId = id;


            $("#changeStatusId").modal('show');


            $('#savestauschanges').off('click').on('click', function(e) {
                e.preventDefault();


                var formData = new FormData();
                formData.append('customerId', customerId);
                formData.append('status', $("#status-select").val());
                formData.append('_token', "{{ csrf_token() }}")


                $.ajax({
                    url: "{{ route('admin.customer.statusupdate') }}",
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




                        $("#changeStatusId").modal('hide');
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


        $(document).on('click', '.admin-message', function() {


            $("#dynamic-modal").modal('show');

            $('.dynamic-body').html("dasfaffafafff");
            $('.dynamic-title').text('');
            message_scenario = $(this).attr("data-custom");

            id = $(this).data('id');
            $.ajax({
                url: "{{ url('admin/case') }}" + "/" + id + "/" + "message",
                method: "GET",
                data: {
                    _token: "{{ csrf_token() }}",
                    message_scenario: message_scenario,

                },
                beforeSend: function() {
                    $(".dynamic-apply").html("");
                    $(".dynamic-body").html("");
                },
                success: function(data) {
                    $('.dynamic-body').html(data);
                    initMessageScript(id);
                }
            })
        });
    </script>

@endsection
