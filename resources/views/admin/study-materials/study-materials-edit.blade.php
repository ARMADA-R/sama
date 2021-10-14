@extends('admin.index')
@section('content')

<form action="{{ route('admin.studyMaterials.update', $studyMaterial->id) }}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{$studyMaterial->id}}">
    <div class="card">
        <div class="border-bottom card-header">
            <h4 class="card-title">{{ trans('general.update_studyMaterial') }}</h4>
        </div>
        <div class="card-body">
            <div class="row pt-2">
                <div class=" col-md-6 col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1">
                                <label class="form-label" for="title">{{ trans('general.title') }}</label>
                                <input required type="text" name="title" class="form-control" id="title" value="{{old('title')? old('title') : $studyMaterial->title}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="mb-1">
                                <label class="form-label" for="min_grade">{{ trans('general.min_grade') }}</label>
                                <input required type="number" name="min_grade" id="min_grade" class="form-control" value="{{old('min_grade')? old('min_grade') : $studyMaterial->min_grade}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="mb-1">
                                <label class="form-label" for="max_grade">{{ trans('general.max_grade') }}</label>
                                <input required type="number" name="max_grade" id="max_grade" class="form-control" value="{{old('max_grade')? old('max_grade') : $studyMaterial->max_grade}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" col-md-6 col-12">
                    <div class="mb-1">
                        <label required class="form-label" for="description">{{ trans('general.description') }}</label>
                        <textarea name="description" class="form-control" id="description" rows="4">{{$studyMaterial->description}}</textarea>
                    </div>
                </div>

                <div class="col-md-4 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="stageSelect">{{ trans('general.stage') }}</label>
                        <select required name="stage" onchange="stageLevels(this.value)" class="form-select" id="stageSelect">
                            <option value="">--</option>
                            @foreach($stages as $stage)
                            <option value="{{ $stage->id }}" {{ old('stage')? ($stage->id == old('stage')? 'selected':'') : ($stage->id == $currentLevel->stage_id? 'selected':'')}}>{{ $stage->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="levelSelect">{{ trans('general.level') }}</label>
                        <select required name="level_id" class="form-select" id="levelSelect">
                            <option value="">--</option>
                            @foreach($levels as $level)
                            <option value="{{ $level->id }}" {{ old('level')? ($level->id == old('level')? 'selected':'') : ($level->id == $currentLevel->id? 'selected':'')}}>{{ $level->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="attachments">{{ trans('general.attachments') }}</label>
                        <input type="file" name="attachments" id="attachments" class="form-control" value="{{old('attachments')? old('attachments') : ''}}">

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
                text: val.title + '  ' + val.code
            }));
        });
    }
</script>
@endpush

@push('header')


@endpush
@endsection