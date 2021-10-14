@extends('admin.index')
@section('content')

<form action="{{ route('admin.stages.create') }}" method="post">
    @csrf
    <div class="card">
        <div class="border-bottom card-header">
            <h4 class="card-title">{{ trans('general.create_stage') }}</h4>
        </div>
        <div class="card-body">
            <div class="row pt-2">
                <div class="col-sm-6">
                    <div class="mb-1">
                        <label class="form-label" for="title">{{ trans('general.title') }}</label>
                        <input required type="text" name="title" class="form-control" id="title" value="{{old('title')? old('title') : ''}}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-1">
                        <label class="form-label" for="code">{{ trans('general.code') }}</label>
                        <input required name="code" id="code" class="form-control" value="{{old('code')? old('code') : ''}}">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary waves-effect waves-float waves-light">{{ trans('general.save') }}</button>
            <button type="reset" class="btn btn-outline-secondary waves-effect">{{ trans('general.reset') }}</button>
        </div>
    </div>

</form>

@push('scripts')


@endpush

@push('header')


@endpush
@endsection