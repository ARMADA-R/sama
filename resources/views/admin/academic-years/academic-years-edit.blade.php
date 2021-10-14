@extends('admin.index')
@section('content')

<form action="{{ route('admin.academicYears.update', $academicYear->id) }}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{$academicYear->id}}">
    <div class="card">
        <div class="border-bottom card-header">
            <h4 class="card-title">{{ trans('general.update_academic_year') }}</h4>
        </div>
        <div class="card-body">
            <div class="row pt-2">
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="title">{{ trans('general.title') }}</label>
                        <input required type="text" name="title" class="form-control" id="title" value="{{old('title')? old('title') :  $academicYear->title }}">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="code">{{ trans('general.code') }}</label>
                        <input required name="code" id="code" class="form-control" value="{{old('code')? old('code') :  $academicYear->code }}">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <label class="form-label" for="start_date">{{ trans('general.start_date') }}</label>
                    <input required type="text" id="start_date" class="form-control flatpickr-basic" name="start_date" value="{{ $academicYear->start_date }}" />
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <label class="form-label" for="end_date">{{ trans('general.end_date') }}</label>
                    <input required type="text" id="end_date" class="form-control flatpickr-basic" name="end_date" value="{{ $academicYear->end_date }}" />
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
<script src="{{ url('design') }}/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
<script>
    (function(window, document, $) {
        'use strict';
        var basicPickr = $('.flatpickr-basic');

        // Default
        if (basicPickr.length) {
            basicPickr.flatpickr();
        }
    })(window, document, jQuery);
</script>
@endpush

@push('header')

<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">

@endpush
@endsection