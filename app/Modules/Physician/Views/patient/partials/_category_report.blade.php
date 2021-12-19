@forelse ($summaryByCat as $summaryByCat=>$summaryOutput)
    <div class="content-area-sub brdr-top">
        <div class="col-sm-12 paragraph">
          <b class="display-block mrgn-btm-10">{!! $summaryByCat !!}</b>             
            <p>{!! $summaryOutput !!}</p>              
        </div>
    </div>
@empty
    <div class="content-area-sub brdr-top"><p>No Summary</p></div>
@endforelse