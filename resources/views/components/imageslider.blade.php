<style>
    * {
        box-sizing: border-box;
    }

    img {
        vertical-align: middle;
    }

    /* Position the image container (needed to position the left and right arrows) */
    .container {
        position: relative;
        overflow: hidden;
        /* Hide overflow to create sliding effect */
        white-space: nowrap;
        /* Align images horizontally */
    }

    .modal-content {
        width: 100%;
        overflow-x: auto;
        /* Enable horizontal scrolling */
    }

    /* Hide the images by default and align them horizontally */
    .mySlides {
        display: inline-block;
        /* Align images horizontally */
        width: 100%;
    }

    /* Add a pointer when hovering over the thumbnail images */
    .cursor {
        cursor: pointer;
    }

    /* Next & previous buttons */
    .prev,
    .next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        width: auto;
        padding: 16px;
        margin-top: -50px;
        color: white;
        font-weight: bold;
        font-size: 20px;
        border-radius: 0 3px 3px 0;
        user-select: none;
        -webkit-user-select: none;
    }

    /* Position the "next button" to the right */
    .next {
        right: 0;
        border-radius: 3px 0 0 3px;
    }

    /* On hover, add a black background color with a little bit see-through */
    .prev:hover,
    .next:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }

    /* Number text (1/3 etc) */
    .numbertext {
        color: #f2f2f2;
        font-size: 12px;
        padding: 8px 12px;
        position: absolute;
        top: 0;
    }

    /* Container for image text */
    .caption-container {
        text-align: center;
        background-color: #222;
        padding: 2px 16px;
        color: white;
    }

    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    /* Six columns side by side */
    .column {
        float: left;
        width: 16.66%;
    }

    /* Add a transparency effect for thumbnail images */
    .demo {
        opacity: 0.6;
    }

    .active,
    .demo:hover {
        opacity: 1;
    }

    /* Modal content width */
    /* .modal-content {
        width: 130% !important;
    } */
</style>

<div id="{{ $modal_id ?? 'imageSlider' }}" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="{{ $modal_body ?? 'modal-body-content' }}">




            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    onclick="closeModal('{{ $modal_id ?? 'imageSlider' }}')">Close</button>

            </div>
        </div>
    </div>
</div>
