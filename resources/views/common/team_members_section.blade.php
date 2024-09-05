
@if(isset($teamMembers))
    <div class="img-group">
        @foreach($teamMembers as $key => $member)
            @if($key < 4)
                <a href="#" class="user-avatar {{ $key != 0 ? 'ms-n3' : '' }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $member->first_name . ' ' . $member->last_name }}">
                    <img src="{{ asset($member->photo) }}" alt="{{ $member->first_name }}" class="thumb-xs rounded-circle" />
                </a>
            @endif
        @endforeach
        @if(count($teamMembers) > 4)
            <a href="#" class="user-avatar">
                <span class="thumb-xs justify-content-center d-flex align-items-center bg-soft-info rounded-circle fw-semibold">+{{ count($teamMembers) - 4 }}</span>
            </a>  
        @endif                  
    </div>
@endif