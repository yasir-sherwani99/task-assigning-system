@extends('layouts.auth')

@section('content')
    <div class="row vh-100 d-flex justify-content-center">
        <div class="col-12 align-self-center">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 mx-auto">
                        <div class="card">
                            <div class="card-body p-0 border-bottom">
                                @include('common.brand')
                            </div>
                            <div class="card-body pt-0">                                    
                                @if(count($errors) > 0)
                                    <div class="alert alert-danger border-0 mt-4 mb-2" role="alert">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </div>
                                @endif
                                @include('auth.inc.login_form')
                                @include('auth.inc.login_footer')
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end card-body-->
        </div><!--end col-->
    </div><!--end row-->
@endsection