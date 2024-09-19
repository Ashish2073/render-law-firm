@extends('layouts.app')

@section('title', 'Lawyer')

@section('content')

    <style>
        .top-right-button {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .profile-image-card,
        .form-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 10px;
            width: 100%;
            max-width: 400px;
        }

        .profile-image-card {
            flex: 1 1 30%;
            text-align: center;
        }



        .profile-image-card input {
            display: block;
            margin: 10px auto;
        }

        .form-cards {
            flex: 1 1 60%;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .form-card {
            margin-bottom: 20px;
        }

        h2 {
            margin-top: 0;
        }

        .form-group {
            margin-top: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px 20px;
            font-size: 16px;
            align-self: flex-end;
        }

        button:hover {
            background-color: #45a049;
        }

        /* General Styles */

        * {
            box-sizing: border-box;
        }

        :root {
            --clr-white: rgb(255, 255, 255);
            --clr-black: rgb(0, 0, 0);
            --clr-light: rgb(245, 248, 255);
            --clr-light-gray: rgb(196, 195, 196);
            --clr-blue: rgb(63, 134, 255);
            --clr-light-blue: rgb(171, 202, 255);
        }

        .upload-area {
            width: 100%;
            /* max-width: 20rem; */
            background-color: var(--clr-white);
            box-shadow: 0 10px 60px rgb(218, 229, 255);
            border: 2px solid var(--clr-light-blue);
            border-radius: 24px;
            padding: 2rem 1.875rem 5rem 1.875rem;
            margin: 0.625rem;
            text-align: center;
        }

        .upload-area--open {
            /* Slid Down Animation */
            animation: slidDown 500ms ease-in-out;
        }

        @keyframes slidDown {
            from {
                height: 28.125rem;
                /* 450px */
            }

            to {
                height: 35rem;
                /* 560px */
            }
        }

        /* Header */
        .upload-area__header {}

        .upload-area__title {
            font-size: 1.8rem;
            font-weight: 500;
            margin-bottom: 0.3125rem;
        }

        .upload-area__paragraph {
            font-size: 0.9375rem;
            color: var(--clr-light-gray);
            margin-top: 0;
        }

        .upload-area__tooltip {
            position: relative;
            color: var(--clr-light-blue);
            cursor: pointer;
            transition: color 300ms ease-in-out;
        }

        .upload-area__tooltip:hover {
            color: var(--clr-blue);
        }

        .upload-area__tooltip-data {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -125%);
            min-width: max-content;
            background-color: var(--clr-white);
            color: var(--clr-blue);
            border: 1px solid var(--clr-light-blue);
            padding: 0.625rem 1.25rem;
            font-weight: 500;
            opacity: 0;
            visibility: hidden;
            transition: none 300ms ease-in-out;
            transition-property: opacity, visibility;
        }

        .upload-area__tooltip:hover .upload-area__tooltip-data {
            opacity: 1;
            visibility: visible;
        }

        /* Drop Zoon */
        .upload-area__drop-zoon {
            position: relative;
            height: 5.25rem;
            /* 180px */
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            border: 2px dashed var(--clr-light-blue);
            border-radius: 15px;
            margin-top: 2.1875rem;
            cursor: pointer;
            transition: border-color 300ms ease-in-out;
        }

        .upload-area__drop-zoon:hover {
            border-color: var(--clr-blue);
        }

        .drop-zoon__icon {
            display: flex;
            font-size: 3.75rem;
            color: var(--clr-blue);
            transition: opacity 300ms ease-in-out;
        }

        .drop-zoon__paragraph {
            font-size: 0.9375rem;
            color: var(--clr-light-gray);
            margin: 0;
            margin-top: 0.625rem;
            transition: opacity 300ms ease-in-out;
        }

        .drop-zoon:hover .drop-zoon__icon,
        .drop-zoon:hover .drop-zoon__paragraph {
            opacity: 0.7;
        }

        .drop-zoon__loading-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
            color: var(--clr-light-blue);
            z-index: 10;
        }

        .drop-zoon__preview-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 0.3125rem;
            border-radius: 10px;
            display: block;
            z-index: 1000;
            transition: opacity 300ms ease-in-out;
        }

        .drop-zoon:hover .drop-zoon__preview-image {
            opacity: 0.8;
        }

        .drop-zoon__file-input {
            display: none;
        }

        /* (drop-zoon--over) Modifier Class */
        .drop-zoon--over {
            border-color: var(--clr-blue);
        }

        .drop-zoon--over .drop-zoon__icon,
        .drop-zoon--over .drop-zoon__paragraph {
            opacity: 0.7;
        }

        /* (drop-zoon--over) Modifier Class */
        .drop-zoon--Uploaded {}

        .drop-zoon--Uploaded .drop-zoon__icon,
        .drop-zoon--Uploaded .drop-zoon__paragraph {
            display: none;
        }

        /* File Details Area */
        .upload-area__file-details {
            height: 0;
            visibility: hidden;
            opacity: 0;
            text-align: left;
            transition: none 500ms ease-in-out;
            transition-property: opacity, visibility;
            transition-delay: 500ms;
        }

        /* (duploaded-file--open) Modifier Class */
        .file-details--open {
            height: auto;
            visibility: visible;
            opacity: 1;
        }

        .file-details__title {
            font-size: 1.125rem;
            font-weight: 500;
            color: var(--clr-light-gray);
        }

        /* Uploaded File */
        .uploaded-file {
            display: flex;
            align-items: center;
            padding: 0.625rem 0;
            visibility: hidden;
            opacity: 0;
            transition: none 500ms ease-in-out;
            transition-property: visibility, opacity;
        }

        /* (duploaded-file--open) Modifier Class */
        .uploaded-file--open {
            visibility: visible;
            opacity: 1;
        }

        .uploaded-file__icon-container {
            position: relative;
            margin-right: 0.3125rem;
        }

        .uploaded-file__icon {
            font-size: 3.4375rem;
            color: var(--clr-blue);
        }

        .uploaded-file__icon-text {
            position: absolute;
            top: 1.5625rem;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.9375rem;
            font-weight: 500;
            color: var(--clr-white);
        }

        .uploaded-file__info {
            position: relative;
            top: -0.3125rem;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        .uploaded-file__info::before,
        .uploaded-file__info::after {
            content: '';
            position: absolute;
            bottom: -0.9375rem;
            width: 0;
            height: 0.5rem;
            background-color: #ebf2ff;
            border-radius: 0.625rem;
        }

        .uploaded-file__info::before {
            width: 100%;
        }

        .uploaded-file__info::after {
            width: 100%;
            background-color: var(--clr-blue);
        }

        /* Progress Animation */
        .uploaded-file__info--active::after {
            animation: progressMove 800ms ease-in-out;
            animation-delay: 300ms;
        }

        @keyframes progressMove {
            from {
                width: 0%;
                background-color: transparent;
            }

            to {
                width: 100%;
                background-color: var(--clr-blue);
            }
        }

        .uploaded-file__name {
            width: 100%;
            max-width: 6.25rem;
            /* 100px */
            display: inline-block;
            font-size: 1rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .uploaded-file__counter {
            font-size: 1rem;
            color: var(--clr-light-gray);
        }

        .dt-search {
            display: flex;
            justify-content: end;
        }

        .dt-search label {
            margin-top: 10px;
        }
    </style>

    @include('components.lawyerfeedback')
    @include('components.viewimagemodal')

    @include('components.loader')


    @include('components.status', [
        'modal_id' => 'lawyerstatuschange',
    ])

    @include('lawyers.create')

    <div id="editlawyerformid" class="modal fade" tabindex="-1" role="dialog">

    </div>

    @include('components.input', [
        'modal_id' => 'proficiencemodal',
        'input_id' => 'proficience_name',
        'modal_heading' => 'Enter Lawyer Proficiene',
        'modal_label_name' => 'Proficience Name',
        'input_name' => 'proficience_name',
        'input_error' => 'proficience_name_error',
        'input_save_button' => 'proficience_save_button',
    ])

    @include('components.editimagemodal', [
        'modal_id' => 'editLawyerImagemodal',
        'modal_heading' => 'Edit Lawyer Image',
        'modal_label_name' => 'Lawyer Image',
        'uploadAreaId' => 'uploadAreaImageEdit',
        'dropZoomId' => 'dropZoonImageEdit',
        'loadingTextId' => 'loadingTextImageEdit',
        'previewImageId' => 'previewImageEdit',
        'fileInputId' => 'fileInputImageEdit',
        'fileDetailsId' => 'fileDetailsImageEdit',
        'uploadedFileId' => 'uploadedFileImageEdit',
        'uploadedFileInfoId' => 'uploadedFileInfoImageEdit',
        'input_save_button' => 'imageupdateSubmitButton',
    ])


    <div class="page-header">
        <h3 class="fw-bold mb-3">Lawyers</h3>
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
                <a href="#">Lawyer List</a>
            </li>
        </ul>
    </div>

    <div class="page-header">
        <button type="button" id="openaddlawyerform" class="btn btn-primary">Add Lawyers</button>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Lawyers List</h4>
                </div>
                <div class="card-body">

                    <div id="customertable" class="table-responsive">
                        <table style="--bs-table-bg: hsl(0, 14%, 92%);"
                            class=" lawyer-data-table   table table-striped table-bordered w-100 text-sm text-left rtl:text-right text-black-500">
                            <thead class="bg-light border-bottom">
                                <tr>
                                    <th class="px-4 py-2 border-end">Sr No.</th>
                                    <th class="px-4 py-2 border-end">Name</th>
                                    <th class="px-4 py-2 border-end">Image</th>
                                    <th class="px-4 py-2 border-end">Email</th>
                                    <th class="px-4 py-2 border-end">Proficiencies Name</th>
                                    <th class="px-4 py-2 border-end">Created At</th>
                                    <th class="px-4 py-2 border-end">Customer FeedBack</th>
                                    <th class="px-4 py-2 border-end">Status</th>
                                    <th class="px-4 py-2 border-end">Action</th>
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
        function toggleDescription(element) {
            const description = element.previousElementSibling;

            if (description.classList.contains('expanded')) {
                // Collapse the text to 10 words
                const shortReview = description.getAttribute('data-short-text');
                description.textContent = shortReview;
                description.classList.remove('expanded');
                element.textContent = 'Show More';
            } else {
                // Expand the text to full review
                const fullReview = description.getAttribute('data-full-text');
                description.textContent = fullReview;
                description.classList.add('expanded');
                element.textContent = 'Show Less';
            }
        }




        function openModalFeddBackReview(id, avgRating, count, ratngsRange) {
            let lawyerId = id

            $("#spinner-div").show();
            $("#poor_rating").html(`(${ratngsRange.range_1_to_2})`);
            $("#average_rating").html(`(${ratngsRange.range_2_to_3})`);
            $("#good_rating").html(`(${ratngsRange.range_3_to_4})`);
            $("#excellent_rating").html(`(${ratngsRange.range_4_to_5})`);

            $("#avg_rating").html(avgRating);
            $("#customer_count").html(`Based on ${count} reviews`);
            $("#feedback-container").html(" ");
            $("#lawyer_feedback").modal('show');
            $('#feedback-container').off('scroll');
            $('#feedback-container').on('scroll', function() {
                let container = $(this);
                if (container.scrollTop() + container.innerHeight() >= container[0].scrollHeight - 50) {
                    console.log("scrollbar");
                    loadFeedbacks(lawyerId);
                }
            });

            let page = 1; // Start with the first page
            let isLoading = false; // Prevent multiple requests
            let hasMoreData = true;

            function appendFeedbacks(feedbacks) {
                if (feedbacks.length > 0) {


                    feedbacks.forEach(feedback => {
                        let starsHtml = generateStars(feedback.ratings);


                        let fullReview = feedback.customer_review.replace(/"/g, '&quot;');
                        let shortReview = fullReview.split(' ').slice(0, 10).join(' ') + '...';

                        let stars_html = '<div class="d-flex align-items-center">';
                        for (let i = 1; i <= 5; i++) {
                            if (i <= feedback.ratings) {

                                stars_html +=
                                    "<i class='fas fa-star' style='color: #FFD700;'></i>";
                            } else {

                                stars_html +=
                                    "<i class='far fa-star' style='color: #FFD700;'></i>";
                            }
                        }

                        stars_html += `</div>`;

                        let feedbackHtml = `<div class="d-flex align-items-start mb-3">
                                 <img src="${feedback.customer_profile_image}" alt="Customer Photo" class="customer-img me-3"><div>
                                  <h6>${feedback.customer_name} <small class="text-muted">${feedback.review_date}</small></h6>
                                  <p>Rating:&nbsp${feedback.ratings} ${stars_html}</p> <!-- Display rating value followed by stars -->
                                  <p class="description" data-full-text="${fullReview}" data-short-text="${shortReview}">${shortReview}</p>
                                  <span class="show-more" onclick="toggleDescription(this)">Show More</span>
                                  </div>
                                  </div>
                  `;

                        $('#feedback-container').append(feedbackHtml);


                    });

                } else {
                    $('#feedback-container').html(
                        "<h3 style='text-align:center;margin-top:150px;'>No review given by customer yet ??</h3>");
                }
            }




            function loadFeedbacks(id) {
                console.log("hjgjg", id);
                if (isLoading || !hasMoreData) return;

                isLoading = true;
                $('#loading-indicator').show();

                $.ajax({
                    url: "{{ route('admin.get-feedbacks') }}",
                    type: 'GET',
                    data: {
                        page: page,
                        lawyer_id: id
                    },
                    success: function(response) {
                        $("#spinner-div").hide();
                        appendFeedbacks(response.data);
                        page++;
                        isLoading = false;
                        $('#loading-indicator').hide();
                        if (response.current_page >= response.last_page) {
                            hasMoreData = false;
                        }
                    },
                    error: function() {
                        $("#spinner-div").hide();
                        isLoading = false;
                        $('#loading-indicator').hide();
                    }
                });
            }

            function generateStars(rating) {
                let starsHtml = '';
                for (let i = 1; i <= 5; i++) {
                    if (i <= rating) {
                        starsHtml += `<span class="bi bi-star-fill review-star"></span>`;
                    } else if (i - rating < 1) {
                        starsHtml += `<span class="bi bi-star-half review-star"></span>`;
                    } else {
                        starsHtml += `<span class="bi bi-star review-star"></span>`;
                    }
                }
                return starsHtml;
            }


            loadFeedbacks(lawyerId);

        }




        function selectSubproficiencecategory(selectElement) {
            var selectedValues = Array.from(selectElement.selectedOptions).filter(option => option.selected).map(option =>
                option.value);
            var selectedTexts = Array.from(selectElement.selectedOptions).filter(option => option.selected).map(option =>
                option.text);

            $.ajax({
                url: "{{ route('admin.lawyer.proficiencelistbyparent') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    selectedValues: selectedValues,
                    selectedTexts: selectedTexts,
                },
                beforeSend: function() {
                    selectedTexts.forEach(selectedText => {
                        let selectedRemoveElement = sanitizeForId(selectedText);
                        if (selectedRemoveElement) {
                            $(`#${selectedRemoveElement}`).remove();
                        }
                    });
                },
                success: (data) => {
                    $("#proficienceoptionelement").append(data.responsehtml);


                    ids = data.id;
                    idLength = ids.length;

                    for (let i = 0; i < idLength; i++) {
                        $(`#${ids[i]}`).select2({
                            placeholder: "Select a proficiency",
                            allowClear: true,
                            dropdownParent: $("#addlawyerformid"),
                        });
                    }
                },
                error: (error) => {
                    console.error("An error occurred:", error);
                },
            });

            function removeElementsRecursively(parentElementId) {
                console.log(parentElementId);
                let selectedChildText = [];
                $(`#${parentElementId} select option`).each(function() {
                    let optionText = $(this).text()
                        .trim(); // Get the option text and trim any leading/trailing spaces

                    if (optionText !== '') { // Check if the text is not empty
                        console.log(optionText);
                        selectedChildText.push(optionText); // Only push non-empty values
                    }
                });

                selectedChildText.forEach(selectedText => {
                    let selectedChildRemoveElement = sanitizeForId(selectedText);
                    console.log(selectedText, selectedChildRemoveElement)
                    if ($(`#${selectedChildRemoveElement}`).length) {
                        removeElementsRecursively(selectedChildRemoveElement);
                        $(`#${selectedChildRemoveElement}`).remove();
                    }
                });
            }

            $(selectElement).on('select2:unselect', function(e) {
                var deselectedText = e.params.data.text.trim();
                let deselectedRemoveElement = sanitizeForId(deselectedText);

                if ($(`#${deselectedRemoveElement}`).length) {
                    removeElementsRecursively(deselectedRemoveElement);
                    $(`#${deselectedRemoveElement}`).remove();
                }
            });
        }


        function sanitizeForId(text) {

            return text.replace(/[^a-zA-Z0-9_\-]/g, '');
        }




        $(document).ready(function() {


            $("#addlawyerformid").on('shown.bs.modal', function() {
                $("#proficience").select2({
                    placeholder: "Select a proficiency",
                    allowClear: true,
                    dropdownParent: $("#addlawyerformid"),

                });

            });


            lawyerListdataTable();

        });











        ProfileImage();

        function ProfileImage() {
            const uploadArea = document.querySelector('#uploadArea')


            const dropZoon = document.querySelector('#dropZoon');


            const loadingText = document.querySelector('#loadingText');


            const fileInput = document.querySelector('#fileInput');


            const previewImage = document.querySelector('#previewImage');


            const fileDetails = document.querySelector('#fileDetails');


            const uploadedFile = document.querySelector('#uploadedFile');


            const uploadedFileInfo = document.querySelector('#uploadedFileInfo');


            const uploadedFileName = document.querySelector('.uploaded-file__name');


            const uploadedFileIconText = document.querySelector('.uploaded-file__icon-text');


            const uploadedFileCounter = document.querySelector('.uploaded-file__counter');


            const toolTipData = document.querySelector('.upload-area__tooltip-data');


            const imagesTypes = [
                "jpeg",
                "png",
                "svg",
                "gif"
            ];


            toolTipData.innerHTML = [...imagesTypes].join(', .');


            dropZoon.addEventListener('dragover', function(event) {

                event.preventDefault();


                dropZoon.classList.add('drop-zoon--over');
            });


            dropZoon.addEventListener('dragleave', function(event) {

                dropZoon.classList.remove('drop-zoon--over');
            });


            dropZoon.addEventListener('drop', function(event) {

                event.preventDefault();


                dropZoon.classList.remove('drop-zoon--over');


                const file = event.dataTransfer.files[0];


                uploadFile(file);
            });


            dropZoon.addEventListener('click', function(event) {

                fileInput.click();
            });


            fileInput.addEventListener('change', function(event) {

                const file = event.target.files[0];


                uploadFile(file);
            });


            function uploadFile(file) {

                const fileReader = new FileReader();

                const fileType = file.type;

                const fileSize = file.size;


                if (fileValidate(fileType, fileSize)) {

                    dropZoon.classList.add('drop-zoon--Uploaded');


                    loadingText.style.display = "block";

                    previewImage.style.display = 'none';


                    uploadedFile.classList.remove('uploaded-file--open');

                    uploadedFileInfo.classList.remove('uploaded-file__info--active');


                    fileReader.addEventListener('load', function() {

                        setTimeout(function() {

                            uploadArea.classList.add('upload-area--open');


                            loadingText.style.display = "none";

                            previewImage.style.display = 'block';


                            fileDetails.classList.add('file-details--open');

                            uploadedFile.classList.add('uploaded-file--open');

                            uploadedFileInfo.classList.add('uploaded-file__info--active');
                        }, 500);


                        previewImage.setAttribute('src', fileReader.result);

                        uploadedFileName.innerHTML = file.name;

                        progressMove();
                    });


                    fileReader.readAsDataURL(file);
                } else {

                    this;

                };
            };


            function progressMove() {

                let counter = 0;


                setTimeout(() => {

                    let counterIncrease = setInterval(() => {

                        if (counter === 100) {

                            clearInterval(counterIncrease);
                        } else {

                            counter = counter + 10;

                            uploadedFileCounter.innerHTML = `${counter}%`
                        }
                    }, 100);
                }, 600);
            };



            function fileValidate(fileType, fileSize) {

                let isImage = imagesTypes.filter((type) => fileType.indexOf(`image/${type}`) !== -1);


                if (isImage[0] === 'jpeg') {

                    uploadedFileIconText.innerHTML = 'jpg';
                } else {

                    uploadedFileIconText.innerHTML = isImage[0];
                };


                if (isImage.length !== 0) {

                    if (fileSize <= 2000000) {
                        return true;
                    } else {
                        return alert('Please Your File Should be 2 Megabytes or Less');
                    };
                } else {
                    return alert('Please make sure to upload An Image File Type');
                };
            };






        }



        function onMouseOveractionOnImage(id) {
            $(`#menu${id}`).removeClass('d-none');

        }

        function onMouseOutactionOnImage(id) {
            $(`#menu${id}`).addClass('d-none');
        }






        function lawyerListdataTable() {
            var table = $('.lawyer-data-table').DataTable({
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
                        text: 'Export to PDF',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        },
                        action: function(e, dt, button, config) {
                            generateCustomPDF('lawyer-data-table', 2, [0, 1, 2, 3, 4], 'lawyer-list.pdf');
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
                    url: "{{ route('admin.lawyers') }}",
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
                            $(td).dblclick(function() {
                                var $td = $(td);
                                var currentText = $(td).text();
                                var input = $('<input>', {
                                    value: currentText,
                                    type: 'text',
                                    blur: function() {
                                        updateLawyerName(rowData.id, input.val());
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
                        data: 'lawyer_image',
                        name: 'lawyer_image',
                        orderable: true,
                        searchable: false,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('id', 'lawyer_image' + rowData.id);
                        }


                    },
                    {
                        data: 'email',
                        name: 'email',
                        orderable: true,
                        searchable: true,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('id', 'email' + rowData.id);
                            $(td).dblclick(function() {
                                var $td = $(td);
                                var currentText = $(td).text();
                                var input = $('<input>', {
                                    value: currentText,
                                    type: 'email',
                                    blur: function() {
                                        updateLawyerEmail(rowData.id, input.val());
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
                        data: 'proficiencies',
                        name: 'proficiencies',
                        orderable: true,
                        searchable: true,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('id', 'proficience_area_name' + rowData.id);
                        }


                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        orderable: true,
                        searchable: false,

                    },
                    {
                        data: 'feedback_rating',
                        name: 'feedback_rating',
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



        function updateLawyerName(lawyerId, newName) {
            $.ajax({
                url: "{{ route('admin.update-lawyer-name') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: lawyerId,
                    name: newName
                },
                success: function(response) {
                    if (response.success) {
                        $(`#name${response.id}`).html(response.name);

                        toastr.success("Lawyer Name Update Successfully");

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


        function updateLawyerEmail(lawyerId, newEmail) {
            $.ajax({
                url: "{{ route('admin.update-lawyer-email') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: lawyerId,
                    email: newEmail
                },
                success: function(response) {
                    if (response.success) {
                        $(`#email${response.id}`).html(response.email);

                        toastr.success("Lawyer Email Update Successfully");

                    } else {
                        alert('Failed to update the lawyer Email.');
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
            $("#lawyerstatuschange").modal('show');

            $('#savestauschanges').off('click').on('click', function(e) {
                e.preventDefault();


                var formData = new FormData();
                formData.append('id', id);
                formData.append('status', $("#status-select").val());
                formData.append('_token', "{{ csrf_token() }}")


                $.ajax({
                    url: "{{ route('admin.lawyer.statusupdate') }}",
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
                        $("#lawyerstatuschange").modal('hide');
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





        $("#openaddlawyerform").on('click', function() {

            $("#name_error").html(" ");

            $("#email_error").html(" ");

            $("#password_error").html(" ");

            $("#experience_error").html(" ");

            $("#phone_no_error").html(" ");

            $("#description_bio_error").html(" ");

            $("#proficienc_ids_error").html(" ");

            $('.socialmedianame_error').map(function(index) {
                $(this).html("");
                $(this).attr('id', `socialmedianame.${index}_error`);

            });

            $('.socialmediaurl_error').map(function(index) {
                $(this).html("");
                $(this).attr('id', `socialmediaurl.${index}_error`);

            });

            $("#lawyer_registration")[0].reset();

            $("#proficience").val(null).trigger("change");
            $("#proficienceoptionelement").children('div').not('#proficience_main_div').remove();

            $("#addlawyerformid").modal('show');




        });


        $("#add_more_proficience").on('click', function() {
            $("#proficiencemodal").modal('show');
        })





        $("#add-lawyer-button").on('click', function(e) {

            e.preventDefault();

            let formData = new FormData($("#lawyer_registration")[0]);

            $.ajax({
                url: "{{ route('admin.lawyer.save') }}",
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

                    $('.socialmedianame_error').map(function(index) {
                        $(this).html("");
                        $(this).attr('id', `socialmedianame.${index}_error`);

                    });

                    $('.socialmediaurl_error').map(function(index) {
                        $(this).html("");
                        $(this).attr('id', `socialmediaurl.${index}_error`);

                    });
                    $("#spinner-div").show();
                },
                success: (data) => {
                    $("#spinner-div").hide();

                    $("#addlawyerformid").modal('hide');
                    lawyerListdataTable();
                    toastr.success("New Lawyer add Successfully And Creadentail send to his email");


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

                    if (xhr.status === 403) {
                        $("#addlawyerformid").modal('hide');
                        let errorMessage = xhr.responseJSON.errorpermissionmessage ||
                            'You do not have permission to perform this action.';

                        toastr.error(errorMessage);

                    }




                }
            });
        });





        $("#proficience_save_button").on('click', function(e) {

            e.preventDefault();

            let formData = new FormData();

            formData.append("proficience_name", $("#proficience_name").val());


            formData.append("_token", "{{ csrf_token() }}");

            $.ajax({
                url: "{{ route('admin.lawyer.proficience-save') }}",
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

                    $("#proficience_name").html(" ");


                },
                success: (data) => {

                    $("#proficiencemodal").modal('hide');

                    let brandOptionHtml =
                        `<option value="${data.proficience.id}">${data.proficience.proficience_name}</option>`;
                    $("#proficience").append(brandOptionHtml);


                    toastr.success("New Proficience Of Lawyers Added Successfully");


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
        });







        let num = 0;

        function addMoreSocialMediaField() {

            num++;


            let options = '';
            const selectedValues = $('.socialMediaType').map(function() {
                return $(this).val();
            }).get();

            const allOptions = {
                1: 'Facebook',
                2: 'Twitter',
                3: 'Instagram',
                4: 'LinkedIn'
            };

            $.each(allOptions, function(value, text) {
                if (!selectedValues.includes(value.toString())) {
                    options += `<option value="${value}">${text}</option>`;
                }
            });




            let htmlField = `<div class="form-row d-flex" id="sicialmediappendelement${num}"> 
                                                          <div class="form-group col-md-5" >
                                                        <label for="socialMediaType${num}">Please Select Social Media
                                                            </label>
                                                        <select id="socialMediaType${num}" name="socialmedianame[]" class="form-control socialMediaType">
                                                         <option value="">Choose...</option>
                                                            ${options}
                                                        </select>
                                                           <span class="text-danger small socialmedianame_error" id="socialmedianame.${num}_error" ></span>
                                                    
                                                    </div>
                                                    <div class="form-group col-md-5">
                                                        <label for="socialMediaUrl">Enter Social Media Link</label>
                                                        <input type="url" name="socialmediaurl[]" class="form-control" id="socialMediaUrl"
                                                            placeholder="Enter URL">
                                                          <span class="text-danger small socialmediaurl_error" id="socialmediaurl.${num}_error" ></span>
                                                    </div>

                                                    <div class="form-group col-md-2">
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeElement('sicialmediappendelement${num}')">-</button>
                                                    </div>
                                                </div>`;

            $("#socialmediacardbody").append(htmlField);


            $(document).on('change', '.socialMediaType', function() {
                updateSocialMediaOptions();
            });

            function updateSocialMediaOptions() {
                const selectedValues = $('.socialMediaType').map(function() {
                    return $(this).val();
                }).get();

                console.log(selectedValues);

                const allOptions = {
                    1: 'Facebook',
                    2: 'Twitter',
                    3: 'Instagram',
                    4: 'LinkedIn'
                };

                $('.socialMediaType').each(function() {
                    const currentSelect = $(this);
                    console.log(currentSelect);
                    const currentValue = currentSelect.val();
                    currentSelect.empty();
                    currentSelect.append('<option value="">Choose...</option>');

                    $.each(allOptions, function(value, text) {
                        if (!selectedValues.includes(value.toString()) || value.toString() ===
                            currentValue) {
                            currentSelect.append(`<option value="${value}">${text}</option>`);
                        }
                    });

                    currentSelect.val(currentValue);
                });
            }




        }


        function removeElement(id) {

            $(`#${id}`).remove();

        }


        function editLawyer(id) {

            formData = new FormData();
            formData.append('id', id);

            formData.append('_token', "{{ csrf_token() }}");

            $.ajax({
                url: "{{ route('admin.lawyer.edit') }}",
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
                    $("#editlawyerformid").html(data.editHtml);


                    $("#editlawyerformid").modal('show');




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



        function lawywerImageEdit(id) {


            let lawyerImageEditImageSrc = $(`#lawyerimage${id}`).attr('src');



            $("#fileInputImageEdit").val('');


            $("#editLawyerImagemodal").modal('show');

            $("#previewImageEdit").attr('src', lawyerImageEditImageSrc);

            $("#imageupdateSubmitButton").off('click').on('click', function(e) {
                e.preventDefault();
                let formData = new FormData($('#imageEditForm')[0]);

                formData.append('id', id);

                console.log($("#fileInputImageEdit")[0].files);

                formData.append('profile_image', $("#fileInputImageEdit")[0].files[0]);

                formData.append("_token", "{{ csrf_token() }}")

                $.ajax({
                    url: "{{ route('admin.lawyer.image.update') }}",
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

                        $(`#lawyerimage${data.id}`).attr('src',
                            `{{ asset('lawyer/images/${data.profile_image}') }}`);
                        $("#editLawyerImagemodal").modal('hide');
                        $("#fileInputImageEdit").val('');
                        $("#previewImageEdit").attr('src', " ");
                        toastr.success(" Lawyer Image Updated Successfully");


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


        function lawyerImageView(id) {
            let lawyerImageSrc = $(`#lawyerimage${id}`).attr('src');



            var modal = document.getElementById('myImageModal');



            var modalImg = document.getElementById("lawyerImageContainer");
            var captionText = document.getElementById("caption");

            modal.style.display = "block";
            modalImg.src = lawyerImageSrc;
            captionText.innerHTML = "Lawyer Image";



            var span = document.getElementsByClassName("imageclose")[0];


            span.onclick = function() {
                modal.style.display = "none";
            }
        }



        let imageHtmlContentId = {
            uploadAreaId: 'uploadAreaImageEdit',
            dropZoomId: 'dropZoonImageEdit',
            loadingTextId: 'loadingTextImageEdit',
            previewImageId: 'previewImageEdit',
            fileInputId: 'fileInputImageEdit',
            fileDetailsId: 'fileDetailsImageEdit',
            uploadedFileId: 'uploadedFileImageEdit',
            uploadedFileInfoId: 'uploadedFileInfoImageEdit'
        };

        profileImageEditModal(imageHtmlContentId);

        function profileImageEditModal(imageHtmlContentId) {

            const uploadArea = document.querySelector(`#${imageHtmlContentId.uploadAreaId}`);
            const dropZoon = document.querySelector(`#${imageHtmlContentId.dropZoomId}`);
            const loadingText = document.querySelector(`#${imageHtmlContentId.loadingTextId}`);
            const fileInput = document.querySelector(`#${imageHtmlContentId.fileInputId}`);
            const previewImage = document.querySelector(`#${imageHtmlContentId.previewImageId}`);
            const fileDetails = document.querySelector(`#${imageHtmlContentId.fileDetailsId}`);
            const uploadedFile = document.querySelector(`#${imageHtmlContentId.uploadedFileId}`);
            const uploadedFileInfo = document.querySelector(`#${imageHtmlContentId.uploadedFileInfoId}`);
            const uploadedFileName = document.querySelector('.uploaded-file__name');
            const uploadedFileIconText = document.querySelector('.uploaded-file__icon-text');
            const uploadedFileCounter = document.querySelector('.uploaded-file__counter');
            const toolTipData = document.querySelector('.upload-area__tooltip-data');

            const imagesTypes = ["jpeg", "png", "svg", "gif"];
            toolTipData.innerHTML = imagesTypes.map(type => `.${type}`).join(', ');

            dropZoon.addEventListener('dragover', function(event) {
                event.preventDefault();
                dropZoon.classList.add('drop-zoon--over');
            });

            dropZoon.addEventListener('dragleave', function() {
                dropZoon.classList.remove('drop-zoon--over');
            });

            dropZoon.addEventListener('drop', function(event) {
                event.preventDefault();
                dropZoon.classList.remove('drop-zoon--over');
                const file = event.dataTransfer.files[0];
                uploadFile(file);
            });

            dropZoon.addEventListener('click', function() {
                console.log('dsfsfsf', fileInput);
                fileInput.click();
            });


            fileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];

                console.log('changesdsd', file)
                uploadFile(file);
                // event.target.value = '';
            });

            function uploadFile(file) {
                const fileReader = new FileReader();
                const fileType = file.type;
                const fileSize = file.size;

                if (fileValidate(fileType, fileSize)) {
                    dropZoon.classList.add('drop-zoon--Uploaded');
                    loadingText.style.display = "block";
                    previewImage.style.display = 'none';
                    uploadedFile.classList.remove('uploaded-file--open');
                    uploadedFileInfo.classList.remove('uploaded-file__info--active');

                    fileReader.addEventListener('load', function() {
                        setTimeout(function() {
                            uploadArea.classList.add('upload-area--open');
                            loadingText.style.display = "none";
                            previewImage.style.display = 'block';
                            fileDetails.classList.add('file-details--open');
                            uploadedFile.classList.add('uploaded-file--open');
                            uploadedFileInfo.classList.add('uploaded-file__info--active');
                        }, 500);

                        console.log(fileReader.result);

                        previewImage.setAttribute('src', fileReader.result);
                        uploadedFileName.innerHTML = file.name;
                        progressMove();
                    });

                    fileReader.readAsDataURL(file);
                }
            }

            function progressMove() {
                let counter = 0;
                setTimeout(() => {
                    let counterIncrease = setInterval(() => {
                        if (counter === 100) {
                            clearInterval(counterIncrease);
                        } else {
                            counter += 10;
                            uploadedFileCounter.innerHTML = `${counter}%`;
                        }
                    }, 100);
                }, 600);
            }

            function fileValidate(fileType, fileSize) {
                const isImage = imagesTypes.find(type => fileType.includes(`image/${type}`));

                console.log(isImage);

                if (isImage) {
                    uploadedFileIconText.innerHTML = isImage === 'jpeg' ? 'jpg' : isImage;
                    if (fileSize <= 2000000) { // 2MB limit
                        return true;
                    } else {
                        alert('Please ensure your file is 2 Megabytes or less');
                        return false;
                    }
                } else {
                    alert('Please upload a valid image file');
                    return false;
                }
            }
        }










        // function generateCustomPDF(tableClass,imageCellPosition) {
        //     var doc = {
        //         content: [{
        //             table: {
        //                 body: []
        //             }
        //         }]
        //     };

        //     var rows = doc.content[0].table.body;
        //     var imgElements = [];

        //     $(`.${tableClass}`).find('tr').each(function(idx, row) {
        //         var rowData = [];
        //         if (idx === 0) {
        //             $(row).find('th').each(function(i, cell) {
        //                 if ([0, 1, 2, 3, 4].includes(i)) {
        //                     rowData.push({
        //                         text: $(cell).text(),
        //                         bold: true
        //                     });
        //                 }
        //             });
        //         } else {
        //             $(row).find('td').each(function(i, cell) {
        //                 if ([0, 1, 2, 3, 4].includes(i)) {
        //                     if (i === imageCellPosition) {
        //                         var imgElement = $(cell).find('img');
        //                         if (imgElement.length > 0) {
        //                             var imgSrc = imgElement.attr('src');
        //                             if (imgSrc) {
        //                                 imgElements.push({
        //                                     imgSrc: imgSrc,
        //                                     rowIdx: rows.length
        //                                 });
        //                                 rowData.push('');
        //                             } else {
        //                                 rowData.push($(cell).text());
        //                             }
        //                         } else {
        //                             rowData.push($(cell).text());
        //                         }
        //                     } else {
        //                         rowData.push($(cell).text());
        //                     }
        //                 }
        //             });
        //         }
        //         rows.push(rowData);
        //     });

        //     var imgPromises = imgElements.map(function(imgData) {
        //         return new Promise(function(resolve) {
        //             var img = new Image();
        //             img.crossOrigin = 'anonymous';
        //             img.src = imgData.imgSrc;
        //             img.onload = function() {
        //                 var canvas = document.createElement('canvas');
        //                 var ctx = canvas.getContext('2d');
        //                 canvas.width = img.width;
        //                 canvas.height = img.height;
        //                 ctx.drawImage(img, 0, 0);
        //                 var imgDataUrl = canvas.toDataURL('image/png');
        //                 resolve({
        //                     imgDataUrl: imgDataUrl,
        //                     rowIdx: imgData.rowIdx
        //                 });
        //             };
        //             img.onerror = function() {
        //                 resolve({
        //                     imgDataUrl: null,
        //                     rowIdx: imgData.rowIdx
        //                 });
        //             };
        //         });
        //     });

        //     Promise.all(imgPromises).then(function(imgDataArray) {
        //         imgDataArray.forEach(function(imgData) {
        //             if (imgData.imgDataUrl && rows[imgData.rowIdx]) {
        //                 rows[imgData.rowIdx][imageCellPosition] = {
        //                     image: imgData.imgDataUrl,
        //                     width: 20,
        //                     height: 20
        //                 };
        //             } else {
        //                 console.error(`Row ${imgData.rowIdx} or cell 3 is undefined`);
        //             }
        //         });
        //         pdfMake.createPdf(doc).download('Lawyer_with_image.pdf');
        //     }).catch(function(error) {
        //         console.error('Error processing images: ', error);
        //     });
        // }
    </script>








@endsection
