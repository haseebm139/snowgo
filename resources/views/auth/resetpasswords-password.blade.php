
@extends('layouts.app')
@section('title', 'Reset Password')
@section('content')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="row flexbox-container">
                <div class="col-xl-7 col-10 d-flex justify-content-center">
                    <div class="card bg-authentication rounded-0 mb-0 w-100">
                        <div class="row m-0">
                            <div class="col-lg-6 d-lg-block d-none text-center align-self-center p-0">
                                <img src="{{ asset('app-assets/images/pages/reset-password.png') }}"
                                    alt="branding logo">
                            </div>
                            <div class="col-lg-6 col-12 p-0">
                                <div class="card rounded-0 mb-0 px-2">
                                    <div class="card-header pb-1">
                                        <div class="card-title">
                                            <h4 class="mb-0">Reset Password</h4>
                                        </div>
                                    </div>
                                    <p class="px-2">Please enter your new password.</p>
                                    <div class="card-content">
                                        <div class="card-body pt-1">
                                            <form action="{{ route('updatePassword') }}" method="post" novalidate>
                                                @csrf
                                                <fieldset class="form-label-group form-group">
                                                    <div class="controls">
                                                        <label for="user-password">Password</label>
                                                        <input type="password" name="password" class="form-control"
                                                            id="user-password" placeholder="Password"
                                                            data-validation-required-message="The password field is required"
                                                            minlength="5" required>
                                                        <input type="hidden" name="remember_token"
                                                            value="{{ $id }}">
                                                    </div>
                                                </fieldset>

                                                <fieldset class="form-label-group form-group">
                                                    <div class="controls">

                                                        <label for="user-confirm-password">Confirm Password</label>
                                                        <input type="password" class="form-control"
                                                            name="confirm-password" id="user-confirm-password"
                                                            placeholder="Confirm Password" required
                                                            data-validation-match-match="password"
                                                            data-validation-required-message="The Confirm password field is required">
                                                    </div>
                                                </fieldset>
                                                <div class="row pt-2">
                                                    <div class="col-12 col-md-6 mb-1">
                                                        <a href="{{ route('login') }}"
                                                            class="btn btn-outline-primary btn-block px-0">Go Back
                                                            to Login</a>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-1">
                                                        <button type="submit"
                                                            class="btn btn-primary btn-block px-0">Reset</button>
                                                    </div>
                                                </div>
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
