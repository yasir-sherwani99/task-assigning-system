<?php
    use Illuminate\Support\Carbon;
?>
<div class="card">
    <div class="card-body">
        <div class="dropdown d-inline-block float-end">
            <a class="dropdown-toggle mr-n2 mt-n2" id="drop2" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <i class="las la-ellipsis-v font-14 text-muted"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="drop2">
                <a class="dropdown-item" href="{{ route('todos.edit', $todo->id) }}">Edit</a>
                <!-- <a class="dropdown-item" href="#">Delete</a> -->
                <form 
                    action="{{ route('todos.destroy', $todo->id) }}" 
                    method="post"
                    onsubmit="return confirm('Are you sure?');"
                >                             
                    @csrf
                    @method('delete')   
                    <button type="submit" class="border-0 bg-transparent dropdown-item">
                        Delete
                    </button>
                </form>
            </div>
        </div><!--end dropdown-->
        @if($todo->status == 'open')
            <i class="mdi mdi-circle-outline d-block mt-n2 font-14 text-warning"></i>
        @else
            <i class="mdi mdi-circle-outline d-block mt-n2 font-14 text-success"></i>
        @endif
        <h5 class="my-2 font-14">{!! Str::limit(strip_tags($todo->description), 30) !!}</h5>
        <p class="text-muted mb-2">{{ Carbon::parse($todo->due_date)->toFormattedDateString() }}</p>
    </div><!--end card-body-->
</div><!--end card-->
