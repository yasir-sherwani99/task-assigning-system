<div class="left-sidebar show" style="background-color: #f8f9fb;">
    <!-- LOGO -->
    <div class="brand">
        <a href="{{ route('home') }}" class="logo">
            <span>
                <img 
                    src="{{ asset('admin-assets/images/logos/1667736879.png') }}" 
                    alt="J1 Door" 
                    class="logo-sm"
                />
            </span>
        </a>
    </div>
    <!--end logo-->
    <div class="menu-content h-100" data-simplebar>
        <div class="menu-body navbar-vertical tab-content">
            <div class="collapse navbar-collapse" id="sidebarCollapse">
                <!-- Navigation -->
                <ul class="navbar-nav">
                    <li class="menu-label mt-0">H<span>ome</span></li>
                    <li class="nav-item">
                        <a 
                            class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" 
                            href="{{ route('home') }}"
                        >
                            <i class="ti ti-home menu-icon"></i>
                            <span>Dashboard</span>
                        </a>
                    </li><!--end nav-item-->
                    <li class="menu-label mt-0">A<span>pp Section</span></li>
                    <li class="nav-item">
                        <a 
                            class="nav-link {{ request()->routeIs('clients.index') || request()->routeIs('clients.edit') || request()->routeIs('clients.create') ? 'active' : '' }}" 
                            href="#sidebarClient" 
                            data-bs-toggle="collapse" 
                            role="button"
                            aria-expanded="false" 
                            aria-controls="sidebarClient"
                        >
                            <i class="ti ti-user-check menu-icon"></i>
                            <span>Clients</span>
                        </a>
                        <div class="collapse {{ request()->routeIs('clients.index') || request()->routeIs('clients.edit') || request()->routeIs('clients.create') ? 'show' : '' }}" id="sidebarClient">
                            <ul class="nav flex-column">
                               <li class="nav-item">
                                    <a 
                                        class="nav-link {{ request()->routeIs('clients.index') || request()->routeIs('clients.edit') ? 'active' : '' }}" 
                                        href="{{ route('clients.index') }}"
                                    >
                                        Clients List
                                    </a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a 
                                        class="nav-link {{ request()->routeIs('clients.create') ? 'active' : '' }}" 
                                        href="{{ route('clients.create') }}"
                                    >
                                        New Client
                                    </a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end sidebarPages-->
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a 
                            class="nav-link {{ request()->routeIs('projects.index') || request()->routeIs('projects.edit') || request()->routeIs('projects.create') ? 'active' : '' }}" 
                            href="#sidebarProject" 
                            data-bs-toggle="collapse" 
                            role="button"
                            aria-expanded="false" 
                            aria-controls="sidebarProject"
                        >
                            <i class="ti ti-presentation menu-icon"></i>
                            <span>Projects</span>
                        </a>
                        <div class="collapse {{ request()->routeIs('projects.index') || request()->routeIs('projects.edit') || request()->routeIs('projects.create') ? 'show' : '' }}" id="sidebarProject">
                            <ul class="nav flex-column">
                               <li class="nav-item">
                                    <a 
                                        class="nav-link {{ request()->routeIs('projects.index') || request()->routeIs('projects.edit') ? 'active' : '' }}" 
                                        href="{{ route('projects.index') }}"
                                    >
                                        Projects List
                                    </a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a 
                                        class="nav-link {{ request()->routeIs('projects.create') ? 'active' : '' }}" 
                                        href="{{ route('projects.create') }}"
                                    >
                                        New Project
                                    </a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end sidebarPages-->
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a 
                            class="nav-link {{ request()->routeIs('tasks.index') || request()->routeIs('tasks.edit') || request()->routeIs('tasks.create') ? 'active' : '' }}" 
                            href="#sidebarTask" 
                            data-bs-toggle="collapse" 
                            role="button"
                            aria-expanded="false" 
                            aria-controls="sidebarTask"
                        >
                            <i class="ti ti-file-check menu-icon"></i>
                            <span>Tasks</span>
                        </a>
                        <div class="collapse {{ request()->routeIs('tasks.index') || request()->routeIs('tasks.edit') || request()->routeIs('tasks.create') || request()->routeIs('tasks.show') || request()->routeIs('mytasks.index') ? 'show' : '' }}" id="sidebarTask">
                            <ul class="nav flex-column">
                               <li class="nav-item">
                                    <a 
                                        class="nav-link {{ request()->routeIs('tasks.index') || request()->routeIs('tasks.edit') || request()->routeIs('tasks.show') ? 'active' : '' }}" 
                                        href="{{ route('tasks.index') }}"
                                    >
                                        Tasks List
                                    </a>
                                </li><!--end nav-item-->
                                @role('team-member')
                                    <li class="nav-item">
                                        <a 
                                            class="nav-link {{ request()->routeIs('mytasks.index') ? 'active' : '' }}" 
                                            href="{{ route('mytasks.index') }}"
                                        >
                                            My Tasks
                                        </a>
                                    </li>
                                @endrole
                                <li class="nav-item">
                                    <a 
                                        class="nav-link {{ request()->routeIs('tasks.create') ? 'active' : '' }}" 
                                        href="{{ route('tasks.create') }}"
                                    >
                                        New Task
                                    </a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end sidebarPages-->
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a 
                            class="nav-link {{ request()->routeIs('defects.index') || request()->routeIs('defects.edit') || request()->routeIs('defects.create') ? 'active' : '' }}" 
                            href="#sidebarDefects" 
                            data-bs-toggle="collapse" 
                            role="button"
                            aria-expanded="false" 
                            aria-controls="sidebarDefects"
                        >
                            <i class="ti ti-bug menu-icon"></i>
                            <span>Defects</span>
                        </a>
                        <div class="collapse {{ request()->routeIs('defects.index') || request()->routeIs('defects.edit') || request()->routeIs('defects.create') ? 'show' : '' }}" id="sidebarDefects">
                            <ul class="nav flex-column">
                               <li class="nav-item">
                                    <a 
                                        class="nav-link {{ request()->routeIs('defects.index') || request()->routeIs('defects.edit') ? 'active' : '' }}" 
                                        href="{{ route('defects.index') }}"
                                    >
                                        Defects List
                                    </a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a 
                                        class="nav-link {{ request()->routeIs('defects.create') ? 'active' : '' }}" 
                                        href="{{ route('defects.create') }}"
                                    >
                                        New Defects
                                    </a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end sidebarPages-->
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a 
                            class="nav-link {{ request()->routeIs('meetings.index') || request()->routeIs('meetings.edit') || request()->routeIs('meetings.create') ? 'active' : '' }}" 
                            href="#sidebarMeetings" 
                            data-bs-toggle="collapse" 
                            role="button"
                            aria-expanded="false" 
                            aria-controls="sidebarMeetings"
                        >
                            <i class="ti ti-briefcase menu-icon"></i>
                            <span>Meetings</span>
                        </a>
                        <div class="collapse {{ request()->routeIs('meetings.index') || request()->routeIs('meetings.edit') || request()->routeIs('meetings.create') ? 'show' : '' }}" id="sidebarMeetings">
                            <ul class="nav flex-column">
                               <li class="nav-item">
                                    <a 
                                        class="nav-link {{ request()->routeIs('meetings.index') || request()->routeIs('meetings.edit') ? 'active' : '' }}" 
                                        href="{{ route('meetings.index') }}"
                                    >
                                        Meetings List
                                    </a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a 
                                        class="nav-link {{ request()->routeIs('meetings.create') ? 'active' : '' }}" 
                                        href="{{ route('meetings.create') }}"
                                    >
                                        New Meeting
                                    </a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end sidebarPages-->
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a 
                            class="nav-link {{ request()->routeIs('appointments.index') || request()->routeIs('appointments.edit') || request()->routeIs('appointments.create') ? 'active' : '' }}" 
                            href="#sidebarAppointments" 
                            data-bs-toggle="collapse" 
                            role="button"
                            aria-expanded="false" 
                            aria-controls="sidebarAppointments"
                        >
                            <i class="ti ti-calendar menu-icon"></i>
                            <span>Appointments</span>
                        </a>
                        <div class="collapse {{ request()->routeIs('appointments.index') || request()->routeIs('appointments.edit') || request()->routeIs('appointments.create') ? 'show' : '' }}" id="sidebarAppointments">
                            <ul class="nav flex-column">
                               <li class="nav-item">
                                    <a 
                                        class="nav-link {{ request()->routeIs('appointments.index') || request()->routeIs('appointments.edit') ? 'active' : '' }}" 
                                        href="{{ route('appointments.index') }}"
                                    >
                                        Appointments List
                                    </a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a 
                                        class="nav-link {{ request()->routeIs('appointments.create') ? 'active' : '' }}" 
                                        href="{{ route('appointments.create') }}"
                                    >
                                        New Appointment
                                    </a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end sidebarPages-->
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a 
                            class="nav-link {{ request()->routeIs('tasks.index') || request()->routeIs('tasks.edit') || request()->routeIs('tasks.create') ? 'active' : '' }}" 
                            href="#sidebarReports" 
                            data-bs-toggle="collapse" 
                            role="button"
                            aria-expanded="false" 
                            aria-controls="sidebarReports"
                        >
                            <i class="ti ti-report menu-icon"></i>
                            <span>Reports</span>
                        </a>
                        <div class="collapse {{ request()->routeIs('tasks.index') || request()->routeIs('tasks.edit') || request()->routeIs('tasks.create') ? 'show' : '' }}" id="sidebarReports">
                            <ul class="nav flex-column">
                               <li class="nav-item">
                                    <a 
                                        class="nav-link {{ request()->routeIs('tasks.index') || request()->routeIs('tasks.edit') ? 'active' : '' }}" 
                                        href="{{ route('tasks.index') }}"
                                    >
                                        Defects List
                                    </a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a 
                                        class="nav-link {{ request()->routeIs('tasks.create') ? 'active' : '' }}" 
                                        href="{{ route('tasks.create') }}"
                                    >
                                        New Defects
                                    </a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end sidebarPages-->
                    </li><!--end nav-item-->
                    <li class="menu-label mt-0">S<span>ettings Section</span></li>
                    <li class="nav-item">
                        <a 
                            class="nav-link {{ request()->routeIs('roles.index') || request()->routeIs('roles.edit') || request()->routeIs('roles.create') || request()->routeIs('permissions.index') || request()->routeIs('permissions.edit') || request()->routeIs('permissions.create') || request()->routeIs('teams.index') || request()->routeIs('teams.edit') || request()->routeIs('teams.create') ? 'active' : '' }}" 
                            href="#sidebarAdmin" 
                            data-bs-toggle="collapse" 
                            role="button"
                            aria-expanded="false" 
                            aria-controls="sidebarAdmin"
                        >
                            <i class="ti ti-settings menu-icon"></i>
                            <span>Administration</span>
                        </a>
                        <div class="collapse {{ request()->routeIs('roles.index') || request()->routeIs('roles.edit') || request()->routeIs('roles.create') || request()->routeIs('permissions.index') || request()->routeIs('permissions.edit') || request()->routeIs('permissions.create') || request()->routeIs('teams.index') || request()->routeIs('teams.edit') || request()->routeIs('teams.create') ? 'show' : '' }}" id="sidebarAdmin">
                            <ul class="nav flex-column">
                               <li class="nav-item">
                                    <a 
                                        class="nav-link {{ request()->routeIs('roles.index') || request()->routeIs('roles.edit') || request()->routeIs('roles.create') ? 'active' : '' }}" 
                                        href="{{ route('roles.index') }}"
                                    >
                                        Roles
                                    </a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a 
                                        class="nav-link {{ request()->routeIs('permissions.index') || request()->routeIs('permissions.edit') || request()->routeIs('permissions.create') ? 'active' : '' }}" 
                                        href="{{ route('permissions.index') }}"
                                    >
                                        Permissions
                                    </a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a 
                                        class="nav-link {{ request()->routeIs('teams.index') || request()->routeIs('teams.edit') || request()->routeIs('teams.create') ? 'active' : '' }}" 
                                        href="{{ route('teams.index') }}"
                                    >
                                        Teams
                                    </a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end sidebarPages-->
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a 
                            class="nav-link {{ request()->routeIs('users.index') || request()->routeIs('users.edit') || request()->routeIs('users.create') || request()->routeIs('users.roles-permissions.edit') ? 'active' : '' }}" 
                            href="#sidebarHRM" 
                            data-bs-toggle="collapse" 
                            role="button"
                            aria-expanded="false" 
                            aria-controls="sidebarHRM"
                        >
                            <i class="ti ti-users menu-icon"></i>
                            <span>HRM</span>
                        </a>
                        <div class="collapse {{ request()->routeIs('users.index') || request()->routeIs('users.edit') || request()->routeIs('users.create') || request()->routeIs('users.roles-permissions.edit') ? 'show' : '' }}" id="sidebarHRM">
                            <ul class="nav flex-column">
                               <li class="nav-item">
                                    <a 
                                        class="nav-link {{ request()->routeIs('users.index') || request()->routeIs('users.edit') || request()->routeIs('users.roles-permissions.edit') ? 'active' : '' }}" 
                                        href="{{ route('users.index') }}"
                                    >
                                        Users
                                    </a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end sidebarPages-->
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a 
                            class="nav-link" 
                            href="#"
                            onclick="
                                event.preventDefault(); 
                                document.getElementById('admin-logout-form-side').submit();
                            "
                        >
                            <i class="ti ti-logout menu-icon"></i>
                            <span>Logout</span>
                        </a>
                    </li><!--end nav-item-->
                </ul><!--end navbar-nav--->
            </div><!--end sidebarCollapse-->
            <form id="admin-logout-form-side" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>    
</div>
<!-- end left-sidenav-->