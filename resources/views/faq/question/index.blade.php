@extends('layouts.app')

@section('title', 'Faq Question & Answer')

@section('content')

    @include('faq.question.add')


    @include('components.status', [
        'modal_id' => 'faqstatuschange',
    ])





    <div class="page-header">
        <h3 class="fw-bold mb-3"> Faq Question</h3>
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
                <a href="#">Question</a>
            </li>

            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Question List</a>
            </li>
        </ul>
    </div>

    <div class="page-header">
        <button type="button" id="openaddfeatureform" class="btn btn-primary">Add Question & Answer</button>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Question & Answer List</h4>
                </div>
                <div class="card-body">

                    <div id="featuretable" class="table-responsive">
                        <table style="--bs-table-bg: #ede7e7;"
                            class="faq-data-table table table-striped table-bordered w-100 text-sm text-left rtl:text-right text-black-500">
                            <thead class="bg-light border-bottom">
                                <tr>
                                    <th class="px-4 py-2 border-end">Sr No.</th>
                                    <th class="px-4 py-2 border-end">Category</th>
                                    <th class="px-4 py-2 border-end">Question</th>
                                    <th class="px-4 py-2 border-end">Answer</th>
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
        $(document).ready(function() {
            faqDataTable();

            $("#faqcategory").select2({
                placeholder: "Select a Category",
                allowClear: true,
                dropdownParent: $("#addfaqformid")


            });

        });




        let text_area_question;
        ClassicEditor.create(document.querySelector("#text-area-question-id"), {
                ckfinder: {
                    uploadUrl: `{{ route('admin.text.image.upload') . '?_token=' . csrf_token() }}`,
                },
            })
            .then((newEditor) => {
                text_area_question = newEditor;
            })
            .catch((error) => {
                console.error(error);
            });



        let text_area_answer;
        ClassicEditor.create(document.querySelector("#text-area-answer-id"), {
                ckfinder: {
                    uploadUrl: `{{ route('admin.text.image.upload') . '?_token=' . csrf_token() }}`,
                },
            })
            .then((newEditor) => {
                text_area_answer = newEditor;
            })
            .catch((error) => {
                console.error(error);
            });


        function faqDataTable() {
            var table = $('.faq-data-table').DataTable({
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
                    url: "{{ route('admin.faq.question') }}",
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
                        data: 'category',
                        name: 'faq_categories.name ',
                        orderable: false,
                        searchable: true,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('id', 'category' + rowData.id);
                            $(td).off('dblclick').on('dblclick', function() {
                                var currentText = $(this).text();
                                var categoryId = rowData.category_id;
                                var faqId = rowData.id;


                                var select = $('<select/>', {
                                    'class': 'form-control',
                                    'data-faq-id': faqId,
                                    'data-category-id': categoryId,
                                });


                                @foreach ($faqCategory as $category)
                                    select.append($('<option>', {
                                        value: '{{ $category->id }}',
                                        text: '{{ $category->name }}',
                                        selected: categoryId == {{ $category->id }} ?
                                            true : false
                                    }));
                                @endforeach


                                $(this).empty().append(select);

                                select.select2({
                                    width: 'resolve',
                                    dropdownAutoWidth: true,
                                    placeholder: "Select a category"
                                });


                                select.focus();


                                select.on('change', function() {
                                    var newCategoryId = $(this).val();
                                    categoryChange(faqId, newCategoryId);


                                });


                                // select.on('focusout', function(faqId) {
                                //     console.log(faqId);
                                //     var newCategoryName = select.find(
                                //             'option:selected')
                                //         .text();
                                //     $(td).text(newCategoryName);

                                // });

                                select.on('select2:close', function() {
                                    var newCategoryName = select.find('option:selected')
                                        .text();
                                    $(td).text(newCategoryName);
                                });



                            });



                        }


                    },

                    {
                        data: 'question',
                        name: 'faqs.question',
                        orderable: false,
                        searchable: true,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('id', 'question' + rowData.id);
                            $(td).off('dblclick').on('dblclick', function() {


                                var currentContent = $(this).html();


                                var textarea = $('<textarea/>', {
                                    id: 'questionEditor' + rowData.id,
                                    class: 'form-control',
                                    text: currentContent
                                });


                                $(this).html(textarea);


                                ClassicEditor.create(document.querySelector('#questionEditor' +
                                    rowData.id), {
                                    ckfinder: {
                                        uploadUrl: `{{ route('admin.text.image.upload') . '?_token=' . csrf_token() }}`,
                                    }
                                }).then(editor => {

                                    var editorInstance = editor;
                                    const editorContainer = editor.ui.view.editable
                                        .element;


                                    $(document).off('click').on('click', function(e) {

                                        if (!$.contains(editorContainer, e.target) && (editorInstance.getData())) {

                                            var updatedContent = editorInstance
                                                .getData();

                                           

                                            $.ajax({
                                                url: "{{ route('admin.faq.updateQuestion') }}",
                                                type: "POST",
                                                data: {
                                                    _token: "{{ csrf_token() }}",
                                                    faq_id: rowData.id,
                                                    question: updatedContent
                                                },
                                                success: function(data) {

                                                    console.log(data);

                                                    $(td).html(
                                                        updatedContent
                                                    );


                                                    editorInstance
                                                        .destroy();


                                                    toastr.success(
                                                        "Question updated successfully"
                                                    );
                                                },
                                                error: function(xhr) {
                                                    toastr.error(
                                                        "Something went wrong. Please try again."
                                                    );
                                                }
                                            });

                                            // Unbind the click event after saving
                                            // $(document).off('click');
                                        }
                                    });
                                }).catch(error => {
                                    console.error(error);
                                });
                            });


                        }


                    }, {
                        data: 'answer',
                        name: 'faqs.answer',
                        orderable: false,
                        searchable: true,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('id', 'answer' + rowData.id);
                            $(td).off('dblclick').on('dblclick', function() {

                                var currentContent = $(this).html();


                                var textarea = $('<textarea/>', {
                                    id: 'answerEditor' + rowData.id,
                                    class: 'form-control',
                                    text: currentContent
                                });


                                $(this).html(textarea);


                                ClassicEditor.create(document.querySelector('#answerEditor' +
                                    rowData.id), {
                                    ckfinder: {
                                        uploadUrl: `{{ route('admin.text.image.upload') . '?_token=' . csrf_token() }}`,
                                    }
                                }).then(editor => {

                                    var editorInstance = editor;
                                    const editorContainer = editor.ui.view.editable
                                        .element;


                                    $(document).off('click').on('click', function(e) {

                                        if (!$.contains(editorContainer, e.target) && (editorInstance.getData())) {

                                            var updatedContent = editorInstance
                                                .getData();


                                            $.ajax({
                                                url: "{{ route('admin.faq.updateAnswer') }}",
                                                type: "POST",
                                                data: {
                                                    _token: "{{ csrf_token() }}",
                                                    faq_id: rowData.id,
                                                    answer: updatedContent
                                                },
                                                success: function(data) {

                                                    console.log(data);

                                                    $(td).html(
                                                        updatedContent
                                                    );


                                                    editorInstance
                                                        .destroy();


                                                    toastr.success(
                                                        "Answer updated successfully"
                                                    );
                                                },
                                                error: function(xhr) {
                                                    toastr.error(
                                                        "Something went wrong. Please try again."
                                                    );
                                                }
                                            });

                                            // Unbind the click event after saving
                                            // $(document).off('click');
                                        }
                                    });
                                }).catch(error => {
                                    console.error(error);
                                });
                            });

                        }


                    },



                    {
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        searchable: false,


                    }, {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: false,

                    },

                ],
                language: {
                    lengthMenu: "Show MENU Entries per Page",
                }

            });


        }




        $("#openaddfeatureform").on('click', function() {


            text_area_question.setData(" ");
            text_area_answer.setData(" ");
            $("#faqid").val(" ");
            $("#text_area_question_error").html(" ");
            $("#text_area_answer_error").html(" ");
            $("#category_error").html(" ");

            $('#add-faq-button').html('Save');

            $("#faqcategory").val(null).trigger('change');

            $("#addfaqformid").modal('show');

            manageFaq();



        });

        function manageFaq() {
            $("#add-faq-button").off('click').on('click', function(e) {
                e.preventDefault();

                let faqFormData = new FormData($("#faq_form")[0]);

                faqFormData.append("text_area_question", text_area_question.getData());
                faqFormData.append("text_area_answer", text_area_answer.getData());


                $.ajax({
                    url: "{{ route('admin.faq.save') }}",
                    type: 'POST',
                    data: faqFormData,
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    beforeSend:function(){

                        $("#spinner-div").show();

                    },
                    success: (data) => {
                        $("#spinner-div").hide();
                        if (data.save) {
                            $("#addfaqformid").modal('hide');
                            toastr.success("New record added successfully");
                            faqDataTable();
                        } else {
                            let item = data.faq[0];
                            let id = item.id;
                            let question = item.question;
                            let answer = item.answer;
                            let category = item.category;

                            $(`#category${id}`).html(category);
                            $(`#answer${id}`).html(question);
                            $(`#question${id}`).html(answer);
                            toastr.success("Record Updated successfully");
                            $("#addfaqformid").modal('hide');
                        }

                    },
                    error: function(xhr) {
                        $("#spinner-div").hide();
                        if (xhr.status == 422) {
                            var errorMessages = xhr.responseJSON.errormessage;
                            toastr.error("Something went wrong");
                            for (fieldName in errorMessages) {
                                if (errorMessages.hasOwnProperty(fieldName)) {

                                    $([`id="${fieldName}_error"`]).html(
                                        errorMessages[fieldName][
                                            0
                                        ]);
                                }
                            }
                        }
                    }
                });







            })
        }


        function editFaq(id) {

            text_area_question.setData($(`#question${id}`).html());
            text_area_answer.setData($(`#answer${id}`).html());

            $("#faqid").val(id);
            let category = $(`#category${id}`).html();

            console.log(category);

            $("#faqcategory option").filter(function() {
                return $(this).text() === category;
            }).prop('selected', true);

            $('#faqcategory').trigger('change');
            $('#add-faq-button').html('Update');
            $("#addfaqformid").modal('show');
            $("#text_area_question_error").html(" ");
            $("#text_area_answer_error").html(" ");
            $("#category_error").html(" ");
            manageFaq();





        }


        function categoryChange(faqId, newCategoryId) {

            $.ajax({
                url: "{{ route('admin.faq.updateCategory') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    faq_id: faqId,
                    category_id: newCategoryId
                },
                success: function(data) {
                    toastr.success("Sucessfully category  Updated");

                    let item = data.faq[0];
                    let id = item.id;

                    let category = item.category;

                    $(`#category${id}`).html(category);



                },
                error: function(xhr) {
                    if (xhr.status == 422) {
                        var errorMessages = xhr.responseJSON.errormessage;
                        toastr.error("Something went wrong");

                    }
                }
            });
        }

        function changeStatus(id) {
            $("#faqstatuschange").modal('show');

            $('#savestauschanges').off('click').on('click', function(e) {
                e.preventDefault();


                var formData = new FormData();
                formData.append('id', id);
                formData.append('status', $("#status-select").val());
                formData.append('_token', "{{ csrf_token() }}")


                $.ajax({
                    url: "{{ route('admin.faq.status') }}",
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
                        $("#faqstatuschange").modal('hide');
                        let status = data.status == 1 ? "Active" : "Inactive";
                        let status_btn = data.status == 1 ? 'btn btn-success' : 'btn btn-danger';
                        toastr.success("Status Updated Successfully");
                        $(`#statuschange${data.id}`).html(status).attr("class", status_btn);
                    },
                    error: function(xhr) {
                        if (xhr.status == 422) {
                            var errorMessageStatus = xhr.responseJSON.errormessage;
                            toastr.error("Something went wrong");
                            for (fieldName in errorMessageStatus) {
                                if (errorMessagestatus.hasOwnProperty(fieldName)) {
                                    $(`[id="statsu_error"`).html(errorMessageStatus[
                                        fieldName][0]);
                                }
                            }
                        }
                    }
                });
            });


        }
    </script>


@endsection
