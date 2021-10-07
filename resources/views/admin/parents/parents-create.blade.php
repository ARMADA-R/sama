@extends('admin.index')
@section('content')

<div class="card">
    <div class="border-bottom card-header">
        <h4 class="card-title">{{ trans('general.add_parent') }}</h4>
    </div>

    <form action="{{ route('admin.parents.create') }}" method="post">
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
                        <label class="form-label" for="job">{{ trans('general.job') }}</label>
                        <input required type="text" name="job" class="form-control" id="job" value="{{old('job')? old('job') : ''}}">
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="phone">{{ trans('general.phone') }}</label>
                        <input required type="text" name="phone" class="form-control" id="phone" value="{{old('phone')? old('phone') : ''}}">
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