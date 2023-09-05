@extends('layouts.app')

@section('title','Register')
@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="row flexbox-container">
                    <div class="col-xl-8 col-10 d-flex justify-content-center">
                        <div class="card bg-authentication rounded-0 mb-0">
                            <div class="row m-0">
                                <div class="col-lg-6 d-lg-block d-none text-center align-self-center pl-0 pr-3 py-0">
                                    <img src="{{ asset('app-assets/images/pages/register.jpg') }}" alt="branding logo">
                                </div>
                                <div class="col-lg-6 col-12 p-0">
                                    <div class="card rounded-0 mb-0 p-2">
                                        <div class="card-header pt-50 pb-1">
                                            <div class="card-title">
                                                <h4 class="mb-0">Create Account</h4>
                                            </div>
                                        </div>
                                        <p class="px-2">Fill the below form to create a new account.</p>
                                        <div class="card-content">
                                            <div class="card-body pt-0">
                                                <form action="{{ route('user-register-process') }}" method="POST"
                                                    enctype="multipart/form-data" novalidate>
                                                    @csrf
                                                    <div class="form-label-group">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <input type="text" id="first_name" name="first_name"
                                                                    class="form-control" placeholder="First Name"
                                                                    data-validation-required-message="This field is required"
                                                                    required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-label-group ">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <input type="text" id="last_name" name="last_name"
                                                                    class="form-control" placeholder="Last Name"
                                                                    required
                                                                    data-validation-required-message="This field is required">
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="form-label-group">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <input type="email" name="email"
                                                                    class="form-control" placeholder="Email" required
                                                                    data-validation-required-message="The email field is required">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-label-group">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <input type="password" class="form-control"
                                                                    placeholder="Your Password"
                                                                    data-validation-required-message="The password field is required"
                                                                    minlength="5" id="password" name="password"
                                                                    required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-label-group">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <input type="password" class="form-control"
                                                                    id="inputConfPassword"
                                                                    placeholder="Confirm Password" required
                                                                    data-validation-match-match="password"
                                                                    data-validation-required-message="The Confirm password field is required"
                                                                    minlength="5">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <a href="{{ route('login') }}"
                                                        class="btn btn-outline-primary float-left btn-inline mb-50">Login</a>
                                                    <button type="submit"
                                                        class="btn btn-primary float-right btn-inline mb-50">Register</a>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
@endsection
