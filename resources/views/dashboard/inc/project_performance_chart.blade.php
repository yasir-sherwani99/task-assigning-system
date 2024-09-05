<div class="card">   
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">                      
                <h4 class="card-title">Project Performance</h4>                      
            </div><!--end col-->                                       
        </div>  <!--end row-->                                  
    </div><!--end card-header-->  
    <div class="card-body">
        <div class="apexchart-wrapper">
            <div id="project_status" class="apex-charts"></div>
        </div>
        <div class="text-center">
            <h6 class="text-primary bg-soft-primary p-3 mb-0">
                <i data-feather="calendar" class="align-self-center icon-xs me-1"></i>
                {{ $startDate }} to {{ $endDate }}
            </h6>
        </div>
    </div><!--end card-body-->    
</div><!--end card-->