<?php
    use Illuminate\Support\Carbon;
?>
<div class="card">  
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">                      
                <h4 class="card-title">Latest Projects</h4>                      
            </div><!--end col-->
            <div class="col-auto"> 
                <a href="{{ route('projects.index') }}" class="text-primary">View All</a>   
            </div><!--end col-->
        </div>  <!--end row-->                                  
    </div><!--end card-header-->                                
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Project Name</th>
                        <th>Client Name</th>
                        <th>Start Date</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>Progress</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($latestProjects) > 0)
                        @foreach($latestProjects as $project)
                            <tr>
                                <td>{{ $project->name }}</td>
                                <td>
                                    <img src="{{ $project->clients->company_logo }}" alt="" class="thumb-sm rounded me-2">
                                    {{ $project->clients->first_name . ' ' . $project->clients->last_name }}
                                </td>
                                <td>{{ Carbon::parse($project->start_date)->toFormattedDateString() }}</td>
                                <td>{{ Carbon::parse($project->end_date)->toFormattedDateString() }}</td>
                                <td>
                                    @if($project->status == "open") 
                                        <span class="badge badge-md badge-boxed badge-soft-primary">Open</span>
                                    @elseif($project->status == "in_progress")
                                        <span class="badge badge-md badge-boxed badge-soft-warning">In Progress</span> 
                                    @elseif($project->status == "on_hold")
                                        <span class="badge badge-md badge-boxed badge-soft-info">On Hold</span>
                                    @elseif($project->status == "cancel")
                                        <span class="badge badge-md badge-boxed badge-soft-danger">Cancel</span>
                                    @else
                                        <span class="badge badge-md badge-boxed badge-soft-success">Completed</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="float-end ms-2 pt-1 font-10">{{ $project->progress }}%</small>
                                    <div class="progress mt-2" style="height:3px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $project->progress }}%;" aria-valuenow="{{ $project->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">No Project found!</td>       
                        </tr>
                    @endif                                                                                                  
                </tbody>
            </table>
                                                            
        </div><!--end table-responsive--> 
    </div><!--end card-body-->                                                                                                        
</div><!--end card-->