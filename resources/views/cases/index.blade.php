@extends('layouts.app')

@section('title', 'Customers')





@section('content')

    <style>
        .card-box {
            display: none;
            position: absolute;
            padding: 10px;
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 3;
        }

        /* progress bar  */
        .multi-step-bar {
            overflow: hidden;
            counter-reset: step;
            width: 315px;

        }

        .status-step {
            text-align: center;
            list-style-type: none;
            color: #363636;
            text-transform: CAPITALIZE;
            width: 16.65%;
            float: left;
            position: relative;
            font-weight: 600;
        }

        .status-step:before {
            content: counter(step);
            counter-increment: step;
            width: 30px;
            line-height: 30px;
            display: block;
            font-size: 12px;
            color: green;
            background: #e6e6e6;
            border-radius: 50%;
            margin: 0 auto 5px auto;
            -webkit-box-shadow: 0 6px 20px 0 rgba(69, 90, 100, 0.15);
            -moz-box-shadow: 0 6px 20px 0 rgba(69, 90, 100, 0.15);
            box-shadow: 0 6px 20px 0 rgba(69, 90, 100, 0.15);
        }

        .status-step:after {
            content: '';
            width: 25px;
            height: 3px;
            background: #208528;
            position: absolute;
            left: -26%;
            top: 15px;
            z-index: 0;
        }

        .status-step:first-child:after {
            content: none;
        }

        .status-step.active:before {
            background: green;
            color: white;
        }




        /* Custom Tooltip Style */

        /*  */
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
    <style>
        #container {
            overflow: visible;

        }

        .step-container {
            position: relative;
            text-align: center;
            transform: translateY(-43%);
        }

        .step-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #fff;
            border: 2px solid #007bff;
            line-height: 30px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            cursor: pointer;

            /* Added cursor pointer */
        }

        .step-line {
            position: absolute;
            top: 16px;
            /* Adjust as needed */
            left: calc(50% - 50px);
            /* Center the line */
            width: calc(100% - 100px);
            /* Ensure the width is sufficient */
            height: 2px;
            background-color: #007bff;
            z-index: 4;

        }

        #multi-step-form {
            overflow-x: hidden;
        }

        .btcd-f-input {
            display: inline-block;
            width: 340px;
            position: relative;
            overflow: hidden;
        }

        .btcd-f-input>div>input::-webkit-file-upload-button {
            cursor: pointer;
        }

        .btcd-f-wrp {
            cursor: pointer;
        }

        .btcd-f-wrp>small {
            color: gray;
        }

        .btcd-f-wrp>button {
            cursor: pointer;
            background: #f3f3f3;
            padding: 5px;
            display: inline-block;
            border-radius: 9px;
            border: none;
            margin-right: 8px;
            height: 35px;
        }

        .btcd-f-wrp>button>img {
            width: 24px;
        }

        .btcd-f-wrp>button>span,
        .btcd-f-wrp>span,
        .btcd-f-wrp>small {
            vertical-align: super;
        }

        .btcd-f-input>.btcd-f-wrp>input {
            z-index: 100;
            width: 100%;
            position: absolute;
            opacity: 0;
            left: 0;
            height: 37px;
            cursor: pointer;
        }

        .btcd-f-wrp:hover {
            background: #fafafa;
            border-radius: 10px;
        }

        .btcd-files>div {
            display: flex;
            align-items: center;
            background: #f8f8f8;
            border-radius: 10px;
            margin-left: 30px;
            width: 91%;
            margin-top: 10px;
            height: 40px;
        }

        .btcd-files>div>div {
            display: inline-block;
            width: 73%;
        }

        .btcd-files>div>div>small {
            color: gray;
        }

        .btcd-files>div>img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
            border-radius: 10px;
        }

        .btcd-files>div>div>span {
            display: inline-block;
            width: 100%;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }

        .btcd-files>div>button {
            background: #e8e8e8;
            border: none;
            border-radius: 50px;
            width: 25px;
            height: 25px;
            font-size: 20px;
            margin-right: 6px;
            padding: 0;
        }

        .btcd-files>div>button:hover {
            background: #bbbbbb;
        }

        .status-progress-bar {
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow: hidden;
            color: var(--bs-progress-bar-color);
            text-align: center;
            white-space: nowrap;
            background-color: var(--bs-progress-bar-bg);
            transition: var(--bs-progress-bar-transition);
        }

        .dropdown-toggle::after {
            display: none
        }
    </style>

    <style>
        .status-case-multi-steps {
            display: flex;
            counter-reset: stepNum;
            justify-content: space-between;
            width: 100%;
            margin: 0 auto;
            font-size: 12px;
            /* Smaller font for compact design */
            position: relative;
        }

        .status-case-multi-steps>li {
            position: relative;
            list-style-type: none;
            text-align: center;
            color: #027f00;
            width: 4.5%;
            z-index: 1;
            /* Adjust for 8 steps */
        }

        .status-case-multi-steps>li:before {
            content: counter(stepNum);
            counter-increment: stepNum;
            display: block;
            margin: 0 auto 4px;
            background-color: #027f00;
            width: 24px;
            /* Smaller circle */
            height: 24px;
            line-height: 24px;
            text-align: center;
            font-weight: bold;
            border-width: 2px;
            border-style: solid;
            border-color: #027f00;
            border-radius: 50%;
            color: white;
        }

        .status-case-multi-steps>li.is-complete:before {
            content: "✓";
            background-color: #027f00;
            color: rgb(255, 255, 255);
        }

        .status-case-multi-steps>li:last-child:after {
            display: none;
        }

        .status-case-multi-steps>li.is-active:before {
            background-color: #027f00;
            border-color: #027f00;
            color: rgb(255, 255, 255);
            animation: pulse 2s infinite;
        }

        .status-case-multi-steps>li.is-active~li {
            color: #808080;
        }

        .status-case-multi-steps>li.is-active~li:before {
            background-color: #e1e1e1;
            border-color: #e1e1e1;
            color: #808080;
        }

        .status-case-progress-progress-container {
            position: absolute;
            top: 11px;
            /* left: 11px; */
            width: 93%;
            height: 6px;
            background-color: white;
            z-index: 0;
        }

        .status-case-progress-bar {
            background-color: #027f00;
            height: 5px;
            width: 0%;
            transition: width 0.5s ease;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 #027f0070;
            }

            100% {
                box-shadow: 0 0 0 10px #027f0000;
            }
        }
    </style>


    @include('components.loader')
    @include('components.sidemodal')

    @include('components.status')
    @include('components.multistepform')

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
        <button type="button" onclick="openCustomerCasesForm()" class="btn btn-primary">Add Cases</button>
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
                                    <th class="px-4 py-2 border-end">Progress</th>
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






    <script src="{{ asset('assets/js/createFileList.js') }}"></script>

    <script>
        //////////////////Step progress Bar////////
        let currentCard = null;

        function openCardStatus($element, content) {
            const cardBox = $element.closest('td').find('.card-box'); // Find the card-box within the same td
            const rect = $element.get(0).getBoundingClientRect(); // Get the position of the clicked li

            if (currentCard === content) {
                // If clicking the same content, close the card box
                cardBox.hide();
                currentCard = null;
            } else {
                // Update card content and position the box just above the clicked li
                cardBox.html(content);
                cardBox.show();

                // Position the card box inside the td just above the clicked li
                cardBox.css({
                    position: 'absolute', // Ensure the card is positioned absolutely
                    // Place above li
                    // Align it with the left of the li
                    width: '50%', // Ensure the card box stays within the td
                });

                currentCard = content;
            }

            // Close the card box when clicking outside
            $(window).on('click', function(event) {
                if (!$(event.target).closest('.status-step').length) {
                    cardBox.hide();
                    currentCard = null;
                }
            });
        }






        /////////////////////////////////Image Crousel//////////
        let slideIndex = 1;

        function openImageModal(imageList, fileName) {

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
                                            results: $.map(data.results, function(
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
                        data: 'case_status',
                        name: 'case_status',
                        searchable: true,
                        searchable: false,
                        createdCell: function(td, cellData, rowData, row, col) {
                            const totalSteps = 8;

                            function next(containerId, stepNumber) {
                                const container = document.getElementById(containerId);
                                const steps = container.querySelectorAll('.status-case-multi-steps > li');
                                const progressBar = container.querySelector('.status-case-progress-bar');

                                if (stepNumber <= totalSteps && stepNumber > 0) {
                                    // Complete all steps up to the given stepNumber
                                    for (let i = 0; i < stepNumber; i++) {
                                        steps[i].classList.add("is-complete");
                                        steps[i].classList.remove("is-active");
                                    }

                                    // Activate the current step
                                    steps[stepNumber - 1].classList.add("is-active");

                                    // Update the progress bar width
                                    let progressPercentage = ((stepNumber - 1) / (totalSteps - 1)) * 100;
                                    progressBar.style.width = progressPercentage + "%";
                                } else {
                                    alert('Invalid step number!');
                                }
                            }

                            setTimeout(() => {
                                next(`first_step${rowData.id}`, rowData.status), 101
                            });
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
                    // upgradeProgressBar(2);

                    // setTimeout(()=>{
                    //     console.log(data)},500);








                    // setTimeout(() => {

                    //     const containers = document.querySelectorAll('.container-fluid');


                    //     containers.forEach(container => {
                    //         const steps = container.querySelectorAll(
                    //             '.status-case-multi-steps > li');
                    //         const progressBar = container.querySelector(
                    //             '.status-case-progress-bar');

                    //         console.log(progressBar);

                    //         let activeStep = 0;


                    //         steps.forEach((step, index) => {
                    //             if (step.classList.contains('is-active')) {
                    //                 activeStep = index + 1;
                    //                 // Complete all previous steps
                    //                 for (let i = 0; i < activeStep - 1; i++) {
                    //                     steps[i].classList.add('is-complete');
                    //                     steps[i].classList.remove('is-active');
                    //                 }
                    //             }
                    //         });


                    //         let progressPercentage = ((activeStep - 1) / (totalSteps - 1)) *
                    //         100;
                    //         progressBar.style.width = progressPercentage + '%';
                    //     });
                    // }, 101);








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


        var routes = {
            countryList: "{{ route('admin.country.list') }}",
            stateList: "{{ route('admin.state.list') }}",
            cityList: "{{ route('admin.city.list') }}",
            customerList: "{{ route('admin.customer-list') }}",
            lawyerList: "{{ route('admin.lawyer.list') }}",
            proficienceList: "{{ route('admin.proficience.list') }}",
        };


        function initializeSelect2(selector, url, parentId = null, placeholder, formatResult, formatSelection, serchTerm =
            '') {

            $(`${selector}`).val(null).trigger("change");

            $(selector).select2({
                placeholder: placeholder,
                allowClear: true,
                dropdownParent: $('#add-customer-cases'),
                width: 'resolve',
                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term || serchTerm,
                            page: params.page || 1,
                            parent_id: parentId

                        };
                    },
                    processResults: function(data, params) {

                        console.log(data);

                        params.page = params.page || 1;

                        return {
                            results: $.map(data.results, function(item) {
                                return {
                                    id: item.id,
                                    text: item.profile_url ?
                                        `<td class="d-flex align-items-center">
                                        <img src="${item.profile_url}" width="20" alt="${item.name}" height="20" class="rounded-circle me-2">
                                        ${item.name}
                                     </td>` : item.name
                                };
                            }),
                            pagination: {
                                more: data.hasMore
                            }
                        };
                    },
                    cache: true
                },
                minimumInputLength: 0,
                minimumResultsForSearch: 0,
                templateResult: formatResult,
                templateSelection: formatSelection,
                escapeMarkup: function(markup) {
                    return markup;

                }
            });
        }


        function formatCountry(country) {
            return country.text ? `<div class="country-result">${country.text}</div>` : country.text;
        }

        function formatCountrySelection(country) {
            return country.text || country.id;
        }

        function formatProficience(proficience) {
            return proficience.text ? `<div class="country-result">${proficience.text}</div>` : proficience.text;
        }

        function formatProficienceSelection(proficience) {
            return proficience.text || proficience.id;
        }

        function formatState(state) {
            return state.text ? `<div class="state-result">${state.text}</div>` : state.text;
        }

        function formatStateSelection(state) {
            return state.text || state.id;
        }

        function formatCity(city) {
            return city.text ? `<div class="city-result">${city.text}</div>` : city.text;
        }

        function formatCitySelection(city) {
            return city.text || city.id;
        }


        function formatCustomer(customer) {
            if (customer.loading) {
                return customer.text;
            }
            return `<div>${customer.text}</div>`;
        }

        // Optional: Format the selected lawyer in the box
        function formatLawyerSelection(lawyer) {
            return lawyer.text || lawyer.id;
        }

        function formatLawyer(lawyer) {
            if (lawyer.loading) {
                return lawyer.text;
            }
            return `<div>${lawyer.text}</div>`;
        }

        // Optional: Format the selected lawyer in the box
        function formatCustomerSelection(customer) {
            return customer.text || customer.id;
        }



        function openCustomerCasesForm() {
            // Show modal
            $("#add-customer-cases").modal('show');

            $("#customer-case-user-basic-detail").trigger("reset");


            $(".preview-content").each(function(index, element) {
                delItem(element);
            });

            getFileSize(0);
            displayStep(1);



            // Initialize country select
            // initializeSelect2('#countrySelect', routes.countryList, null, 'Select a Country', formatCountry,
            //     formatCountrySelection);

            initializeSelect2('#customerSelect', routes.customerList, null, 'Select a Customer', formatCustomer,
                formatCustomerSelection);
            initializeSelect2('#stateSelect', routes.stateList, 233, 'Select a State', formatState,
                formatStateSelection);

            initializeSelect2('#preferdAttroneySelect', routes.lawyerList, null, 'Select a prefred lawyer', formatLawyer,
                formatLawyerSelection);

            initializeSelect2('#caseTypeSelect', routes.proficienceList, null, 'Select a case type', formatProficience,
                formatProficienceSelection);

            // $('#countrySelect').on('change', function() {
            //     var countryId = $(this).val();

            //     if (countryId) {
            //         $("#stateSelect").val(null).trigger("change");
            //         $("#citySelect").val(null).trigger("change");
            //         initializeSelect2('#stateSelect', routes.stateList, countryId, 'Select a State', formatState,
            //             formatStateSelection);


            //     }
            // });


            $('#stateSelect').on('change', function() {
                var stateId = $(this).val();
                if (stateId) {
                    $("#citySelect").val(null).trigger("change");
                    initializeSelect2('#citySelect', routes.cityList, stateId, 'Select a City', formatCity,
                        formatCitySelection);
                }
            });



        }






        function getCountryStateCity(zipcode) {
            if (zipcode.trim() !== '' && zipcode.trim().length > 4) {
                console.log('Searching for State and City using Zipcode:', zipcode);

                $.ajax({
                    url: "{{ route('admin.zipcodeinfo') }}",
                    method: 'POST',
                    data: {
                        zipcode: zipcode,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        $("#spinner-div").show();
                    },
                    success: function(response) {
                        if (response.status) {
                            const result = response.result[0];
                            const state = result.state;
                            const city = result.postalLocation;
                            const stateId = result.state_id;
                            const cityId = result.city_id;

                            console.log('State from API:', state);
                            console.log('City from API:', city);



                            var newStateOption = new Option(state, stateId, true, true);
                            $('#stateSelect').append(newStateOption).trigger('change');

                            var newCityOption = new Option(city, cityId, true, true);
                            $('#citySelect').append(newCityOption).trigger('change');





                        } else {
                            console.log('Error: No valid data found');
                        }
                        $("#spinner-div").hide();
                    },
                    error: function(xhr, status, error) {
                        $("#spinner-div").hide();
                        console.log('Error occurred while fetching state and city:', error);
                    }
                });
            }
        }


        function saveCustomerCaseUserBasicDetail(e) {
            e.preventDefault();

            let formData = new FormData($("#customer-case-user-basic-detail")[0]);

            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: "{{ route('admin.customer-case-user-bascic-detail') }}",
                method: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                beforeSend: function() {
                    $("#spinner-div").show();
                },
                success: function(response) {
                    $("#spinner-div").hide();
                    toastr.success("Case user basic detail save successfully!!");
                    customerCaseDetailsDataTable();
                    $("#add-customer-cases").modal('hide');

                },
                error: function(xhr, status, error) {

                    errorMessage1 = xhr.responseJSON.error1.original.errors;
                    errorMessage2 = xhr.responseJSON.error2.original.errors;

                    $("#spinner-div").hide();
                    if (xhr.status == 422) {

                        var errorMessage = "";
                        if (errorMessage1.length != 0) {
                            var errorMessage = xhr.responseJSON.error1.original.errors;
                            displayStep(1)
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

                        if (xhr.responseJSON.error2) {
                            var errorMessage = xhr.responseJSON.error2.original.errors;


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

                    if (xhr.status === 403) {

                        let errorMessage = xhr.responseJSON.errorpermissionmessage ||
                            'You do not have permission to perform this action.';

                        toastr.error(errorMessage);

                    }




                }
            });




        };
    </script>
    <script>
        var currentStep = 1;
        var updateProgressBar;

        function displayStep(stepNumber) {
            if (stepNumber >= 1 && stepNumber <= 3) {
                $(".step-" + currentStep).hide();
                $(".step-" + stepNumber).show();
                currentStep = stepNumber;
                updateProgressBar();
            }
        }

        $(document).ready(function() {
            $('#multi-step-form').find('.step').slice(1).hide();

            $(".next-step").click(function() {
                if (currentStep < 3) {
                    $(".step-" + currentStep).addClass("animate__animated animate__fadeOutLeft");
                    currentStep++;
                    setTimeout(function() {
                        $(".step").removeClass("animate__animated animate__fadeOutLeft").hide();
                        $(".step-" + currentStep).show().addClass(
                            "animate__animated animate__fadeInRight");
                        updateProgressBar();
                    }, 500);
                }
            });

            $(".prev-step").click(function() {
                if (currentStep > 1) {
                    $(".step-" + currentStep).addClass("animate__animated animate__fadeOutRight");
                    currentStep--;
                    setTimeout(function() {
                        $(".step").removeClass("animate__animated animate__fadeOutRight").hide();
                        $(".step-" + currentStep).show().addClass(
                            "animate__animated animate__fadeInLeft");
                        updateProgressBar();
                    }, 500);
                }
            });

            updateProgressBar = function() {
                var progressPercentage = ((currentStep - 1) / 1) * 100;
                $(".progress-bar").css("width", progressPercentage + "%");
            }
        });


        function upgradeProgressBar(currentStep) {
            console.log(currentStep);
            var statusProgressPercentage = ((currentStep - 1) / 6) * 100;
            console.log(statusProgressPercentage);
            console.log($(".status-progress-bar"));
            $(".status-progress-bar").css("width", statusProgressPercentage + "%");
        }



        const fInputs = document.querySelectorAll('.btcd-f-input>div>input')

        function getFileSize(size) {
            let _size = size
            let unt = ['Bytes', 'KB', 'MB', 'GB'],
                i = 0;
            while (_size > 900) {
                _size /= 1024;
                i++;
            }
            return (Math.round(_size * 100) / 100) + ' ' + unt[i];
        }

        function delItem(el) {

            fileList = {
                files: []
            }
            let fInp = el.parentNode.parentNode.parentNode.querySelector('input[type="file"]')
            for (let i = 0; i < fInp.files.length; i++) {
                fileList.files.push(fInp.files[i])
            }
            fileList.files.splice(el.getAttribute('data-index'), 1)

            fInp.files = createFileList(...fileList.files)
            if (fInp.files.length > 0) {
                el.parentNode.parentNode.parentNode.querySelector('.btcd-f-title').innerHTML =
                    `${fInp.files.length} File Selected`
            } else {
                el.parentNode.parentNode.parentNode.querySelector('.btcd-f-title').innerHTML = 'No File Chosen'
            }
            el.parentNode.remove()
        }

        function fade(element) {
            let op = 1; // initial opacity
            let timer = setInterval(function() {
                if (op <= 0.1) {
                    clearInterval(timer);
                    element.style.display = 'none';
                }
                element.style.opacity = op;
                element.style.filter = 'alpha(opacity=' + op * 100 + ")";
                op -= op * 0.1;
            }, 50);
        }

        function unfade(element) {
            let op = 0.01; // initial opacity
            element.style.opacity = op;
            element.style.display = 'flex';
            let timer = setInterval(function() {
                if (op >= 1) {
                    clearInterval(timer);
                }
                element.style.opacity = op;
                element.style.filter = 'alpha(opacity=' + op * 100 + ")";
                op += op * 0.1;
            }, 13);
        }

        function get_browser() {
            let ua = navigator.userAgent,
                tem, M = ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
            if (/trident/i.test(M[1])) {
                tem = /\brv[ :]+(\d+)/g.exec(ua) || [];
                return {
                    name: 'IE',
                    version: (tem[1] || '')
                };
            }
            if (M[1] === 'Chrome') {
                tem = ua.match(/\bOPR|Edge\/(\d+)/)
                if (tem != null) {
                    return {
                        name: 'Opera',
                        version: tem[1]
                    };
                }
            }
            M = M[2] ? [M[1], M[2]] : [navigator.appName, navigator.appVersion, '-?'];
            if ((tem = ua.match(/version\/(\d+)/i)) != null) {
                M.splice(1, 1, tem[1]);
            }
            return {
                name: M[0],
                version: M[1]
            };
        }

        for (let inp of fInputs) {
            inp.parentNode.querySelector('.btcd-inpBtn>img').src =
                'data:image/svg+xml;base64,PHN2ZyBoZWlnaHQ9IjUxMiIgdmlld0JveD0iMCAwIDY0IDY0IiB3aWR0aD0iNTEyIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGlkPSJDbGlwIj48cGF0aCBkPSJtMTIuMDggNTcuNzQ5YTkgOSAwIDAgMCAxMi43MjggMGwzMS4xMTItMzEuMTEzYTEzIDEzIDAgMSAwIC0xOC4zODQtMTguMzg1bC0yMC41MDcgMjAuNTA2IDEuNDE1IDEuNDE1IDIwLjUwNi0yMC41MDZhMTEgMTEgMCAxIDEgMTUuNTU2IDE1LjU1NmwtMzEuMTEyIDMxLjExMmE3IDcgMCAwIDEgLTkuOS05LjlsMjYuODctMjYuODdhMyAzIDAgMCAxIDQuMjQyIDQuMjQzbC0xNi4yNjMgMTYuMjY0IDEuNDE0IDEuNDE0IDE2LjI2NC0xNi4yNjNhNSA1IDAgMCAwIC03LjA3MS03LjA3MWwtMjYuODcgMjYuODdhOSA5IDAgMCAwIDAgMTIuNzI4eiIvPjwvZz48L3N2Zz4='
            inp.addEventListener('mousedown', function(e) {
                setPrevData(e)
            })
            inp.addEventListener('change', function(e) {
                handleFile(e)
            })
        }

        let fileList = {
            files: []
        }
        let fName = null
        let mxSiz = null

        function setPrevData(e) {
            if (e.target.hasAttribute('multiple') && fName !== e.target.name) {

                fName = e.target.name
                fileList = fileList = {
                    files: []
                }
                if (e.target.files.length > 0) {
                    for (let i = 0; i < e.target.files.length; i += 1) {
                        console.log(e.target.files[i])
                        fileList.files.push(e.target.files[i])
                    }
                }
            }
        }

        function handleFile(e) {
            let err = []
            const fLen = e.target.files.length;
            mxSiz = e.target.parentNode.querySelector('.f-max')
            mxSiz = mxSiz != null && (Number(mxSiz.innerHTML.replace(/\D/g, '')) * Math.pow(1024, 2))

            if (e.target.hasAttribute('multiple')) {
                for (let i = 0; i < fLen; i += 1) {
                    fileList.files.push(e.target.files[i])
                }
            } else {
                fileList.files.push(e.target.files[0])
            }

            //type validate
            if (e.target.hasAttribute('accept')) {
                let tmpf = []
                let type = new RegExp(e.target.getAttribute('accept').split(",").join("$|") + '$', 'gi')
                for (let i = 0; i < fileList.files.length; i += 1) {
                    if (fileList.files[i].name.match(type)) {
                        tmpf.push(fileList.files[i])
                    } else {
                        err.push('Wrong File Type Selected')
                    }
                }
                fileList.files = tmpf
            }

            // size validate
            if (mxSiz > 0) {
                let tmpf = []
                for (let i = 0; i < fileList.files.length; i += 1) {
                    if (fileList.files[i].size < mxSiz) {
                        tmpf.push(fileList.files[i])
                        mxSiz -= fileList.files[i].size
                    } else {
                        console.log('rejected', i, fileList.files[i].size)
                        err.push('Max Upload Size Exceeded')
                    }
                }
                fileList.files = tmpf
            }

            if (e.target.hasAttribute('multiple')) {
                e.target.files = createFileList(...fileList.files)
            } else {
                e.target.files = createFileList(fileList.files[fileList.files.length - 1])
                fileList = {
                    files: []
                }
            }

            // set File list view
            if (e.target.files.length > 0) {
                e.target.parentNode.querySelector('.btcd-f-title').innerHTML = e.target.files.length + ' File Selected'
                e.target.parentNode.parentNode.querySelector('.btcd-files').innerHTML = ''
                for (let i = 0; i < e.target.files.length; i += 1) {
                    let img = null
                    if (e.target.files[i].type.match(/image-*/)) {
                        img = window.URL.createObjectURL(e.target.files[i])
                    } else {
                        img =
                            'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyMi4wLjEsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9IjAgMCAzNTIgNDI5LjEiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDM1MiA0MjkuMTsiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPHN0eWxlIHR5cGU9InRleHQvY3NzIj4NCgkuc3Qwe2ZpbGw6IzAwNEJCNzt9DQo8L3N0eWxlPg0KPHBhdGggZD0iTTQwOC44LDY2Ljh2MzI3LjRjMCwyNy40LDIyLjgsNDkuOCw1MC4zLDQ5LjhoMjM5LjNjMjcuNSwwLDQ5LjgtMjIuMyw0OS44LTQ5LjhWMTE2Yy0wLjEtMi42LTEuMi01LjItMy4xLTdsLTg4LjktODkuMQ0KCWMtMS45LTEuOS00LjQtMi45LTcuMS0yLjloLTE5MEM0MzEuNiwxNyw0MDguOCwzOS40LDQwOC44LDY2Ljh6IE03MTMuOCwxMDUuOUg2ODNjLTYuMywwLTEyLjQtMi41LTE2LjgtNi45DQoJYy00LjUtNC41LTctMTAuNS02LjktMTYuOHYtMzFMNzEzLjgsMTA1Ljl6IE00MjguOCw2Ni44YzAtMTYuNSwxMy45LTI5LjgsMzAuMy0yOS44aDE4MC4ydjQ1LjFjMCwxMS42LDQuNiwyMi43LDEyLjgsMzENCgljOC4yLDguMiwxOS4zLDEyLjgsMzAuOSwxMi44aDQ1LjF2MjY4LjVjMCwxNi41LTEzLjksMjkuOC0zMC4zLDI5LjhINDU5LjFjLTE2LjYsMC0zMC4zLTEzLjQtMzAuMy0yOS44VjY2Ljh6Ii8+DQo8cGF0aCBjbGFzcz0ic3QwIiBkPSJNMjc3LjIsMTY2LjlIMTMwLjZjLTUuMSwwLTkuMiw0LjEtOS4yLDkuMnM0LjEsOS4yLDkuMiw5LjJoMTQ2LjVjNS4xLDAsOS4yLTQuMSw5LjItOS4xDQoJQzI4Ni40LDE3MSwyODIuMywxNjYuOSwyNzcuMiwxNjYuOXoiLz4NCjxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik05My41LDE2Ni45SDY2LjRjLTUuMSwwLTkuMiw0LjEtOS4yLDkuMnM0LjEsOS4yLDkuMiw5LjJoMjcuMWM1LjEsMCw5LjItNC4xLDkuMi05LjJTOTguNiwxNjYuOSw5My41LDE2Ni45eiINCgkvPg0KPHBhdGggY2xhc3M9InN0MCIgZD0iTTI3Ny4yLDI0MC4zSDEzMC42Yy01LjEsMC05LjIsNC4xLTkuMiw5LjJjMCw1LjEsNC4xLDkuMiw5LjIsOS4yaDE0Ni41YzUuMSwwLDkuMi00LjEsOS4yLTkuMQ0KCVMyODIuMywyNDAuNCwyNzcuMiwyNDAuM3oiLz4NCjxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik05My41LDI0MC4zSDY2LjRjLTUuMSwwLTkuMiw0LjEtOS4yLDkuMmMwLDUuMSw0LjEsOS4yLDkuMiw5LjJoMjcuMWM1LjEsMCw5LjItNC4xLDkuMi05LjINCglDMTAyLjcsMjQ0LjQsOTguNiwyNDAuMyw5My41LDI0MC4zeiIvPg0KPHBhdGggY2xhc3M9InN0MCIgZD0iTTI3Ny4yLDMxMy44SDEzMC42Yy01LjEsMC05LjIsNC4xLTkuMiw5LjJjMCw1LjEsNC4xLDkuMiw5LjIsOS4yaDE0Ni41YzUuMSwwLDkuMi00LjEsOS4yLTkuMQ0KCUMyODYuNCwzMTgsMjgyLjMsMzEzLjgsMjc3LjIsMzEzLjh6Ii8+DQo8cGF0aCBjbGFzcz0ic3QwIiBkPSJNOTMuNSwzMTMuOEg2Ni40Yy01LjEsMC05LjIsNC4xLTkuMiw5LjJjMCw1LjEsNC4xLDkuMiw5LjIsOS4yaDI3LjFjNS4xLDAsOS4yLTQuMSw5LjItOS4yDQoJQzEwMi43LDMxNy45LDk4LjYsMzEzLjgsOTMuNSwzMTMuOHoiLz4NCjxnPg0KCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0yNjMsNDEyLjFIODljLTQxLjQsMC03NS0zMy42LTc1LTc1di0yNDVjMC00MS40LDMzLjYtNzUsNzUtNzVoMTQ3LjVjOCwwLDE1LjcsMywyMS42LDguNWw2OSw2My42DQoJCWM2LjksNi4zLDEwLjgsMTUuMywxMC44LDI0Ljd2MjIzLjJDMzM4LDM3OC40LDMwNC40LDQxMi4xLDI2Myw0MTIuMXogTTg5LDM3LjNjLTMwLjIsMC01NC43LDI0LjYtNTQuNyw1NC43djI0NQ0KCQljMCwzMC4yLDI0LjYsNTQuNyw1NC43LDU0LjdoMTc0YzMwLjIsMCw1NC43LTI0LjYsNTQuNy01NC43VjExMy44YzAtMy43LTEuNi03LjMtNC4zLTkuOGwtNjktNjMuNmMtMi4yLTItNS0zLjEtNy45LTMuMUg4OXoiLz4NCjwvZz4NCjwvc3ZnPg0K'
                    }
                    e.target.parentNode.parentNode.querySelector('.btcd-files').insertAdjacentHTML('beforeend', `<div>
                    <img src="${img}" alt="img"  title="${e.target.files[i].name}">
                    <div>
                        <span title="${e.target.files[i].name}">${e.target.files[i].name}</span>
                        <br/>
                        <small>${getFileSize(e.target.files[i].size)}</small>
                    </div>
                    <button class="preview-content" type="button" onclick="delItem(this)" data-index="${i}" title="Remove This File"><span>&times;</span></button>
                </div>`)

                }
            }

            // set eror
            if (err.length > 0) {
                for (let i = 0; i < err.length; i += 1) {
                    e.target.parentNode.parentNode.querySelector('.btcd-files').insertAdjacentHTML('afterbegin', `
            <div style="background: #fff2f2;color: darkred;display:none" class="btcd-f-err">
                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjg2LjA1NCIgaGVpZ2h0PSIyODYuMDU0IiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgoKIDxnPgogIDx0aXRsZT5iYWNrZ3JvdW5kPC90aXRsZT4KICA8cmVjdCBmaWxsPSJub25lIiBpZD0iY2FudmFzX2JhY2tncm91bmQiIGhlaWdodD0iNDAyIiB3aWR0aD0iNTgyIiB5PSItMSIgeD0iLTEiLz4KIDwvZz4KIDxnPgogIDx0aXRsZT5MYXllciAxPC90aXRsZT4KICA8ZyBzdHJva2U9Im51bGwiIGlkPSJzdmdfMSI+CiAgIDxwYXRoIHN0cm9rZT0ibnVsbCIgaWQ9InN2Z18yIiBmaWxsPSIjOTEwNjAxIiBkPSJtMTQzLjAyNjk5Nyw1Ni4wMDAwMDVjLTQ4LjA2MDg2NSwwIC04Ny4wMjY5OTcsMzguOTY2MTMxIC04Ny4wMjY5OTcsODcuMDI2OTk3YzAsNDguMDY2MzQyIDM4Ljk2NjEzMSw4Ny4wMjY5OTcgODcuMDI2OTk3LDg3LjAyNjk5N2M0OC4wNjYzNDIsMCA4Ny4wMjY5OTcsLTM4Ljk1NTE3OSA4Ny4wMjY5OTcsLTg3LjAyNjk5N2MwLC00OC4wNjA4NjUgLTM4Ljk2MTI2NCwtODcuMDI2OTk3IC04Ny4wMjY5OTcsLTg3LjAyNjk5N3ptMCwxNTcuNzM2MTY2Yy0zOS4wNTMxNDIsMCAtNzAuNzA5MTY5LC0zMS42NTYwMjcgLTcwLjcwOTE2OSwtNzAuNzA5MTY5czMxLjY1NjAyNywtNzAuNzA5MTY5IDcwLjcwOTE2OSwtNzAuNzA5MTY5czcwLjcwOTE2OSwzMS42NTYwMjcgNzAuNzA5MTY5LDcwLjcwOTE2OXMtMzEuNjU2MDI3LDcwLjcwOTE2OSAtNzAuNzA5MTY5LDcwLjcwOTE2OXptMC4wMDU0NzYsLTExOS41Njk1NThjLTYuMjMzMTIxLDAgLTEwLjk0OTMzNywzLjI1Mjg1NyAtMTAuOTQ5MzM3LDguNTA2OTU2bDAsNDguMTkxMDc3YzAsNS4yNTk1NzYgNC43MTU2MDgsOC41MDE0OCAxMC45NDkzMzcsOC41MDE0OGM2LjA4MTAwNCwwIDEwLjk0OTMzNywtMy4zNzc1OTIgMTAuOTQ5MzM3LC04LjUwMTQ4bDAsLTQ4LjE5MTA3N2MtMC4wMDA2MDgsLTUuMTI5MzY0IC00Ljg2ODMzMywtOC41MDY5NTYgLTEwLjk0OTMzNywtOC41MDY5NTZ6bTAsNzYuMDU2MzY0Yy01Ljk4ODUxOCwwIC0xMC44NjIzMjYsNC44NzM4MDkgLTEwLjg2MjMyNiwxMC44NjcxOTRjMCw1Ljk4MzA0MSA0Ljg3MzgwOSwxMC44NTY4NSAxMC44NjIzMjYsMTAuODU2ODVzMTAuODU2ODUsLTQuODczODA5IDEwLjg1Njg1LC0xMC44NTY4NWMtMC4wMDA2MDgsLTUuOTkzOTk0IC00Ljg2ODMzMywtMTAuODY3MTk0IC0xMC44NTY4NSwtMTAuODY3MTk0eiIvPgogIDwvZz4KICA8ZyBpZD0ic3ZnXzMiLz4KICA8ZyBpZD0ic3ZnXzQiLz4KICA8ZyBpZD0ic3ZnXzUiLz4KICA8ZyBpZD0ic3ZnXzYiLz4KICA8ZyBpZD0ic3ZnXzciLz4KICA8ZyBpZD0ic3ZnXzgiLz4KICA8ZyBpZD0ic3ZnXzkiLz4KICA8ZyBpZD0ic3ZnXzEwIi8+CiAgPGcgaWQ9InN2Z18xMSIvPgogIDxnIGlkPSJzdmdfMTIiLz4KICA8ZyBpZD0ic3ZnXzEzIi8+CiAgPGcgaWQ9InN2Z18xNCIvPgogIDxnIGlkPSJzdmdfMTUiLz4KICA8ZyBpZD0ic3ZnXzE2Ii8+CiAgPGcgaWQ9InN2Z18xNyIvPgogPC9nPgo8L3N2Zz4=" alt="img">
                <span>${err[i]}</span>
            </div>`)
                }
                const errNods = e.target.parentNode.parentNode.querySelectorAll('.btcd-files>.btcd-f-err')
                for (let i = 0; i < errNods.length; i += 1) {
                    unfade(errNods[i])
                    setTimeout(() => {
                        fade(errNods[i])
                    }, 3000);
                    setTimeout(() => {
                        errNods[i].remove()
                    }, 4000);
                }
                err = []
            }

        }
    </script>


@endsection
