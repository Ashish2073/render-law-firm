<div id="addLawyerProficienceformid" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="max-width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rolePermissionModalLabel">Add New Proficience</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" style="overflow-x: auto; overflow-y: auto; max-height: 800px;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Proficience</div>

                            <div class="card-body">


                                <form action="" method="POST" id="lawyer-proficience-form">
                                    @csrf


                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" id="proficience_name"
                                            name="proficience_name">
                                        <span class="text-danger small" id="proficience_name_error"></span>
                                    </div>




                                    <div class="form-group">
                                        <label>Parent</label>


                                        <select name="parent_id" id="proficience_parent_id" style="width:100%">
                                            <option value=""></option>
                                            <option value="0">Parent</option>
                                            @foreach ($proficience as $data)
                                                <option value="{{ $data->id }}">{{ $data->proficience_name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <span class="text-danger small" id="parent_id_error"></span>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary"
                                            id="add-lawyer-proficience-button">Save</button>
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
                <button type="button" class="btn btn-primary close-modal" id="closedModal"  onclick="closeModal('addLawyerProficienceformid')" >Close</button>
            </div>
        </div>
    </div>
</div>
