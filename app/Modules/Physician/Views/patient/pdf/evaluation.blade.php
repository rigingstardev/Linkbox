<?php
$style = [
    /* Layout ------------------------------ */
    'html' => 'min-height: 100%;font-size: 14px;font-family: sans-serif;',
    'body' => 'min-height: 100%;',
    'table' => 'width:100%;',
    'table.content' => 'margin-top: 50px;',
    'table.block1' => 'margin-top: 20px;width:60%;',
    'table.block1.td' => 'padding: 6px 0;',
    'table.block2' => 'line-height: 20px;width:100%;',
    'table.h3' => 'margin-bottom: 0; margin-top: 20px; color: #00a0e3;',
    'remove.margin' => 'margin: 0;',
    'margin.btm.ten' => 'margin-bottom: 10px;',
];
?>
<!DOCTYPE html>
<html style="{{$style['html']}}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Summary Report</title>
    </head>
    <body style="{{ $style['body'] }}">
        <table style="{{$style['table'].$style['table.content']}}">
            <tr>
                <td>
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKYAAAAmCAYAAABOOOCvAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyBpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNSBXaW5kb3dzIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkJBMUE4NzA1QzExQjExRTY5Mzg1RDFFNUMwMkYxNkJDIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkJBMUE4NzA2QzExQjExRTY5Mzg1RDFFNUMwMkYxNkJDIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6QkExQTg3MDNDMTFCMTFFNjkzODVEMUU1QzAyRjE2QkMiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6QkExQTg3MDRDMTFCMTFFNjkzODVEMUU1QzAyRjE2QkMiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4mhPcmAAAOrUlEQVR42uyce1hUZR7H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" alt="logo">
                </td>
            </tr>
        </table>
        <hr>
        <table  style="{{ $style['table'].$style['table.block1']  }}">
            <tr>
                <td style="{{ $style['table.block1.td']}}">Patient Name</td><td>{{ $evaluationData['patient']['first_name']. " ". $evaluationData['patient']['last_name'] }}</td>
            </tr>
            <tr>
                <td style="{{ $style['table.block1.td']}}">Age</td><td>{{ Carbon\Carbon::parse($evaluationData['patient']['dob'])->diff(Carbon\Carbon::now())->format('%y') }}</td>
            </tr>
            <tr>
                <td style="{{ $style['table.block1.td']}}">Gender</td><td>@if($evaluationData['patient']['gender'] == 'F' ) {{'Female'}} @else{{'Male'}} @endif</td>
            </tr>
            <tr>
                <td style="{{ $style['table.block1.td']}}">Chief Complaint</td><td>{{ $evaluationData['question']['title'] }}</td>
            </tr>
            <tr>
                <td style="{{ $style['table.block1.td']}}">Physician Name</td><td>{{Auth::user()->name}}</td>
            </tr>
            <tr>
                <td style="{{ $style['table.block1.td']}}">Report generated on</td><td><?php echo date('m-d-Y H:i:s'); ?></td>
            </tr>
        </table>
        <hr>
        <table  style="{{ $style['table'].$style['table.block2']}}">
            <tr>
                <td><h3 style="{{$style['table.h3']}}">{{ $evaluationData['question']['title'] }}</h3></td>
            </tr>
            <tr>
                <td>{{ $summary }}</td>
            </tr>
        </table>
        <br>
        <hr>

        <table  style="{{ $style['table'].$style['table.block2']}}">
            <tr>
                <td><h3 style="{{$style['table.h3']}}">Allergies</h3></td>
            </tr>
            @forelse ($medicalHistoryDetails['patient_allergies'] as $key => $medicalHistory)
            <tr>
                <td>
                    <p>
                        {{++$key}} . {!! $medicalHistory['type'] !!}
                        <br>
                        {!! $medicalHistory['description'] !!}
                    </p>
                </td>
            </tr>
            @empty
            <tr>
                <td>
                    <p>No Record</p>
                </td>
            </tr>
            @endforelse
        </table>
        
        <table  style="{{ $style['table'].$style['table.block2']}}">
            <tr>
                <td><h3 style="{{$style['table.h3']}}">Medications</h3></td>
            </tr>
            @forelse ($medicalHistoryDetails['medications'] as $key => $medication)
            <tr>
                <td>
                    <p>
                        {{++$key}} . {!! $medication['type'] !!}
                        <br>
                        {!! $medication['description'] !!}
                    </p>
                </td>
            </tr>
            @empty
            <tr>
                <td>
                    <p>No Record</p>
                </td>
            </tr>
            @endforelse
        </table>

        <table  style="{{ $style['table'].$style['table.block2']}}">
            <tr>
                <td><h3 style="{{$style['table.h3']}}">Past Medical History</h3></td>
            </tr>
            @forelse ($medicalHistoryDetails['past_medical_history'] as $key => $medicalHistory) 
            <tr>
                <td>
                    <p>
                        {{++$key}} . {!! $medicalHistory['type'] !!}
                        <br>
                        {!! $medicalHistory['description'] !!}
                    </p>
                </td>
            </tr>
            @empty
            <tr>
                <td>
                    <p>No Record</p>
                </td>
            </tr>
            @endforelse
        </table>
        <table  style="{{ $style['table'].$style['table.block2']}}">
            <tr>
                <td><h3 style="{{$style['table.h3']}}">Past Surgical History</h3></td>
            </tr>
            @forelse ($medicalHistoryDetails['surgical_history'] as $key => $medicalHistory) 


            <tr>
                <td>
                    <p style="{{$style['remove.margin']}}">
                        {{++$key}} . <b>{!! $medicalHistory['surgery'] !!}</b> done on {!! Carbon\Carbon::parse($medicalHistory['surgery_date'])->format('m-d-Y') !!}
                    </p>
                </td>
            </tr>
            @empty
            <tr>
                <td>
                    <p>No Record</p>
                </td>
            </tr>
            @endforelse
        </table>

        <table  style="{{ $style['table'].$style['table.block2']}}">
            <tr>
                <td><h3 style="{{$style['table.h3']}}">Family History</h3></td>
            </tr>
            @forelse ($medicalHistoryDetails['family_history'] as $key => $medicalHistory)             
            <tr>
                <td>
                    <p style="{{$style['margin.btm.ten']}}">
                        {{++$key}} . {!! $medicalHistory['relation'] !!}
                        <br>
                        {!! $medicalHistory['illness'] !!}
                    </p>
                </td>
            </tr>
            @empty
            <tr>
                <td>
                    <p>No Record</p>
                </td>
            </tr>
            @endforelse
        </table>

        <table  style="{{ $style['table'].$style['table.block2']}}">
            <tr>
                <td><h3 style="{{$style['table.h3']}}">Social History</h3></td>
            </tr>
            @foreach ($medicalHistoryDetails['social_history'] as $medicalHistory) 

            <tr>
                <td>Smoking - @if($medicalHistory['smoke']) {{"Yes"}} @else {{"No"}} @endif</td>
            </tr>
            <tr>
                <td>Drinking - @if($medicalHistory['drink']) {{"Yes"}} @else {{"No"}} @endif</td>
            </tr>
            <tr>
                <td>Drug - @if($medicalHistory['drug']) {{"Yes"}} @else {{"No"}} @endif</td>
            </tr>
            <tr>
                <td>
                    <h3 style="{{$style['table.h3']}}">Other Comments</h3>
                    <br>
                    {!! $medicalHistory['comments'] !!}</td>
            </tr>
            @endforeach
        </table>
        @if($clinicalReport)
        <table  style="{{ $style['table'].$style['table.block2']}}">
            <tr>
                <td><h3 style="{{$style['table.h3']}}">Clinical Question information</h3></td>
            </tr>
            @foreach ($clinicalReport as $clinicalQs=>$clinicalAns) 

            <tr>
                <td>{!! $loop->iteration !!} . {!! $clinicalQs !!}</td>
            </tr>
            <tr>
                <td>{!! $clinicalAns !!}</td>
            </tr>
            @endforeach
        </table>
        @endif
    </body>
</html> 