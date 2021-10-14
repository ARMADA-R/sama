@extends('admin.index')
@section('content')

<form action="{{ route('admin.stages.update', $stage->id) }}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{$stage->id}}">
    <div class="card">
        <div class="border-bottom card-header">
            <h4 class="card-title">{{ trans('general.update_stage') }}</h4>
        </div>
        <div class="card-body">
            <div class="row pt-2">
                <div class="col-sm-4">
                    <div class="mb-1">
                        <label class="form-label" for="title">{{ trans('general.title') }}</label>
                        <input required type="text" name="title" class="form-control" id="title" value="{{old('title')? old('title') : $stage->title}}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-1">
                        <label class="form-label" for="code">{{ trans('general.code') }}</label>
                        <input required name="code" id="code" class="form-control" value="{{old('code')? old('code') : $stage->code}}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-1">
                        <label class="form-label" for="headmaster">{{ trans('general.headmaster') }}</label>
                        <select name="headmaster" class="form-select" id="headmaster">
                            <option value="">--</option>
                            @foreach($headmasters as $headmaster)
                            <option value="{{ $headmaster->id }}" {{ old('headmaster')? ($headmaster->id == old('headmaster')? 'selected':'') : ($headmaster->id == $stage->headmaster_id? 'selected':'') }}>{{ $headmaster->first_name .' '. $headmaster->last_name }}</option>
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