<style>
    #container {
        overflow: visible;

    }

    .step-container {
        position: relative;
        text-align: center;
        transform: translateY(-43%);
    }

    .step-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #fff;
        border: 2px solid #007bff;
        line-height: 30px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        cursor: pointer;

        /* Added cursor pointer */
    }

    .step-line {
        position: absolute;
        top: 16px;
        /* Adjust as needed */
        left: calc(50% - 50px);
        /* Center the line */
        width: calc(100% - 100px);
        /* Ensure the width is sufficient */
        height: 2px;
        background-color: #007bff;
        z-index: 4;

    }

    #multi-step-form {
        overflow-x: hidden;
    }
</style>

<div id="add-customer-cases" class="modal fade" tabindex="-1" role="dialog">















    <div class="modal-dialog" role="document" style="max-width:950px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addWelcomeMessageFormModalLabel">Add Customer Cases</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header"></div>

                            <div class="card-body">

                                <div id="container" class="container mt-5">
                                    <div class="progress px-1" style="height: 3px;">
                                        <div class="progress-bar" role="progressbar" style="width: 0%;"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="step-container d-flex justify-content-between">
                                        <div class="step-circle" onclick="displayStep(1)">1</div>
                                        <div class="step-circle" onclick="displayStep(2)">2</div>
                                        <div class="step-circle" onclick="displayStep(3)">3</div>
                                    </div>

                                    <div id="multi-step-form">
                                        <div class="step step-1">
                                            <!-- Step 1 form fields here -->

                                            <h3>Case Users Basic Detail </h3>
                                            <div class="mb-3">
                                                <div class="card-body">
                                                    <h2 class="mb-4">Registration Form</h2>
                                                    <form id="customer-case-user-basic-detail">

                                                        <div class="mb-3">
                                                            <div for="customerSelect" class="form-label">Customer Name
                                                            </div>
                                                            <select class="form-select" id="customerSelect"
                                                                style="width:100%">
                                                                <option value="">Select State</option>


                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="fullName" class="form-label">Full Name</label>
                                                            <input type="text" class="form-control" id="fullName"
                                                                placeholder="Enter your name">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="email" class="form-label">Email
                                                                Address</label>
                                                            <input type="email" class="form-control" id="email"
                                                                placeholder="Enter your email">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="phone" class="form-label">Phone
                                                                Number</label>
                                                            <input type="tel" class="form-control" id="phone"
                                                                placeholder="Enter your phone number">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="address" class="form-label">Current
                                                                Address</label>
                                                            <input type="text" class="form-control" id="address"
                                                                placeholder="Enter your address">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="zipcode" class="form-label">Zipcode</label>
                                                            <input type="text" class="form-control" id="zipcode"
                                                                placeholder="Enter your zipcode"
                                                                oninput="getCountryStateCity(this.value)">
                                                        </div>
                                                        {{-- <div class="mb-3">
                                                            <div for="country" class="form-label">Country</div>
                                                            <select class="form-select" id="countrySelect"
                                                                style="width:100%">
                                                                <option value=""></option>

                                                            </select>

                                                        </div> --}}



                                                        <div class="mb-3">
                                                            <div for="stateSelect" class="form-label">State</div>
                                                            <select class="form-select" id="stateSelect"
                                                                style="width:100%">
                                                                <option value="">Select State</option>


                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <div for="citySelect" class="form-label">City</div>
                                                            <select class="form-select" id="citySelect"
                                                                style="width:100%">
                                                                <option value="">Select City</option>


                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="details" class="form-label">Tell us more in
                                                                details...</label>
                                                            <textarea class="form-control" id="details" rows="3" placeholder="Enter more details"></textarea>
                                                        </div>
                                                    </form>
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <button type="submit" class="btn btn-primary mt-3 "
                                                            id="add-lawyer-button">Save
                                                        </button>
                                                    </div>



                                                </div>

                                            </div>
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="button" class="btn btn-primary next-step">Next</button>
                                            </div>

                                        </div>

                                        <div class="step step-2">
                                            <!-- Step 2 form fields here -->
                                            <h3>Step 2</h3>
                                            <div class="mb-3">
                                                <div class="card-body">
                                                    <h2 class="mb-4">Case Detail</h2>
                                                    <form>
                                                        <div class="mb-3">
                                                            <label for="fullName" class="form-label">Title</label>
                                                            <input type="text" class="form-control" id="fullName"
                                                                placeholder="Enter your name">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="case_type" class="form-label">Case Type
                                                            </label>
                                                            <input type="email" class="form-control" id="case_type"
                                                                placeholder="Enter your email">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="phone" class="form-label">Preferd
                                                                Attroney</label>
                                                            <input type="tel" class="form-control" id="phone"
                                                                placeholder="Enter your phone number">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="address" class="form-label">Case
                                                                Doucument</label>
                                                            <input type="text" class="form-control" id="address"
                                                                placeholder="Enter your address">
                                                        </div>



                                                        <div class="mb-3">
                                                            <label for="details" class="form-label">Requires Details
                                                                details...</label>
                                                            <textarea class="form-control" id="details" rows="3" placeholder="Enter more details"></textarea>
                                                        </div>
                                                    </form>
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <button type="button"
                                                            onclick="saveCustomeCaseUserBasicDeatil()"
                                                            class="btn btn-primary mt-3 " id="add-lawyer-button">Save
                                                        </button>
                                                    </div>



                                                </div>

                                            </div>
                                            <div class="col-12 gap-3 d-flex justify-content-end">
                                                <button type="button"
                                                    class="btn btn-primary prev-step">Previous</button>
                                                <button type="button" class="btn btn-primary next-step">Next</button>
                                            </div>
                                        </div>

                                        <div class="step step-3">
                                            <!-- Step 3 form fields here -->
                                            <h3>Step 3</h3>
                                            <div class="mb-3">
                                                <label for="field3" class="form-label">Field 3:</label>
                                                <input type="text" class="form-control" id="field3"
                                                    name="field3">
                                            </div>
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="button"
                                                    class="btn btn-primary prev-step">Previous</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>

                    </div>
                </div>
                <div class="modal-footer">


                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

</div>
<script>
    var currentStep = 1;
    var updateProgressBar;

    function displayStep(stepNumber) {
        if (stepNumber >= 1 && stepNumber <= 3) {
            $(".step-" + currentStep).hide();
            $(".step-" + stepNumber).show();
            currentStep = stepNumber;
            updateProgressBar();
        }
    }

    $(document).ready(function() {
        $('#multi-step-form').find('.step').slice(1).hide();

        $(".next-step").click(function() {
            if (currentStep < 3) {
                $(".step-" + currentStep).addClass("animate__animated animate__fadeOutLeft");
                currentStep++;
                setTimeout(function() {
                    $(".step").removeClass("animate__animated animate__fadeOutLeft").hide();
                    $(".step-" + currentStep).show().addClass(
                        "animate__animated animate__fadeInRight");
                    updateProgressBar();
                }, 500);
            }
        });

        $(".prev-step").click(function() {
            if (currentStep > 1) {
                $(".step-" + currentStep).addClass("animate__animated animate__fadeOutRight");
                currentStep--;
                setTimeout(function() {
                    $(".step").removeClass("animate__animated animate__fadeOutRight").hide();
                    $(".step-" + currentStep).show().addClass(
                        "animate__animated animate__fadeInLeft");
                    updateProgressBar();
                }, 500);
            }
        });

        updateProgressBar = function() {
            var progressPercentage = ((currentStep - 1) / 2) * 100;
            $(".progress-bar").css("width", progressPercentage + "%");
        }
    });
</script>
