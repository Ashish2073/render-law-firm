@extends('layouts.app')

@section('title', 'PushNotification')


@section('content')

@include('components.loader')

    <style>
        .border-color {
            border-color: black !important;
        }

        
    .dt-search {
            display: flex;
            justify-content:end;
        }

        .dt-search label {
            margin-top:10px;
        }
    </style>

    <!-- load breadcrumb and pass values -->
    {{-- <x-breadcrumb ></x-breadcrumb> --}}

    <div class="page-header">
        <h3 class="fw-bold mb-3">Push Notification</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="{{url('admin/dashboard')}}">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Push Notification</a>
            </li>


        </ul>
    </div>


    <div class="page-header">
        <button type="button" id="openSendPushNotifcationform" class="btn btn-primary">Send PushNotification</button>
    </div>

    @include('pushnotification.create')


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> Notificication List</h4>
                </div>
                <div class="card-body">

                    <div id="pushnotificationtable" class="table-responsive">
                        <table style="--bs-table-bg: #ede7e7;"
                            class="push-notification-data-table   table table-striped table-bordered w-100 text-sm text-left rtl:text-right text-black-500">
                            <thead class="bg-light border-bottom">
                                <tr>
                                    <th class="px-4 py-2 border-end">Sr No.</th>
                                    <th class="px-4 py-2 border-end">Title</th>
                                    <th class="px-4 py-2 border-end">Message</th>
                                    <th class="px-4 py-2 border-end">Image</th>
                                    <th class="px-4 py-2 border-end">Status</th>
                                    <th class="px-4 py-2 border-end">Resend Notification</th>
                                </tr>
                            </thead>
                            <tbody>

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
        function resendPushNotification(jobId, id) {

            let formdata = new FormData();
            formdata.append('title', $(`#title${id}`).html());
            formdata.append('description', $(`#description${id}`).html());
            formdata.append('notification_image', $(`#notification_image${id}`).attr('src'));
            formdata.append('jobId', jobId);
            formdata.append('id', id);
            formdata.append("_token", "{{ csrf_token() }}");

            Swal.fire({
                title: "Do you want to send the notification ?",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Send",
                denyButtonText: "Don't send",

            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: "{{ route('admin.notification.save') }}",
                        type: 'POST',
                        data: formdata,
                        async: false,
                        cache: false,
                        contentType: false,
                        processData: false,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"),
                        },
                        beforeSend: function() {

                            $("#title_error").html(" ");

                            $("#description_error").html(" ");

                        },
                        success: function(data) {
                            toastr.success(
                                "Notifications are being sent");

                        },
                        error: function(xhr, status, error) {

                            if (xhr.status == 422) {

                                errorMessage = xhr.responseJSON.errormessage;

                                for (var fieldName in errorMessage) {

                                    if (errorMessage.hasOwnProperty(fieldName)) {
                                        $([id=`"${fieldName}_error"`]).html(
                                            errorMessage[fieldName][
                                                0
                                            ]);


                                    }

                                }



                                toastr.error(
                                    "Somthing get wroung"
                                );





                            }



                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });



        }


       



        $(document).ready(function() {

            $("#openSendPushNotifcationform").on('click', function() {
                let imageHtmlContentId = {
                uploadAreaId: 'uploadAreaPushNotificationId',
                dropZoomId: 'dropZoomPushNotificationId',
                loadingTextId: 'loadingTextPushNotificationId',
                previewImageId: 'previewImagePushNotificationId',
                fileInputId: 'fileInputPushNotificationId',
                fileDetailsId: 'fileDetailsPushNotificationId',
                uploadedFileId: 'uploadedFilePushNotificationId',
                uploadedFileInfoId: 'uploadedFileInfoPushNotificationId'
            };

            imagePreveiewUpload(imageHtmlContentId);

                $("#addpushnotificationformid").modal('show');
            })

            notificationDataTable();


            function notificationDataTable() {
                var table = $('.push-notification-data-table').DataTable({
                    dom: '<"top"lfB>rt<"bottom"ip><"clear">', 
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
                        url: "{{ route('admin.notification.show') }}",
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
                            data: 'title',
                            name: 'title',
                            orderable: true,
                            searchable: true,
                            createdCell: function(td, cellData, rowData, row, col) {
                                $(td).attr('id', 'title' + rowData.id);

                            }


                        },
                        {
                            data: 'description',
                            name: 'push_notifications.description',
                            orderable: true,
                            searchable: true,
                            createdCell: function(td, cellData, rowData, row, col) {
                                $(td).attr('id', 'description' + rowData.id);

                            }


                        },
                        {
                            data: 'notification_image',
                            name: 'notification_image',
                            orderable: true,
                            searchable: false,
                            createdCell: function(td, cellData, rowData, row, col) {
                                $(td).attr('id', 'notification_image' + rowData.id);

                            }


                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: true,
                            searchable: true,
                            createdCell: function(td, cellData, rowData, row, col) {


                            }

                        },

                        {
                            data: 'resendpushnotification',
                            name: 'resendpushnotification',
                            orderable: true,
                            searchable: false,

                        }
                    ],
                    language: {
                        lengthMenu: "Show _MENU_ Entries per Page",
                    }

                });
            }









            $("#sendnotification").on('click', function(e) {
                e.preventDefault();
                let formdata = new FormData();
                formdata.append('title', $("#title").val());
                formdata.append('description', $("#description").val());
                formdata.append('notification_image', $("#fileInputPushNotificationId")[0].files[0]);
                formdata.append("_token", "{{ csrf_token() }}");

                Swal.fire({
                    title: "Do you want to send the notification ?",
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Send",
                    denyButtonText: "Don't send",

                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: "{{ route('admin.notification.save') }}",
                            type: 'POST',
                            data: formdata,
                            async: false,
                            cache: false,
                            contentType: false,
                            processData: false,
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                    "content"),
                            },
                            beforeSend: function() {

                                $("#title_error").html(" ");

                                $("#description_error").html(" ");

                            },
                            success: function(data) {
                                notificationDataTable();
                                $("#addpushnotificationformid").modal('hide');
                                toastr.success(
                                    "Notifications are being sent");

                            },
                            error: function(xhr, status, error) {

                                if (xhr.status == 422) {

                                    errorMessage = xhr.responseJSON.errormessage;

                                    for (var fieldName in errorMessage) {

                                        if (errorMessage.hasOwnProperty(fieldName)) {
                                            $([id="${fieldName}_error"]).html(
                                                errorMessage[fieldName][
                                                    0
                                                ]);


                                        }

                                    }



                                    toastr.error(
                                        "Somthing get wroung"
                                    );





                                }



                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire("Changes are not saved", "", "info");
                    }
                });








            });







        });
    </script>

@endsection