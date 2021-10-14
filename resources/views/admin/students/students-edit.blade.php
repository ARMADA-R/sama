@extends('admin.index')
@section('content')

<div class="card">
    <div class="border-bottom card-header">
        <h4 class="card-title">{{ trans('general.edit_student_info') }}</h4>

    </div>
</div>
<form action="{{ route('admin.students.update.student', $student->student_id) }}" method="post" onsubmit="updateStudent(this); return false;">
    @csrf
    <input type="hidden" name="student_id" value="{{$student->student_id}}">
    <div class="card">
        <div id="update-student-overlay" class="card-overlay">
            <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                <div class="spinner-border" style="width: 3rem; height: 3rem" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        <div class="border-bottom card-header">
            <h4 class="card-title">{{ trans('general.stduent_data') }}</h4>
        </div>


        <div class="card-body  mb-2">
            <div class="row pt-2">
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="fname">{{ trans('general.First Name') }}</label>
                        <input required type="text" name="firstName" class="form-control" id="fname" placeholder="Nour" value="{{old('firstName')? old('firstName') : $student->first_name}}">
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="lname">{{ trans('general.Last Name') }}</label>
                        <input required type="text" name="lastName" class="form-control" id="lname" placeholder="Yaseen" value="{{old('lastName')? old('lastName') : $student->last_name}}">
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="genderSelect">{{ trans('general.gender') }}</label>
                        <select required name="gender" class="form-select" id="genderSelect">
                            <option value="">--</option>
                            <option value="male" {{ old('gender')? ('male' == old('gender')? 'selected':'') : ('male' == $student->gender? 'selected':'')}}>{{ trans('general.male') }}</option>
                            <option value="female" {{ old('gender')? ('female' == old('gender')? 'selected':'') : ('female' == $student->gender? 'selected':'')}}>{{ trans('general.female') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-12">
                    <label class="form-label" for="select2-multiple">{{ trans('general.nationality') }}</label>
                    <select required name="nationality" class="select2 form-select" id="select2-multiple" multiple>
                        <option value="" disabled>--</option>
                        @foreach($nationalities as $nationality)
                        <option value="{{ $nationality->id }}" {{ old('nationality')? ($nationality->id == old('nationality')? 'selected':'') : (in_array($nationality->id, $studentNationalitiesIDs)? 'selected':'')}}>{{ $nationality->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="birth_place">{{ trans('general.birth_place') }}</label>
                        <input required type="text" name="birth_place" class="form-control" id="birth_place" value="{{old('birth_place')? old('birth_place') : $student->birth_place}}">
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="birth_date">{{ trans('general.birth_date') }}</label>
                        <input type="text" name="birth_date" id="birth_date" class="form-control flatpickr-basic" value="{{old('birth_date')? old('birth_date') : $student->birth_date}}" placeholder="YYYY-MM-DD" />
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="religion">{{ trans('general.religion') }}</label>
                        <select required name="religion" class="form-select" id="religion">
                            <option value="">--</option>
                            @foreach($religions as $religion)
                            <option value="{{ $religion->id }}" {{ old('religion')? ($religion->id == old('religion')? 'selected':'') : ($religion->id == $student->religion_id? 'selected':'')}}>{{ $religion->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="stage">{{ trans('general.stage') }}</label>
                        <select required name="stage" onchange="stageLevels(this.value)" class="form-select" id="stage">
                            <option value="">--</option>
                            @foreach($stages as $stage)
                            <option value="{{ $stage->id }}" {{ old('stage')? ($stage->id == old('stage')? 'selected':'') : ($stage->id == $currentStage->id? 'selected':'')}}>{{ $stage->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="level_to_study">{{ trans('general.level_to_study') }}</label>
                        <select required name="level_to_study" class="form-select" id="level_to_study">
                            <option value="">--</option>
                            @foreach($levels as $level)
                            <option value="{{ $level->id }}" {{ old('level_to_study')? ($level->id == old('level_to_study')? 'selected':'') : ($level->id == $student->level_id? 'selected':'')}}>{{ $level->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="phone">{{ trans('general.phone') }}</label>
                        <input required type="text" name="phone" class="form-control" id="phone" value="{{old('phone')? old('phone') : $student->phone}}">
                    </div>
                </div>
                <div class="col-xl col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="telephone">{{ trans('general.telephone') }}</label>
                        <input required type="text" name="telephone" class="form-control" id="telephone" value="{{old('telephone')? old('telephone') : $student->telephone}}">
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
<div class="card">
    <div class="border-bottom card-header">
        <h4 class="card-title">{{ trans('general.student_parents_info') }}</h4>
    </div>
</div>
<div class="card">
    <form action="{{ route('admin.students.update.mother', $student->student_id) }}" method="post" onsubmit="updateMother(this); return false;">
        @csrf
        <input type="hidden" name="student_id" value="{{$student->student_id}}">
        <!-- <hr class="mb-0"> -->
        <div id="update-mother-overlay" class="card-overlay">
            <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                <div class="spinner-border" style="width: 3rem; height: 3rem" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        <div class="border-bottom card-header justify-content-center">
            <h4 class="card-title">{{ trans('general.mother') }}</h4>
        </div>
        <div class="demo-inline-spacing justify-content-around">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="editMotherType" id="current-mother-account" value="0" {{ old('editMotherType')? ('0' == old('editMotherType')? 'checked':'') : 'checked'}}>
                <label class="form-check-label" for="current-mother-account">الحساب الحالي</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="editMotherType" id="exist-mother-account" value="1" {{ old('editMotherType')? ('1' == old('editMotherType')? 'checked':'') : ''}}>
                <label class="form-check-label" for="exist-mother-account">ربط بحساب آخر</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="editMotherType" id="new-mother-account" value="2" {{ old('editMotherType')? ('1' == old('editMotherType')? 'checked':'') : ''}}>
                <label class="form-check-label" for="new-mother-account">حساب جديد</label>
            </div>

        </div>
        <div class="card-body">
            <div id="mother-search-input" style="display: none;">
                <input class="form-control input" oninput="getMothersSuggestions(this)" type="text" placeholder="بحث: الاسم او رقم الجوال">
                <div class="text-center  overlay-light p-2" style="display: none;" id="mothers-suggestions-spinner">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div id="mother-search-list" class="list-group hide-scrollbars" style="max-height: 200px; overflow-y: auto;">

                </div>
            </div>


            <div class="row pt-2">
                <input type="hidden" name="mother_id" id="mother_id" value="{{old('mother_id')? old('mother_id') : $student->mother_id}}">
                <div class="col-xxl-3 col-xl-3 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="mother_fname">{{ trans('general.First Name') }}</label>
                        <input required type="text" name="mother_firstName" class="form-control" id="mother_fname" value="{{old('mother_firstName')? old('mother_firstName') : $mother->first_name}}">
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="mother_lname">{{ trans('general.Last Name') }}</label>
                        <input required type="text" name="mother_lastName" class="form-control" id="mother_lname" value="{{old('mother_lastName')? old('mother_lastName') : $mother->last_name}}">
                    </div>
                </div>

                <div class="col-xxl-3 col-xl-3 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="mother_job">{{ trans('general.job') }}</label>
                        <input required type="text" name="mother_job" class="form-control" id="mother_job" value="{{old('mother_job')? old('mother_job') : $mother->job}}">
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="mother_phone">{{ trans('general.phone') }}</label>
                        <input required type="text" name="mother_phone" class="form-control" id="mother_phone" value="{{old('mother_phone')? old('mother_phone') : $mother->phone}}">
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
    <form action="{{ route('admin.students.update.father', $student->student_id) }}" method="post" onsubmit="updateFather(this); return false;">
        @csrf
        <input type="hidden" name="student_id" value="{{$student->student_id}}">
        <div id="update-father-overlay" class="card-overlay">
            <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                <div class="spinner-border" style="width: 3rem; height: 3rem" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        <div class="border-bottom card-header justify-content-center">
            <h4 class="card-title">{{ trans('general.father') }}</h4>
        </div>
        <div class="demo-inline-spacing justify-content-around">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="editFatherType" id="current-father-account" value="0" {{ old('editFatherType')? ('0' == old('editFatherType')? 'checked':'') : 'checked'}}>
                <label class="form-check-label" for="current-father-account">الحساب الحالي</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="editFatherType" id="exist-father-account" value="1" {{ old('editFatherType')? ('0' == old('editFatherType')? 'checked':'') : ''}}>
                <label class="form-check-label" for="exist-father-account">ربط بحساب آخر</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="editFatherType" id="new-father-account" value="2" {{ old('editFatherType')? ('1' == old('editFatherType')? 'checked':'') : ''}}>
                <label class="form-check-label" for="new-father-account">حساب جديد</label>
            </div>

        </div>
        <div class="card-body mb-2">
            <div id="father-search-input" style="display: none;">
                <input class="form-control input" oninput="getFathersSuggestions(this)" type="text" placeholder="بحث: الاسم او رقم الجوال">

                <div class="text-center overlay-light p-2" style="display: none;" id="fathers-suggestions-spinner">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div id="father-search-list" class="list-group hide-scrollbars" style="max-height: 200px; overflow-y: auto;">

                </div>
            </div>
            <div class="row pt-2">
                <input type="hidden" name="father_id" id="father_id" value="{{old('father_id')? old('father_id') : $student->father_id}}">
                <div class="col-xxl-3 col-xl-3 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="father_fname">{{ trans('general.First Name') }}</label>
                        <input required type="text" name="father_firstName" class="form-control" id="father_fname" value="{{old('father_firstName')? old('father_firstName') : $father->first_name}}">
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="father_lname">{{ trans('general.Last Name') }}</label>
                        <input required type="text" name="father_lastName" class="form-control" id="father_lname" value="{{old('father_lastName')? old('father_lastName') : $father->last_name}}">
                    </div>
                </div>

                <div class="col-xxl-3 col-xl-3 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="father_job">{{ trans('general.job') }}</label>
                        <input required type="text" name="father_job" class="form-control" id="father_job" value="{{old('father_job')? old('father_job') : $father->job}}">
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="father_phone">{{ trans('general.phone') }}</label>
                        <input required type="text" name="father_phone" class="form-control" id="father_phone" value="{{old('father_phone')? old('father_phone') : $father->phone}}">
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

    <form action="{{ route('admin.students.update.addressTransEmergency', $student->student_id) }}" method="post" onsubmit="updateAddressTransEmergency(this); return false;">
        @csrf
        <input type="hidden" name="student_id" value="{{$student->student_id}}">
        <div id="update-addressTransEmergency-overlay" class="card-overlay">
            <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                <div class="spinner-border" style="width: 3rem; height: 3rem" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        <div class="border-bottom card-header">
            <h4 class="card-title">{{ trans('general.student_address_transportation') }}</h4>
        </div>

        <div class="row px-2">
            <div class="col-sm-4 col-12  mt-1">
                {{ trans('general.transportation') }}
            </div>
            <div class="col-sm-4 col-6  mt-1 text-nowrap">
                <input class="form-check-input" type="radio" name="transportation" id="trans-subscriber" value="1" {{ old('transportation')? ('1' == old('transportation')? 'checked':'') : ($student->transportation != null)? 'checked': ''}}>
                <label class="form-check-label" for="trans-subscriber">{{trans("general.subscriber")}}</label>
            </div>
            <div class="col-sm-4 col-6  mt-1 text-nowrap">
                <input class="form-check-input" type="radio" name="transportation" id="trans-non-subscriber" value="0" {{ old('transportation')? ('0' == old('transportation')? 'checked':'') : $student->transportation??'checked'}}>
                <label class="form-check-label" for="trans-non-subscriber">{{trans("general.non-subscriber")}}</label>
            </div>
        </div>

        <hr>
        <div class="border-bottom card-header">
            <h4 class="card-title">{{ trans('general.address') }}</h4>
        </div>

        <div class="card-body">

            <div class="row pt-2">
                <div class="col-xl-6 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="city">{{ trans('general.city') }}</label>
                        <select required name="city" class="form-select" id="city">
                            <option value="">--</option>
                            @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ old('city')? ($city->id == old('city')? 'selected':'') : ($city->id == $student->city_id? 'selected':'')}}>{{ $city->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="area">{{ trans('general.area') }}</label>
                        <input required type="text" name="area" class="form-control" id="area" value="{{old('area')? old('area') : $student->area}}">
                    </div>
                </div>

                <div class="col-12">
                    <div class="mb-1">
                        <label class="form-label" for="street">{{ trans('general.street') }}</label>
                        <textarea required name="street" id="street" class="form-control" rows="3">{{old('street')? old('street') : $student->street}}</textarea>
                    </div>
                </div>

            </div>

        </div>
        <hr>
        <div class="border-bottom card-header">
            <h4 class="card-title">{{ trans('general.emergency') }}</h4>
        </div>

        <div class="card-body mb-2">
            <div class="row pt-2">
                <div class="col-sm-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="emergency_phone">{{ trans('general.phone') }}</label>
                        <input required type="text" name="emergency_phone" class="form-control" id="emergency_phone" value="{{old('emergency_phone')? old('emergency_phone') : $student->emergency_phone}}">
                    </div>
                </div>
                <div class="col-sm-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="kinship">{{ trans('general.kinship') }}</label>
                        <input required type="text" name="kinship" class="form-control" id="kinship" value="{{old('kinship')? old('kinship') : $student->emergency_kinship}}">
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
<section class="form-control-repeater">
    <div class="row">
        <!-- school-sequence repeater -->
        <div class="col-12">
            <div class="card">
                <div id="update-sequence-overlay" class="card-overlay">
                    <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                        <div class="spinner-border" style="width: 3rem; height: 3rem" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <form action="{{ route('admin.students.update.sequence', $student->student_id) }}" method="post" onsubmit="updateSequence(this); return false;">
                    @csrf
                    <input type="hidden" name="student_id" value="{{$student->student_id}}">

                    <div class="card-header">
                        <h4 class="card-title">{{trans("general.school_sequence")}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="school-sequence-repeater">
                            <div data-repeater-list="school_sequence">
                                @if(count($schoolSequence))
                                @foreach($schoolSequence as $sequence)

                                <div data-repeater-item>
                                    <input type="hidden" name="sequence_id" value="{{$sequence->id}}">
                                    <div class="row d-flex align-items-end">
                                        <div class="col-md-2 col-12">
                                            <div class="mb-1">
                                                <label class="form-label">{{trans('general.class')}}</label>
                                                <select required name="level" class="form-select">
                                                    <option value="">--</option>
                                                    @foreach($levels as $level)
                                                    <option value="{{ $level->id }}" {{ old('level')? ($level->id == old('level')? 'selected':'') : ($level->id == $sequence->level_id? 'selected':'')}}>{{ $level->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="mb-1">
                                                <label class="form-label">{{trans("general.school_name")}}</label>
                                                <input required type="text" name="school_name" class="form-control" value="{{$sequence->school}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="mb-1">
                                                <label class="form-label">{{trans("general.year")}}</label>
                                                <input required type="text" name="year" class="form-control" value="{{$sequence->year}}" />
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <!-- button group radio -->
                                            <div class="btn-group mb-1 d-grid" role="group" aria-label="Basic radio toggle button group">
                                                <div class="row">
                                                    <div class="radio-elements col-6 d-grid">
                                                        <input required type="radio" class="btn-check" {{$sequence->status == 1? 'checked' : ''}} name="status" value="1" autocomplete="off">
                                                        <label class="btn btn-outline-success waves-effect text-truncate" onclick="checkNearest(this)">{{trans('general.passed')}}</label>
                                                    </div>
                                                    <div class="radio-elements col-6 d-grid">
                                                        <input required type="radio" class="btn-check" name="status" {{$sequence->status == 0? 'checked' : ''}} value="0" autocomplete="off">
                                                        <label class="btn btn-outline-danger waves-effect text-truncate" onclick="checkNearest(this)">{{trans('general.fail')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-1 col-12">
                                            <div class="mb-1">
                                                <button class="btn btn-outline-danger text-nowrap px-25 w-100" data-repeater-delete type="button">
                                                    <i data-feather="x"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                @endforeach
                                @else
                                <div data-repeater-item>
                                    <input type="hidden" name="sequence_id">
                                    <div class="row d-flex align-items-end">
                                        <div class="col-md-2 col-12">
                                            <div class="mb-1">
                                                <label class="form-label">{{trans('general.class')}}</label>
                                                <select required name="level" class="form-select">
                                                    <option value="">--</option>
                                                    @foreach($levels as $level)
                                                    <option value="{{ $level->id }}" {{ old('level')? ($level->id == old('level')? 'selected':'') : ''}}>{{ $level->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="mb-1">
                                                <label class="form-label">{{trans("general.school_name")}}</label>
                                                <input required type="text" name="school_name" class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="mb-1">
                                                <label class="form-label">{{trans("general.year")}}</label>
                                                <input required type="text" name="year" class="form-control"/>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <!-- button group radio -->
                                            <div class="btn-group mb-1 d-grid" role="group" aria-label="Basic radio toggle button group">
                                                <div class="row">
                                                    <div class="radio-elements col-6 d-grid">
                                                        <input required type="radio" class="btn-check" name="status" value="1" autocomplete="off">
                                                        <label class="btn btn-outline-success waves-effect text-truncate" onclick="checkNearest(this)">{{trans('general.passed')}}</label>
                                                    </div>
                                                    <div class="radio-elements col-6 d-grid">
                                                        <input required type="radio" class="btn-check" name="status" value="0" autocomplete="off">
                                                        <label class="btn btn-outline-danger waves-effect text-truncate" onclick="checkNearest(this)">{{trans('general.fail')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-1 col-12">
                                            <div class="mb-1">
                                                <button class="btn btn-outline-danger text-nowrap px-25 w-100" data-repeater-delete type="button">
                                                    <i data-feather="x"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <button type="submit" class="btn btn-primary waves-effect waves-float waves-light">{{ trans('general.save') }}</button>
                                    <button type="reset" class="btn btn-outline-secondary waves-effect">{{ trans('general.reset') }}</button>
                                </div>
                                <button type="button" class="btn btn-icon btn-primary" data-repeater-create>
                                    <i data-feather="plus" class="me-25"></i>
                                    <span>{{trans("general.add")}}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /school-sequence repeater -->
    </div>
</section>
<section class="form-control-repeater">
    <div class="row">
        <!-- school-sequence repeater -->
        <div class="col-12">
            <div class="card">
                <div id="update-languages-overlay" class="card-overlay">
                    <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                        <div class="spinner-border" style="width: 3rem; height: 3rem" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <form action="{{ route('admin.students.update.languages', $student->student_id) }}" method="post" onsubmit="updateLanguages(this); return false;">
                    @csrf
                    <input type="hidden" name="student_id" value="{{$student->student_id}}">
                    <div class="card-header">
                        <h4 class="card-title">{{trans("general.languages")}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="languages-repeater">
                            <div data-repeater-list="languages">
                                @if(count($studentLanguages))
                                @foreach($studentLanguages as $Slanguage)
                                <div data-repeater-item>
                                    <input type="hidden" name="student_lang_id" value="{{$Slanguage->id}}">
                                    <div class="row d-flex align-items-end">
                                        <div class="col-md-3 col-12">
                                            <div class="mb-1">
                                                <label class="form-label">{{trans('general.language')}}</label>
                                                <select required name="language" class="form-select">
                                                    <option value="">--</option>
                                                    @foreach($languages as $language)
                                                    <option value="{{ $language->id }}" {{ old('language')? ($language->id == old('language')? 'selected':'') : ($language->id == $Slanguage->language_id? 'selected':'')}}>{{ $language->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-8 col-12">
                                            <!-- button group radio -->
                                            <div class="btn-group mb-1 d-grid" role="group" aria-label="Basic radio toggle button group">
                                                <div class="row">
                                                    <div class="radio-elements col-3 d-grid">
                                                        <input required type="radio" class="btn-check" name="level" value="4" autocomplete="off" {{$Slanguage->level == 4? 'checked' : ''}}>
                                                        <label class="btn btn-outline-dark waves-effect text-truncate" onclick="checkNearest(this)">{{trans('general.very_good')}}</label>
                                                    </div>
                                                    <div class="radio-elements col-3 d-grid">
                                                        <input required type="radio" class="btn-check" name="level" value="3" autocomplete="off" {{$Slanguage->level == 3? 'checked' : ''}}>
                                                        <label class="btn btn-outline-success waves-effect text-truncate" onclick="checkNearest(this)">{{trans('general.good')}}</label>
                                                    </div>
                                                    <div class="radio-elements col-3 d-grid">
                                                        <input required type="radio" class="btn-check" name="level" value="2" autocomplete="off" {{$Slanguage->level == 2? 'checked' : ''}}>
                                                        <label class="btn btn-outline-warning waves-effect text-truncate" onclick="checkNearest(this)">{{trans('general.mid')}}</label>
                                                    </div>
                                                    <div class="radio-elements col-3 d-grid">
                                                        <input required type="radio" class="btn-check" name="level" value="1" autocomplete="off" {{$Slanguage->level == 1? 'checked' : ''}}>
                                                        <label class="btn btn-outline-danger waves-effect text-truncate" onclick="checkNearest(this)">{{trans('general.low')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-md-1 col-12">
                                            <div class="mb-1">
                                                <button class="btn btn-outline-danger text-nowrap px-25 w-100" data-repeater-delete type="button">
                                                    <i data-feather="x"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                @endforeach
                                @else
                                <div data-repeater-item>
                                    <input type="hidden" name="student_lang_id">
                                    <div class="row d-flex align-items-end">
                                        <div class="col-md-3 col-12">
                                            <div class="mb-1">
                                                <label class="form-label">{{trans('general.language')}}</label>
                                                <select required name="language" class="form-select">
                                                    <option value="">--</option>
                                                    @foreach($languages as $language)
                                                    <option value="{{ $language->id }}" {{ old('language')? ($language->id == old('language')? 'selected':'') : ''}}>{{ $language->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-8 col-12">
                                            <!-- button group radio -->
                                            <div class="btn-group mb-1 d-grid" role="group" aria-label="Basic radio toggle button group">
                                                <div class="row">
                                                    <div class="radio-elements col-3 d-grid">
                                                        <input required type="radio" class="btn-check" name="level" value="4" autocomplete="off">
                                                        <label class="btn btn-outline-dark waves-effect text-truncate" onclick="checkNearest(this)">{{trans('general.very_good')}}</label>
                                                    </div>
                                                    <div class="radio-elements col-3 d-grid">
                                                        <input required type="radio" class="btn-check" name="level" value="3" autocomplete="off">
                                                        <label class="btn btn-outline-success waves-effect text-truncate" onclick="checkNearest(this)">{{trans('general.good')}}</label>
                                                    </div>
                                                    <div class="radio-elements col-3 d-grid">
                                                        <input required type="radio" class="btn-check" name="level" value="2" autocomplete="off">
                                                        <label class="btn btn-outline-warning waves-effect text-truncate" onclick="checkNearest(this)">{{trans('general.mid')}}</label>
                                                    </div>
                                                    <div class="radio-elements col-3 d-grid">
                                                        <input required type="radio" class="btn-check" name="level" value="1" autocomplete="off">
                                                        <label class="btn btn-outline-danger waves-effect text-truncate" onclick="checkNearest(this)">{{trans('general.low')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-md-1 col-12">
                                            <div class="mb-1">
                                                <button class="btn btn-outline-danger text-nowrap px-25 w-100" data-repeater-delete type="button">
                                                    <i data-feather="x"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>

                                @endif
                            </div>

                            <div class="d-flex justify-content-between">
                                <div>
                                    <button type="submit" class="btn btn-primary waves-effect waves-float waves-light">{{ trans('general.save') }}</button>
                                    <button type="reset" class="btn btn-outline-secondary waves-effect">{{ trans('general.reset') }}</button>
                                </div>
                                <button type="button" class="btn btn-icon btn-primary" data-repeater-create>
                                    <i data-feather="plus" class="me-25"></i>
                                    <span>{{trans("general.add")}}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /school-sequence repeater -->
    </div>
</section>
<section class="form-control-repeater">
    <div class="row">
        <!-- health problems repeater -->
        <div class="col-12">
            <div class="card">
                <div id="update-health-overlay" class="card-overlay">
                    <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                        <div class="spinner-border" style="width: 3rem; height: 3rem" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <form action="{{ route('admin.students.update.health', $student->student_id) }}" method="post" onsubmit="updateHealth(this); return false;">
                    @csrf
                    <input type="hidden" name="student_id" value="{{$student->student_id}}">
                    <div class="card-header">
                        <h4 class="card-title">{{trans("general.health_problems")}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="health-problems-repeater">
                            <div data-repeater-list="health-problems">
                                @if(count($studentHealthRecords))
                                @foreach($studentHealthRecords as $record)
                                <div data-repeater-item>
                                    <input type="hidden" name="student_health_id" value="{{$record->id}}">
                                    <div class="row d-flex align-items-end">
                                        <div class="col-3">
                                            <div class="mb-1">
                                                <label class="form-label">{{trans("general.health_problem_type")}}</label>
                                                <input required type="text" name="health_problem" class="form-control" value="{{$record->title}}" />
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="mb-1">
                                                <label class="form-label">{{trans("general.description")}}</label>
                                                <textarea required name="description" rows="1" style="padding-top: 5.6px !important; padding-bottom: 5.6px !important;" class="form-control ">{{$record->description}}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-2">
                                            <div class="mb-1">
                                                <button class="btn btn-outline-danger text-nowrap px-25 w-100" data-repeater-delete type="button">
                                                    <i data-feather="x"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                @endforeach
                                @else
                                <div data-repeater-item>
                                    <input type="hidden" name="student_health_id">
                                    <div class="row d-flex align-items-end">
                                        <div class="col-3">
                                            <div class="mb-1">
                                                <label class="form-label">{{trans("general.health_problem_type")}}</label>
                                                <input required type="text" name="health_problem" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="mb-1">
                                                <label class="form-label">{{trans("general.description")}}</label>
                                                <textarea required name="description" rows="1" style="padding-top: 5.6px !important; padding-bottom: 5.6px !important;" class="form-control "></textarea>
                                            </div>
                                        </div>

                                        <div class="col-2">
                                            <div class="mb-1">
                                                <button class="btn btn-outline-danger text-nowrap px-25 w-100" data-repeater-delete type="button">
                                                    <i data-feather="x"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                @endif

                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <button type="submit" class="btn btn-primary waves-effect waves-float waves-light">{{ trans('general.save') }}</button>
                                    <button type="reset" class="btn btn-outline-secondary waves-effect">{{ trans('general.reset') }}</button>
                                </div>
                                <button type="button" class="btn btn-icon btn-primary" data-repeater-create>
                                    <i data-feather="plus" class="me-25"></i>
                                    <span>{{trans("general.add")}}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /health problems repeater -->
    </div>
</section>





@push('scripts')
<script src="{{ url('design') }}/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>

<script src="{{ url('design') }}/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
<script src="{{ url('design') }}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<!-- BEGIN: Page Vendor JS-->
<!-- <script src="{{ url('design') }}/app-assets/vendors/js/forms/select/select2.full.min.js"></script> -->
<!-- END: Page Vendor JS-->

<!-- BEGIN: Page JS-->
<!-- <script src="{{ url('design') }}/app-assets/js/scripts/forms/form-select2.js"></script> -->
<!-- END: Page JS-->

<script>
    $(document).ready(function() {

        $(function() {
            'use strict';

            // form repeater jquery
            $('.school-sequence-repeater, .languages-repeater, .repeater-default, .health-problems-repeater').repeater({
                // initEmpty: true,
                show: function() {
                    $(this).slideDown();
                    // Feather Icons
                    if (feather) {
                        feather.replace({
                            width: 14,
                            height: 14
                        });
                    }
                },
                hide: function(deleteElement) {
                    if (confirm('{{trans("general.Are you sure you want to delete this element?")}}')) {
                        $(this).slideUp(deleteElement);
                    }
                },

            });
        });

    });
    $(document).ready(function() {
        $("input[name='editMotherType']").change(function() {

            if ($(this).val() == 0) {
                $("#mother_fname").removeAttr('disabled');
                $("#mother_lname").removeAttr('disabled');
                $("#mother_job").removeAttr('disabled');
                $("#mother_phone").removeAttr('disabled');
                $("#mother_id").val('{{$mother->id}}');
                $("#mother_fname").val('{{$mother->first_name}}');
                $("#mother_lname").val('{{$mother->last_name}}');
                $("#mother_job").val('{{$mother->job}}');
                $("#mother_phone").val('{{$mother->phone}}');
                $("#mother-search-input").css('display', 'none');
            } else if ($(this).val() == 1) { // link with other account
                $("#mother_fname").attr('disabled', 'disabled');
                $("#mother_lname").attr('disabled', 'disabled');
                $("#mother_job").attr('disabled', 'disabled');
                $("#mother_phone").attr('disabled', 'disabled');
                $("#mother_id").val('');
                $("#mother_fname").val('');
                $("#mother_lname").val('');
                $("#mother_job").val('');
                $("#mother_phone").val('');
                $("#mother-search-input").css('display', '');

            } else {
                $("#mother_fname").removeAttr('disabled', 'disabled');
                $("#mother_lname").removeAttr('disabled', 'disabled');
                $("#mother_job").removeAttr('disabled', 'disabled');
                $("#mother_phone").removeAttr('disabled', 'disabled');
                $("#mother_id").val('');
                $("#mother_fname").val('');
                $("#mother_lname").val('');
                $("#mother_job").val('');
                $("#mother_phone").val('');
                $("#mother-search-input").css('display', 'none');
            }
        });


        $("input[name='editFatherType']").change(function() {

            if ($(this).val() == 0) { // edit currernt account
                $("#father_fname").removeAttr('disabled');
                $("#father_lname").removeAttr('disabled');
                $("#father_job").removeAttr('disabled');
                $("#father_phone").removeAttr('disabled');
                $("#father_id").val('{{$father->id}}');
                $("#father_fname").val('{{$father->first_name}}');
                $("#father_lname").val('{{$father->last_name}}');
                $("#father_job").val('{{$father->job}}');
                $("#father_phone").val('{{$father->phone}}');
                $("#father-search-input").css('display', 'none');
            } else if ($(this).val() == 1) { // link with other account
                $("#father_fname").attr('disabled', 'disabled');
                $("#father_lname").attr('disabled', 'disabled');
                $("#father_job").attr('disabled', 'disabled');
                $("#father_phone").attr('disabled', 'disabled');
                $("#father_id").val('');
                $("#father_fname").val('');
                $("#father_lname").val('');
                $("#father_job").val('');
                $("#father_phone").val('');
                $("#father-search-input").css('display', '');
            } else { // create new account
                $("#father_fname").removeAttr('disabled', 'disabled');
                $("#father_lname").removeAttr('disabled', 'disabled');
                $("#father_job").removeAttr('disabled', 'disabled');
                $("#father_phone").removeAttr('disabled', 'disabled');
                $("#father_fname").val('');
                $("#father_lname").val('');
                $("#father_job").val('');
                $("#father_phone").val('');
                $("#father_id").val('');
                $("#father-search-input").css('display', 'none');
            }
        });


        if ($('#new-mother-account').is(':checked')) {
            $("#mother_fname").removeAttr('disabled');
            $("#mother_lname").removeAttr('disabled');
            $("#mother_job").removeAttr('disabled');
            $("#mother_phone").removeAttr('disabled');
        }
        if ($('#new-father-account').is(':checked')) {
            $("#father_fname").removeAttr('disabled');
            $("#father_lname").removeAttr('disabled');
            $("#father_job").removeAttr('disabled');
            $("#father_phone").removeAttr('disabled');
        }
    });
    (function(window, document, $) {
        'use strict';
        $('.flatpickr-basic').flatpickr();
        var select = $('.select2');
        select.each(function() {
            var $this = $(this);
            $this.wrap('<div class="position-relative"></div>');
            $this.select2({
                // the following code is used to disable x-scrollbar when click in select input and
                // take 100% width in responsive also
                dropdownAutoWidth: true,
                width: '100%',
                dropdownParent: $this.parent()
            });
        });
    })(window, document, jQuery);


    function getMothersSuggestions(element) {
        if (element.value != "") {
            $("#mothers-suggestions-spinner").show();
            var jqxhr = $.ajax({
                    url: "{{route('admin.parents.mother.search')}}",
                    method: "GET",
                    timeout: 0,
                    data: {
                        "key": element.value,
                    },
                })
                .done(function(response) {
                    $("#mothers-suggestions-spinner").hide();
                    setDataToMothersSuggestionsList(response.data);
                    console.log(response);
                })
                .fail(function(response) {
                    $("#mothers-suggestions-spinner").hide();
                    setDataToMothersSuggestionsList([]);
                    console.log(response);
                });

        } else {
            $("#mothers-suggestions-spinner").hide();
            setDataToMothersSuggestionsList([]);
        }
    }

    function setDataToMothersSuggestionsList(data) {
        $("#mother-search-list").html("");
        data.forEach(function(item) {
            $("#mother-search-list").append(`<a href="#" id="${item.id}" onclick="setMotherData(this)" class="list-group-item list-group-item-action">
                <div class="row">
                    <div class="col-sm-3 col-6 mother-first">${item.first_name}</div>
                    <div class="col-sm-3 col-6 mother-last">${item.last_name}</div>
                    <div class="col-sm-3 col-6 mother-phone">${item.phone}</div>
                    <div class="col-sm-3 col-6 mother-job">${item.job}</div>
                </div>
            </a>`);
        });
    }

    function setMotherData(element) {

        $("#mother_fname").val($(element).find(".mother-first").html());
        $("#mother_lname").val($(element).find(".mother-last").html());
        $("#mother_phone").val($(element).find(".mother-phone").html());
        $("#mother_job").val($(element).find(".mother-job").html());
        $("#mother_id").val($(element).attr("id"));
        setDataToMothersSuggestionsList([]);
        $("#exist-mother-account").click();
    }

    function getFathersSuggestions(element) {

        if (element.value != "") {
            $("#fathers-suggestions-spinner").show();
            var jqxhr = $.ajax({
                    url: "{{route('admin.parents.father.search')}}",
                    method: "GET",
                    timeout: 0,
                    data: {
                        "key": element.value,
                    },
                })
                .done(function(response) {
                    $("#fathers-suggestions-spinner").hide();
                    setDataToFathersSuggestionsList(response.data);
                    console.log(response);
                })
                .fail(function(response) {
                    $("#fathers-suggestions-spinner").hide();
                    setDataToFathersSuggestionsList([])
                    console.log(response);
                });
        } else {
            setDataToFathersSuggestionsList([]);
            $("#fathers-suggestions-spinner").hide();
        }
    }

    function setDataToFathersSuggestionsList(data) {
        $("#father-search-list").html("");
        data.forEach(function(item) {
            $("#father-search-list").append(`<a href="#" id="${item.id}" onclick="setFatherData(this)" class="list-group-item list-group-item-action">
                <div class="row">
                    <div class="col-sm-3 col-6 father-first">${item.first_name}</div>
                    <div class="col-sm-3 col-6 father-last">${item.last_name}</div>
                    <div class="col-sm-3 col-6 father-phone">${item.phone}</div>
                    <div class="col-sm-3 col-6 father-job">${item.job}</div>
                </div>
            </a>`);
        });
    }

    function setFatherData(element) {

        $("#father_fname").val($(element).find(".father-first").html());
        $("#father_lname").val($(element).find(".father-last").html());
        $("#father_phone").val($(element).find(".father-phone").html());
        $("#father_job").val($(element).find(".father-job").html());
        $("#father_id").val($(element).attr("id"));
        setDataToFathersSuggestionsList([]);
        $("#exist-father-account").click();
    }

    function checkNearest(element) {
        var closestRadio = $(element).parent().find("input[type=radio]");
        closestRadio.attr('id', new Date().getTime())
        $(element).attr('for', closestRadio.attr('id'));
        $("input[name='" + closestRadio.attr('name') + "']").each(function(index, elmnt) {
            elmnt.removeAttribute('checked');
        });
        closestRadio.attr('checked', true);
        console.log(closestRadio);
    }

    function updateStudent(element) {
        try {
            form = $(element).serializeArray().reduce(function(obj, item) {
                if (obj[item.name]) {
                    obj[item.name] += "," + item.value
                } else {
                    obj[item.name] = item.value;
                }
                return obj;
            }, {});

            $("#update-student-overlay").show();
            var jqxhr = $.ajax({
                    url: "{{route('admin.students.update.student', $student->student_id)}}",
                    method: "POST",
                    timeout: 0,
                    data: form,
                })
                .done(function(response) {
                    $("#update-student-overlay").hide();
                    console.log(response);
                    showSuccess(json2array(response.message));
                })
                .fail(function(response) {
                    $("#update-student-overlay").hide();
                    showErrors(json2array(response.responseJSON))
                    console.log(response);
                });
        } catch (error) {
            $("#update-student-overlay").hide();
        }
    }

    function updateMother(element) {
        try {
            form = $(element).serializeArray().reduce(function(obj, item) {
                if (obj[item.name]) {
                    obj[item.name] += "," + item.value
                } else {
                    obj[item.name] = item.value;
                }
                return obj;
            }, {});

            $("#update-mother-overlay").show();
            var jqxhr = $.ajax({
                    url: "{{route('admin.students.update.mother', $student->student_id)}}",
                    method: "POST",
                    timeout: 0,
                    data: form,
                })
                .done(function(response) {
                    $("#update-mother-overlay").hide();
                    console.log(response);
                    showSuccess(json2array(response.message));
                })
                .fail(function(response) {
                    $("#update-mother-overlay").hide();
                    showErrors(json2array(response.responseJSON))
                    console.log(response);
                });
        } catch (error) {
            $("#update-mother-overlay").hide();
        }
    }

    function updateFather(element) {
        try {
            form = $(element).serializeArray().reduce(function(obj, item) {
                if (obj[item.name]) {
                    obj[item.name] += "," + item.value
                } else {
                    obj[item.name] = item.value;
                }
                return obj;
            }, {});

            $("#update-father-overlay").show();
            var jqxhr = $.ajax({
                    url: "{{route('admin.students.update.father', $student->student_id)}}",
                    method: "POST",
                    timeout: 0,
                    data: form,
                })
                .done(function(response) {
                    $("#update-father-overlay").hide();
                    console.log(response);
                    showSuccess(json2array(response.message));
                })
                .fail(function(response) {
                    $("#update-father-overlay").hide();
                    showErrors(json2array(response.responseJSON))
                    console.log(response);
                });
        } catch (error) {
            $("#update-father-overlay").hide();
        }
    }

    function updateAddressTransEmergency(element) {
        try {
            form = $(element).serializeArray().reduce(function(obj, item) {
                if (obj[item.name]) {
                    obj[item.name] += "," + item.value
                } else {
                    obj[item.name] = item.value;
                }
                return obj;
            }, {});

            $("#update-addressTransEmergency-overlay").show();
            var jqxhr = $.ajax({
                    url: "{{route('admin.students.update.addressTransEmergency', $student->student_id)}}",
                    method: "POST",
                    timeout: 0,
                    data: form,
                })
                .done(function(response) {
                    $("#update-addressTransEmergency-overlay").hide();
                    console.log(response);
                    showSuccess(json2array(response.message));
                })
                .fail(function(response) {
                    $("#update-addressTransEmergency-overlay").hide();
                    showErrors(json2array(response.responseJSON))
                    console.log(response);
                });
        } catch (error) {
            $("#update-addressTransEmergency-overlay").hide();
        }
    }

    function updateSequence(element) {
        try {

            form = $(element).serializeArray().reduce(function(obj, item) {
                if (obj[item.name]) {
                    obj[item.name] += "," + item.value
                } else {
                    obj[item.name] = item.value;
                }
                return obj;
            }, {});

            $("#update-sequence-overlay").show();
            var jqxhr = $.ajax({
                    url: "{{route('admin.students.update.sequence', $student->student_id)}}",
                    method: "POST",
                    timeout: 0,
                    data: form,
                })
                .done(function(response) {
                    $("#update-sequence-overlay").hide();
                    console.log(response);
                    showSuccess(json2array(response.message));
                })
                .fail(function(response) {
                    $("#update-sequence-overlay").hide();
                    showErrors(json2array(response.responseJSON))
                    console.log(response);
                });
        } catch (error) {
            $("#update-sequence-overlay").hide();
        }
    }

    function updateLanguages(element) {
        try {

            form = $(element).serializeArray().reduce(function(obj, item) {
                if (obj[item.name]) {
                    obj[item.name] += "," + item.value
                } else {
                    obj[item.name] = item.value;
                }
                return obj;
            }, {});

            $("#update-languages-overlay").show();
            var jqxhr = $.ajax({
                    url: "{{route('admin.students.update.languages', $student->student_id)}}",
                    method: "POST",
                    timeout: 0,
                    data: form,
                })
                .done(function(response) {
                    $("#update-languages-overlay").hide();
                    console.log(response);
                    showSuccess(json2array(response.message));
                })
                .fail(function(response) {
                    $("#update-languages-overlay").hide();
                    showErrors(json2array(response.responseJSON))
                    console.log(response);
                });
        } catch (error) {
            $("#update-languages-overlay").hide();
        }
    }

    function updateHealth(element) {
        try {

            form = $(element).serializeArray().reduce(function(obj, item) {
                if (obj[item.name]) {
                    obj[item.name] += "," + item.value
                } else {
                    obj[item.name] = item.value;
                }
                return obj;
            }, {});

            $("#update-health-overlay").show();
            var jqxhr = $.ajax({
                    url: "{{route('admin.students.update.health', $student->student_id)}}",
                    method: "POST",
                    timeout: 0,
                    data: form,
                })
                .done(function(response) {
                    $("#update-health-overlay").hide();
                    console.log(response);
                    showSuccess(json2array(response.message));
                })
                .fail(function(response) {
                    $("#update-health-overlay").hide();
                    showErrors(json2array(response.responseJSON))
                    console.log(response);
                });
        } catch (error) {
            $("#update-health-overlay").hide();
        }
    }

    
    function stageLevels(stage_id) {
        console.log('stageLevels');
        var jqxhr = $.ajax({
                url: "{{route('admin.stage.levels')}}",
                method: "GET",
                timeout: 0,
                data:{
                    stage_id:stage_id
                }
            })
            .done(function(response) {
                setLevelsOptions(response.data);
                console.log(response);
            })
            .fail(function(response) {
                console.log(response);
                toastr.error(response.responseJSON.msg, 'خطأ');
            });

    }


    function setLevelsOptions(data) {
        var levelSelect = $('#level_to_study');
        levelSelect.html('');
        levelSelect.append($('<option>', {
            value: '',
            text: '--'
        }));
        $.each(data, function(index, val) {
            levelSelect.append($('<option>', {
                value: val.id,
                text: val.title
            }));
        });
    }
</script>
<!-- update-student-overlay
update-mother-overlay
update-father-overlay
update-addressTransEmergency-overlay
update-sequence-overlay
update-languages-overlay
update-health-overlay -->
@endpush

@push('header')
<!-- <link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/vendors/css/forms/select/select2.min.css"> -->
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/vendors/css/forms/select/select2.min.css">

@endpush
@endsection