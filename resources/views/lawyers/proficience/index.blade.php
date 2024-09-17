@extends('layouts.app')

@section('title', 'Laywer Proficience')

@section('content')

    @include('components.loader')

    @include('lawyers.proficience.add')

    @include('components.input', [
        'modal_id' => 'proficienceinputid',
        'modal_heading' => 'Update Lawyer Proficience',
        'modal_label_name' => 'Parent Name',
        'input_name' => 'parent_name',
        'input_id' => 'parent_id',
        'inputlabelName' => 'Parent Name',
        'hiddenInputFiled' => 'proficienceid',
        'input_save_button' => 'feature_update_button',
        'input_form_id' => 'lawyer_proficience_update_form',
    ])

    <div class="page-header">
        <h3 class="fw-bold mb-3">Proficience</h3>
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
                <a href="#">Lawyers</a>
            </li>

            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Lawyer Proficience List</a>
            </li>
        </ul>
    </div>

    <div class="page-header">
        <button type="button" id="openaddlawyerform" class="btn btn-primary">Add Proficience</button>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Lawyers Proficience List</h4>
                </div>
                <div class="card-body">

                    <div id="customertable" class="table-responsive">
                        <table style="--bs-table-bg: #ede7e7;"
                            class=" proficience-data-table   table table-striped table-bordered w-100 text-sm text-left rtl:text-right text-black-500">
                            <thead class="bg-light border-bottom">
                                <tr>
                                    <th class="px-4 py-2 border-end">Sr No.</th>
                                    <th class="px-4 py-2 border-end">Proficience</th>
                                    <th class="px-4 py-2 border-end">Sub Proficience</th>
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
        function ucwords(str) {
            return str.toLowerCase().replace(/\b\w/g, function(char) {
                return char.toUpperCase();
            });
        }
        $(document).ready(function() {

            $("#proficience_parent_id").select2({
                placeholder: "Select a proficiency",
                allowClear: true,
                dropdownParent: $("#addLawyerProficienceformid")
            });
            proficienceListDataTable();

        });

        function removeElement(id) {
            $(`#${id}`).remove();
        }

        $("#openaddlawyerform").on('click', function() {

            $("#proficience_name_error").html(" ");

            $("#proficience_name").val(" ");


            $("#parent_id_error").html(" ");

            $("#proficience_parent_id").val(null).trigger("change");

            $("#addLawyerProficienceformid").modal('show');
        });


        function proficienceListDataTable() {
            var table = $('.proficience-data-table').DataTable({
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
                    url: "{{ route('admin.lawyers.proficience') }}",
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
                        data: 'proficience',
                        name: 'proficience',
                        orderable: true,
                        searchable: true,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('id', 'proficience' + rowData.id);
                        }


                    },
                    {
                        data: 'sub_area_of_proficience',
                        name: 'sub_area_of_proficience',
                        orderable: true,
                        searchable: true,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('id', 'sub_area_of_proficience' + rowData.id);
                        }


                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: false,

                    },

                ],
                language: {
                    lengthMenu: "Show _MENU_ Entries per Page",
                }

            });


        }



        $("#add-lawyer-proficience-button").on('click', function(e) {

            e.preventDefault();

            let formData = new FormData($("#lawyer-proficience-form")[0]);

            $.ajax({
                url: "{{ route('admin.lawyer.proficience-save') }}",
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
                    $("#proficience_name_error").html(" ");

                    $("#parent_id_error").html(" ");
                    $("#spinner-div").show();

                },
                success: (data) => {
                    proficienceListDataTable();
                    $("#addLawyerProficienceformid").modal('hide');
                    $("#spinner-div").hide();

                    toastr.success("New Lawyer Proficience add Successfully");

                    console.log(data.proficience)

                    if (data.proficience.proficience_name) {
                        let optionHtml =
                            `<option value="${data.proficience.id}">${data.proficience.proficience_name}</option>`;

                        console.log(optionHtml);
                        $("#proficience_parent_id").append(optionHtml);
                    }


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


        // Declare liArray globally so it can be accessed by both functions
        let liArray = [];

        function removeliElement(liId, selectedValue) {
            // Remove the element from the DOM
            $("#" + liId).remove();

            // Remove the item from liArray based on the value (selectedValue) instead of index
            liArray = liArray.filter(function(item) {
                return item.id !== selectedValue;
            });
        }

        function editLawyerProficience(id) {
            let formData = new FormData();
            formData.append('id', id);
            formData.append('_token', "{{ csrf_token() }}");

            $.ajax({
                url: "{{ route('admin.lawyer.proficience-edit') }}",
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
                    $("#spinner-div").show();
                },
                success: (data) => {
                    let childProficienceHtml = data.html;
                    let parentName = $(`#proficience${id}`).html();

                    // Reset liArray when loading a new set of items
                    liArray = [];

                    // Get existing list items



                    var html = `<div class="form-group">
                                     <label for="Parent Name">
                                            <h5>Proficiency Name</h5>
                                    </label>
                <input type="text"  class="form-control" id="parent_name" value="${parentName}" name="parent_name">
                <input type="hidden" name="parent_id" value="${id}" />   
                <span class="text-danger small" id="parent_name_error"></span>
            </div>
            ${childProficienceHtml}`;




                    $("#lawyer_proficience_update_form").html(html);
                    $("#proficienceinputid").modal('show');

                    // Initialize select2 dropdown
                    $("#proficienceinputid").on('shown.bs.modal', function() {
                        let select2Dropdown = $("#child_proficience_list").select2({
                            placeholder: "Select a proficiency", // Placeholder text
                            allowClear: true,
                            dropdownParent: $(
                                "#proficienceinputid"
                            ), // Make sure the dropdown is within the modal
                        });

                        $("#spinner-div").hide();



                        select2Dropdown.on('change', function() {
                            let selectedValue = $(this).val();
                            let selectedText = $(this).find('option:selected').text();


                            let existsInArray = liArray.some(function(item) {
                                return item.text === selectedText && item.id ===
                                    selectedValue;
                            });




                            if (!existsInArray && selectedValue && selectedText) {

                                liArray.push({
                                    text: selectedText,
                                    id: selectedValue
                                });

                            }
                        });

                    });



                },
                error: function(xhr) {}
            });
        }








        $("#feature_update_button").off('click').on('click', function(e) {
            e.preventDefault();
            let formData = new FormData($("#lawyer_proficience_update_form")[0]);

            formData.append("_token", "{{ csrf_token() }}");

            $.ajax({
                url: "{{ route('admin.lawyer.proficience-update') }}",
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
                    $("#proficience_name_error").html(" ");

                    $("#parent_id_error").html(" ");






                },
                success: (response) => {



                    let resultData = response.data;

                    console.log(resultData);
                    let html = "<ul>";
                    for (let value of resultData) {
                        html += `<li id="${value.id}">${value.proficience_name}</li>`;

                    }

                    html += "</ul>";

                    $(`#sub_area_of_proficience${response.parent_id}`).html(html);
                    $(`#proficience${response.parent_id}`).html(response.parent_name);






                    toastr.success("Lawyer Proficience Updated Successfully");
                    $("#proficienceinputid").modal('hide');




                },
                error: function(xhr) {
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
    </script>

@endsection
