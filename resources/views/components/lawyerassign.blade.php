<div id="lawyerCard" class="card mt-3" style="padding: 10px;">
    <div class="card-body">
        <div class="row align-items-center">
            <!-- Lawyer Selection on the left -->
            <div class="col-md-6 mb-3 mb-md-0">
                <label for="lawyerSelect" class="form-label"><strong>Lawyer</strong></label>
                <select id="lawyerSelect" class="form-select">
                    <option value="" selected disabled>Select a Lawyer</option>

                </select>
            </div>
            <!-- Buttons on the right -->
            <div class="col-md-6 mt-2 text-md-end">
                <button id="assignButton" class="btn btn-primary me-2"
                    onclick="lawyerAssignToPlaintiff()">Assign</button>
                <button id="dissociateButton" class="btn btn-danger"
                    onclick="lawyerDissociateToPlaintiff()">Dissociate</button>
            </div>
        </div>
    </div>
</div>
