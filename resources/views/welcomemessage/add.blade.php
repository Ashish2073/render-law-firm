<div id="add-welcome-message-form" class="modal fade" tabindex="-1" role="dialog">


    <div class="modal-dialog" role="document"
        style="max-width:950px;overflow-x: auto; overflow-y: auto; max-height: 1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addWelcomeMessageFormModalLabel">Add Welcome Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Message</div>

                            <div class="card-body">


                                <form action="" method="POST" id="welcome-message-form">
                                    @csrf


                                    <input type="hidden" id="welcome-message-id" value="" name="id" />
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" id="title" name="title">
                                        <span class="text-danger small" id="title_error"></span>
                                    </div>

                                    <div class="form-group">
                                        <label for="description" class="font-weight-bold">Content:</label>
                                        <textarea id="content" name="content" class="form-control border-color"></textarea>
                                        <span class="text-danger small" id="content_error"></span>
                                    </div>





                                    <div class="form-group">
                                        <label>Image</label>


                                        @include('components.image', [
                                            'imgsrc' => asset('defaultimage.png'),
                                            'ImageUploadHeading' => 'Welcome Message Image',
                                            'uploadAreaId' => 'uploadAreaWelcomeMessageId',
                                            'dropZoomId' => 'dropZoomWelcomeMessageId',
                                            'loadingTextId' => 'loadingTextWelcomeMessageId',
                                            'previewImageId' => 'previewImageWelcomeMessageId',
                                            'fileInputId' => 'fileInputWelcomeMessageId',
                                            'fileDetailsId' => 'fileDetailsWelcomeMessageId',
                                            'uploadedFileId' => 'uploadedFileWelcomeMessageId',
                                            'uploadedFileInfoId' => 'uploadedFileInfoWelcomeMessageId',
                                            'fileInputName' => 'welcome_message_image',
                                        ])


                                        <span class="text-danger small" id="welcome_message_image_error"></span>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary"
                                            id="add-welcome-message-button">Save</button>
                                    </div>
                                </form>

                            </div>
                        </div>


                    </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                <button type="button" class="btn btn-primary close-modal"
                    onclick="closeModal('add-welcome-message-form')" id="closedModal">Close</button>
            </div>
        </div>
    </div>
</div>
