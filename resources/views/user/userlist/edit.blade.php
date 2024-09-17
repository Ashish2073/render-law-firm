<div class="modal-dialog" role="document" style="max-width: 50%;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="rolePermissionModalLabel">Update User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        @php $allUserRole=json_decode($user->getRoleNames(),true); @endphp


        <div class="modal-body" style="overflow-x: auto; overflow-y: auto; max-height: 800px;">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">User Registartion</div>

                        <div class="card-body">


                            <input type="hidden" class="form-control" value="{{ $user->id }}" id="user_id"
                                name="user_id">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" value="{{ $user->name }}" id="name_edit"
                                    name="name">
                                <span class="text-danger small" id="name_edit_error"></span>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="mail" class="form-control" value="{{ $user->email }}" id="email_edit"
                                    name="email">
                                <span class="text-danger small" id="email_edit_error"></span>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password_edit" name="password">
                                    <span class="input-group-text togglePassword" id=""
                                        onclick="passwordShowHide(this)" style="cursor: pointer;">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </div>
                                <span class="text-danger small" id="password_edit_error"></span>
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password_confirmation_edit"
                                        name="password_confirmation">
                                    <span class="input-group-text togglePassword" id=""
                                        onclick="passwordShowHide(this)" style="cursor: pointer;">
                                        <i class="fa fa-eye"></i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Assign Role(Optional)</label>


                                <select name="role_ids[]" id="roles_edit" multiple="multiple" style="width:100%">


                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            @if (in_array($role->name, $allUserRole)) selected @endif>{{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary" id="update-user-button">Update</button>
                            </div>




                        </div>
                    </div>


                </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
            <button type="button" class="btn btn-primary close-modal" id="closedModal" onclick="closeModal('edituserformid')">Close</button>
        </div>
    </div>
</div>
