@extends('admin.index')
@section('content')

<form action="{{ route('admin.divisions.update', $division->id) }}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{$division->id}}">
    <div class="card">
        <div class="border-bottom card-header">
            <h4 class="card-title">{{ trans('general.create_division') }}</h4>
        </div>
        <div class="card-body">
            <div class="row pt-2">
            <div class="col-lg-3 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="title">{{ trans('general.title') }}</label>
                        <input required type="text" name="title" class="form-control" id="title" value="{{old('title')? old('title') : $division->title}}">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="code">{{ trans('general.code') }}</label>
                        <input required name="code" id="code" class="form-control" value="{{old('code')? old('code') : $division->code}}">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="capacity">{{ trans('general.capacity') }}</label>
                        <input required name="capacity" id="capacity" class="form-control" value="{{old('capacity')? old('capacity') : $division->capacity}}">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="levelSelect">{{ trans('general.level') }}</label>
                        <select name="level_id" class="form-select" id="levelSelect">
                            <option value="">--</option>
                            @foreach($levels as $level)
                            <option value="{{ $level->id }}" {{ old('level_id')? ($level->id == old('level_id')? 'selected':'') : (($level->id == $division->level_id)? 'selected':'')}}>{{ $level->title }}</option>
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

@endpush

@push('header')


@endpush
@endsection