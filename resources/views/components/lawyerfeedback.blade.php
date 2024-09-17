<style>
    .rating-bar {
        height: 8px;
    }

    .review-star {
        color: #FFD700;
    }

    /* Gold color for stars */
    .customer-img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }

    /* Custom width for the modal */
    .modal-lg-custom {
        max-width: 900px;
    }

    /* Styles for the Show More functionality */
    .description {
        display: block;
        max-height: 4.5em;
        /* Limit height to approx 3 lines of text */
        overflow: hidden;
        text-overflow: ellipsis;
        transition: max-height 0.3s ease;
        /* Smooth transition */
    }

    .description.expanded {
        max-height: 100%;
        /* Expand fully when the show more is clicked */
    }

    .show-more {
        color: #007bff;
        cursor: pointer;
        display: block;
        margin-top: 5px;
    }

    /* Loading Indicator */
    #loading-indicator {
        display: none;
    }

    /* Scrollable Feedback Container */
    #feedback-container {
        height: 400px;
        overflow-y: scroll;
        border: 1px solid #ccc;
        padding: 10px;
    }
</style>

<!-- Modal -->
<div id="lawyer_feedback" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg-custom" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Customer Feedback</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container mt-4">

                    <!-- Header -->
                    <div class="d-flex align-items-center mb-3">
                        <button class="btn btn-light me-2"><i class="bi bi-chevron-left"></i></button>
                        <h4></h4>
                    </div>

                    <input type="hidden" value="" id="lawyer_id" />
                    <!-- Rating Overview -->
                    <div class="text-center mb-4">
                        <h1 class="display-4" id="avg_rating">3.9</h1>
                        <p class="text-muted" id="customer_count">Based on 20 reviews</p>
                    </div>

                    <!-- Rating Distribution -->
                    <div>
                        <div class="mb-2">
                            <label>Excellent</label>
                            <div class="bg-light rating-bar rounded d-flex">
                                <div class="bg-success rating-bar rounded" style="width: 70%"></div>
                                <i class='fas fa-users ms-2 me-1' style='color: #000;'></i>
                                <h6 id="excellent_rating"></h6>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label>Good</label>
                            <div class="bg-light rating-bar rounded d-flex">
                                <div class="bg-warning rating-bar rounded" style="width: 50%"></div>
                                <i class='fas fa-users ms-2 me-1' style='color: #000;'></i>
                                <h6 id="good_rating"></h6>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label>Average</label>
                            <div class="bg-light rating-bar rounded d-flex">
                                <div class="bg-primary rating-bar rounded" style="width: 30%"></div>
                                <i class='fas fa-users ms-2 me-1' style='color: #000;'></i>
                                <h6 id="average_rating">(4.3 K)</h6>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Poor</label>
                            <div class="bg-light rating-bar rounded d-flex">
                                <div class="bg-danger rating-bar rounded" style="width: 10%"></div>
                                <i class='fas fa-users ms-2 me-1' style='color: #000;'></i>
                                <h6 id="poor_rating">(4.3 K)</h6>
                            </div>
                        </div>
                    </div>

                    <!-- Reviews Section with Scrollable Feedback Container -->
                    <div class="container mt-4" id="feedback-container">
                        <!-- Feedback list will be appended here -->
                    </div>

                    <!-- Loading Indicator -->
                    <div class="text-center mt-3" id="loading-indicator">
                        <p>Loading...</p>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
