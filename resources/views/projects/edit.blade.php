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
            <form method="POST" class="needs-validation" action="{{ route('projects.update', $project->id) }}" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Project Info</h4>
                    </div><!--end card-header-->
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="fom-group">
                                    <label for="logo" class="form-label fw-bold">Project Logo</label>
                                    <img 
                                        src="{{ asset($project->image) }}" 
                                        alt="babystore.ae" 
                                        class="thumb-lg rounded mx-3"
                                        id="logo" 
                                    >
                                    <label class="btn btn-de-primary btn-sm text-light">
                                        Change Logo 
                                        <input 
                                            type="file" 
                                            hidden
                                            accept="image/*" 
                                            id="imgInp" 
                                            name="logo"
                                            onchange="imagePreview(event)"
                                        />
                                    </label>
                                </div>
                            </div>
                        </div><!--end form-group-->
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="name" class="form-label fw-bold">Project Name <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="name" 
                                    name="name"
                                    placeholder="Enter project name"
                                    value="{{ $project->name }}"
                                    required
                                />
                                <div class="invalid-feedback">
                                    Project name is a required field.
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="version" class="form-label fw-bold">Version <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="version" 
                                    name="version"
                                    placeholder="Enter version"
                                    value="{{ $project->version }}"
                                    required
                                />
                                <small class="text-muted">e.g. 1.0, 1.1, 1.2</small>
                                <div class="invalid-feedback">
                                    Version is a required field.
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="client_id" class="form-label fw-bold">Client <span class="text-danger">*</span></label>
                                <select 
                                    class="form-select" 
                                    aria-label="Select Client"
                                    name="client_id"
                                    id="client_id"
                                    required
                                >
                                    <option value="{{ isset($project->clients) ? $project->client_id : '' }}">{{ isset($project->clients) ? $project->clients->first_name . ' ' . $project->clients->last_name : 'N/A' }}</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->first_name . ' ' . $client->last_name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Client is a required field.
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
                                    <option value="{{ isset($project->teams) ? $project->team_id : '' }}">{{ isset($project->teams) ? $project->teams->name : 'N/A' }}</option>
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
                                    <option value="{{ $project->assigned_to_id }}">{{ $project->assigned->first_name . ' ' . $project->assigned->last_name }}</option>
                                </select>
                                <div class="invalid-feedback">
                                    Assigned to is a required field.
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="demo_url" class="form-label fw-bold">Demo URL </label>
                                <input 
                                    type="text" 
                                    id="demo_url"
                                    class="form-control"
                                    name="demo_url"
                                    placeholder="Enter Demo URL"
                                    value="{{ $project->demo_url }}"
                                />
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
                                    <option value="{{ $project->status }}">{{ ucwords(Str::replace('_', ' ', $project->status)) }}</option>
                                    <option value="open">Open</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="on_hold">On Hold</option>
                                    <option value="cancel">Cancel</option>
                                    <option value="completed">Completed</option>
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
                        <h4 class="card-title">Project Dates</h4>
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
                                    value="{{ $project->start_date }}"
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
                                    value="{{ $project->end_date }}"
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
                        <h4 class="card-title">Project Description</h4>
                    </div><!--end card-header-->
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="description" class="form-label fw-bold">Description</label>
                                <textarea
                                    id="description"
                                    name="description"
                                    class="form-control tinymce_editor"
                                    required
                                    placeholder="Enter description"
                                >{{ $project->description }}</textarea>
                            </div>
                        </div>
                    </div>                                           
                </div><!--end card-body-->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Other Info</h4>
                    </div><!--end card-header-->
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="billing_type" class="form-label fw-bold">Billing Type </label>
                                <select 
                                    class="form-select" 
                                    aria-label="Select Billing Type"
                                    name="billing_type"
                                    id="billing_type"
                                >
                                    <option value="{{ $project->billing_type }}">{{ ucfirst($project->billing_type) . ' Rate' }}</option>
                                    <option value="hourly">Hourly Rate</option>
                                    <option value="fixed">Fixed Rate</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="budget" class="form-label fw-bold">Hourly Rate/Fixed Price </label>
                                <input 
                                    type="text" 
                                    id="budget"
                                    class="form-control"
                                    name="budget"
                                    placeholder="Enter Price Rate"
                                    value="{{ $project->budget }}"
                                />
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
                                    value="{{ $project->estimated_hours }}"
                                />
                                <small class="text-muted">HH:MM</small>
                            </div>
                            <div class="col-md-6">
                                <label for="is_auto_progress" class="form-label fw-bold d-block">Auto Progress </label>
                                <input 
                                    type="checkbox" 
                                    id="is_auto_progress"
                                    name="is_auto_progress"
                                    class="mt-2"
                                    {{ $project->is_auto_progress == 1 ? 'checked' : '' }}
                                />
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
