<div class="demo-inline-spacing justify-content-around ">

    <!-- view user btn -->

    <!-- <a type="button" class="btn btn-sm btn-warning action-row" title="{{trans('general.view')}}" style="margin: 0px;" id="view_{{ $id }}" href="route('admin.UserAccountDetails',$id) }}">
        <i class="far fa-eye "></i>
    </a> -->


    <!-- Edit user btn -->

    <a type="button" class="btn btn-sm btn-info action-row" title="{{trans('general.edit')}}" style="margin: 0px;" id="edit_{{ $id }}" href="{{route('admin.parents.update',$id) }}">
        <i class="far fa-edit "></i>
        <!-- <i data-feather='edit'></i> -->
    </a>

   
    <button type="button" onclick="confirm(`{{trans('general.delete_record_confirmation')}}`) ? document.getElementById('del-parent-{{ $id }}').submit() : false;" class="btn btn-sm btn-danger action-row" title="{{trans('general.delete')}}" style="margin: 0px;" id="delete_{{ $id }}">
        <i class="fas fa-trash "></i>
    </button>

    <!-- close account btn -->
</div>
<form role="form" id="del-parent-{{ $id }}" action="{{ route('admin.parents.delete') }}" method="POST">
    @csrf
    <input type="hidden" name="parent_id" value="{{ $id }}">
</form>