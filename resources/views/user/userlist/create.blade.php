<div id="adduserformid" class="modal fade" tabindex="-1" role="dialog">
    
    <div class="modal-dialog" role="document" style="max-width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rolePermissionModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" style="overflow-x: auto; overflow-y: auto; max-height: 800px;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">User Registartion</div>

                            <div class="card-body">


                                <form action="" method="POST">
                                    @csrf


                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" id="name" name="name">
                                        <span class="text-danger small" id="name_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="mail" class="form-control" id="email" name="email">
                                        <span class="text-danger small" id="email_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <div class="input-group">

                                            <input type="password" class="form-control" id="password" name="password">
                                            <span  onclick="passwordShowHide(this)"  class="input-group-text togglePassword" id=""
                                                style="cursor: pointer;" >
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                        <span class="text-danger small" id="password_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation">
                                            <span onclick="passwordShowHide(this)"  class="input-group-text togglePassword" id=""
                                                style="cursor: pointer;">
                                                <i class="fa fa-eye"></i>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Assign Role(Optional)</label>


                                        <select name="role_ids[]" id="roles" multiple="multiple" style="width:100%">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary" id="add-user-button">Save</button>
                                    </div>

                                    
                                </form>

                            </div>
                        </div>


                    </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">           
                <button type="button" class="btn btn-primary close-modal" id="closedModal" onclick="closeModal('adduserformid')">Close</button>
            </div>
        </div>
    </div>
</div>
