@extends('admin.index')
@section('content')

<form action="{{ route('admin.semesters.update', $semester->id) }}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{$semester->id}}">
    <div class="card">
        <div class="border-bottom card-header">
            <h4 class="card-title">{{ trans('general.create_semester') }}</h4>
        </div>
        <div class="card-body">
        <div class="row pt-2">
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="title">{{ trans('general.title') }}</label>
                        <input required type="text" name="title" class="form-control" id="title" value="{{old('title')? old('title') :  $semester->title }}">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="code">{{ trans('general.code') }}</label>
                        <input required name="code" id="code" class="form-control" value="{{old('code')? old('code') :  $semester->code }}">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <label class="form-label" for="start_date">{{ trans('general.start_date') }}</label>
                    <input required type="text" id="start_date" class="form-control flatpickr-basic" name="start_date" value="{{ $semester->start_date }}"/>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <label class="form-label" for="end_date">{{ trans('general.end_date') }}</label>
                    <input required type="text" id="end_date" class="form-control flatpickr-basic" name="end_date" value="{{ $semester->end_date }}"/>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="academicYear">{{ trans('general.academic_year') }}</label>
                        <select required name="academic_year_id" class="form-select" id="academicYear">
                            <option value="">--</option>
                            @foreach($academicYears as $year)
                            <option value="{{ $year->id }}" {{ old('year')? ($year->id == old('year')? 'selected':'') :  ($year->id == $semester->academic_year_id? 'selected':'')}}>{{ $year->title }}</option>
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