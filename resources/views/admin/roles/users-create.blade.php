@extends('admin.index')
@section('content')

<div class="card">
    <div class="border-bottom card-header">
        <h4 class="card-title">{{ trans('general.users.Create Account') }}</h4>
    </div>

    <form action="{{ route('admin.users.create') }}" method="post">
        @csrf
        <div class="card-body">
            <div class="row pt-2">
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="fname">{{ trans('general.First Name') }}</label>
                        <input required type="text" name="firstName" class="form-control" id="fname" placeholder="Nour" value="{{old('firstName')? old('firstName') : ''}}">
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="lname">{{ trans('general.Last Name') }}</label>
                        <input required type="text" name="lastName" class="form-control" id="lname" placeholder="Yaseen" value="{{old('lastName')? old('lastName') : ''}}">
                    </div>
                </div>
               
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="email">{{ trans('general.Email') }}</label>
                        <input required type="text" name="email" class="form-control" id="email" placeholder="nob@gmail.com" value="{{old('email')? old('email') : ''}}">
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="username">{{ trans('general.Username') }}</label>
                        <input required type="text" name="username" class="form-control" id="username" placeholder="no_shd" value="{{old('username')? old('username') : ''}}">
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="password">{{ trans('general.Password') }}</label>
                        <input required type="text" name="password" class="form-control" id="password">
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="confirm-password">{{ trans('general.Confirm Password') }}</label>
                        <input required type="text" name="password_confirmation" class="form-control" id="confirm-password">
                    </div>
                </div>
                <div class="col-xl-4 col-md col-12">
                    <div class="mb-1">
                        <label class="form-label" for="roleSelect">{{ trans('general.Role') }}</label>
                        <select required name="role" class="form-select" id="roleSelect" >
                            <option value="">--</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role')? ($role->id == old('role')? 'selected':'') : ''}}>{{ $role->title }}</option>
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


@push('scripts')



@endpush

@push('header')


@endpush
@endsection