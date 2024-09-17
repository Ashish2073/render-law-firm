@extends('layouts.app')

@section('title', 'Customers')





@section('content')

    <style>
        .orange-btn {
            background: #F77D24;
            display: inline-block;
            color: #fff;
            text-decoration: none;
            text-transform: uppercase;
            font-family: Sans-serif;
            font-size: 10px;
            padding-left: 15px;
            transition: box-shadow 0.3s ease;
            /* Smooth transition */

            i {
                display: inline-block;
                border-left: 1px solid rgba(255, 255, 255, 0.35);
                padding: 15px;
                margin-left: 15px;
            }
        }

        .orange-btn:hover {
            color: #fff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            /* Shadow on hover */
        }

        .modal-dialog-aside {
            width: 44% !important;
        }

        .status {
            cursor: pointer;
        }

        .btn-assign-lawyer {
            background-color: blue;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }

        .btn-assign-lawyer:hover {
            background-color: darkblue;
            /* Optional: Darker shade for hover effect */
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


        .cutomer-profile {
            height: 100px;
        }

        col[data-dt-column="8"] {
            display: none;
        }


        /*
                        col[data-dt-column="2"] {
                            width: 302.453px !important;
                         

                        } */
        col[data-dt-column="3"] {
            width: 250.453px !important;
        }

        col[data-dt-column="4"] {
            width: 302.453px !important;
        }

        col[data-dt-column="0"] {
            width: 101.453px !important;
        }
    </style>


    @include('components.sidemodal')

    @include('components.status')

    @include('components.imageslider', [
        'modal_body' => 'image-slider-container-body',
        'modal_id' => 'image-slider-modal',
    ])




    <div class="page-header">
        <h3 class="fw-bold mb-3">Customer cases</h3>
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
                <a href="#">Cases</a>
            </li>

        </ul>
    </div>

    <div class="page-header">
        <button type="button" class="btn btn-primary">Add Cases</button>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Cases List</h4>
                </div>
                <div class="card-body">

                    <div id="customer-case-table" class="table-responsive">
                        <table style="--bs-table-bg: #ede7e7;"
                            class="customers-case-data-table   table table-striped table-bordered w-100 text-sm text-left rtl:text-right text-black-500">
                            <thead class="bg-light border-bottom">
                                <tr>
                                    <th class="px-4 py-2 border-end" id="thead-cases-checkbox" hidden><input
                                            id="check-box-all" type='checkbox' />&nbsp&nbspAll</th>
                                    <th class="px-4 py-2 border-end">Sr No.</th>
                                    <th class="px-4 py-2 border-end">Title</th>
                                    <th class="px-4 py-2 border-end">Customer</th>
                                    <th class="px-4 py-2 border-end">Lawyer</th>
                                    <th class="px-4 py-2 border-end">Plaintiff</th>
                                    <th class="px-4 py-2 border-end">Chat</th>
                                    <th class="px-4 py-2 border-end">Document</th>

                                    <th class="px-4 py-2">Created Date</th>
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
        /////////////////////////////////Image Crousel//////////
        let slideIndex = 1;
        function openImageModal(imageList,fileName) {
           
            let imageArraylength = imageList.length;

            let sliderHtml = `<h2 style="text-align:center">Case File Document</h2><div class="container">`;

            let bigImageContainer = ``;
            let smallImageContainer = `<div class="row">`;

            for (let i = 0; i < imageArraylength; i++) {
                bigImageContainer +=
                    `<div class="mySlides" style="position:relative;">
                     <div class="numbertext">${i + 1} / ${imageArraylength}</div>
                     <img src="${imageList[i]}" style="width:100%">
                      <a href="${fileName[i]}" download style="position:absolute; bottom:10px; right:10px;">
                    <i class="fa fa-download" style="font-size:24px; color:white;"></i>
                </a>
            </div>`;
                smallImageContainer +=
                    `<div class="column"><img class="demo cursor" src="${imageList[i]}" style="width:100%" onclick="currentSlide(${i + 1})" alt="${i + 1}"></div>`;
            }

            smallImageContainer += `</div>`;

            let previousNextButton = `<a class="prev" onclick="plusSlides(-1)">❮</a>
                              <a class="next" onclick="plusSlides(1)">❯</a>`;

            let imageSpanTagName = `<div class="caption-container"><p id="caption"></p></div>`;

            sliderHtml += bigImageContainer + previousNextButton + imageSpanTagName + smallImageContainer + `</div>`;

          

            $("#image-slider-container-body").html(sliderHtml);

            // Show the modal
            $("#image-slider-modal").modal('show');

            // Initialize the slideshow
        
            showSlides(slideIndex);
        }

        // Define plusSlides, currentSlide, and showSlides globally
        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("demo");
            let captionText = document.getElementById("caption");

            if (n > slides.length) {
                slideIndex = 1;
            }
            if (n < 1) {
                slideIndex = slides.length;
            }

            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }

            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
            captionText.innerHTML = dots[slideIndex - 1].alt;
        }









        ///////////////////////////////


        function exportPDFWithImages(tableClass, columnsToInclude, columnsWithImageName) {
            var doc = {
                content: [{
                    table: {
                        body: []
                    }
                }]
            };

            var rows = doc.content[0].table.body;
            var imgElements = [];

            // Helper function to process image and name
            function processImageAndName(cell, rowIndex, rowData, columnIdx) {
                var imgElement = $(cell).find('img');
                var imgSrc = imgElement.attr('src');
                var nameText = $(cell).text().trim();

                if (imgSrc && imgSrc !== "") {
                    imgElements.push({
                        imgSrc: imgSrc,
                        rowIdx: rowIndex,
                        colIdx: columnIdx,
                        name: nameText
                    });
                    rowData.push(''); // Placeholder for the image + name
                } else {
                    // If no image, add "Not Assigned" or the plain name text
                    var notAssignedText = $(cell).find('a').text().trim();
                    rowData.push(notAssignedText || nameText || "Not Assigned");
                }
            }

            // Function to generate the table and process images for specific columns
            function generatePDFTable() {
                // Handle table header
                var headerRow = [];
                $(`.${tableClass} thead tr th`).each(function(i, cell) {
                    if (columnsToInclude.includes(i)) { // Include only specified columns
                        headerRow.push({
                            text: $(cell).text(),
                            bold: true
                        });
                    }
                });

                if (headerRow.length > 0) {
                    rows.push(headerRow); // Add the header row
                }

                // Iterate over table rows
                $(`.${tableClass} tbody tr`).each(function(idx, row) {
                    var rowData = [];

                    $(row).find('td').each(function(i, cell) {
                        if (columnsToInclude.includes(i)) { // Include only specified columns
                            if (columnsWithImageName.includes(i)) {
                                processImageAndName(cell, rows.length, rowData, i -
                                    1); // Process image and name columns
                            } else {
                                rowData.push($(cell).text().trim()); // Text content for regular columns
                            }
                        }
                    });

                    // Ensure the row data has the correct number of columns
                    if (rowData.length === columnsToInclude.length) {
                        rows.push(rowData); // Add the row to the table body
                    }

                    // Add page break after every 10 rows (excluding the header)
                    if ((rows.length - 1) % 11 === 0 && rows.length > 1) {
                        rows.push([{
                            text: '',
                            pageBreak: 'after',
                            colSpan: columnsToInclude.length
                        }]);
                    }
                });
            }

            // Generate the PDF table
            generatePDFTable();

            // Process the images
            var imgPromises = imgElements.map(function(imgData) {
                return new Promise(function(resolve) {
                    var img = new Image();
                    img.crossOrigin = 'anonymous';
                    img.src = imgData.imgSrc;
                    img.onload = function() {
                        var canvas = document.createElement('canvas');
                        var ctx = canvas.getContext('2d');
                        canvas.width = img.width;
                        canvas.height = img.height;
                        ctx.drawImage(img, 0, 0);
                        var imgDataUrl = canvas.toDataURL('image/png');
                        resolve({
                            imgDataUrl: imgDataUrl,
                            rowIdx: imgData.rowIdx,
                            colIdx: imgData.colIdx,
                            name: imgData.name
                        });
                    };
                    img.onerror = function() {
                        resolve({
                            imgDataUrl: null,
                            rowIdx: imgData.rowIdx,
                            colIdx: imgData.colIdx,
                            name: imgData.name
                        });
                    };
                });
            });

            // After processing all images
            Promise.all(imgPromises).then(function(imgDataArray) {
                imgDataArray.forEach(function(imgData) {
                    if (imgData.imgDataUrl && rows[imgData.rowIdx]) {
                        rows[imgData.rowIdx][imgData.colIdx] = {
                            stack: [{
                                    image: imgData.imgDataUrl,
                                    width: 40, // Adjusted image width
                                    height: 40 // Adjusted image height
                                },
                                {
                                    text: imgData.name,
                                    margin: [0, 4, 0, 0], // Increased margin between image and name
                                    fontSize: 12 // Adjusted font size for the name
                                }
                            ]
                        };
                    } else {
                        rows[imgData.rowIdx][imgData.colIdx] = imgData.name ||
                            "Not Assigned"; // Handle "Not Assigned"
                    }
                });

                // Create and download the PDF
                pdfMake.createPdf(doc).download('cases.pdf');
            }).catch(function(error) {
                console.error('Error processing images: ', error);
            });
        }








        customerCaseDetailsDataTable();

        let selectedRows = [];

        function customerCaseDetailsDataTable() {

            var table = $('.customers-case-data-table').DataTable({
                dom: '<"top"lfB>rt<"bottom"ip><"clear">',
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: [1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'Export to PDF',
                        exportOptions: {
                            columns: [1, 2, 3, 4]
                        },
                        action: function(e, dt, button, config) {
                            exportPDFWithImages('customers-case-data-table', [1, 2, 3, 4, 5], [3, 4]);
                        }
                    },

                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5]
                        }
                    },
                    {

                        text: 'Assign Lawyer',
                        attr: {
                            id: 'assignlawyer',
                            class: 'btn-assign-lawyer'
                        },
                        action: function(e, dt, node, config) {

                            if ($('#lawyerCard').length === 0) {

                                $('.dt-buttons').after(
                                    `{!! view('components.lawyerassign')->render() !!}`
                                );
                                $(".case-checkbox").removeAttr("hidden");
                                $(".case-checkbox").closest("td").removeAttr("hidden", false);
                                $("#thead-cases-checkbox").removeAttr("hidden");;





                            } else {

                                $("#lawyerCard").remove();
                                $(".case-checkbox").attr("hidden", true);
                                $(".case-checkbox").closest("td").attr("hidden", true);
                                $("#thead-cases-checkbox").attr("hidden", true);
                                $("#lawyerSelect").val(null).trigger("change");
                                $('#lawyerCard').toggle();

                            }



                            $('#lawyerSelect').select2({
                                placeholder: 'Select a Lawyer',
                                ajax: {
                                    url: "{{ route('admin.lawyer.list') }}", // The API endpoint that returns lawyer data
                                    dataType: 'json',
                                    delay: 250, // Delay for preventing too many requests
                                    data: function(params) {
                                        return {
                                            search: params.term ||
                                                '', // Search term, empty for initial load
                                            page: params.page ||
                                                1 // Current page for infinite scroll
                                        };
                                    },
                                    processResults: function(data, params) {
                                        params.page = params.page || 1;

                                        return {
                                            results: $.map(data.lawyers, function(
                                                lawyer) {
                                                return {
                                                    id: lawyer.id,
                                                    // Lawyer name for dropdown 
                                                    text: `<td class="d-flex align-items-center"><img src="${lawyer.profile_url}" width="20" alt="${lawyer.name}" kumar="" height="20" class="rounded-circle me-2">${lawyer.name}</td>`
                                                };
                                            }),
                                            pagination: {
                                                more: data
                                                    .hasMore // Set to true if more pages available
                                            }
                                        };
                                    },
                                    cache: true
                                },
                                minimumInputLength: 0, // Search can be initiated even with 0 characters
                                minimumResultsForSearch: 0, // Ensures the search box is always shown
                                templateResult: formatLawyer, // Optional: Custom display for results
                                templateSelection: formatLawyerSelection, // Optional: Custom display for selected lawyer
                                escapeMarkup: function(markup) {
                                    return markup; // Render custom markup for results
                                }
                            });

                            // Optional: Format the lawyer dropdown items
                            function formatLawyer(lawyer) {
                                if (lawyer.loading) {
                                    return lawyer.text;
                                }
                                return `<div>${lawyer.text}</div>`;
                            }

                            // Optional: Format the selected lawyer in the box
                            function formatLawyerSelection(lawyer) {
                                return lawyer.text || lawyer.id;
                            }






                        }
                    }
                ],
                stateSave: true,
                processing: true,
                serverSide: true,
                fixedHeader: true,
                "bDestroy": true,
                ajax: {
                    url: "{{ route('admin.customer-cases') }}",
                    type: "GET",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },


                },

                columns: [{
                        data: 'case_checkbox',
                        name: 'case_checkbox',
                        orderable: false,

                    }, {
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
                    },
                    {
                        data: 'customer',
                        name: 'customer',
                        orderable: true,
                        searchable: true,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('class', 'cutomer-profile');
                        }
                    },


                    {
                        data: 'lawyer',
                        name: 'lawyer',
                        orderable: true,
                        searchable: true,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('id', `lawyer-assign-case-${rowData.id}`);
                        }
                    },

                    {
                        data: 'case_users_name',
                        name: 'case_users.name',
                        orderable: true,
                        searchable: true,
                        createdCell: function(td, cellData, rowData, row, col) {

                        }
                    },

                    {
                        data: 'customercasechat',
                        name: 'customercasechat',
                        searchable: true,
                    },
                    {
                        data: 'casedocument',
                        name: 'casedocument',
                        searchable: true,

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

                'createdRow': function(row, data, dataIndex) {
                    var checkboxCell = $(row).find('.case-checkbox').closest('td');
                    var checkbox = $(row).find('.case-checkbox');


                    checkboxCell.attr('hidden', true);
                    if ($('#lawyerCard').length != 0) {



                        checkboxCell.attr('hidden', false);
                        checkbox.attr("hidden", false);

                    }


                },
                'drawCallback': function(row, data, dataIndex) {


                    $('.case-checkbox').each(function() {
                        var rowId = $(this).val();


                        setTimeout(() => {
                            if (selectedRows.includes(Number(rowId))) {

                                $(`#case-checkbox-${Number(rowId)}`).prop('checked', true);


                            }
                        }, 100);

                        setTimeout(() => {
                            if ($('.case-checkbox:checked').length === $('.case-checkbox')
                                .length) {
                                $('#check-box-all').prop('checked', true);
                            } else {
                                $('#check-box-all').prop('checked', false);
                            }
                        }, 101);
                    });
                },

            });

            $('#check-box-all').on('click', function() {
                var isChecked = $(this).is(':checked');
                $('.case-checkbox').prop('checked', isChecked); // Toggle all row checkboxes

                // Add/Remove all visible rows to/from selectedRows array
                table.rows().every(function() {
                    var data = this.data();
                    if (isChecked) {
                        if (!selectedRows.includes(data.id)) {
                            selectedRows.push(data.id);


                        }
                    } else {
                        selectedRows = selectedRows.filter(id => id !== data.id);
                    }
                });
            });


            $(document).on('change', '.case-checkbox', function() {
                var rowId = $(this).val();
                var isChecked = $(this).is(':checked');

                if (isChecked) {
                    if (!selectedRows.includes(Number(rowId))) {
                        selectedRows.push(Number(rowId)); // Add to selected rows array
                    }
                } else {
                    selectedRows = selectedRows.filter(id => id !== rowId); // Remove from selected rows array
                }


                setTimeout(() => {
                    if ($('.case-checkbox:checked').length === $('.case-checkbox').length) {
                        $('#check-box-all').prop('checked', true);
                    } else {
                        $('#check-box-all').prop('checked', false);
                    }
                }, 200);
            });


            table.on('draw', function() {
                // On table redraw (pagination, search, etc.), update the row checkboxes
                $('.case-checkbox').each(function() {
                    var rowId = $(this).val();
                    if (selectedRows.includes(rowId)) {
                        $(this).prop('checked', true);
                    } else {
                        $(this).prop('checked', false);
                    }
                });

                // Update master checkbox based on the number of selected checkboxes on the current page
                if ($('.case-checkbox:checked').length === $('.case-checkbox').length) {
                    $('#check-box-all').prop('checked', true);
                } else {
                    $('#check-box-all').prop('checked', false);
                }
            });

        }







        function lawyerAssignToPlaintiff() {
            let casesIds = selectedRows;
            let lawyerId = $("#lawyerSelect").val();

            $.ajax({
                url: "{{ route('admin.lawyer-cases-assign') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: casesIds,
                    lawyerId: lawyerId
                },
                success: function(response) {
                    if (response.lawyer) {
                        console.log(response);

                        let casesId = response.id;

                        for (const item of casesId) {

                            $(`#lawyer-assign-case-${Number(item)}`).html(response.lawyer);
                        }


                        toastr.success("Cases Assign to Lawyer");

                    } else {
                        alert('Failed to update the lawyer name.');
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





        function lawyerDissociateToPlaintiff() {
            let casesIds = selectedRows;
            let lawyerId = $("#lawyerSelect").val();

            $.ajax({
                url: "{{ route('admin.lawyer-dissiociate-assign') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: casesIds,
                },
                success: function(response) {
                    if (response.lawyer) {
                        console.log(response);

                        let casesId = response.id;

                        for (const item of casesId) {

                            $(`#lawyer-assign-case-${Number(item)}`).html(response.lawyer);
                        }


                        toastr.success("Lawyer Dissiociate form case");

                    } else {
                        alert('Failed to update the lawyer name.');
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















        $(document).on('click', '.admin-message', function() {


            $("#dynamic-modal").modal('show');

            $('.dynamic-body').html("dasfaffafafff");
            $('.dynamic-title').text('');


            id = $(this).data('id');
            $.ajax({
                url: "{{ url('admin/case') }}" + "/" + id + "/" + "message",
                method: "GET",
                data: {
                    _token: "{{ csrf_token() }}",


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
