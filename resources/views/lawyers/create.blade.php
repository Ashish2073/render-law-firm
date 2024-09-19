<div id="addlawyerformid" class="modal fade" tabindex="-1" role="dialog">

    <div class="modal-dialog" role="document" style="max-width:1090px;overflow-x: auto;">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rolePermissionModalLabel">Add Lawyer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Lawyer Registration</div>

                            <div class="card-body">
                                <form action="" id="lawyer_registration" method="POST">
                                    @csrf
                                    <div class="form-row d-flex">
                                        <div class="form-group col-md-6">
                                            <label>Name</label>
                                            <input type="text" class="form-control" id="name" name="name">
                                            <span class="text-danger small" id="name_error"></span>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Experience(Years)</label>
                                            <input type="number" class="form-control" id="experience"
                                                name="experience">
                                            <span class="text-danger small" id="experience_error"></span>
                                        </div>
                                    </div>
                                    <div class="form-row d-flex">
                                        <div class="form-group col-md-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="mail" class="form-control" id="email"
                                                    name="email">
                                                <span class="text-danger small" id="email_error"></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="form-group">
                                                <label>Phone No </label>
                                                <input type="tel" class="form-control" value="" id="phone"
                                                    name="phone_no" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}">
                                                <span class="text-danger small" id="phone_no_error"></span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-row d-flex">
                                        <div class="form-group col-md-6">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="password"
                                                        name="password">
                                                    <span class="input-group-text togglePassword" id=""
                                                        onclick="passwordShowHide(this)" style="cursor: pointer;">
                                                        <i class="fa fa-eye"></i>
                                                </div>
                                                <span class="text-danger small" id="password_error"></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control"
                                                        id="password_confirmation" name="password_confirmation">
                                                    <span class="input-group-text togglePassword" id=""
                                                        onclick="passwordShowHide(this)" style="cursor: pointer;">
                                                        <i class="fa fa-eye"></i>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="description" class="font-weight-bold">Description Bio:</label>
                                        <textarea id="description" name="description_bio" class="form-control border-color"></textarea>
                                        <span class="text-danger small" id="description_bio_error"></span>
                                    </div>
                                    <div class="row" id="proficienceoptionelement">
                                        <div class="form-group" id="proficience_main_div">
                                            <label>Choose Proficiencies (Specialization Area)</label>

                                            <select name="proficienc_ids[]"
                                                onchange="selectSubproficiencecategory(this)" id="proficience"
                                                multiple="multiple" class="form-control proficience"
                                                style="width:100%">

                                                @foreach ($proficience as $data)
                                                    <option value="{{ $data->id }}">
                                                        {{ $data->proficience_name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <span class="text-danger small" id="proficienc_ids_error"></span>

                                        </div>
                                    </div>


                                    @include('components.image')


                                    <div class="card">
                                        <div class="card-body" id="socialmediacardbody">
                                            <button type="button" class="btn btn-primary btn-sm top-right-button"
                                                onclick="addMoreSocialMediaField()">+</button>
                                            <div class="form-row d-flex">
                                                <div class="form-group col-md-5">
                                                    <label for="socialMediaType">Please Select Social Media
                                                    </label>
                                                    <select id="socialMediaType" name="socialmedianame[]"
                                                        class="form-control socialMediaType">
                                                        <option value="">Choose...</option>
                                                        <option value="1">Facebook</option>
                                                        <option value="2">Twitter</option>
                                                        <option value="3">Instagram</option>
                                                        <option value="4">LinkedIn</option>
                                                    </select>
                                                    <span class="text-danger small socialmedianame_error"
                                                        id="socialmedianame.0_error"></span>
                                                </div>
                                                <div class="form-group col-md-5">
                                                    <label for="socialMediaUrl">Enter Social Media Link</label>
                                                    <input type="url" name="socialmediaurl[]"
                                                        class="form-control" id="socialMediaUrl"
                                                        placeholder="Enter URL">
                                                    <span class="text-danger small socialmediaurl_error"
                                                        id="socialmediaurl.0_error"></span>
                                                </div>
                                            </div>



                                        </div>
                                    </div>







                                    <div class="col-12 d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary mt-3 "
                                            id="add-lawyer-button">Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary close-modal" id="closedModal"
                    onclick="closeModal('addlawyerformid')">Close</button>
            </div>
        </div>
    </div>
</div>
