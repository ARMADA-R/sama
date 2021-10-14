@extends('admin.index')
@section('content')

<div class="card">
    <div class="border-bottom card-header">
        <h4 class="card-title">{{ trans('general.create_headmasters_account') }}</h4>
    </div>

    <form action="{{ route('admin.headmasters.create') }}" method="post">
        @csrf
        <div class="card-body">
            <div class="row pt-2">
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="fname">{{ trans('general.First Name') }}</label>
                        <input required type="text" name="firstName" class="form-control" id="fname" value="{{old('firstName')? old('firstName') : ''}}">
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="lname">{{ trans('general.Last Name') }}</label>
                        <input required type="text" name="lastName" class="form-control" id="lname" value="{{old('lastName')? old('lastName') : ''}}">
                    </div>
                </div>
               
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="phone">{{ trans('general.phone') }}</label>
                        <input required type="text" name="phone" class="form-control" id="phone"  value="{{old('phone')? old('phone') : ''}}">
                    </div>
                </div>
               
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="email">{{ trans('general.Email') }}</label>
                        <input required type="text" name="email" class="form-control" id="email"  value="{{old('email')? old('email') : ''}}">
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="username">{{ trans('general.Username') }}</label>
                        <input required type="text" name="username" class="form-control" id="username" value="{{old('username')? old('username') : ''}}">
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="password">{{ trans('general.Password') }}</label>
                        <input required type="text" name="password" class="form-control" id="password">
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