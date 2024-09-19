<div class="modal-dialog" role="document" style="max-width:950px;overflow-x: auto; overflow-y: auto;">

    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="rolePermissionModalLabel">Update Lawyer Profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Lawyer Details</div>

                        @foreach ($lawyer as $data)
                            <div class="card-body">
                                <form action="" id="lawyer_registration_edit" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" id="lawyerId" value={{ $data->id }} />
                                    <div class="form-row d-flex">
                                        <div class="form-group col-md-6">
                                            <label>Name</label>
                                            <input type="text" class="form-control" id="name"
                                                value="{{ $data->name }}" name="name">
                                            <span class="text-danger small" id="name_edit_error"></span>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Experience(Years)</label>
                                            <input type="numEditber" class="form-control" id="experience"
                                                value="{{ $data->experience }}" name="experience">
                                            <span class="text-danger small" id="experience_edit_error"></span>
                                        </div>
                                    </div>
                                    <div class="form-row d-flex">
                                        <div class="form-group col-md-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="mail" class="form-control" id="email"
                                                    value="{{ $data->email }}" name="email">
                                                <span class="text-danger small" id="email_edit_error"></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="form-group">
                                                <label>Phone No </label>
                                                <input type="tel" class="form-control" value="{{ $data->phone_no }}"
                                                    id="phone" name="phone_no">
                                                <span class="text-danger small" id="phone_no_edit_error"></span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-row d-flex">
                                        <div class="form-group col-md-6">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="password"
                                                        name="password">
                                                    <span class="input-group-text togglePassword" id=""
                                                        onclick="passwordShowHide(this)" style="cursor: pointer;">
                                                        <i class="fa fa-eye"></i>
                                                </div>
                                                <span class="text-danger small" id="password_edit_error"></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control"
                                                        id="password_confirmation" name="password_confirmation">
                                                    <span class="input-group-text togglePassword" id=""
                                                        onclick="passwordShowHide(this)" style="cursor: pointer;">
                                                        <i class="fa fa-eye"></i>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="description" class="font-weight-bold">Description Bio:</label>
                                        <textarea id="description" name="description_bio" class="form-control border-color">{{ $data->description_bio }}</textarea>
                                        <span class="text-danger small" id="description_bio_edit_error"></span>
                                    </div>


                                    @php
                                        $lawyerSocialMediaId = [];
                                        foreach ($data->socialmedia as $key => $value) {
                                            $lawyerSocialMediaId[] = $value->social_media_id;
                                        }

                                    @endphp


                                    @php $proficienceParentList=[] @endphp

                                    <div class="row" id="proficienceoptionelementedit">
                                        @if (empty($groupedProficiencies))
                                            @php
                                                $proficienceDetails = \App\Models\Proficience::where(
                                                    'parent_id',
                                                    0,
                                                )->get();

                                            @endphp

                                            <div class="form-group" id="proficience_main_div_edit">
                                                <label>Choose Proficiencies (Specialization Area)</label>
                                                <div class="input-group">
                                                    <select name="proficienc_ids[]" id="proficience_edit"
                                                        onchange="selectSubproficiencecategoryEdit(this)"
                                                        multiple="multiple" class="form-control " style="width:80%">


                                                        @foreach ($proficienceDetails as $pro)
                                                            <option value="{{ $pro->id }}">
                                                                {{ $pro->proficience_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    <span class="text-danger small"
                                                        id="proficienc_ids_edit_error"></span>
                                                </div>
                                            </div>
                                        @endif






                                        @foreach ($groupedProficiencies as $key => $value)
                                            @php
                                                $proficienceDetails = \App\Models\Proficience::where(
                                                    'parent_id',
                                                    $key,
                                                )->get();

                                                if ($key != 0) {
                                                    $proficienceParent = \App\Models\Proficience::find($key);
                                                    $proficienceParentList[] = $proficienceParent->proficience_name;
                                                }

                                            @endphp

                                            @if ($key == 0)
                                                <div class="form-group" id="proficience_main_div_edit">
                                                    <label>Choose Proficiencies (Specialization Area)</label>
                                                    <div class="input-group">
                                                        <select name="proficienc_ids[]" id="proficience_edit"
                                                            onchange="selectSubproficiencecategoryEdit(this)"
                                                            multiple="multiple" class="form-control "
                                                            style="width:80%">


                                                            @foreach ($proficienceDetails as $pro)
                                                                <option
                                                                    @if (in_array($pro->id, $value)) selected @endif
                                                                    value="{{ $pro->id }}">
                                                                    {{ $pro->proficience_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        <span class="text-danger small"
                                                            id="proficienc_ids_edit_error"></span>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="form-group"
                                                    id="edit_{{ str_replace(' ', '', $proficienceParent->proficience_name) }}">
                                                    <label>Choose Proficiencies
                                                        {{ $proficienceParent->proficience_name }}
                                                        Category</label>

                                                    <select name="proficienc_ids[]"
                                                        onchange="selectSubproficiencecategoryEdit(this)"
                                                        id="select_edit_{{ str_replace(' ', '', $proficienceParent->proficience_name) }}"
                                                        multiple="multiple" class="form-control " style="width:80%">


                                                        @foreach ($proficienceDetails as $pro)
                                                            <option @if (in_array($pro->id, $value)) selected @endif
                                                                value="{{ $pro->id }}">
                                                                {{ $pro->proficience_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    <span class="text-danger small"
                                                        id="{{ $proficienceParent->proficience_name }}_edit_error"></span>

                                                </div>
                                            @endif
                                        @endforeach
                                    </div>










                                    @include('components.image', [
                                        'imgsrc' => asset('lawyer/images/' . $data->profile_image),
                                        'uploadAreaId' => 'uploadAreaEdit',
                                        'dropZoomId' => 'dropZoomEdit',
                                        'loadingTextId' => 'loadingTextEdit',
                                        'previewImageId' => 'previewImageEdit',
                                        'fileInputId' => 'fileInputEdit',
                                        'fileDetailsId' => 'fileDetailsEdit',
                                        'uploadedFileId' => 'uploadedFileEdit',
                                        'uploadedFileInfoId' => 'uploadedFileInfoEdit',
                                        'dropZoomId' => 'dropZoonEdit',
                                    ])



                                    <div class="card">
                                        <div class="card-body" id="socialmediacardbodyedit">
                                            <button type="button" class="btn btn-primary btn-sm top-right-button"
                                                onclick="addMoreSocialMediaFieldEdit()">+</button>

                                            @php $lawyerSocailMediaDeatils = json_decode($data->socialmedia, true); @endphp


                                            @forelse  ($lawyerSocailMediaDeatils as $key => $value)
                                                <div class="form-row d-flex"
                                                    id="socialmediappendelementedit{{ $key }}">

                                                    <div class="form-group col-md-5">
                                                        <label for="socialMediaTypeEdit">Please Select Social Media
                                                        </label>
                                                        <select id="socialMediaTypeEdit" name="socialmedianame[]"
                                                            class="form-control socialMediaTypeEdit">
                                                            <option value="">Choose...</option>

                                                            <option @if ($value['social_media_id'] == '1') selected @endif
                                                                value="1">
                                                                Facebook</option>
                                                            <option @if ($value['social_media_id'] == '2') selected @endif
                                                                value="2">
                                                                Twitter</option>
                                                            <option @if ($value['social_media_id'] == '3') selected @endif
                                                                value="3">
                                                                Instagram</option>
                                                            <option @if ($value['social_media_id'] == '4') selected @endif
                                                                value="4">
                                                                LinkedIn</option>
                                                        </select>
                                                        <span class="text-danger small socialmedianame_edit_error"
                                                            id="socialmedianame.{{ $key }}_edit_error"></span>
                                                    </div>




                                                    <div class="form-group col-md-5">
                                                        <label for="socialMediaUrl">Enter Social Media Link</label>
                                                        <input type="url" value={{ $value['social_media_url'] }}
                                                            name="socialmediaurl[]" class="form-control"
                                                            id="socialMediaUrl" placeholder="Enter URL">
                                                        <span class="text-danger small socialmediaurl_edit_error"
                                                            id="socialmediaurl.{{ $key }}_edit_error"></span>
                                                    </div>

                                                    @if ($key > 0)
                                                        <div class="form-group col-md-2">
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="removeElement('socialmediappendelementedit{{ $key }}')">-</button>
                                                        </div>
                                                    @endif


                                                </div>
                                            @empty
                                                <div class="form-row d-flex" id="socialmediappendelementedit0">

                                                    <div class="form-group col-md-5">
                                                        <label for="socialMediaTypeEdit">Please Select Social Media
                                                        </label>
                                                        <select id="socialMediaTypeEdit" name="socialmedianame[]"
                                                            class="form-control socialMediaTypeEdit">
                                                            <option value="">Choose...</option>

                                                            <option value="1">Facebook</option>
                                                            <option value="2">Twitter</option>
                                                            <option value="3">Instagram</option>
                                                            <option value="4">LinkedIn</option>
                                                        </select>
                                                        <span class="text-danger small socialmedianame_edit_error"
                                                            id="socialmedianame.0_edit_error"></span>
                                                    </div>




                                                    <div class="form-group col-md-5">
                                                        <label for="socialMediaUrl">Enter Social Media Link</label>
                                                        <input type="url" value="" name="socialmediaurl[]"
                                                            class="form-control" id="socialMediaUrl"
                                                            placeholder="Enter URL">
                                                        <span class="text-danger small socialmediaurl_edit_error"
                                                            id="socialmediaurl.0_edit_error"></span>
                                                    </div>
                                            @endforelse


                                            @php $socialMediaLastIndex= $key??0; @endphp


                                        </div>
                                    </div>





                            </div>
                            <div class="col-12 d-flex justify-content-center pb-3">
                                <button type="submit" class="btn btn-primary" id="update-lawyer-button">Update
                                </button>
                            </div>
                            </form>
                    </div>
                    @endforeach

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary close-modal" id="closedModal"
                            onclick="closeModal('editlawyerformid')">Close</button>

                    </div>



                </div>
            </div>
        </div>
    </div>

</div>
<script>
    $("#proficience_edit").select2({
        dropdownParent: $("#editlawyerformid")
    });

    var proficienceParentList = @json($proficienceParentList);

    proficienceParentList.forEach(item => {

        $(`#select_edit_${item.replace(/ /g, '')}`).select2({
            dropdownParent: $("#editlawyerformid")
        });


    });




    function selectSubproficiencecategoryEdit(selectElement) {
        var selectedValues = Array.from(selectElement.selectedOptions).filter(option => option.selected).map(option =>
            option.value);
        var selectedTexts = Array.from(selectElement.selectedOptions).filter(option => option.selected).map(option =>
            option.text);

        $.ajax({
            url: "{{ route('admin.lawyer.proficiencelistbyparent') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: $("#lawyerId").val(),
                selectedValues: selectedValues,
                selectedTexts: selectedTexts,
            },
            beforeSend: function() {
                selectedTexts.forEach(selectedText => {
                    let selectedRemoveElement = sanitizeForId(selectedText);
                    if (selectedRemoveElement) {
                        $(`#edit_${selectedRemoveElement}`).remove();
                    }
                });
            },
            success: (data) => {
                $("#proficienceoptionelementedit").append(data.responsehtml);
                console.log(data.responsehtml);
                ids = data.id;
                idLength = ids.length;

                for (let i = 0; i < idLength; i++) {


                    $(`#${ids[i]}`).select2({
                        placeholder: "Select a proficiency",
                        allowClear: true,
                        dropdownParent: $("#editlawyerformid"),
                    });
                }
            },
            error: (error) => {
                console.error("An error occurred:", error);
            },
        });

        function removeElementsRecursivelyEdit(parentElementId) {
            let selectedChildText = [];
            $(`#edit_${parentElementId} select option`).each(function() {
                selectedChildText.push($(this).text());
            });

            selectedChildText.forEach(selectedText => {
                let selectedChildRemoveElement = sanitizeForId(selectedText);
                if ($(`#edit_${selectedChildRemoveElement}`).length) {
                    removeElementsRecursivelyEdit(selectedChildRemoveElement);
                    $(`#edit_${selectedChildRemoveElement}`).remove();
                }
            });
        }

        $(selectElement).on('select2:unselect', function(e) {
            var deselectedText = e.params.data.text.trim();
            let deselectedRemoveElement = sanitizeForId(deselectedText);

            if ($(`#edit_${deselectedRemoveElement}`).length) {
                removeElementsRecursivelyEdit(deselectedRemoveElement);
                $(`#edit_${deselectedRemoveElement}`).remove();
            }
        });
    }


    function sanitizeForId(text) {

        return text.replace(/[^a-zA-Z0-9_\-]/g, '');
    }









    var numEdit = "{{ $socialMediaLastIndex ?? 0 }}";


    $(document).on('change', '.socialMediaTypeEdit', function() {
        updateSocialMediaOptionsEdit();
    });



    function addMoreSocialMediaFieldEdit() {

        console.log(numEdit);



        numEdit++;


        let options = '';
        const selectedValues = $('.socialMediaTypeEdit').map(function() {
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




        let htmlField = `<div class="form-row d-flex" id="socialmediappendelementedit${numEdit}"> 
                                              <div class="form-group col-md-5" >
                                            <label for="socialMediaTypeEdit${numEdit}">Please Select Social Media
                                                </label>
                                            <select id="socialMediaTypeEdit${numEdit}" name="socialmedianame[]" class="form-control socialMediaTypeEdit">
                                             <option value="">Choose...</option>
                                                ${options}
                                            </select>
                                               <span class="text-danger small socialmedianame_edit_error" id="socialmedianame.${numEdit}_error" ></span>
                                        
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label for="socialMediaUrl">Enter Social Media Link</label>
                                            <input type="url" name="socialmediaurl[]" class="form-control" id="socialMediaUrl"
                                                placeholder="Enter URL">
                                              <span class="text-danger small socialmediaurl_edit_error" id="socialmediaurl.${numEdit}_error" ></span>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <button type="button" class="btn btn-danger btn-sm" onclick="removeElement('socialmediappendelementedit${numEdit}')">-</button>
                                        </div>
                                    </div>`;

        $("#socialmediacardbodyedit").append(htmlField);


        // $(document).on('change', '.socialMediaTypeEdit', function() {
        //     updateSocialMediaOptionsEdit();
        // });






    }



    function updateSocialMediaOptionsEdit() {
        const selectedValues = $('.socialMediaTypeEdit').map(function() {
            return $(this).val();
        }).get();

        console.log(selectedValues);

        const allOptions = {
            1: 'Facebook',
            2: 'Twitter',
            3: 'Instagram',
            4: 'LinkedIn'
        };

        $('.socialMediaTypeEdit').each(function() {
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



    $("#update-lawyer-button").on('click', function(e) {

        e.preventDefault();

        let formData = new FormData($("#lawyer_registration_edit")[0]);

        $.ajax({
            url: "{{ route('admin.lawyer.update') }}",
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
                $("#name_edit_error").html(" ");

                $("#email_edit_error").html(" ");

                $("#password_edit_error").html(" ");

                $('.socialmedianame_edit_error').map(function(index) {
                    $(this).html("");
                    $(this).attr('id', `socialmedianame.${index}_edit_error`);

                });

                $('.socialmediaurl_edit_error').map(function(index) {
                    $(this).html("");
                    $(this).attr('id', `socialmediaurl.${index}_edit_error`);

                });

            },
            success: (data) => {

                $("#spinner-div").hide();


                let lawyerId = data.lawyerDetail[0].id;
                let lawyerProficiencies = data.lawyerDetail[0].proficiencies;

                $(`#name${lawyerId}`).html(data.lawyerDetail[0].name);
                $(`#email${lawyerId}`).html(data.lawyerDetail[0].email);

                $(`#lawyerimage${lawyerId}`).attr('src',
                    `{{ asset('lawyer/images/${data.lawyerDetail[0].profile_image}') }}`);


                let lawywerProficienceHtml = `<ul>`;
                for (let lawyerProficiency of lawyerProficiencies) {
                    lawywerProficienceHtml = lawywerProficienceHtml +
                        `<li>${lawyerProficiency.proficience_name} </li>`
                }
                lawywerProficienceHtml = lawywerProficienceHtml + `</ul>`;
                $(`#proficience_area_name${lawyerId}`).html(lawywerProficienceHtml);
                $("#editlawyerformid").modal('hide');
                toastr.success(" Lawyer details Updated Successfully");


            },
            error: function(xhr) {
                $("#spinner-div").hide();
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
                if (xhr.status === 403) {
                    $("#editlawyerformid").modal('hide');
                    let errorMessage = xhr.responseJSON.errorpermissionmessage ||
                        'You do not have permission to perform this action.';

                    toastr.error(errorMessage);

                }
            }
        });
    });



    ProfileImageEdit();

    function ProfileImageEdit() {
        const uploadAreaEdit = document.querySelector('#uploadAreaEdit')


        const dropZoonEdit = document.querySelector('#dropZoonEdit');


        const loadingTextEdit = document.querySelector('#loadingTextEdit');


        const fileInputEdit = document.querySelector('#fileInputEdit');


        const previewImageEdit = document.querySelector('#previewImageEdit');


        const fileDetailsEdit = document.querySelector('#fileDetailsEdit');


        const uploadedFileEdit = document.querySelector('#uploadedFileEdit');


        const uploadedFileInfoEdit = document.querySelector('#uploadedFileInfoEdit');


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


        dropZoonEdit.addEventListener('dragover', function(event) {

            event.preventDefault();


            dropZoonEdit.classList.add('drop-zoon--over');
        });


        dropZoonEdit.addEventListener('dragleave', function(event) {

            dropZoonEdit.classList.remove('drop-zoon--over');
        });


        dropZoonEdit.addEventListener('drop', function(event) {

            event.preventDefault();


            dropZoonEdit.classList.remove('drop-zoon--over');


            const file = event.dataTransfer.files[0];


            uploadFileEdit(file);
        });


        dropZoonEdit.addEventListener('click', function(event) {

            fileInputEdit.click();
        });


        fileInputEdit.addEventListener('change', function(event) {

            const file = event.target.files[0];


            uploadFileEdit(file);
        });


        function uploadFileEdit(file) {

            const fileReader = new FileReader();

            const fileType = file.type;

            const fileSize = file.size;


            if (fileValidate(fileType, fileSize)) {

                dropZoonEdit.classList.add('drop-zoon--Uploaded');


                loadingTextEdit.style.display = "block";

                previewImageEdit.style.display = 'none';


                uploadedFileEdit.classList.remove('uploaded-file--open');

                uploadedFileInfoEdit.classList.remove('uploaded-file__info--active');


                fileReader.addEventListener('load', function() {

                    setTimeout(function() {

                        uploadAreaEdit.classList.add('upload-area--open');


                        loadingTextEdit.style.display = "none";

                        previewImageEdit.style.display = 'block';


                        fileDetailsEdit.classList.add('file-details--open');

                        uploadedFileEdit.classList.add('uploaded-file--open');

                        uploadedFileInfoEdit.classList.add('uploaded-file__info--active');
                    }, 500);


                    previewImageEdit.setAttribute('src', fileReader.result);

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
</script>
