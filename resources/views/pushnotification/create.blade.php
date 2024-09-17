<div id="addpushnotificationformid" class="modal fade" tabindex="-1" role="dialog">
   
    <div class="modal-dialog" role="document" style="max-width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addpushnotificationformModalLabel">Push Notification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" style="overflow-x: auto; overflow-y: auto; max-height: 1000px;">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Push Notification</h4>
                            </div>
                            <div class="card-body">
                               
                                  
                                        <h2 class="h4 font-weight-bold mb-4">Notification</h2>
                                        <form action="" method="POST" class="space-y-4">
                                            @csrf
                                            <div class="form-group">
                                                <label for="title" class="font-weight-bold">Title:</label>
                                                <input type="text" id="title" name="title"
                                                    class="form-control border-color">
                                                <span class="text-danger small" id="title_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="description" class="font-weight-bold">Description:</label>
                                                <textarea id="description" name="description" class="form-control border-color"></textarea>
                                                <span class="text-danger small" id="description_error"></span>
                                            </div>

                                            <div class="form-group">
                                                <label>Image</label>


                                                @include('components.image', [
                                                    'imgsrc' => asset('defaultimage.png'),
                                                    'ImageUploadHeading' => 'Notification Image',
                                                    'uploadAreaId' => 'uploadAreaPushNotificationId',
                                                    'dropZoomId' => 'dropZoomPushNotificationId',
                                                    'loadingTextId' => 'loadingTextPushNotificationId',
                                                    'previewImageId' => 'previewImagePushNotificationId',
                                                    'fileInputId' => 'fileInputPushNotificationId',
                                                    'fileDetailsId' => 'fileDetailsPushNotificationId',
                                                    'uploadedFileId' => 'uploadedFilePushNotificationId',
                                                    'uploadedFileInfoId' => 'uploadedFileInfoPushNotificationId',
                                                    'fileInputName' => 'notification_image',
                                                ])


                                                <span class="text-danger small" id="notification_image_error"></span>
                                            </div>



                                            <span class="text-danger small" id="description_error"></span>
                                            <div class="d-flex justify-content-center">
                                                <button type="submit" id="sendnotification"
                                                    class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                  
                                


                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary close-modal" id="closedModal"  onclick="closeModal('addpushnotificationformid')">Close</button>
            </div>
        </div>
    </div>
</div>