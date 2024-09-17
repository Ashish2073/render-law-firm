@extends('layouts.app')

@section('title', 'Subscription Feature')

@section('content')

    @include('components.input', [
        'modal_id' => 'featureinputid',
        'modal_heading' => 'Enter Subscription Feature Name',
        'modal_label_name' => 'Name',
        'input_name' => 'name',
        'input_id' => 'name',
        'hiddenInputFiled'=>'featureid',
        'input_save_button' => 'feature_save_button',
        'input_form_id'=>'subscription_feature_form'
    ])


    @include('components.status', [
        'modal_id' => 'featurestatuschange',
    ])


    <div class="page-header">
        <h3 class="fw-bold mb-3"> Subscription Feature</h3>
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
                <a href="#">Subscription</a>
            </li>

            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Feature List</a>
            </li>
        </ul>
    </div>

    <div class="page-header">
        <button type="button" id="openaddfeatureform" class="btn btn-primary">Add Feature</button>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Lawyers List</h4>
                </div>
                <div class="card-body">

                    <div id="featuretable" class="table-responsive">
                        <table style="--bs-table-bg: #ede7e7;"
                            class="feature-data-table table table-striped table-bordered w-100 text-sm text-left rtl:text-right text-black-500">
                            <thead class="bg-light border-bottom">
                                <tr>
                                    <th class="px-4 py-2 border-end">Sr No.</th>
                                    <th class="px-4 py-2 border-end">Name</th>

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
        featureListDataTable();
        $("#openaddfeatureform").on('click', function() {
            $("#featureinputidModalLabel").html("Enter Subscription Feature Name");
            $("#name").val("");
            $("#name_error").html("");
            $("#featureid").val(" ");
            $("#feature_save_button").html('Save');
            $("#featureinputid").modal('show');

        });



        function featureListDataTable() {
            var table = $('.feature-data-table').DataTable({
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
                    url: "{{ route('admin.subscription.feature') }}",
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
                        orderable: false,
                        searchable: true,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('id', 'name' + rowData.id);
                            $(td).dblclick(function() {
                                var $td = $(td);
                                var currentText = $(td).text();
                                var input = $('<input>', {
                                    value: currentText,
                                    type: 'text',
                                    blur: function() {
                                        updateFeatureName(rowData.id, input
                                            .val());
                                    },
                                    keyup: function(e) {
                                        if (e.which === 13) {
                                            input.blur();
                                        }
                                    }
                                }).appendTo($td.empty()).focus().select();
                                input.css({
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

                    },

                ],
                language: {
                    lengthMenu: "Show _MENU_ Entries per Page",
                }

            });


        }

        $("#feature_save_button").off('click').on('click', function(e) {
            e.preventDefault();

            var formData = new FormData($("#subscription_feature_form")[0]);
          


            $.ajax({
                url: "{{ route('admin.subscription.feature.save') }}",
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
                    if(data.id){
                        $(`#name${data.id}`).html(data.name);
                        toastr.success("feature Updated Successfully");
                    }else{
                        featureListDataTable()
                        toastr.success("feature added Successfully");
                    }
                  

                    $("#featureinputid").modal('hide');

                },
                error: function(xhr) {
                    if (xhr.status == 422) {
                        var errorMessageName = xhr.responseJSON.errormessage;
                        toastr.error("Something went wrong");
                        for (fieldName in errorMessageName) {
                            if (errorMessageName.hasOwnProperty(fieldName)) {
                                $(`[id="name_error"`).html(errorMessageName[
                                    fieldName][0]);
                            }
                        }
                    }
                }
            });





        })



        function updateFeatureName(id, name) {
            $.ajax({
                url: "{{ route('admin.subscription.feature.update') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    name: name
                },
                success: function(response) {
                    if (response.success) {
                        $(`#name${response.id}`).html(response.name);

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



        function changeStatus(id) {
            $("#featurestatuschange").modal('show');

            $('#savestauschanges').off('click').on('click', function(e) {
                e.preventDefault();


                var formData = new FormData();
                formData.append('id', id);
                formData.append('status', $("#status-select").val());
                formData.append('_token', "{{ csrf_token() }}")


                $.ajax({
                    url: "{{ route('admin.subscription.feature.status') }}",
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
                        $("#featurestatuschange").modal('hide');
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


        function editFeature(id) {

            let featureId=id;
            $("#featureinputidModalLabel").html("Update Subscription Feature Name");
            $("#name").val($(`#name${id}`).html());
            $("#feature_save_button").html('Update');
            $("#name_error").html(" ");
            $("#featureid").val(id);
            $("#featureinputid").modal('show');

            addWelcomeMessageEvent();


        }
    </script>


@endsection
