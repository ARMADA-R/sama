@extends('admin.index')
@section('content')

<form action="{{ route('admin.roles.update', $role->id) }}" method="post">
    <input type="hidden" name="id" id="id" value="{{old('id')? old('id') : $role->id}}">
    @csrf

    <div class="card">
        <div class="border-bottom card-header">
            <h4 class="card-title">{{ trans('general.Update Role') }}</h4>
            <div>
                <button type="submit" class="btn btn-primary waves-effect waves-float waves-light">{{ trans('general.save') }}</button>
                <button type="reset" class="btn btn-outline-secondary waves-effect">{{ trans('general.reset') }}</button>
            </div>
        </div>
        <div class="card-body">
            <div class="row pt-2">
                <div class=" col-12">
                    <div class="mb-1">
                        <label class="form-label" for="title">{{ trans('general.title') }}</label>
                        <input required type="text" name="title" class="form-control" id="title" placeholder="Admin" value="{{old('title')? old('title') : $role->title}}">
                    </div>
                </div>


                <div class=" col-12">
                    <div class="mb-1">
                        <label class="form-label" for="description">{{ trans('general.description') }}</label>
                        <textarea required name="description" id="description" class="form-control" rows="4">{{old('description')? old('description') : $role->description}}</textarea>
                    </div>
                </div>

            </div>
        </div>
        <hr class="mb-0">
        <div class="border-bottom card-header">
            <h4 class="card-title">{{ trans('general.Permissions') }}</h4>
            <div>
                <button type="button" onclick="selectAllPermission()" class="btn btn-outline-secondary waves-effect">{{ trans('general.Select all') }}</button>
                <button type="button" onclick="deselectAllPermission()" class="btn btn-outline-secondary waves-effect">{{ trans('general.Deselect all') }}</button>
            </div>
        </div>
        <div class="card-body">
            <div class="row pt-2">
                @foreach($permissionsAsGroups as $group => $permissions)
                <div class="col-xxl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="card shadow-none bg-transparent">
                        <div class="card-header">
                            {{$group}}
                        </div>
                        <div class="card-body">
                            @foreach($permissions as $permission)
                            <div class="form-check">
                                <input class="form-check-input" name="permissions[]" type="checkbox" id="permission-check-{{$permission->id}}" value="{{$permission->id}}" {{$permission->status_id != null? 'checked':''}}>                       
                                <label class="form-check-label" for="permission-check-{{$permission->id}}">{{ $permission->title }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</form>

@push('scripts')

<script>

function selectAllPermission() {
        var ele = document.getElementsByName('permissions[]');
        for (var i = 0; i < ele.length; i++) {
            if (ele[i].type == 'checkbox')
                ele[i].checked = true;
        }
    }

    function deselectAllPermission() {
        var ele = document.getElementsByName('permissions[]');
        for (var i = 0; i < ele.length; i++) {
            if (ele[i].type == 'checkbox')
                ele[i].checked = false;
        }
    }


</script>

@endpush

@push('header')


@endpush
@endsection