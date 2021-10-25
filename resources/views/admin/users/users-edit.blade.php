@extends('admin.index')
@section('content')

@if($user->settings)
<?php
$userSettings = json_decode($user->settings, true);
?>

@else
<?php
$userSettings = json_decode('{}', true);
?>
@endif
<div class="card">
    <div class="border-bottom card-header">
        <h4 class="card-title">{{ trans('general.users.Edit Account') }}</h4>
    </div>

    <form action="{{ route('admin.users.update', $user->id) }}" method="post">
        @csrf
        <div class="card-body">
            <div class="row pt-2">
                <div class="col-xxl-3 col-xl-4 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="fname">{{ trans('general.First Name') }}</label>
                        <input required type="text" name="firstName" class="form-control" id="fname" placeholder="Nour" value="{{old('firstName')? old('firstName') : $user->first_name}}">
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="lname">{{ trans('general.Last Name') }}</label>
                        <input required type="text" name="lastName" class="form-control" id="lname" placeholder="Yaseen" value="{{old('lastName')? old('lastName') : $user->last_name}}">
                    </div>
                </div>
                <div class="col-xxl-2 col-xl-4 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="email">{{ trans('general.Email') }}</label>
                        <input disabled required type="text" name="email" class="form-control" id="email" placeholder="nob@gmail.com" value="{{old('email')? old('email') : $user->email}}">
                    </div>
                </div>
                <div class="col-xxl-2 col-xl-6 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="username">{{ trans('general.Username') }}</label>
                        <input disabled required type="text" name="username" class="form-control" id="username" placeholder="no_shd" value="{{old('username')? old('username') : $user->username}}">
                    </div>
                </div>

                <div class="col-xxl-2 col-xl-6 col-md col-12">
                    <div class="mb-1">
                        <label class="form-label" for="roleSelect">{{ trans('general.Role') }}</label>
                        <select required name="role" class="form-select" id="roleSelect">
                            <option value="">--</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role')? ($role->id == old('role')? 'selected':'') : ($user->role_id == $role->id? 'selected' : '' )}}>{{ $role->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary waves-effect waves-float waves-light">{{ trans('general.save') }}</button>
            <button type="reset" class="btn btn-outline-secondary waves-effect">{{ trans('general.reset') }}</button>
        </div>
    </form>
</div>


<div class="card">
    <div class="border-bottom card-header">
        <h4 class="card-title">{{ trans('general.Change Password') }}</h4>
    </div>

    <form action="{{ route('admin.users.update.password', $user->id) }}" method="post">
        @csrf
        <div class="card-body">
            <div class="row pt-2">
                <div class="col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="password">{{ trans('general.New Password') }}</label>
                        <input required type="text" name="password" class="form-control" id="password">
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="confirm-password">{{ trans('general.Confirm your new password') }}</label>
                        <input required type="text" name="password_confirmation" class="form-control" id="confirm-password">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary waves-effect waves-float waves-light">{{ trans('general.save') }}</button>
            <button type="reset" class="btn btn-outline-secondary waves-effect">{{ trans('general.reset') }}</button>
        </div>
    </form>
</div>


<section id="responsive-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">{{ trans("general.user_permission") }}</h4>
                    <button class="btn btn-outline-primary waves-effect" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal" data-bs-target="#addPermissionModal">
                        <span>{{ trans("general.add") }}</span>
                    </button>
                    <!-- <a href="{{ route('admin.users.create') }}" class="btn btn-outline-primary waves-effect">{{ trans("general.add") }}</a> -->
                </div>
                <div class="card-datatable">
                    {{ $dataTable->table([
                    "class" => "dt-responsive table",
                    "style" => ""
                        ])
                    }}
                </div>
            </div>
        </div>
    </div>
</section>


<div class="card">
    <div class="border-bottom card-header">
        <h4 class="card-title">{{ trans('general.Account Status') }}</h4>
        @if(!empty($userSettings))
        @if($userSettings['status'] == 1)
        <button type="" disabled class="btn btn-success deactivate-account">{{ trans("general.Activated Account") }}</button>
        @else
        <button type="" disabled class="btn btn-danger deactivate-account">{{ trans("general.Deactivated Account") }}</button>
        @endif
        @else
        <button type="" disabled class="btn btn-success deactivate-account">{{ trans("general.Activated Account") }}</button>
        @endif
    </div>

    <form action="{{ route('admin.users.update.status', $user->id) }}" onsubmit="if(confirm(`{{ trans('general.Confirm Change Account Status') }}`)){return true;} return false;" method="post">
        @csrf
        <div class="card-body">
            <div class="row ">
                <div class=" col-12">
                    <div class="mb-1 d-grid">
                        @if(!empty($userSettings))
                        @if($userSettings['status'] == 0)
                        <input required type="hidden" name="status" class="form-control" value="1" id="status">
                        <button type="submit" class="btn btn-success deactivate-account">{{ trans("general.Activate Account") }}</button>
                        @else
                        <input required type="hidden" name="status" class="form-control" value="0" id="status">
                        <button type="submit" class="btn btn-danger deactivate-account">{{ trans("general.Deactivate Account") }}</button>
                        @endif
                        @else
                        <input required type="hidden" name="status" class="form-control" value="0" id="status">
                        <button type="submit" class="btn btn-danger deactivate-account">{{ trans("general.Deactivate Account") }}</button>
                        @endif

                    </div>
                </div>
            </div>
        </div>

    </form>
</div>

<!-- Add Permission Modal -->
<div class="modal fade" id="addPermissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 pb-5">
                <div class="text-center mb-2">
                    <h1 class="mb-1">Add New Permission</h1>
                    <p>Permissions you may use and assign to your users.</p>
                </div>
                <form id="addPermissionForm" class="row" onsubmit="return false">
                    <div class="col-12">
                        <label class="form-label" for="modalPermissionName">Permission Name</label>
                        <input type="text" id="modalPermissionName" name="modalPermissionName" class="form-control" placeholder="Permission Name" autofocus data-msg="Please enter permission name" />
                    </div>
                    <div class="col-12 mt-75">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="corePermission" />
                            <label class="form-check-label" for="corePermission"> Set as core permission </label>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary mt-2 me-1">Create Permission</button>
                        <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal" aria-label="Close">
                            Discard
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Add Permission Modal -->
<!-- Edit Permission Modal -->
<div class="modal fade" id="editPermissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 pt-0">
                <div class="text-center mb-2">
                    <h1 class="mb-1">Edit Permission</h1>
                    <p>Edit permission as per your requirements.</p>
                </div>

                <div class="alert alert-warning" role="alert">
                    <h6 class="alert-heading">Warning!</h6>
                    <div class="alert-body">
                        By editing the permission name, you might break the system permissions functionality. Please ensure you're
                        absolutely certain before proceeding.
                    </div>
                </div>

                <form id="editPermissionForm" class="row" onsubmit="return false">
                    <div class="col-sm-9">
                        <label class="form-label" for="editPermissionName">Permission Name</label>
                        <input type="text" id="editPermissionName" name="editPermissionName" class="form-control" placeholder="Enter a permission name" tabindex="-1" data-msg="Please enter permission name" />
                    </div>
                    <div class="col-sm-3 ps-sm-0">
                        <button type="submit" class="btn btn-primary mt-2">Update</button>
                    </div>
                    <div class="col-12 mt-75">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="editCorePermission" />
                            <label class="form-check-label" for="editCorePermission"> Set as core permission </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Edit Permission Modal -->


@push('scripts')


<script src="{{ url('design') }}/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
<script src="{{ url('design') }}/app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js"></script>
<script src="{{ url('design') }}/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
<script src="{{ url('design') }}/app-assets/vendors/js/tables/datatable/responsive.bootstrap5.js"></script>
{!! $dataTable->scripts() !!}

@endpush

@push('header')


<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/vendors/css/vendors-rtl.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
<!-- END: Vendor CSS-->

<!-- BEGIN: Theme CSS-->
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/css-rtl/bootstrap.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/css-rtl/bootstrap-extended.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/css-rtl/colors.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/css-rtl/components.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/css-rtl/themes/dark-layout.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/css-rtl/themes/bordered-layout.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/css-rtl/themes/semi-dark-layout.css">

<!-- BEGIN: Custom CSS-->
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/css-rtl/custom-rtl.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/assets/css/style-rtl.css">
<!-- END: Custom CSS-->
@endpush
@endsection