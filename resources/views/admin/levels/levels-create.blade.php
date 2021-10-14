@extends('admin.index')
@section('content')

<form action="{{ route('admin.levels.create') }}" method="post">
    @csrf
    <div class="card">
        <div class="border-bottom card-header">
            <h4 class="card-title">{{ trans('general.create_level') }}</h4>
        </div>
        <div class="card-body">
            <div class="row pt-2">
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="title">{{ trans('general.title') }}</label>
                        <input required type="text" name="title" class="form-control" id="title" value="{{old('title')? old('title') : ''}}">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="code">{{ trans('general.code') }}</label>
                        <input required name="code" id="code" class="form-control" value="{{old('code')? old('code') : ''}}">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="stageSelect">{{ trans('general.stage') }}</label>
                        <select required name="stage" onchange="stageLevels(this.value)" class="form-select" id="stageSelect">
                            <option value="">--</option>
                            @foreach($stages as $stage)
                            <option value="{{ $stage->id }}" {{ old('stage')? ($stage->id == old('stage')? 'selected':'') : ''}}>{{ $stage->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="levelSelect">{{ trans('general.prev-level') }}</label>
                        <select required name="parent" class="form-select" id="levelSelect">
                            <option value="">--</option>

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

<script>
    function stageLevels(stage_id) {
        var jqxhr = $.ajax({
                url: "{{route('admin.stage.levels.all')}}",
                method: "GET",
                timeout: 0,
                data: {
                    stage_id: stage_id
                }
            })
            .done(function(response) {
                setLevelsOptions(response.data);
                console.log(response);
            })
            .fail(function(response) {
                console.log(response);
                setLevelsOptions([]);
                toastr.error(response.responseJSON.msg, 'خطأ');
            });
    }

    function setLevelsOptions(data) {
        var levelSelect = $('#levelSelect');
        levelSelect.html('');
        levelSelect.append($('<option>', {
            value: '',
            text: '--'
        }));
        $.each(data, function(index, val) {
            levelSelect.append($('<option>', {
                value: val.id,
                text: val.title +'  '+ val.code
            }));
        });
    }
</script>

@endpush

@push('header')


@endpush
@endsection