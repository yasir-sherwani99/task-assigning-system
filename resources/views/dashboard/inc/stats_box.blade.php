<div class="card report-card">
    <div class="card-body">
        <div class="row d-flex justify-content-center">
            <div class="col">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-dark mb-1 fw-semibold">{{ $title }}</p>
                        <h4 class="my-1">{{ $count }}</h4>
                    </div>
                    <div class="bg-light-alt d-flex justify-content-center align-items-center thumb-md rounded-circle">
                        <i data-feather="{{ $icon }}" class="align-self-center text-muted icon-sm"></i>  
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    @if(isset($in_progress))
                        <p class="mb-0 text-truncate text-muted">
                            <span class="text-success">
                                <i class="mdi mdi-checkbox-marked-circle-outline me-1"></i>
                            </span>
                            {{ $in_progress }} In Progress
                        </p>
                    @endif
                    @if(isset($active_clients))
                        <p class="mb-0 text-truncate text-muted">
                            <span class="text-success">
                                <i class="mdi mdi-checkbox-marked-circle-outline me-1"></i>
                            </span>
                            {{ $active_clients }} Active Clients
                        </p>
                    @endif
                    @if(isset($over_due))
                        <p class="mb-0 text-truncate text-muted">
                            <span class="text-danger">
                                <i class="mdi mdi-clock-alert-outline me-1"></i>
                            </span>
                            {{ $over_due }} Over Due
                        </p>
                    @endif
                </div>
            </div>
            <!-- <div class="col-auto align-self-center">
                <div class="bg-light-alt d-flex justify-content-center align-items-center thumb-md rounded-circle">
                    <i data-feather="{{ $icon }}" class="align-self-center text-muted icon-sm"></i>  
                </div>
            </div> -->
        </div>
    </div><!--end card-body--> 
</div><!--end card-->