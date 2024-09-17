<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>

<body>
    <div class="container mt-4">

        <!-- Header -->
        <div class="d-flex align-items-center mb-3">
            <button class="btn btn-light me-2"><i class="bi bi-chevron-left"></i></button>
            <h4>Customer Feedback</h4>
        </div>

        <!-- Rating Overview -->
        <div class="text-center mb-4">
            <h1 class="display-4">3.9</h1>
            <p class="text-muted">Based on 20 reviews</p>
        </div>

        <!-- Rating Distribution -->
        <div>
            <div class="mb-2">
                <label>Excellent</label>
                <div class="bg-light rating-bar rounded">
                    <div class="bg-success rating-bar rounded" style="width: 70%"></div>
                </div>
            </div>
            <div class="mb-2">
                <label>Good</label>
                <div class="bg-light rating-bar rounded">
                    <div class="bg-warning rating-bar rounded" style="width: 50%"></div>
                </div>
            </div>
            <div class="mb-2">
                <label>Average</label>
                <div class="bg-light rating-bar rounded">
                    <div class="bg-primary rating-bar rounded" style="width: 30%"></div>
                </div>
            </div>
            <div class="mb-3">
                <label>Poor</label>
                <div class="bg-light rating-bar rounded">
                    <div class="bg-danger rating-bar rounded" style="width: 10%"></div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="d-flex align-items-start mb-3">
            <img src="path_to_customer_image.jpg" alt="Customer Photo" class="customer-img me-3">
            <div>
                <h6>Martin Luather <small class="text-muted">2 days ago</small></h6>
                <p>
                    <span class="bi bi-star-fill review-star"></span>
                    <span class="bi bi-star-fill review-star"></span>
                    <span class="bi bi-star-fill review-star"></span>
                    <span class="bi bi-star-fill review-star"></span>
                    <span class="bi bi-star-half review-star"></span> 4.5
                </p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
        </div>
        <div class="d-flex align-items-start mb-3">
            <img src="path_to_another_customer_image.jpg" alt="Customer Photo" class="customer-img me-3">
            <div>
                <h6>Johan Smith Joe <small class="text-muted">3 days ago</small></h6>
                <p>
                    <span class="bi bi-star-fill review-star"></span>
                    <span class="bi bi-star-fill review-star"></span>
                    <span class="bi bi-star-fill review-star"></span>
                    <span class="bi bi-star-fill review-star"></span>
                    <span class="bi bi-star review-star"></span> 4.0
                </p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
        </div>

        <!-- Action Button -->
        <div class="mt-4">
            <button class="btn btn-primary w-100">Write a review</button>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"></script>
</body>

</html>
