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

    .btcd-f-input {
        display: inline-block;
        width: 340px;
        position: relative;
        overflow: hidden;
    }

    .btcd-f-input>div>input::-webkit-file-upload-button {
        cursor: pointer;
    }

    .btcd-f-wrp {
        cursor: pointer;
    }

    .btcd-f-wrp>small {
        color: gray;
    }

    .btcd-f-wrp>button {
        cursor: pointer;
        background: #f3f3f3;
        padding: 5px;
        display: inline-block;
        border-radius: 9px;
        border: none;
        margin-right: 8px;
        height: 35px;
    }

    .btcd-f-wrp>button>img {
        width: 24px;
    }

    .btcd-f-wrp>button>span,
    .btcd-f-wrp>span,
    .btcd-f-wrp>small {
        vertical-align: super;
    }

    .btcd-f-input>.btcd-f-wrp>input {
        z-index: 100;
        width: 100%;
        position: absolute;
        opacity: 0;
        left: 0;
        height: 37px;
        cursor: pointer;
    }

    .btcd-f-wrp:hover {
        background: #fafafa;
        border-radius: 10px;
    }

    .btcd-files>div {
        display: flex;
        align-items: center;
        background: #f8f8f8;
        border-radius: 10px;
        margin-left: 30px;
        width: 91%;
        margin-top: 10px;
        height: 40px;
    }

    .btcd-files>div>div {
        display: inline-block;
        width: 73%;
    }

    .btcd-files>div>div>small {
        color: gray;
    }

    .btcd-files>div>img {
        width: 40px;
        height: 40px;
        margin-right: 10px;
        border-radius: 10px;
    }

    .btcd-files>div>div>span {
        display: inline-block;
        width: 100%;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }

    .btcd-files>div>button {
        background: #e8e8e8;
        border: none;
        border-radius: 50px;
        width: 25px;
        height: 25px;
        font-size: 20px;
        margin-right: 6px;
        padding: 0;
    }

    .btcd-files>div>button:hover {
        background: #bbbbbb;
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
                                                            <div for="preferdAttroneySelect" class="form-label">
                                                                Preferd
                                                                Attroney</div>
                                                            <select class="form-select" id="preferdAttroneySelect"
                                                                name="preferd_attroney_id" style="width:100%">
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
                                                                    <input multiple type="file"
                                                                        name="casedocument[]" id="">
                                                                </div>
                                                                <div class="btcd-files">
                                                                </div>
                                                            </div>
                                                        </div>






                                                        <div class="mb-3">
                                                            <label for="details" class="form-label">Requires Details
                                                                details...</label>
                                                            <textarea class="form-control" id="details" rows="3" placeholder="Enter more details"></textarea>
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
            var progressPercentage = ((currentStep - 1) / 1) * 100;
            $(".progress-bar").css("width", progressPercentage + "%");
        }
    });





    const fInputs = document.querySelectorAll('.btcd-f-input>div>input')

    function getFileSize(size) {
        let _size = size
        let unt = ['Bytes', 'KB', 'MB', 'GB'],
            i = 0;
        while (_size > 900) {
            _size /= 1024;
            i++;
        }
        return (Math.round(_size * 100) / 100) + ' ' + unt[i];
    }

    function delItem(el) {
        fileList = {
            files: []
        }
        let fInp = el.parentNode.parentNode.parentNode.querySelector('input[type="file"]')
        for (let i = 0; i < fInp.files.length; i++) {
            fileList.files.push(fInp.files[i])
        }
        fileList.files.splice(el.getAttribute('data-index'), 1)

        fInp.files = createFileList(...fileList.files)
        if (fInp.files.length > 0) {
            el.parentNode.parentNode.parentNode.querySelector('.btcd-f-title').innerHTML =
                `${fInp.files.length} File Selected`
        } else {
            el.parentNode.parentNode.parentNode.querySelector('.btcd-f-title').innerHTML = 'No File Chosen'
        }
        el.parentNode.remove()
    }

    function fade(element) {
        let op = 1; // initial opacity
        let timer = setInterval(function() {
            if (op <= 0.1) {
                clearInterval(timer);
                element.style.display = 'none';
            }
            element.style.opacity = op;
            element.style.filter = 'alpha(opacity=' + op * 100 + ")";
            op -= op * 0.1;
        }, 50);
    }

    function unfade(element) {
        let op = 0.01; // initial opacity
        element.style.opacity = op;
        element.style.display = 'flex';
        let timer = setInterval(function() {
            if (op >= 1) {
                clearInterval(timer);
            }
            element.style.opacity = op;
            element.style.filter = 'alpha(opacity=' + op * 100 + ")";
            op += op * 0.1;
        }, 13);
    }

    function get_browser() {
        let ua = navigator.userAgent,
            tem, M = ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
        if (/trident/i.test(M[1])) {
            tem = /\brv[ :]+(\d+)/g.exec(ua) || [];
            return {
                name: 'IE',
                version: (tem[1] || '')
            };
        }
        if (M[1] === 'Chrome') {
            tem = ua.match(/\bOPR|Edge\/(\d+)/)
            if (tem != null) {
                return {
                    name: 'Opera',
                    version: tem[1]
                };
            }
        }
        M = M[2] ? [M[1], M[2]] : [navigator.appName, navigator.appVersion, '-?'];
        if ((tem = ua.match(/version\/(\d+)/i)) != null) {
            M.splice(1, 1, tem[1]);
        }
        return {
            name: M[0],
            version: M[1]
        };
    }

    for (let inp of fInputs) {

        inp.addEventListener('mousedown', function(e) {
            setPrevData(e)
        })
        inp.addEventListener('change', function(e) {
            handleFile(e)
        })
    }

    let fileList = {
        files: []
    }
    let fName = null
    let mxSiz = null

    function setPrevData(e) {
        if (e.target.hasAttribute('multiple') && fName !== e.target.name) {
            console.log('multiple')
            fName = e.target.name
            fileList = fileList = {
                files: []
            }
            if (e.target.files.length > 0) {
                for (let i = 0; i < e.target.files.length; i += 1) {
                    console.log(e.target.files[i])
                    fileList.files.push(e.target.files[i])
                }
            }
        }
    }

    function handleFile(e) {
        let err = []
        const fLen = e.target.files.length;
        mxSiz = e.target.parentNode.querySelector('.f-max')
        mxSiz = mxSiz != null && (Number(mxSiz.innerHTML.replace(/\D/g, '')) * Math.pow(1024, 2))

        if (e.target.hasAttribute('multiple')) {
            for (let i = 0; i < fLen; i += 1) {
                fileList.files.push(e.target.files[i])
            }
        } else {
            fileList.files.push(e.target.files[0])
        }

        //type validate
        if (e.target.hasAttribute('accept')) {
            let tmpf = []
            let type = new RegExp(e.target.getAttribute('accept').split(",").join("$|") + '$', 'gi')
            for (let i = 0; i < fileList.files.length; i += 1) {
                if (fileList.files[i].name.match(type)) {
                    tmpf.push(fileList.files[i])
                } else {
                    err.push('Wrong File Type Selected')
                }
            }
            fileList.files = tmpf
        }

        // size validate
        if (mxSiz > 0) {
            let tmpf = []
            for (let i = 0; i < fileList.files.length; i += 1) {
                if (fileList.files[i].size < mxSiz) {
                    tmpf.push(fileList.files[i])
                    mxSiz -= fileList.files[i].size
                } else {
                    console.log('rejected', i, fileList.files[i].size)
                    err.push('Max Upload Size Exceeded')
                }
            }
            fileList.files = tmpf
        }

        if (e.target.hasAttribute('multiple')) {
            e.target.files = createFileList(...fileList.files)
        } else {
            e.target.files = createFileList(fileList.files[fileList.files.length - 1])
            fileList = {
                files: []
            }
        }

        // set File list view
        if (e.target.files.length > 0) {
            e.target.parentNode.querySelector('.btcd-f-title').innerHTML = e.target.files.length + ' File Selected'
            e.target.parentNode.parentNode.querySelector('.btcd-files').innerHTML = ''
            for (let i = 0; i < e.target.files.length; i += 1) {
                let img = null
                if (e.target.files[i].type.match(/image-*/)) {
                    img = window.URL.createObjectURL(e.target.files[i])
                } else {
                    img =
                        'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyMi4wLjEsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9IjAgMCAzNTIgNDI5LjEiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDM1MiA0MjkuMTsiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPHN0eWxlIHR5cGU9InRleHQvY3NzIj4NCgkuc3Qwe2ZpbGw6IzAwNEJCNzt9DQo8L3N0eWxlPg0KPHBhdGggZD0iTTQwOC44LDY2Ljh2MzI3LjRjMCwyNy40LDIyLjgsNDkuOCw1MC4zLDQ5LjhoMjM5LjNjMjcuNSwwLDQ5LjgtMjIuMyw0OS44LTQ5LjhWMTE2Yy0wLjEtMi42LTEuMi01LjItMy4xLTdsLTg4LjktODkuMQ0KCWMtMS45LTEuOS00LjQtMi45LTcuMS0yLjloLTE5MEM0MzEuNiwxNyw0MDguOCwzOS40LDQwOC44LDY2Ljh6IE03MTMuOCwxMDUuOUg2ODNjLTYuMywwLTEyLjQtMi41LTE2LjgtNi45DQoJYy00LjUtNC41LTctMTAuNS02LjktMTYuOHYtMzFMNzEzLjgsMTA1Ljl6IE00MjguOCw2Ni44YzAtMTYuNSwxMy45LTI5LjgsMzAuMy0yOS44aDE4MC4ydjQ1LjFjMCwxMS42LDQuNiwyMi43LDEyLjgsMzENCgljOC4yLDguMiwxOS4zLDEyLjgsMzAuOSwxMi44aDQ1LjF2MjY4LjVjMCwxNi41LTEzLjksMjkuOC0zMC4zLDI5LjhINDU5LjFjLTE2LjYsMC0zMC4zLTEzLjQtMzAuMy0yOS44VjY2Ljh6Ii8+DQo8cGF0aCBjbGFzcz0ic3QwIiBkPSJNMjc3LjIsMTY2LjlIMTMwLjZjLTUuMSwwLTkuMiw0LjEtOS4yLDkuMnM0LjEsOS4yLDkuMiw5LjJoMTQ2LjVjNS4xLDAsOS4yLTQuMSw5LjItOS4xDQoJQzI4Ni40LDE3MSwyODIuMywxNjYuOSwyNzcuMiwxNjYuOXoiLz4NCjxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik05My41LDE2Ni45SDY2LjRjLTUuMSwwLTkuMiw0LjEtOS4yLDkuMnM0LjEsOS4yLDkuMiw5LjJoMjcuMWM1LjEsMCw5LjItNC4xLDkuMi05LjJTOTguNiwxNjYuOSw5My41LDE2Ni45eiINCgkvPg0KPHBhdGggY2xhc3M9InN0MCIgZD0iTTI3Ny4yLDI0MC4zSDEzMC42Yy01LjEsMC05LjIsNC4xLTkuMiw5LjJjMCw1LjEsNC4xLDkuMiw5LjIsOS4yaDE0Ni41YzUuMSwwLDkuMi00LjEsOS4yLTkuMQ0KCVMyODIuMywyNDAuNCwyNzcuMiwyNDAuM3oiLz4NCjxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik05My41LDI0MC4zSDY2LjRjLTUuMSwwLTkuMiw0LjEtOS4yLDkuMmMwLDUuMSw0LjEsOS4yLDkuMiw5LjJoMjcuMWM1LjEsMCw5LjItNC4xLDkuMi05LjINCglDMTAyLjcsMjQ0LjQsOTguNiwyNDAuMyw5My41LDI0MC4zeiIvPg0KPHBhdGggY2xhc3M9InN0MCIgZD0iTTI3Ny4yLDMxMy44SDEzMC42Yy01LjEsMC05LjIsNC4xLTkuMiw5LjJjMCw1LjEsNC4xLDkuMiw5LjIsOS4yaDE0Ni41YzUuMSwwLDkuMi00LjEsOS4yLTkuMQ0KCUMyODYuNCwzMTgsMjgyLjMsMzEzLjgsMjc3LjIsMzEzLjh6Ii8+DQo8cGF0aCBjbGFzcz0ic3QwIiBkPSJNOTMuNSwzMTMuOEg2Ni40Yy01LjEsMC05LjIsNC4xLTkuMiw5LjJjMCw1LjEsNC4xLDkuMiw5LjIsOS4yaDI3LjFjNS4xLDAsOS4yLTQuMSw5LjItOS4yDQoJQzEwMi43LDMxNy45LDk4LjYsMzEzLjgsOTMuNSwzMTMuOHoiLz4NCjxnPg0KCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0yNjMsNDEyLjFIODljLTQxLjQsMC03NS0zMy42LTc1LTc1di0yNDVjMC00MS40LDMzLjYtNzUsNzUtNzVoMTQ3LjVjOCwwLDE1LjcsMywyMS42LDguNWw2OSw2My42DQoJCWM2LjksNi4zLDEwLjgsMTUuMywxMC44LDI0Ljd2MjIzLjJDMzM4LDM3OC40LDMwNC40LDQxMi4xLDI2Myw0MTIuMXogTTg5LDM3LjNjLTMwLjIsMC01NC43LDI0LjYtNTQuNyw1NC43djI0NQ0KCQljMCwzMC4yLDI0LjYsNTQuNyw1NC43LDU0LjdoMTc0YzMwLjIsMCw1NC43LTI0LjYsNTQuNy01NC43VjExMy44YzAtMy43LTEuNi03LjMtNC4zLTkuOGwtNjktNjMuNmMtMi4yLTItNS0zLjEtNy45LTMuMUg4OXoiLz4NCjwvZz4NCjwvc3ZnPg0K'
                }
                e.target.parentNode.parentNode.querySelector('.btcd-files').insertAdjacentHTML('beforeend', `<div>
                    <img src="${img}" alt="img"  title="${e.target.files[i].name}">
                    <div>
                        <span title="${e.target.files[i].name}">${e.target.files[i].name}</span>
                        <br/>
                        <small>${getFileSize(e.target.files[i].size)}</small>
                    </div>
                    <button type="button" onclick="delItem(this)" data-index="${i}" title="Remove This File"><span>&times;</span></button>
                </div>`)

            }
        }

        // set eror
        if (err.length > 0) {
            for (let i = 0; i < err.length; i += 1) {
                e.target.parentNode.parentNode.querySelector('.btcd-files').insertAdjacentHTML('afterbegin', `
            <div style="background: #fff2f2;color: darkred;display:none" class="btcd-f-err">
                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjg2LjA1NCIgaGVpZ2h0PSIyODYuMDU0IiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgoKIDxnPgogIDx0aXRsZT5iYWNrZ3JvdW5kPC90aXRsZT4KICA8cmVjdCBmaWxsPSJub25lIiBpZD0iY2FudmFzX2JhY2tncm91bmQiIGhlaWdodD0iNDAyIiB3aWR0aD0iNTgyIiB5PSItMSIgeD0iLTEiLz4KIDwvZz4KIDxnPgogIDx0aXRsZT5MYXllciAxPC90aXRsZT4KICA8ZyBzdHJva2U9Im51bGwiIGlkPSJzdmdfMSI+CiAgIDxwYXRoIHN0cm9rZT0ibnVsbCIgaWQ9InN2Z18yIiBmaWxsPSIjOTEwNjAxIiBkPSJtMTQzLjAyNjk5Nyw1Ni4wMDAwMDVjLTQ4LjA2MDg2NSwwIC04Ny4wMjY5OTcsMzguOTY2MTMxIC04Ny4wMjY5OTcsODcuMDI2OTk3YzAsNDguMDY2MzQyIDM4Ljk2NjEzMSw4Ny4wMjY5OTcgODcuMDI2OTk3LDg3LjAyNjk5N2M0OC4wNjYzNDIsMCA4Ny4wMjY5OTcsLTM4Ljk1NTE3OSA4Ny4wMjY5OTcsLTg3LjAyNjk5N2MwLC00OC4wNjA4NjUgLTM4Ljk2MTI2NCwtODcuMDI2OTk3IC04Ny4wMjY5OTcsLTg3LjAyNjk5N3ptMCwxNTcuNzM2MTY2Yy0zOS4wNTMxNDIsMCAtNzAuNzA5MTY5LC0zMS42NTYwMjcgLTcwLjcwOTE2OSwtNzAuNzA5MTY5czMxLjY1NjAyNywtNzAuNzA5MTY5IDcwLjcwOTE2OSwtNzAuNzA5MTY5czcwLjcwOTE2OSwzMS42NTYwMjcgNzAuNzA5MTY5LDcwLjcwOTE2OXMtMzEuNjU2MDI3LDcwLjcwOTE2OSAtNzAuNzA5MTY5LDcwLjcwOTE2OXptMC4wMDU0NzYsLTExOS41Njk1NThjLTYuMjMzMTIxLDAgLTEwLjk0OTMzNywzLjI1Mjg1NyAtMTAuOTQ5MzM3LDguNTA2OTU2bDAsNDguMTkxMDc3YzAsNS4yNTk1NzYgNC43MTU2MDgsOC41MDE0OCAxMC45NDkzMzcsOC41MDE0OGM2LjA4MTAwNCwwIDEwLjk0OTMzNywtMy4zNzc1OTIgMTAuOTQ5MzM3LC04LjUwMTQ4bDAsLTQ4LjE5MTA3N2MtMC4wMDA2MDgsLTUuMTI5MzY0IC00Ljg2ODMzMywtOC41MDY5NTYgLTEwLjk0OTMzNywtOC41MDY5NTZ6bTAsNzYuMDU2MzY0Yy01Ljk4ODUxOCwwIC0xMC44NjIzMjYsNC44NzM4MDkgLTEwLjg2MjMyNiwxMC44NjcxOTRjMCw1Ljk4MzA0MSA0Ljg3MzgwOSwxMC44NTY4NSAxMC44NjIzMjYsMTAuODU2ODVzMTAuODU2ODUsLTQuODczODA5IDEwLjg1Njg1LC0xMC44NTY4NWMtMC4wMDA2MDgsLTUuOTkzOTk0IC00Ljg2ODMzMywtMTAuODY3MTk0IC0xMC44NTY4NSwtMTAuODY3MTk0eiIvPgogIDwvZz4KICA8ZyBpZD0ic3ZnXzMiLz4KICA8ZyBpZD0ic3ZnXzQiLz4KICA8ZyBpZD0ic3ZnXzUiLz4KICA8ZyBpZD0ic3ZnXzYiLz4KICA8ZyBpZD0ic3ZnXzciLz4KICA8ZyBpZD0ic3ZnXzgiLz4KICA8ZyBpZD0ic3ZnXzkiLz4KICA8ZyBpZD0ic3ZnXzEwIi8+CiAgPGcgaWQ9InN2Z18xMSIvPgogIDxnIGlkPSJzdmdfMTIiLz4KICA8ZyBpZD0ic3ZnXzEzIi8+CiAgPGcgaWQ9InN2Z18xNCIvPgogIDxnIGlkPSJzdmdfMTUiLz4KICA8ZyBpZD0ic3ZnXzE2Ii8+CiAgPGcgaWQ9InN2Z18xNyIvPgogPC9nPgo8L3N2Zz4=" alt="img">
                <span>${err[i]}</span>
            </div>`)
            }
            const errNods = e.target.parentNode.parentNode.querySelectorAll('.btcd-files>.btcd-f-err')
            for (let i = 0; i < errNods.length; i += 1) {
                unfade(errNods[i])
                setTimeout(() => {
                    fade(errNods[i])
                }, 3000);
                setTimeout(() => {
                    errNods[i].remove()
                }, 4000);
            }
            err = []
        }

    }
</script>
