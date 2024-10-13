<div class="container-fluid pb-4 pt-4 paddding">
    <div class="container paddding">
        <div class="row mx-0">
            <div class="col-md-8 animate-box" data-animate-effect="fadeInLeft">
                {{ $slotLeft ?? ''}}
            </div>
            <div class="col-md-3 animate-box" data-animate-effect="fadeInRight">
                {{ $slotRight ?? ''}}
            </div>
        </div>
        <div class="row mx-0 animate-box" data-animate-effect="fadeInUp">
            {{ $slotUp ?? ''}}
        </div>
    </div>
</div>