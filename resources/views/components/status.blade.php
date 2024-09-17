<div id="{{$modal_id ??'changeStatusId'}}" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Change Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
  
  
                <div class="form-group">
                    <label for="status-select">Select Status</label>
                    <select class="form-control" id="status-select" name="status">
                        <option selected disabled>Please Select</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal('{{ $modal_id ?? 'changeStatusId' }}')">Close</button>
                <button type="button" class="btn btn-primary" id="savestauschanges">Save changes</button>
            </div>
        </div>
    </div>
  </div>
  