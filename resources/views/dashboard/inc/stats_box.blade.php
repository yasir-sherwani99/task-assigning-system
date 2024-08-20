<div class="card report-card">
    <div class="card-body">
        <div class="row d-flex justify-content-center">
            <div class="col">
                <p class="text-dark mb-1 fw-semibold">{{ $title }}</p>
                <h4 class="my-1">{{ $count }}</h4>
                <p class="mb-0 text-truncate text-muted">
                    <!-- <span class="text-success">
                        <i class="mdi mdi-checkbox-marked-circle-outline me-1"></i>
                    </span> -->
                    @if(isset($in_progress))
                        {{ $in_progress }} In Progress
                    @endif
                </p>
            </div>
            <div class="col-auto align-self-center">
                <div class="bg-light-alt d-flex justify-content-center align-items-center thumb-md rounded-circle">
                    <i data-feather="{{ $icon }}" class="align-self-center text-muted icon-sm"></i>  
                </div>
            </div>
        </div>
    </div><!--end card-body--> 
</div><!--end card-->