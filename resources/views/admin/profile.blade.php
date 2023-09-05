@extends('admin.layouts.master')

@section('header-script')
    <style type="text/css">

    </style>
@endsection

@section('body-section')
    <section class="users-edit">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center active" id="account-tab" data-toggle="tab"
                                href="#account" aria-controls="account" role="tab" aria-selected="true">
                                <i class="feather icon-user mr-25"></i><span class="d-none d-sm-block">Account</span>
                            </a>
                        </li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                            <!-- users edit media object start -->
                            <div class="media mb-2">
                                <a class="mr-2 my-25" href="#">
                                    @php $profile = auth()->user()->profile??null; @endphp
                                    <img src='{{ asset("documents/profile/$profile") }}' alt="users avatar"
                                        class="users-avatar-shadow rounded" height="90" width="90">
                                </a>
                                <div class="media-body mt-50">
                                    <h4 class="media-heading">{{ auth()->user()->first_name }}
                                        {{ auth()->user()->last_name }}</h4>

                                </div>
                            </div>
                            <!-- users edit media object ends -->
                            <!-- users edit account form start -->
                            <form novalidate action="{{ route('profile-update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>First Name</label>
                                                <input type="text" class="form-control" name="first_name"
                                                    placeholder="First Name" value="{{ auth()->user()->first_name }}"
                                                    required data-validation-required-message="This  field is required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Last Name</label>
                                                <input type="text" class="form-control" name="last_name"
                                                    placeholder="Last Name" value="{{ auth()->user()->last_name }}" required
                                                    data-validation-required-message="This  field is required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>E-mail</label>
                                                <input type="email" class="form-control" name="email" readonly
                                                    placeholder="Email" value="{{ auth()->user()->email }}" required
                                                    data-validation-required-message="This email field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">

                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" disabled="disabled" name="status" readonly>
                                                <option value="1">Active</option>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Role</label>
                                            <select class="form-control" disabled="disabled" name="type" readonly>
                                                <option value="admin">Admin</option>
                                            </select>
                                        </div>

                                        </fieldset>

                                        <div class="form-group">
                                            <label>Profile</label>
                                            <input type="file" name="profile" class="form-control">

                                        </div>



                                    </div>

                                    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                        <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save
                                            Changes</button>
                                        <button type="reset" class="btn btn-outline-warning">Reset</button>
                                    </div>
                                </div>

                            </form>
                            <!-- users edit account form ends -->
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('footer-section')
@endsection

@section('footer-script')
    <script>

    </script>
@endsection
