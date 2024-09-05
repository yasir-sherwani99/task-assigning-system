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
            <form method="POST" class="needs-validation" action="{{ route('defects.update', $defect->id) }}" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Defect Info</h4>
                    </div><!--end card-header-->
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="name" class="form-label fw-bold">Defect Name <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="name" 
                                    name="name"
                                    placeholder="Enter defect name"
                                    value="{{ $defect->name }}"
                                    required
                                />
                                <div class="invalid-feedback">
                                    Defect name is a required field.
                                </div>
                            </div>
                        </div>
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
                                    value="{{ $defect->start_date }}"
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
                                    value="{{ $defect->end_date }}"
                                />
                                <div class="invalid-feedback">
                                    End date is a required field.
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="defect_type" class="form-label fw-bold">Defect Type</label>
                                <select 
                                    class="form-select" 
                                    aria-label="Select Defect Type"
                                    name="defect_type"
                                    id="defect_type"
                                    required
                                >
                                    <option value="{{ $defect->type }}">{{ ucfirst($defect->type) }}</option>
                                    <option value="defects">Defects</option>
                                    <option value="enhancement">Enhancement</option>
                                </select>
                                <div class="invalid-feedback">
                                    Defect type is a required field.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="priority" class="form-label fw-bold">Priority <span class="text-danger">*</span></label>
                                <select 
                                    class="form-select" 
                                    aria-label="Select priority"
                                    name="priority"
                                    id="priority"
                                    required
                                >
                                    <option value="{{ $defect->priority }}">{{ ucwords(Str::replace('_', ' ', $defect->priority)) }}</option>
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
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="project_id" class="form-label fw-bold">Project <span class="text-danger">*</span></label>
                                <select 
                                    class="form-select" 
                                    aria-label="Select Project"
                                    name="project_id"
                                    id="project_id"
                                    required
                                >
                                    <option value="{{ $defect->project_id }}">{{ $defect->projects->name }}</option>
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
                                <label for="team_id" class="form-label fw-bold">Team <span class="text-danger">*</span></label>
                                <select 
                                    class="form-select" 
                                    aria-label="Select Team"
                                    name="team_id"
                                    id="team_id"
                                    onclick="getTeamMembers()"
                                    required
                                >
                                    <option value="{{ $defect->team_id }}">{{ $defect->teams->name }}</option>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Team is a required field.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="assigned_to_id" class="form-label fw-bold">Assigned To <span class="text-danger">*</span></label>
                                <select 
                                    class="form-select" 
                                    aria-label="Select Client"
                                    name="assigned_to_id"
                                    id="assigned_to_id"
                                    required
                                >
                                    <option value="{{ $defect->assigned_to_id }}">{{ $defect->assigned->first_name . ' ' . $defect->assigned->last_name }}</option>
                                    @foreach($defect->teams->members as $member)
                                        <option value="{{ $member->id }}">{{ $member->first_name . ' ' . $member->last_name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Assigned to is a required field.
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="estimated_hours" class="form-label fw-bold">Estimate Hours </label>
                                <input 
                                    type="text" 
                                    id="estimated_hours"
                                    class="form-control"
                                    name="estimated_hours"
                                    placeholder="00:00"
                                    value="{{ $defect->estimated_hours }}"
                                />
                                <small class="text-muted">HH:MM</small>
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
                                    <option value="{{ $defect->priority }}">{{ ucwords(Str::replace('_', ' ', $defect->status)) }}</option>
                                    <option value="open">Open</option>
                                    <option value="assigned">Assigned</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="solved">Solved</option>
                                    <option value="reopen">Reopen</option>
                                    <option value="closed">Closed</option>
                                    <option value="deferred">Deferred</option>
                                </select>
                                <div class="invalid-feedback">
                                    Status is a required field.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Defect Description</h4>
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
                                >{{ $defect->description }}</textarea>
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
    <script>
        const getTeamMembers = () => {
            let csrf = "{{ csrf_token() }}";
            let teamId = document.getElementById('team_id').value;
            fetch(`/team/${teamId}/members`, {
                method: 'GET',
                headers: {
                    "X-CSRF-Token": csrf,
                    "Content-Type": "application/json"
                }
            })
            .then(res => res.json())
            .then(data => {
                let option = ''
                if(data.data.members.length > 0) {
                    data.data.members.map((mem) => {
                        option += `<option value=${mem.id}>`;
                        option += mem.first_name + ' ' + mem.last_name;
                        option += "</option>";
                    })
                }

                document.getElementById('assigned_to_id').innerHTML = option;
            })
            .catch(error => console.log(error))
        }
    </script>
    <script>
        let imagePreview = function(event) {
            let newImage = event.target.files[0];
            let imageExt = newImage.type;
            if(imageExt == "image/jpg" || imageExt == "image/png" || imageExt == "image/gif" || imageExt == "image/svg" || imageExt == "image/jpeg") {
                let imgPreview = document.getElementById('logo');
                imgPreview.src = URL.createObjectURL(newImage);
            } else {
                alert('Only images allowed');
            } 
        };
    </script>
@endsection
