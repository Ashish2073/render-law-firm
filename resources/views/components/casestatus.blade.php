@php $step=json_decode(json_encode($step_status, true), true); @endphp




<div class="container-fluid" id="first_step{{ $case_id }}" style="width:580px;margin-right: 39px;">
    <ul class="status-case-multi-steps">
        <li id="step-1-{{ $case_id }}" class="{{ getStepClass($step[1]) }}">
            Raised<br /><br />
            {{ getStepStatusText($step[1]) }}<br />
            {{ $rased_case_date }}<br />({{ $rased_case_time }})
        </li>
        <li id="step-2-{{ $case_id }}" class="{{ getStepClass($step[2]) }}">
            Acceptance<br />(RLF)<br />
            {{ getStepStatusText($step[2]) }}<br />
            {{ $rased_case_date }}<br />({{ $rased_case_time }})
        </li>
        <li id="step-3-{{ $case_id }}" class="{{ getStepClass($step[3]) }}">
            Lawyer<br />Assigned<br />
            {{ getStepStatusText($step[3]) }}<br />
            {{ $rased_case_date }}<br />({{ $rased_case_time }})
        </li>
        <li id="step-4-{{ $case_id }}" class="{{ getStepClass($step[4]) }}">
            Acceptance<br />Lawyer<br />
            {{ getStepStatusText($step[4]) }}<br />
            {{ $rased_case_date }}<br />({{ $rased_case_time }})
        </li>
        <li id="step-5-{{ $case_id }}" class="{{ getStepClass($step[5]) }}">
            L&P<br />(Chat)<br />
            {{ getStepStatusText($step[5]) }}<br />
            {{ $rased_case_date }}<br />({{ $rased_case_time }})
        </li>
        <li id="step-6-{{ $case_id }}" class="{{ getStepClass($step[6]) }}">
            Case<br />Filed<br />(court)<br />
            {{ getStepStatusText($step[6]) }}<br />
            {{ $rased_case_date }}<br />({{ $rased_case_time }})
        </li>
        <li id="step-7-{{ $case_id }}" class="{{ getStepClass($step[7]) }}">
            Hearing<br /><br />
            {{ getStepStatusText($step[7]) }}<br />
            {{ $rased_case_date }}<br />({{ $rased_case_time }})
        </li>
        <li id="step-8-{{ $case_id }}" class="{{ getStepClass($step[8]) }}">
            Case<br />Closed<br />
            {{ getStepStatusText($step[8]) }}<br />
            {{ $rased_case_date }}<br />({{ $rased_case_time }})
        </li>
        <div class="status-case-progress-progress-container">
            <div class="status-case-progress-bar" id="status-case-progress-bar"></div>
        </div>
    </ul>
</div>
