@extends('layouts.app')

@section('style')
@endsection

@section('content')

    @if(count($errors) > 0)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <form method="POST" class="needs-validation" action="{{ route('tasks.update', $task->id) }}" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Task Info</h4>
                    </div><!--end card-header-->
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="name" class="form-label fw-bold">Task Name <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="name" 
                                    name="name"
                                    placeholder="Enter task name"
                                    value="{{ $task->name }}"
                                    required
                                />
                                <div class="invalid-feedback">
                                    Task name is a required field.
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="project_id" class="form-label fw-bold">Project <span class="text-danger">*</span></label>
                                <select 
                                    class="form-select" 
                                    aria-label="Select Client"
                                    name="project_id"
                                    id="project_id"
                                    onclick="getTeamMembers()"
                                    required
                                >
                                    <option value="{{ isset($task->projects) ? $task->project_id : '' }}">{{ isset($task->projects) ? $task->projects->name : 'N/A' }}</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Project is a required field.
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="members" class="form-label fw-bold">Assigned To <span class="text-danger">*</span></label>
                                <select 
                                    class="form-select" 
                                    aria-label="Select task members"
                                    name="members[]"
                                    id="members"
                                    required
                                >
                                    
                                    
                                </select>
                                <div class="invalid-feedback">
                                    Assigned to is a required field.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                                <select 
                                    class="form-select" 
                                    aria-label="Select Status"
                                    name="status"
                                    id="status"
                                    required
                                >
                                    <option value="{{ $task->status }}">{{ ucwords(Str::replace('_', ' ', $task->status)) }}</option>
                                    <option value="open">Open</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="on_hold">On Hold</option>
                                    <option value="cancel">Cancel</option>
                                    <option value="completed">Completed</option>
                                    <option value="waiting">Waiting</option>
                                </select>
                                <div class="invalid-feedback">
                                    Status is a required field.
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="priority" class="form-label fw-bold">Priority <span class="text-danger">*</span></label>
                                <select 
                                    class="form-select" 
                                    aria-label="Select priority"
                                    name="priority"
                                    id="priority"
                                    required
                                >
                                    <option value="{{ $task->priority }}">{{ ucwords(Str::replace('_', ' ', $task->priority)) }}</option>
                                    <option value="urgent">Urgent</option>
                                    <option value="very_high">Very High</option>
                                    <option value="high">High</option>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                </select>
                                <div class="invalid-feedback">
                                    Priority is a required field.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="estimated_hours" class="form-label fw-bold">Estimate Hours </label>
                                <input 
                                    type="text" 
                                    id="estimated_hours"
                                    class="form-control"
                                    name="estimated_hours"
                                    placeholder="00:00"
                                    value="{{ $task->estimated_hours }}"
                                />
                                <small class="text-muted">HH:MM</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Task Dates</h4>
                    </div><!--end card-header-->
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label fw-bold">Start Date <span class="text-danger">*</span></label>
                                <input 
                                    type="date" 
                                    class="form-control" 
                                    id="start_date" 
                                    name="start_date"
                                    placeholder="Enter start date"
                                    required
                                    value="{{ $task->start_date }}"
                                />
                                <div class="invalid-feedback">
                                    Start date is a required field.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label fw-bold">End Date <span class="text-danger">*</span></label>
                                <input 
                                    type="date" 
                                    id="end_date"
                                    class="form-control"
                                    name="end_date"
                                    placeholder="Enter end date"
                                    required
                                    value="{{ $task->end_date }}"
                                />
                                <div class="invalid-feedback">
                                    End date is a required field.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Task Description</h4>
                    </div><!--end card-header-->
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="description" class="form-label fw-bold">Description</label>
                                <textarea
                                    id="description"
                                    name="description"
                                    class="form-control tinymce_editor"
                                    placeholder="Enter description"
                                >{{ $task->description }}</textarea>
                            </div>
                        </div>
                    </div>                                           
                </div><!--end card-body-->
                <hr />
                <div class="row my-3">
                    <div class="col-12 text-center">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </div>
            </form>
        </div><!--end col-->
    </div><!--end row-->
@endsection

@section('script')
    <script src="{{ asset('admin-assets/plugins/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: '.tinymce_editor',
            menubar: false,
            statusbar: false,
            readonly: false,
            height: 200,
            plugins: [
                'advlist autolink link image lists charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                'table emoticons template paste help'
            ],
            toolbar: 'bold italic | alignleft aligncenter alignright alignjustify | ' + ' | link image media fullpage | ' +
                'bullist numlist | ' + 'emoticons',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    </script>
    <script src="{{ asset('admin-assets/plugins/select/selectr.min.js') }}"></script>
    <script>

        let defaultMembers = "{{ $defaultMembers }}";
        let defaultMemberss = JSON.parse(defaultMembers.replace(/&quot;/g, '"'));

        let selectedMembers = "{{ $selectedMembers }}";
        let selectedMemberss = JSON.parse(selectedMembers.replace(/&quot;/g, '"'));

        let selectr = new Selectr('#members',{
            multiple: true,
            placeholder: 'Select Team Members...',
            data: defaultMemberss
        });

        selectr.setValue(selectedMemberss)
    </script>
    <script>
        const getTeamMembers = () => {
            let csrf = "{{ csrf_token() }}";
            let projectId = document.getElementById('project_id').value;
            console.log(projectId)
            fetch(`/project/${projectId}/team-members`, {
                method: 'GET',
                headers: {
                    "X-CSRF-Token": csrf,
                    "Content-Type": "application/json"
                }
            })
            .then(res => res.json())
            .then(data => {
                console.log(data)
                let option = [];
                if(data.data.members.length > 0) {
                    data.data.members.map((mem) => {
                        let obj = {
                            value: mem.id,
                            text: mem.first_name + ' ' + mem.last_name
                        };

                        option.push(obj)
                    })
                }

                selectr.clear();
                selectr.reset();
                selectr.removeAll();
                selectr.add(option);
            })
            .catch(error => console.log(error))
        }
    </script>
@endsection
