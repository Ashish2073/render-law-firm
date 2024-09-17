<div id="addfaqformid" class="modal fade" tabindex="-1" role="dialog">
    @include('components.loader');
    <div class="modal-dialog" role="document" style="max-width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addfaqformidModalLabel">Add Question & Answer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" style="overflow-x: auto; overflow-y: auto; max-height: 1000px;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Question & Answer</div>

                            <div class="card-body">
                                <form action="" id="faq_form" method="POST">
                                    @csrf

                                    <div class="col-md-12">

                                        <input type="hidden" name="id" value="" id="faqid" />


                                        <label for="faqcategory">Please Select Category
                                        </label>
                                        <select id="faqcategory" name="category" class="form-control faqcategory"
                                            style="width:100%">
                                            <option value="">Choose...</option>
                                            @foreach ($faqCategory as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach

                                        </select>
                                        <span class="text-danger small socialmedianame_error"
                                            id="category_error"></span>



                                    </div>



                                    @include('components.textarea', [
                                        'modal_label_name' => 'Question',
                                        'text_area_id' => 'text-area-question-id',
                                        'text_area_name' => 'text_area_question',
                                    ])

                                    @include('components.textarea', [
                                        'modal_label_name' => 'Answer',
                                        'text_area_id' => 'text-area-answer-id',
                                        'text_area_name' => 'text_area_answer',
                                    ])


                                    <div class="col-12 d-flex justify-content-center ">
                                        <button type="submit" class="btn btn-primary mt-3 " id="add-faq-button">Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary close-modal" id="closedModal" onclick="closeModal('addfaqformid')" >Close</button>
            </div>
        </div>
    </div>
</div>