<div id="rolepermissionformId" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document"  style="max-width: 70%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rolePermissionModalLabel">Add Role & Permission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" style="overflow-x: auto; overflow-y: auto; max-height: 800px;">
                <div class="row">
                    <div class="col-md-12">
                      

                        <form id="role-create-form" action="" method="post">

                            <input type="hidden" name="role_id" id="role_id" value="" />

                            
                            <div class="form-group">
                                <label for="name">Role Name</label>

                                <input name="name" id="role_name" class=" form-control " value=""
                                    type="text" placeholder="Enter Role Name">
                            </div>
                            <h4>Access Control</h4>

                            @include('user.roleandpermission.permission')
                            <hr>
                            <div class="form-group">
                                <button type="submit" id="submit-add-role" class="btn btn-primary">Add Role</button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                <button type="button" class="btn btn-primary" id="savestauschanges">Close</button>
            </div>
        </div>
    </div>
</div>


