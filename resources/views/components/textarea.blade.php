<div class="col-md-12 p-3">
    <label for="{{ $text_area_id ?? 'answer_text_area_id' }}" class="form-label">{{ $modal_label_name ?? 'Answer' }}</label>
    <div class="form-floating">
        <textarea class="form-control" id="{{ $text_area_id ?? 'answer_text_area_id' }}" name="{{$text_area_name ?? 'answer_text_area'}}" placeholder="Leave a comment here"
            style="height: 100px"></textarea>
    </div>
</div>