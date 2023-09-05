

@extends('admin.layouts.master')
@section('title',"Role")

@section('header-script')
@endsection

@section('body-section')
    <section class="input-validation dashboard-analytics">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-content">
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('roles.store') }}" novalidate
                                enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Role Name</label>
                                            <div class="controls">
                                                <input type="text" name="name" class="form-control"
                                                    data-validation-required-message="This field is required"
                                                    placeholder="Role Name">
                                            </div>
                                        </div>

                                    </div>

                                <div class="card-body px-75">
                                    <div class="card-header border-bottom mx-2 px-0">
                                        <h6 class="border-bottom py-1 mb-0 font-medium-2"><i class="feather icon-lock mr-50 "></i>Permission
                                        </h6>
                                    </div>
                                    <div class="table-responsive users-view-permission">
                                        <table class="table table-borderless">

                                            <tbody>
                                                @if(count($permission_type)>0)
                                                @foreach($permission_type as $item)
                                                <tr>
                                                    <td>{{$item}}</td>
                                                    @foreach($permission as $permissions)
                                                     @if($permissions->type == $item)
                                                        <td>
                                                            <div class="controls">
                                                                <div class="custom-control custom-checkbox ml-50"><input type="checkbox" name="permission[]" value="{{$permissions->id}}" id="users-checkbox{{$permissions->id}}" class="custom-control-input"  data-validation-required-message="This field is required"  required>
                                                                    <label class="custom-control-label" for="users-checkbox{{$permissions->id}}">{{$permissions->display_name}}</label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @endif

                                                    @endforeach
                                                </tr>
                                                @endforeach
                                              @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
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
    <!-- <script src="{{ asset('assets/js/countrystatecity.js?v2') }}"></script> -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-149371669-1"></script>
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyDMzBtl2TKTecLe_NEmSup5U-nkj93Ch7o"></script>
    <link rel="stylesheet" href="{{ asset('app-assets/css/toastr.min.css') }}" />

    <script src="{{ asset('app-assets/js/waitMe.js') }}"></script>
    <script src="{{ asset('app-assets/js/toastr.min.js') }}"></script>

    <script>
        var loadFile = function(event) {
            var image = document.getElementById('output');
            image.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>

    <script type="text/javascript">
        var APP_URL = {!! json_encode(url('/')) !!}
    </script>
@endsection
