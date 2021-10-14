@extends('admin.index')
@section('content')

<div class="card">
    <div class="border-bottom card-header">
        <h4 class="card-title">{{ trans('general.update_parent_info') }}</h4>
    </div>

    <form action="{{ route('admin.parents.update', $parent->id) }}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{$parent->id}}">
        <div class="card-body">
            <div class="row pt-2">

                <div class="col-xl-4 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="fname">{{ trans('general.First Name') }}</label>
                        <input required type="text" name="firstName" class="form-control" id="fname" placeholder="Nour" value="{{old('firstName')? old('firstName') : ($parent->first_name)}}">
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="lname">{{ trans('general.Last Name') }}</label>
                        <input required type="text" name="lastName" class="form-control" id="lname" placeholder="Yaseen" value="{{old('lastName')? old('lastName') : ($parent->last_name)}}">
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="job">{{ trans('general.job') }}</label>
                        <input required type="text" name="job" class="form-control" id="job" value="{{old('job')? old('job') : ($parent->job)}}">
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="phone">{{ trans('general.phone') }}</label>
                        <input required type="text" name="phone" class="form-control" id="phone" value="{{old('phone')? old('phone') : ($parent->phone)}}">
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="genderSelect">{{ trans('general.gender') }}</label>
                        <select required name="gender" class="form-select" id="genderSelect">
                            <option value="">--</option>
                            <option value="male" {{ old('gender')? ('male' == old('gender')? 'selected':'') : ('male' == $parent->gender? 'selected':'')}}>{{ trans('general.male') }}</option>
                            <option value="female" {{ old('gender')? ('female' == old('gender')? 'selected':'') : ('female' == $parent->gender? 'selected':'')}}>{{ trans('general.female') }}</option>
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
        <h4 class="card-title">{{ trans('general.update_parent_account') }}</h4>
    </div>

    <form action="{{ route('admin.parents.acc.update', $parent->id) }}" method="post">
        @csrf
        @if(isset($parentAccount))
        <input type="hidden" name="id" value="{{$parentAccount->id}}">

        <div class="card-body">
            <div class="row pt-2">
                <div class="col-xxl-2 col-xl-4 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="email">{{ trans('general.Email') }}</label>
                        <input disabled required type="text" name="email" class="form-control" id="email" value="{{$parentAccount->email}}">
                    </div>
                </div>
                <div class="col-xxl-2 col-xl-6 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="username">{{ trans('general.Username') }}</label>
                        <input disabled required type="text" name="username" class="form-control" id="username" value="{{$parentAccount->username}}">
                    </div>
                </div>
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
        @else
        <div class="card-body">
            <div class="row p-4 text-center">
                <h3 class="text-danger">
                    {{trans('general.parent_dont_have_account')}}
                </h3>
            </div>
        </div>
        @endif
    </form>
</div>


@push('scripts')



@endpush

@push('header')


@endpush
@endsection