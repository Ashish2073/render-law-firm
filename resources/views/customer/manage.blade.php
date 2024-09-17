<div id="addCustomerId" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="max-width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addcustomeridModalLabel">Add Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" style="overflow-x: auto; overflow-y: auto; max-height: 1000px;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Customer Registration</div>

                            <div class="card-body">
                                <form action="" id="customer_registration" method="POST">
                                    @csrf
                                    <div class="form-row d-flex">
                                        <div class="form-group col-md-12">
                                            <label>Name</label>
                                            <input type="text" class="form-control" id="name" name="name">
                                            <span class="text-danger small" id="name_error"></span>
                                        </div>
                                    </div>
                                    <div class="form-row d-flex">
                                        <div class="form-group col-md-12">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="mail" class="form-control" id="email"
                                                    name="email">
                                                <span class="text-danger small" id="email_error"></span>
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

                                                <span class="text-danger small" id="password_error"></span>
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



                                    @include('components.image', [
                                        'ImageUploadHeading' => 'Customer Profile Image',
                                        'uploadAreaId' => 'uploadCustomerId',
                                        'dropZoomId' => 'dropZoomCustomerId',
                                        'loadingTextId' => 'loadingTextCustomerId',
                                        'previewImageId' => 'previewImageCustomerId',
                                        'fileInputId' => 'fileInputCustomerId',
                                        'fileDetailsId' => 'fileDetailsCustomerId',
                                        'uploadedFileId' => 'uploadedFileCustomerId',
                                        'uploadedFileInfoId' => 'uploadedFileInfoCustomerId',
                                        'fileInputName' => 'customer_image',
                                    ])



                                    <div class="col-12 d-flex justify-content-center ">
                                        <button type="submit" class="btn btn-primary mt-3 "
                                            id="add-customer-button">Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary close-modal"  onclick="closeModal('addCustomerId')" id="closedModal">Close</button>
            </div>
        </div>
    </div>
</div>
