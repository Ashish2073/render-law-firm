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

                                    </div>

                                    <div id="multi-step-form">
                                        <form id="customer-case-user-basic-detail">
                                            <div class="step step-1">
                                                <!-- Step 1 form fields here -->

                                                <h3>Case Users Basic Detail </h3>
                                                <div class="mb-3">
                                                    <div class="card-body">
                                                        <h2 class="mb-4">Registration Form</h2>


                                                        <div class="mb-3">
                                                            <div for="customerSelect" class="form-label">Customer Name
                                                            </div>
                                                            <select class="form-select" id="customerSelect"
                                                                name="customer_id" style="width:100%">
                                                                <option value=""></option>


                                                            </select>



                                                        </div>
                                                        <span class="text-danger small" id="customer_id_error"></span>
                                                        <div class="mb-3">
                                                            <label for="fullName" class="form-label">Full Name</label>
                                                            <input type="text" class="form-control" id="fullName"
                                                                name="name" placeholder="Enter your name">
                                                            <span class="text-danger small" id="name_error"></span>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="email" class="form-label">Email
                                                                Address</label>
                                                            <input type="email" class="form-control" id="email"
                                                                name="email" placeholder="Enter your email">
                                                            <span class="text-danger small" id="email_error"></span>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="phone" class="form-label">Phone
                                                                Number</label>
                                                            <input type="tel" class="form-control" id="phone"
                                                                name="phone" placeholder="Enter your phone number">
                                                            <span class="text-danger small" id="phone_error"></span>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="address" class="form-label">Current
                                                                Address</label>
                                                            <input type="text" class="form-control" id="address"
                                                                name="address" placeholder="Enter your address">
                                                            <span class="text-danger small" id="address_error"></span>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="zipcode" class="form-label">Zipcode</label>
                                                            <input type="text" class="form-control" id="zipcode"
                                                                name="zipcode" placeholder="Enter your zipcode"
                                                                oninput="getCountryStateCity(this.value)">
                                                            <span class="text-danger small" id="zipcode_error"></span>
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
                                                                name="state_id" style="width:100%">
                                                                <option value="">Select State</option>


                                                            </select>

                                                        </div>
                                                        <span class="text-danger small" id="state_id_error"></span>
                                                        <div class="mb-3">
                                                            <div for="citySelect" class="form-label">City</div>
                                                            <select class="form-select" id="citySelect"
                                                                name="city_id" style="width:100%">
                                                                <option value="">Select City</option>


                                                            </select>

                                                        </div>
                                                        <span class="text-danger small" id="city_id_error"></span>
                                                        <div class="mb-3">
                                                            <label for="details" class="form-label">Tell us more in
                                                                details...</label>
                                                            <textarea class="form-control" id="details" name="details" rows="3" placeholder="Enter more details"></textarea>
                                                        </div>





                                                    </div>

                                                </div>
                                                <div class="col-12 d-flex justify-content-end">
                                                    <button type="button"
                                                        class="btn btn-primary next-step">Next</button>
                                                </div>

                                            </div>

                                            <div class="step step-2">
                                                <!-- Step 2 form fields here -->
                                                <h3>Step 2</h3>
                                                <div class="mb-3">
                                                    <div class="card-body">
                                                        <h2 class="mb-4">Case Detail</h2>

                                                        <div class="mb-3">
                                                            <label for="fullName" class="form-label">Title</label>
                                                            <input type="text" name="title" class="form-control"
                                                                id="title" placeholder="Enter your name">
                                                        </div>
                                                        <div class="mb-3">
                                                            <div for="preferdAttroneySelect" class="form-label">Case
                                                                Type</div>
                                                            <select class="form-select" id="caseTypeSelect"
                                                                name="case_type" style="width:100%">
                                                                <option value=""></option>


                                                            </select>

                                                        </div>

                                                        <div class="mb-3">
                                                            <div for="urgencySelect" class="form-label">Urgency Label
                                                            </div>
                                                            <select class="form-select" id="urgencySelect"
                                                                name="case_urgency_level" style="width:100%">
                                                                <option value="1">Emergency</option>
                                                                <option value="2">Medium</option>
                                                                <option value="3">Common Scenario</option>
                                                                <option value="4">Running</option>


                                                            </select>

                                                        </div>



                                                        <div class="mb-3">
                                                            <div for="preferdAttroneySelect" class="form-label">
                                                                Preferd
                                                                Attroney</div>
                                                            <select class="form-select" id="preferdAttroneySelect"
                                                                name="preferred_attorney_id" style="width:100%">
                                                                <option value="">Select Lawyer</option>


                                                            </select>

                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="address" class="form-label"></label>
                                                            <div class="btcd-f-input">
                                                                <small>Upload Document</small>
                                                                <div class="btcd-f-wrp">
                                                                    <button class="btcd-inpBtn" type="button"> <img
                                                                            src="{{ asset('download.svg') }}"
                                                                            alt=""> <span>
                                                                            Attach File</span></button>
                                                                    <span class="btcd-f-title">No File Chosen</span>
                                                                    <small class="f-max"> (Max 2 MB)</small>
                                                                    <input multiple type="file" name="case_file[]"
                                                                        id="">
                                                                </div>
                                                                <div class="btcd-files">
                                                                </div>
                                                            </div>
                                                        </div>






                                                        <div class="mb-3">
                                                            <label for="details" class="form-label">Requires Details
                                                                details...</label>
                                                            <textarea class="form-control" id="details" name="requirement_details" rows="3"
                                                                placeholder="Enter more details"></textarea>
                                                        </div>
                                        </form>
                                        <div class="col-12 d-flex justify-content-center">
                                            <button type="submit" class="btn btn-primary mt-3 "
                                                onclick="saveCustomerCaseUserBasicDetail(event)">Save
                                        </div>



                                    </div>

                                </div>
                                <div class="col-12 gap-3 d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary prev-step">Previous</button>
                                    <button type="button" class="btn btn-primary next-step">Next</button>
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
