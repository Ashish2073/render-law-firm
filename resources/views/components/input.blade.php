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
            <div class="modal-body">

                <div class="card-body">
                    <form id="{{ $input_form_id ?? 'lawyerProficienceForm' }}">
                        @csrf

                        <input type="hidden" name="id" value="" id="{{$hiddenInputFiled ??'lawyer_proficience_id'}}" />
                        <div class="form-group">
                            <label for="{{$inputlabelName ??'name'}}">
                                <h5>{{ $modal_label_name ?? 'Proficience Name' }}</h5>
                            </label>


                            <input type="text" class="form-control" id="{{ $input_id ?? 'name' }}"
                                name="{{ $input_name ?? 'name' }}">
                            <span class="text-danger small" id="{{ $input_name . '_error' ?? 'name_error' }}"></span>

                        </div>
                    </form>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal('{{ $modal_id ?? 'inputId' }}')">Close</button>
                <button type="button" class="btn btn-primary" id="{{ $input_save_button ?? 'input_button_save' }}">Save
                    changes</button>
            </div>
        </div>
    </div>
</div>
