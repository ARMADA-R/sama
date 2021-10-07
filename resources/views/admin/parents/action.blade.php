<div class="demo-inline-spacing justify-content-around ">

    <!-- view user btn -->

    <!-- <a type="button" class="btn btn-sm btn-warning action-row" title="{{trans('general.view')}}" style="margin: 0px;" id="view_{{ $id }}" href="route('admin.UserAccountDetails',$id) }}">
        <i class="far fa-eye "></i>
    </a> -->


    <!-- Edit user btn -->

    <a type="button" class="btn btn-sm btn-info action-row" title="{{trans('general.edit')}}" style="margin: 0px;" id="edit_{{ $id }}" href="{{route('admin.students.update',$id) }}">
        <i class="far fa-edit "></i>
        <!-- <i data-feather='edit'></i> -->
    </a>

   
    <button type="button" onclick="confirm(`{{trans('general.delete_student_confirmation')}}`) ? document.getElementById('del-student-{{ $id }}').submit() : false;" class="btn btn-sm btn-danger action-row" title="{{trans('general.delete')}}" style="margin: 0px;" id="delete_{{ $id }}">
        <i class="fas fa-trash "></i>
    </button>

    <!-- close account btn -->
</div>
<form role="form" id="del-student-{{ $id }}" action="{{ route('admin.students.delete') }}" method="POST">
    @csrf
    <input type="hidden" name="student_id" value="{{ $id }}">
</form>