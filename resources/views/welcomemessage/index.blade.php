@extends('layouts.app')

@section('title', 'Welcome Message')

<style>
    .dt-search {
        display: flex;
        justify-content: end;
    }

    .dt-search label {
        margin-top: 10px;
    }
</style>


@section('content')




    @include('components.status', [
        'modal_id' => 'welcomemessagestatuschange',
    ])

    @include('welcomemessage.add')

    @include('components.viewimagemodal', [
        'imageViewModalId' => 'welcome-message-view-modal',
    ])


    @include('components.editimagemodal', [
        'modal_id' => 'editWelcomeMessageModal',
        'modal_heading' => 'Edit Welcome Message Image',
        'modal_label_name' => 'Welcome Message Image',
        'uploadAreaId' => 'uploadAreaWelcomeMessageModalImageEdit',
        'dropZoomId' => 'dropZoonWelcomeMessageModalImageEdit',
        'loadingTextId' => 'loadingTextWelcomeMessageModalImageEdit',
        'previewImageId' => 'previewWelcomeMessageModalImageEdit',
        'fileInputId' => 'fileInputWelcomeMessageModalImageEdit',
        'fileDetailsId' => 'fileDetailsWelcomeMessageModalImageEdit',
        'uploadedFileId' => 'uploadedFileWelcomeMessageModalImageEdit',
        'uploadedFileInfoId' => 'uploadedFileInfoWelcomeMessageModalImageEdit',
        'input_save_button' => 'imageupdateSubmitButton',
    ])


    @include('components.loader')

    <div class="page-header">
        <h3 class="fw-bold mb-3">Welcome Message</h3>
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
                <a href="#">Message</a>
            </li>

            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">List</a>
            </li>
        </ul>
    </div>



    <div class="page-header">
        <button type="button" id="open-welcome-message-add-form" class="btn btn-primary">Add Message</button>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> Welcome Message List</h4>
                </div>
                <div class="card-body">

                    <div id="welcomemessagetable" class="table-responsive">
                        <table style="--bs-table-bg: #ede7e7;"
                            class="welcome-Message-data-table   table table-striped table-bordered w-100 text-sm text-left rtl:text-right text-black-500">
                            <thead class="bg-light border-bottom">
                                <tr>
                                    <th class="px-4 py-2 border-end">Sr No.</th>
                                    <th class="px-4 py-2 border-end">Title</th>
                                    <th class="px-4 py-2 border-end">Image</th>
                                    <th class="px-4 py-2 border-end">Content</th>
                                    <th class="px-4 py-2 border-end">Status</th>
                                    <th class="px-4 py-2 border-end">Action</th>
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
        let imageHtmlContentId = {
            uploadAreaId: 'uploadAreaWelcomeMessageId',
            dropZoomId: 'dropZoomWelcomeMessageId', 
            loadingTextId: 'loadingTextWelcomeMessageId',
            previewImageId: 'previewImageWelcomeMessageId',
            fileInputId: 'fileInputWelcomeMessageId',
            fileDetailsId: 'fileDetailsWelcomeMessageId',
            uploadedFileId: 'uploadedFileWelcomeMessageId',
            uploadedFileInfoId: 'uploadedFileInfoWelcomeMessageId'
        };

        imagePreveiewUpload(imageHtmlContentId);

        welcomeMessageDataTable();


        function welcomeMessageDataTable() {
            var table = $('.welcome-Message-data-table').DataTable({
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
                    url: "{{ route('admin.welcome.message') }}",
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
                            $(td).dblclick(function() {
                                var $td = $(td);
                                var currentText = $(td).text();
                                var input = $('<input>', {
                                    value: currentText,
                                    type: 'text',
                                    blur: function() {
                                        updateWelcomeMessageTitle(rowData.id, input
                                            .val());
                                    },
                                    keyup: function(e) {
                                        if (e.which === 13) {
                                            input.blur();
                                        }
                                    }
                                }).appendTo($td.empty()).focus().select();
                            });

                        }


                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: true,
                        searchable: false,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('id', 'image' + rowData.id);

                        }


                    },
                    {
                        data: 'content',
                        name: 'content',
                        orderable: true,
                        searchable: true,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('id', 'content' + rowData.id);
                            $(td).dblclick(function() {
                                var $td = $(td);
                                var currentText = $td.text();


                                var textarea = $('<textarea>', {
                                    text: currentText,
                                    blur: function() {
                                        updateWelcomeMessageContent(rowData.id, textarea
                                            .val());
                                        $td.text(textarea
                                            .val());
                                    },
                                    keyup: function(e) {
                                        if (e.which === 13 && !e
                                            .shiftKey) {
                                            textarea.blur();
                                        }
                                    }
                                }).appendTo($td.empty()).focus().select();

                                // Optional: Adjust textarea size
                                textarea.css({
                                    width: '100%',
                                    height: 'auto'
                                });

                            });

                        }

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



        function addWelcomeMessageEvent() {

            $("#add-welcome-message-button").off('click').on('click', function(e) {
                e.preventDefault();
                let formData = new FormData($("#welcome-message-form")[0]);

                $.ajax({
                    url: "{{ route('admin.welocome.message.save') }}",
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
                        $("#content_error").html(" ");

                        $("#title_error").html(" ");

                        $("#welcome_message_image_error").html(" ");
                        $("#spinner-div").show();


                    },
                    success: (data) => {
                        $("#spinner-div").hide();
                        $("#add-welcome-message-form").modal('hide');
                        toastr.success("Welcome Message Save Successfully");
                        welcomeMessageDataTable();

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
        }


        $("#open-welcome-message-add-form").on('click', function() {



            $("#addWelcomeMessageFormModalLabel").html("Add Welcome Message");
            $("#title").val(" ");
            $("#content").val("");
            $("#previewImageWelcomeMessageId").attr('src', "{{ asset('defaultimage.png') }}");
            $("#welcome-message-id").val(" ");
            $("#add-welcome-message-button").html('Save');
            $("#add-welcome-message-form").modal('show');

            addWelcomeMessageEvent();

 



        });



        function onMouseOveractionOnImage(id) {
            $(`#menu${id}`).removeClass('d-none');

        }

        function onMouseOutactionOnImage(id) {
            $(`#menu${id}`).addClass('d-none');
        }



        function welcomeMessageModalImageView(id) {
            let lawyerImageSrc = $(`#welcomeimage${id}`).attr('src');



            var modal = document.getElementById('myImageModal');



            var modalImg = document.getElementById("welcome-message-view-modal");
            var captionText = document.getElementById("caption");

            modal.style.display = "block";
            modalImg.src = lawyerImageSrc;
            captionText.innerHTML = "Welcome Message Image";



            var span = document.getElementsByClassName("imageclose")[0];


            span.onclick = function() {
                modal.style.display = "none";
            }
        }



        function welcomeMessageModalImageEdit(id) {


            let welcomeImageEditImageSrc = $(`#welcomeimage${id}`).attr('src');

            let imageHtmlContentId = {
                modal_label_name: 'Welcome Message Image',
                uploadAreaId: 'uploadAreaWelcomeMessageModalImageEdit',
                dropZoomId: 'dropZoonWelcomeMessageModalImageEdit',
                loadingTextId: 'loadingTextWelcomeMessageModalImageEdit',
                previewImageId: 'previewWelcomeMessageModalImageEdit',
                fileInputId: 'fileInputWelcomeMessageModalImageEdit',
                fileDetailsId: 'fileDetailsWelcomeMessageModalImageEdit',
                uploadedFileId: 'uploadedFileWelcomeMessageModalImageEdit',
                uploadedFileInfoId: 'uploadedFileInfoWelcomeMessageModalImageEdit',
                input_save_button: 'imageupdateSubmitButton',
            };

            imagePreveiewUpload(imageHtmlContentId);



            $("#fileInputWelcomeMessageModalImageEdit").val('');




            $("#editWelcomeMessageModal").modal('show');

            $("#previewWelcomeMessageModalImageEdit").attr('src', welcomeImageEditImageSrc);

            $("#imageupdateSubmitButton").off('click').on('click', function(e) {
                e.preventDefault();
                let formData = new FormData();

                formData.append('id', id);



                formData.append('image', $("#fileInputWelcomeMessageModalImageEdit")[0].files[0]);

                formData.append("_token", "{{ csrf_token() }}")

                $.ajax({
                    url: "{{ route('admin.welocome.message.image.update') }}",
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





                    },
                    success: (data) => {

                        $(`#welcomeimage${data.id}`).attr('src',
                            `{{ asset('welcome_message/images/${data.image}') }}`);
                        $("#editWelcomeMessageModal").modal('hide');
                        $("#fileInputWelcomeMessageModalImageEdit").val('');
                        $("#previewWelcomeMessageModalImageEdit").attr('src', " ");
                        toastr.success("Image Updated Successfully");


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




        function updateWelcomeMessageTitle(id, title) {
            $.ajax({
                url: "{{ route('admin.welcome.update-welcome-message.title') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    title: title
                },
                success: function(response) {
                    if (response.success) {
                        $(`#title${response.id}`).html(response.title);

                        toastr.success("Welcome Message Title Update Successfully");

                    } else {
                        alert('Failed to update Welcome Message Title.');
                    }
                },
                error: function(xhr) {

                    if (xhr.status == 422) {
                        var errorMessage = xhr.responseJSON.errormessage;

                        for (fieldName in errorMessage) {
                            if (errorMessage.hasOwnProperty(fieldName)) {


                                toastr.error(errorMessage[fieldName][0]);




                            }
                        }
                    }


                }
            });
        }



        function updateWelcomeMessageContent(id, content) {

            $.ajax({
                url: "{{ route('admin.welcome.update-welcome-message.content') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    content: content
                },
                success: function(response) {
                    if (response.success) {
                        $(`#content${response.id}`).html(response.content);

                        toastr.success("Welcome Message Content Update Successfully");

                    } else {
                        alert('Failed to update Welcome Message Title.');
                    }
                },
                error: function(xhr) {

                    if (xhr.status == 422) {
                        var errorMessage = xhr.responseJSON.errormessage;

                        for (fieldName in errorMessage) {
                            if (errorMessage.hasOwnProperty(fieldName)) {


                                toastr.error(errorMessage[fieldName][0]);




                            }
                        }
                    }


                }
            });

        }



        function changeStatus(id) {
            $("#welcomemessagestatuschange").modal('show');

            $('#savestauschanges').off('click').on('click', function(e) {
                e.preventDefault();


                var formData = new FormData();
                formData.append('id', id);
                formData.append('status', $("#status-select").val());
                formData.append('_token', "{{ csrf_token() }}")


                $.ajax({
                    url: "{{ route('admin.welcome.message.statusupdate') }}",
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
                        $("#welcomemessagestatuschange").modal('hide');
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


        function editWelcomeMessage(id) {

            $("#addWelcomeMessageFormModalLabel").html("Update Welcome Message");

            $("#title").val($(`#title${id}`).html());

            $("#content").val($(`#content${id}`).html());

            $("#previewImageWelcomeMessageId").attr('src', $(`#welcomeimage${id}`).attr('src'))

            $("#welcome-message-id").val(id);
            $("#add-welcome-message-button").html('Update');
            $("#content_error").html(" ");

            $("#title_error").html(" ");

            $("#welcome_message_image_error").html(" ");

            $("#add-welcome-message-form").modal('show');

            addWelcomeMessageEvent();




        }
    </script>

@endsection
