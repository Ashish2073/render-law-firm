<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* progress bar  */
        .multi-step-bar {
            overflow: hidden;
            counter-reset: step;
            width: 315px;
        }

        .status-step {
            text-align: center;
            list-style-type: none;
            color: #363636;
            text-transform: CAPITALIZE;
            width: 16.65%;
            float: left;
            position: relative;
            font-weight: 600;
        }

        .status-step:before {
            content: counter(step);
            counter-increment: step;
            width: 30px;
            line-height: 30px;
            display: block;
            font-size: 12px;
            background: #e6e6e6;
            border-radius: 50%;
            margin: 0 auto 5px auto;
            -webkit-box-shadow: 0 6px 20px 0 rgba(69, 90, 100, 0.15);
            -moz-box-shadow: 0 6px 20px 0 rgba(69, 90, 100, 0.15);
            box-shadow: 0 6px 20px 0 rgba(69, 90, 100, 0.15);
        }

        .status-step:after {
            content: '';
            width: 25px;
            height: 3px;
            background: #007bff;
            position: absolute;
            left: -26%;
            top: 15px;
            z-index: 0;
        }

        .status-step:first-child:after {
            content: none;
        }

        .status-step.active:before {
            background: green;
            color: white;
        }

        /* Custom Tooltip Style */
        .orange-btn {
            background: #F77D24;
            display: inline-block;
            color: #fff;
            text-decoration: none;
            text-transform: uppercase;
            font-family: Sans-serif;
            font-size: 10px;
            padding-left: 15px;
            transition: box-shadow 0.3s ease;
        }

        .orange-btn:hover {
            color: #fff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .status-case-multi-steps {
            display: flex;
            counter-reset: stepNum;
            justify-content: space-between;
            width: 100%;
            margin: 0 auto;
            font-size: 12px;
            position: relative;
        }

        .status-case-multi-steps>li {
            position: relative;
            list-style-type: none;
            text-align: center;
            width: 4.5%;
            z-index: 1;
        }

        .status-case-multi-steps>li:before {
            content: counter(stepNum);
            counter-increment: stepNum;
            display: block;
            margin: 0 auto 4px;
            width: 24px;
            height: 24px;
            line-height: 24px;
            text-align: center;
            font-weight: bold;
            border-width: 2px;
            border-style: solid;
            border-radius: 50%;
        }

        .status-case-multi-steps>li.is-complete:before {
            background-color: green;
            color: white;
            content: "✓";
        }

        .status-case-multi-steps>li.is-rejected:before {
            background-color: red;
            color: white;
            content: "✕";
        }

        .status-case-multi-steps>li.is-pending:before {
            background-color: yellow;
            color: black;
            content: "!";
        }

        .status-case-progress-progress-container {
            position: absolute;
            top: 11px;
            width: 93%;
            height: 6px;
            background-color: white;
            z-index: 0;
        }

        .status-case-progress-bar {
            background-color: #007bff;
            height: 5px;
            width: 0%;
            transition: width 0.5s ease;
        }
    </style>
</head>

<body>
    <div class="container-fluid" id="first_step" style="width:560px">
        <ul class="status-case-multi-steps">
            <li id="step-1"> Raised</br></li>
            <li id="step-2">Accepted</br>(RLF)</li>
            <li id="step-3">Lawyer</br>Assigned</li>
            <li id="step-4">Accepted</br>Lawyer</li>
            <li id="step-5">lawyer</br>&</br>Plaintiff</br>(Chat)</li>
            <li id="step-6">Case</br> Filed</br>(court)</li>
            <li id="step-7">Hearing</li>
            <li id="step-8">Case</br>Closed</li>
            <div class="status-case-progress-progress-container">
                <div class="status-case-progress-bar" id="status-case-progress-bar"></div>
            </div>
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const totalSteps = 8;

        // Updated function to handle all statuses up to the current step
        function next(containerId, stepNumber, statusArray) {
            const container = document.getElementById(containerId);
            const steps = container.querySelectorAll('.status-case-multi-steps > li');
            const progressBar = container.querySelector('.status-case-progress-bar');

            // Validate the status array length matches stepNumber
            if (statusArray.length !== stepNumber) {
                console.error('Status array length must match the current step number.');
                return;
            }

            // Loop through the steps and apply status
            for (let i = 0; i < stepNumber; i++) {
                steps[i].classList.remove("is-complete", "is-rejected", "is-pending");

                if (statusArray[i] === 1) {
                    steps[i].classList.add("is-complete");
                } else if (statusArray[i] === 2) {
                    steps[i].classList.add("is-rejected");
                } else if (statusArray[i] === 3) {
                    steps[i].classList.add("is-pending");
                }
            }

            // Update the progress bar width
            let progressPercentage = ((stepNumber - 1) / (totalSteps - 1)) * 100;
            progressBar.style.width = progressPercentage + "%";
        }

        // Test the next function with a step and array of step statuses
        setTimeout(() => {
            next('first_step', 4, [1, 2, 2,
            2]); // step 4, previous statuses [accepted, rejected, rejected, rejected]
        }, 1000);
    </script>
</body>

</html>
