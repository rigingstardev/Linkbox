<div class="content-sub mrgn-btm-20 pdng-0">
    <div class="content-sub-heading">
        <div class="col-sm-12">
            <b>Medical Records</b>
        </div>
        <div class="clearfix"></div>
    </div>


    <div class="content-area-sub brdr-top content-medical-record">
        <div class="col-sm-12">
            <h5 class="txt-blue">Allergies</h5>
            <ul>
                @forelse ($medicalHistoryDetails['patient_allergies'] as $key => $medicalHistory)             
                <li>
                    <h5>{{++$key}} . {!! $medicalHistory['type'] !!}</h5> 
                    <p>{!! $medicalHistory['description'] !!}</p>
                </li>
                @empty
                <li>No Record</li>
                @endforelse
            </ul>
        </div>
    </div>
    
    <div class="content-area-sub brdr-top content-medical-record">
        <div class="col-sm-12">
            <h5 class="txt-blue">Medications</h5>
            <ul>
                @forelse ($medicalHistoryDetails['medications'] as $key => $medication)             
                <li>
                    <h5>{{++$key}} . {!! $medication['type'] !!}</h5> 
                    <p>{!! $medication['description'] !!}</p>
                </li>
                @empty
                <li>No Record</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="content-area-sub brdr-top content-medical-record">
        <div class="col-sm-12">
            <h5 class="txt-blue">Past Medical History</h5>
            <ul>
                @forelse ($medicalHistoryDetails['past_medical_history'] as $key => $medicalHistory)             
                <li>
                    <h5>{{++$key}} . {!! $medicalHistory['type'] !!}</h5>
                    <p>{!! $medicalHistory['description'] !!}</p>
                </li>
                @empty
                <li>No Record</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="content-area-sub brdr-top content-medical-record">
        <div class="col-sm-12">
            <h5 class="txt-blue">Past Surgical History</h5>
            <ul>
                @forelse ($medicalHistoryDetails['surgical_history'] as $key => $medicalHistory)             
                <li>
                    <span><b>{{++$key}} . {!! $medicalHistory['surgery'] !!}</b></span> done on {!! Carbon\Carbon::parse($medicalHistory['surgery_date'])->format('m-d-Y') !!}
                </li>
                @empty
                <li>No Record</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="content-area-sub brdr-top content-medical-record">
        <div class="col-sm-12">
            <h5 class="txt-blue">Family History</h5>
            <ul>
                @forelse ($medicalHistoryDetails['family_history'] as $key => $medicalHistory)             
                <li>
                    <h5>{{++$key}} . {!! $medicalHistory['relation'] !!}</h5>
                    <p>{!! $medicalHistory['illness'] !!}</p>
                </li>
                @empty
                <li>No Record</li>
                @endforelse
            </ul>
        </div>
    </div>    

    <div class="content-area-sub brdr-top content-medical-record">
        <div class="col-sm-12">
            <h5 class="txt-blue">Social History</h5>
            <ul>
                @forelse ($medicalHistoryDetails['social_history'] as $medicalHistory)           
                <li>Smoking - @if($medicalHistory['smoke']) {{"Yes"}} @else {{"No"}} @endif</li>
                <li>Drinking - @if($medicalHistory['drink']) {{"Yes"}} @else {{"No"}} @endif</li>
                <li>Drug - @if($medicalHistory['drug']) {{"Yes"}} @else {{"No"}} @endif</li>
                <li><h5 class="txt-blue">Other Comments</h5><p>{!! $medicalHistory['comments'] !!}</li></p></li>
                @empty
                <li>No Record</li>
                @endforelse
            </ul>
        </div>
    </div>

    @if($clinicalReport)
    <div class="content-area-sub brdr-top content-medical-record">
            <div class="col-sm-12">
                <h5 class="txt-blue">Clinical Question information</h5>
                <ul>
                    @forelse ($clinicalReport as $clinicalQs=>$clinicalAns)          
                    <li>
                        <h5>{!! $loop->iteration !!} . {!! $clinicalQs !!}</h5>
                        <p>{!! $clinicalAns !!}</p>
                    </li>
                    @empty
                    <li>No Record</li>
                    @endforelse
                </ul>
            </div>
        </div>
    @endif

</div>