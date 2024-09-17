<div id="{{ $modal_id ?? 'inputId' }}" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="{{ $modal_id ?? 'inputId' }}ModalLabel">
                    {{ $modal_heading ?? 'Enter Lawyer Proficience' }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="imageEditForm" action="post">
                @csrf
                <div class="modal-body">

                    <div class="card-body">
                        <div id="{{ $uploadAreaId ?? 'uploadArea' }}" class="upload-area">

                            <div class="upload-area__header">
                                <h1 class="upload-area__title">Upload Lawyer Image</h1>
                                <p class="upload-area__paragraph">
                                    File should be an image
                                    <strong class="upload-area__tooltip">
                                        Like
                                        <span
                                            class="{{ $uploadareatooltipdata ?? 'upload-area__tooltip-data' }}"></span>

                                    </strong>
                                </p>
                            </div>

                            <div id="{{ $dropZoomId ?? 'dropZoon' }}" class="upload-area__drop-zoon drop-zoon">
                                <span class="drop-zoon__icon">
                                    <i class='bx bxs-file-image'></i>
                                </span>
                                <p class="drop-zoon__paragraph">Drop your file here or Click to browse</p>
                                <span id="{{ $loadingTextId ?? 'loadingText' }}" class="drop-zoon__loading-text">Please
                                    Wait</span>
                                <img src="{{ $imgsrc ?? asset('customer_image/defaultcustomer.jpg') }}"
                                    alt="Preview Image" id="{{ $previewImageId ?? 'previewImage' }}"
                                    class="drop-zoon__preview-image" draggable="false">
                                <input type="file" id="{{ $fileInputId ?? 'fileInput' }}" name="profile_image"
                                    class="drop-zoon__file-input" style="display:none;"  accept="image/*">
                            </div>

                            <div id="{{ $fileDetailsId ?? 'fileDetails' }}"
                                class="upload-area__file-details file-details">
                                <h3 class="file-details__title">Uploaded File</h3>

                                <div id="{{ $uploadedFileId ?? 'uploadedFile' }}" class="uploaded-file">
                                    <div class="uploaded-file__icon-container">
                                        <i class='bx bxs-file-blank uploaded-file__icon'></i>
                                        <span class="{{ $uploadedfileicontext ?? 'uploaded-file__icon-text' }}"></span>

                                    </div>

                                    <div id="{{ $uploadedFileInfoId ?? 'uploadedFileInfo' }}"
                                        class="uploaded-file__info">
                                        <span class="{{ $uploadedfilenameClass ?? 'uploaded-file__name' }}">Proejct
                                            1</span>
                                        <span class="{{ $uploadedfilecounter ?? 'uploaded-file__counter' }}">0%</span>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal('{{ $modal_id ?? 'inputId' }}')">Close</button>
                    <button type="button" class="btn btn-primary"
                        id="{{ $input_save_button ?? 'input_button_save' }}">Save
                        changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
