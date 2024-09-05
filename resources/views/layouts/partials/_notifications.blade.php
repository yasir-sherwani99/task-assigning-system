<a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#" role="button"
    aria-haspopup="false" aria-expanded="false">
    <i class="ti ti-bell"></i>
    @if(auth()->user()->unreadNotifications->count() > 0)
        <span class="alert-badge"></span>
    @endif
</a>
<div class="dropdown-menu dropdown-menu-end dropdown-lg pt-0">
    <h6 class="dropdown-item-text font-15 m-0 py-3 border-bottom d-flex justify-content-between align-items-center">
        Notifications <span class="badge bg-soft-primary badge-pill">{{ auth()->user()->unreadNotifications->count() }}</span>
    </h6> 
    <div class="notification-menu" data-simplebar>
        @if(count($notifications) > 0)
            @foreach($notifications as $noti)
                <!-- item-->
                <a href="#" class="dropdown-item py-3">
                    <small class="float-end text-muted ps-2">{{ $noti['date_human'] }}</small>
                    <div class="media">
                        <div class="avatar-md bg-soft-primary">
                            <i class="{{ $noti['icon'] }}"></i>
                        </div>
                        <div class="media-body align-self-center ms-2 text-truncate">
                            <h6 class="my-0 fw-normal text-dark">{{ $noti['title'] }}</h6>
                            <small class="text-muted mb-0">{{ $noti['message'] }}</small>
                        </div><!--end media-body-->
                    </div><!--end media-->
                </a><!--end-item-->
            @endforeach
        @else
            <a href="#" class="dropdown-item py-3">
                <p>No notification found!</p>
            </a>
        @endif
    </div>
    <!-- All-->
    <a href="{{ route('notifications') }}" class="dropdown-item text-center text-primary">
        View all <i class="fi-arrow-right"></i>
    </a>
</div>