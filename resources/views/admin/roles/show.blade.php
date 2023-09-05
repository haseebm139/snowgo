@extends('admin.layouts.master')
@section('title')
   Roles and Permission
@endsection
@section('page_css')
    <link rel="stylesheet" href="{{ mix('assets/css/services/services.css') }}">
@endsection
@section('css')
    @livewireStyles
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Roles and Permission</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="{{route('roles.create')}}" class="btn btn-primary">Add <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
					<div class="content">



                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Name:</strong>
                                {{ $role->display_name??'N/A' }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Permissions:</strong>
                                <div class="row gy-2">
                                @if(!empty($rolePermissions))
                                    @foreach($rolePermissions as $v)
                                    <div class="col-lg-4">
                                        <label class="label label-success">{{ $v->display_name }}</label>
                                        </div>
                                    @endforeach
                                @else
                                <p>N/A</p>
                                @endif
                                </div>

                            </div>
                        </div>

						</div>
					</div>
				</div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')

@endsection
