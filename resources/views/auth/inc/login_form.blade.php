<form class="my-4 needs-validation" method="post" action="{{ route('login') }}" novalidate>            
    @csrf
    <div class="form-group mb-2">
        <label class="form-label text-primary" for="username">Email</label>
        <input type="text" class="form-control" id="username" name="email" value="{{ old('email') }}" placeholder="Enter email" required />                               
        <div class="invalid-feedback">
            Username/email is a required field.
        </div>
    </div><!--end form-group--> 

    <div class="form-group">
        <label class="form-label text-primary" for="password">Password</label>                                            
        <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" required />                            
        <div class="invalid-feedback">
            Password is a required field.
        </div>
    </div><!--end form-group--> 

    <div class="form-group row mt-3">
        <div class="col-sm-6">
            <div class="form-check form-switch form-switch-success">
                <input class="form-check-input" type="checkbox" id="customSwitchSuccess">
                <label class="form-check-label" for="customSwitchSuccess">Remember me</label>
            </div>
        </div><!--end col--> 
        <!-- <div class="col-sm-6 text-end">
            <a href="auth-recover-pw.html" class="text-muted font-13"><i class="dripicons-lock"></i> Forgot password?</a>                                    
        </div> -->
        <!--end col--> 
    </div><!--end form-group--> 

    <div class="form-group mb-0 row">
        <div class="col-12">
            <div class="d-grid mt-3">
                <button class="btn btn-primary" type="submit">Log In <i class="fas fa-sign-in-alt ms-1"></i></button>
            </div>
        </div><!--end col--> 
    </div> <!--end form-group-->                           
</form><!--end form-->

