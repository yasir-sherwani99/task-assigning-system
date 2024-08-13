<div class="card">
        <div class="card-body">    
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link fw-semibold pt-0" data-bs-toggle="tab" href="#Project1_Tab" role="tab">Project1</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active fw-semibold pt-0" data-bs-toggle="tab" href="#Project2_Tab" role="tab">Project2</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold pt-0" data-bs-toggle="tab" href="#Project3_Tab" role="tab">Project3</a>
                </li>
            </ul>
        </div><!--end card-body-->
        <div class="card-body pt-0">
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane" id="Project1_Tab" role="tabpanel">  
                    <div class="row">
                        <div class="col-md-6">
                            <div class="media mb-3">
                                <img src="{{ asset('admin-assets/images/small/project-3.jpg') }}" alt="" class="thumb-md rounded-circle">                                      
                                <div class="media-body align-self-center text-truncate ms-3">                                                            
                                    <h4 class="m-0 fw-semibold text-dark font-16">Payment App</h4>   
                                    <p class="text-muted mb-0 font-13"><span class="text-dark">Client : </span>Kevin  J. Heal</p>                                         
                                </div><!--end media-body-->
                            </div>       
                        </div><!--end col-->
                        <div class="col-md-6 text-lg-end  mb-2 mb-lg-0">
                            <h6 class="fw-semibold m-0">Start : <span class="text-muted fw-normal"> 02 June 2021</span></h6>
                            <h6 class="fw-semibold  mb-0 mt-2">Deadline : <span class="text-muted fw-normal"> 31 Oct 2021</span></h6>
                        </div><!--end col-->
                    </div><!--end row-->
                                                    
                    <div class="holder">
                        <ul class="steppedprogress pt-1">
                            <li class="complete"><span>Planing</span></li>
                            <li class="complete"><span>Design</span></li>
                            <li class="complete continuous"><span>Development</span></li>
                            <li class=""><span>Testing</span></li>
                        </ul>
                    </div>
                    <div class="task-box">
                        <div class="task-priority-icon"><i class="fas fa-circle text-success"></i></div>                                                
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-semibold m-0 align-self-center">All Hours : <span class="text-muted fw-normal"> 530 / 281:30</span></h6>
                            <h6 class="fw-semibold">Today : <span class="text-muted fw-normal"> 2:45</span><span class="badge badge-soft-pink fw-semibold ms-2"><i class="far fa-fw fa-clock"></i> 35 days left</span></h6>
                        </div>
                        <p class="text-muted mb-1">There are many variations of passages of Lorem Ipsum available, 
                            but the majority have suffered alteration in some form.
                        </p>
                        <p class="text-muted text-end mb-1">34% Complete</p>
                        <div class="progress mb-3" style="height: 4px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 34%;" aria-valuenow="34" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="img-group">
                                <a class="user-avatar" href="#">
                                    <img src="{{ asset('admin-assets/images/users/user-8.jpg') }}" alt="user" class="thumb-xs rounded-circle">
                                </a>
                                <a class="user-avatar ms-n3" href="#">
                                    <img src="{{ asset('admin-assets/images/users/user-5.jpg') }}" alt="user" class="thumb-xs rounded-circle">
                                </a>
                                <a class="user-avatar ms-n3" href="#">
                                    <img src="{{ asset('admin-assets/images/users/user-4.jpg') }}" alt="user" class="thumb-xs rounded-circle">
                                </a>
                                <a class="user-avatar ms-n3" href="#">
                                    <img src="{{ asset('admin-assets/images/users/user-6.jpg') }}" alt="user" class="thumb-xs rounded-circle">
                                </a>
                                <a href="" class="btn btn-soft-primary btn-icon-circle btn-icon-circle-sm">
                                    <i class="las la-plus"></i>6
                                </a>
                            </div><!--end img-group--> 
                            <ul class="list-inline mb-0 align-self-center">                                                                    
                                <li class="list-item d-inline-block me-2">
                                    <a class="" href="#">
                                        <i class="mdi mdi-format-list-bulleted text-success font-15"></i>
                                        <span class="text-muted fw-bold">34/100</span>
                                    </a>
                                </li>
                                <li class="list-item d-inline-block">
                                    <a class="" href="#">
                                        <i class="mdi mdi-comment-outline text-primary font-15"></i>
                                        <span class="text-muted fw-bold">3</span>
                                    </a>                                                                               
                                </li>
                                <li class="list-item d-inline-block">
                                    <a class="ms-2" href="#">
                                        <i class="mdi mdi-pencil-outline text-muted font-18"></i>
                                    </a>                                                                               
                                </li>
                                <li class="list-item d-inline-block">
                                    <a class="" href="#">
                                        <i class="mdi mdi-trash-can-outline text-muted font-18"></i>
                                    </a>                                                                               
                                </li>
                            </ul>
                        </div>                                        
                    </div><!--end task-box-->  
                    <hr class="hr-dashed">
                    <div class="row mt-3">                                                
                        <div class="col-md">
                            <div class="d-flex  mb-2 mb-lg-0">
                                <i data-feather="headphones" class="align-self-center text-secondary icon-sm"></i> 
                                <div class="d-block align-self-center ms-2">
                                    <h6 class="m-0">Last Meeting</h6>
                                    <p class="mb-0 text-muted">28 Oct 2021 / 10:30AM - 12:30PM</p>
                                </div>
                            </div>
                        </div><!--end col-->
                        <div class="col-md-auto">
                            <div class="d-flex">
                                <i data-feather="headphones" class="align-self-center text-secondary icon-sm"></i> 
                                <div class="d-block align-self-center ms-2">
                                    <h6 class="m-0">Next Meeting</h6>
                                    <p class="mb-0 text-muted">06 Nov 2021 / 10:30AM - 12:30PM</p>
                                </div>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->                                         
                </div><!--end tab-pane-->

                <div class="tab-pane active" id="Project2_Tab" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="media mb-3">
                                <img src="{{ asset('admin-assets/images/small/project-2.jpg') }}" alt="" class="thumb-md rounded-circle">                                      
                                <div class="media-body align-self-center text-truncate ms-3">
                                    
                                    <h4 class="m-0 fw-semibold text-dark font-16">Banking</h4>   
                                    <p class="text-muted  mb-0 font-13"><span class="text-dark">Client : </span>Hyman M. Cross</p>                                         
                                </div><!--end media-body-->
                            </div>       
                        </div><!--end col-->
                        <div class="col-md-6 text-lg-end mb-2 mb-lg-0">
                            <h6 class="fw-semibold m-0">Start : <span class="text-muted fw-normal"> 15 Nov 2021</span></h6>
                            <h6 class="fw-semibold mb-0 mt-2">Deadline : <span class="text-muted fw-normal"> 28 Fab 2021</span></h6>
                        </div><!--end col-->
                    </div><!--end row-->
                                                    
                    <div class="holder">
                        <ul class="steppedprogress pt-1">
                            <li class="complete"><span>Planing</span></li>
                            <li class="complete continuous"><span>Design</span></li>
                            <li class=""><span>Development</span></li>
                            <li class=""><span>Testing</span></li>
                        </ul>
                    </div>
                    <div class="task-box">
                        <div class="task-priority-icon"><i class="fas fa-circle text-success"></i></div>                                                
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-semibold m-0 align-self-center">All Hours : <span class="text-muted fw-normal"> 530 / 281:30</span></h6>
                            <h6 class="fw-semibold">Today : <span class="text-muted fw-normal"> 2:45</span><span class="badge badge-soft-pink fw-semibold ms-2"><i class="far fa-fw fa-clock"></i> 35 days left</span></h6>
                        </div>
                        <p class="text-muted mb-1">There are many variations of passages of Lorem Ipsum available, 
                            but the majority have suffered alteration in some form.
                        </p>
                        <p class="text-muted text-end mb-1">15% Complete</p>
                        <div class="progress mb-3" style="height: 4px;">
                            <div class="progress-bar bg-purple" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="img-group">
                                <a class="user-avatar" href="#">
                                    <img src="{{ asset('admin-assets/images/users/user-8.jpg') }}" alt="user" class="thumb-xs rounded-circle">
                                </a>
                                <a class="user-avatar ms-n3" href="#">
                                    <img src="{{ asset('admin-assets/images/users/user-5.jpg') }}" alt="user" class="thumb-xs rounded-circle">
                                </a>
                                <a class="user-avatar ms-n3" href="#">
                                    <img src="{{ asset('admin-assets/images/users/user-4.jpg') }}" alt="user" class="thumb-xs rounded-circle">
                                </a>
                                <a class="user-avatar ms-n3" href="#">
                                    <img src="{{ asset('admin-assets/images/users/user-6.jpg') }}" alt="user" class="thumb-xs rounded-circle">
                                </a>
                                <a href="" class="btn btn-soft-primary btn-icon-circle btn-icon-circle-sm">
                                    <i class="las la-plus"></i>4
                                </a>
                            </div><!--end img-group--> 
                            <ul class="list-inline mb-0 align-self-center">                                                                    
                                <li class="list-item d-inline-block me-2">
                                    <a class="" href="#">
                                        <i class="mdi mdi-format-list-bulleted text-success font-15"></i>
                                        <span class="text-muted fw-bold">15/100</span>
                                    </a>
                                </li>
                                <li class="list-item d-inline-block">
                                    <a class="" href="#">
                                        <i class="mdi mdi-comment-outline text-primary font-15"></i>
                                        <span class="text-muted fw-bold">3</span>
                                    </a>                                                                               
                                </li>
                                <li class="list-item d-inline-block">
                                    <a class="ms-2" href="#">
                                        <i class="mdi mdi-pencil-outline text-muted font-18"></i>
                                    </a>                                                                               
                                </li>
                                <li class="list-item d-inline-block">
                                    <a class="" href="#">
                                        <i class="mdi mdi-trash-can-outline text-muted font-18"></i>
                                    </a>                                                                               
                                </li>
                            </ul>
                        </div>                                        
                    </div><!--end task-box-->
                    <hr class="hr-dashed">
                    <div class="row mt-3">                                                
                        <div class="col-md">
                            <div class="d-flex mb-2 mb-lg-0">
                                <i data-feather="headphones" class="align-self-center text-secondary icon-sm"></i> 
                                <div class="d-block align-self-center ms-2">
                                    <h6 class="m-0">Last Meeting</h6>
                                    <p class="mb-0 text-muted">28 Oct 2021 / 10:30AM - 12:30PM</p>
                                </div>
                            </div>
                        </div><!--end col-->
                        <div class="col-md-auto">
                            <div class="d-flex">
                                <i data-feather="headphones" class="align-self-center text-secondary icon-sm"></i> 
                                <div class="d-block align-self-center ms-2">
                                    <h6 class="m-0">Next Meeting</h6>
                                    <p class="mb-0 text-muted">06 Nov 2021 / 10:30AM - 12:30PM</p>
                                </div>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end tab-pane-->

                <div class="tab-pane" id="Project3_Tab" role="tabpanel">  
                    <div class="row">
                        <div class="col-md-6">
                            <div class="media mb-3">
                                <img src="{{ asset('admin-assets/images/small/project-1.jpg') }}" alt="" class="thumb-md rounded-circle">                                      
                                <div class="media-body align-self-center text-truncate ms-3">
                                    
                                    <h4 class="m-0 fw-semibold text-dark font-16">Transfer Money</h4>   
                                    <p class="text-muted  mb-0 font-13"><span class="text-dark">Client : </span>Kevin  J. Heal</p>                                         
                                </div><!--end media-body-->
                            </div>       
                        </div><!--end col-->
                        <div class="col-md-6 text-lg-end  mb-2 mb-lg-0">
                            <h6 class="fw-semibold m-0">Start : <span class="text-muted fw-normal"> 01 Jan 2021</span></h6>
                            <h6 class="fw-semibold mb-0 mt-2">Deadline : <span class="text-muted fw-normal"> 15 Mar 2021</span></h6>
                        </div><!--end col-->
                    </div><!--end row-->
                                                    
                    <div class="holder">
                        <ul class="steppedprogress pt-1">
                            <li class="complete"><span>Planing</span></li>
                            <li class="complete"><span>Design</span></li>
                            <li class="complete"><span>Development</span></li>
                            <li class="complete finish"><span>Testing</span></li>
                        </ul>
                    </div>
                    <div class="task-box">
                        <div class="task-priority-icon"><i class="fas fa-check text-danger"></i></div>                                                
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-semibold m-0 align-self-center">All Hours : <span class="text-muted fw-normal"> 530 / 481:30</span></h6>
                            <h6 class="fw-semibold">Today : <span class="text-muted fw-normal"> 2:45</span><span class="badge badge-soft-pink fw-semibold ms-2"><i class="far fa-fw fa-clock"></i> 2 days left</span></h6>
                        </div>
                        <p class="text-muted mb-1">There are many variations of passages of Lorem Ipsum available, 
                            but the majority have suffered alteration in some form.
                        </p>
                        <p class="text-muted text-end mb-1">100% Complete</p>
                        <div class="progress mb-3" style="height: 4px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="img-group">
                                <a class="user-avatar" href="#">
                                    <img src="{{ asset('admin-assets/images/users/user-8.jpg') }}" alt="user" class="thumb-xs rounded-circle">
                                </a>
                                <a class="user-avatar ms-n3" href="#">
                                    <img src="{{ asset('admin-assets/images/users/user-5.jpg') }}" alt="user" class="thumb-xs rounded-circle">
                                </a>
                                <a class="user-avatar ms-n3" href="#">
                                    <img src="{{ asset('admin-assets/images/users/user-4.jpg') }}" alt="user" class="thumb-xs rounded-circle">
                                </a>
                                <a class="user-avatar ms-n3" href="#">
                                    <img src="{{ asset('admin-assets/images/users/user-6.jpg') }}" alt="user" class="thumb-xs rounded-circle">
                                </a>
                                <a href="" class="btn btn-soft-primary btn-icon-circle btn-icon-circle-sm">
                                    <i class="las la-plus"></i>2
                                </a>
                            </div><!--end img-group--> 
                            <ul class="list-inline mb-0 align-self-center">                                                                    
                                <li class="list-item d-inline-block me-2">
                                    <a class="" href="#">
                                        <i class="mdi mdi-format-list-bulleted text-success font-15"></i>
                                        <span class="text-muted fw-bold">100/100</span>
                                    </a>
                                </li>
                                <li class="list-item d-inline-block">
                                    <a class="" href="#">
                                        <i class="mdi mdi-comment-outline text-primary font-15"></i>
                                        <span class="text-muted fw-bold">3</span>
                                    </a>                                                                               
                                </li>
                                <li class="list-item d-inline-block">
                                    <a class="ms-2" href="#">
                                        <i class="mdi mdi-pencil-outline text-muted font-18"></i>
                                    </a>                                                                               
                                </li>
                                <li class="list-item d-inline-block">
                                    <a class="" href="#">
                                        <i class="mdi mdi-trash-can-outline text-muted font-18"></i>
                                    </a>                                                                               
                                </li>
                            </ul>
                        </div>                                        
                    </div><!--end task-box-->  
                    <hr class="hr-dashed">
                    <div class="row mt-3">                                                
                        <div class="col-md">
                            <div class="d-flex  mb-2 mb-lg-0">
                                <i data-feather="headphones" class="align-self-center text-secondary icon-sm"></i> 
                                <div class="d-block align-self-center ms-2">
                                    <h6 class="m-0">Last Meeting</h6>
                                    <p class="mb-0 text-muted">28 Oct 2021 / 10:30AM - 12:30PM</p>
                                </div>
                            </div>
                        </div><!--end col-->
                        <div class="col-md-auto">
                            <div class="d-flex">
                                <i data-feather="headphones" class="align-self-center text-secondary icon-sm"></i> 
                                <div class="d-block align-self-center ms-2">
                                    <h6 class="m-0">Next Meeting</h6>
                                    <p class="mb-0 text-muted">06 Nov 2021 / 10:30AM - 12:30PM</p>
                                </div>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->                                         
                </div><!--end tab-pane-->
            </div>        
        </div><!--end card-body-->
    </div><!--end card-->