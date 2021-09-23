<div class="demo-inline-spacing justify-content-around ">

    <!-- view user btn -->

    <!-- <a type="button" class="btn btn-sm btn-warning action-row" title="{{trans('general.view')}}" style="margin: 0px;" id="view_{{ $id }}" href="{{route('admin.UserAccountDetails',$id) }}">
        <i class="far fa-eye "></i>
    </a> -->


    <!-- Edit user btn -->

    <a type="button" class="btn btn-sm btn-info action-row" title="{{trans('general.edit')}}" style="margin: 0px;" id="edit_{{ $id }}" href="{{route('admin.users.update',$id) }}">
        <i class="far fa-edit "></i>
        <!-- <i data-feather='edit'></i> -->
    </a>

    @if(!empty($settings))

    @if(json_decode($settings, true)['status'] == 0)
    <button type="button" onclick="changeAccStatusConfirmation() ? document.getElementById('accountStatus-{{ $id }}').submit() : false;" class="btn btn-sm btn-success action-row" title="{{trans('general.Activate Account')}}" style="margin: 0px;" id="close_{{ $id }}">
        <i class="fas fa-user-times "></i>
    </button>
    @else
    <button type="button" onclick="changeAccStatusConfirmation() ? document.getElementById('accountStatus-{{ $id }}').submit() : false;" class="btn btn-sm btn-danger action-row" title="{{trans('general.Deactivate Account')}}" style="margin: 0px;" id="close_{{ $id }}">
        <i class="fas fa-user-times "></i>
    </button>
    @endif
    @else
    <button type="button" onclick="changeAccStatusConfirmation() ? document.getElementById('accountStatus-{{ $id }}').submit() : false;" class="btn btn-sm btn-danger action-row" title="{{trans('general.Deactivate Account')}}" style="margin: 0px;" id="close_{{ $id }}">
        <i class="fas fa-user-times "></i>
    </button>
    @endif

    <!-- close account btn -->
</div>
<form role="form" id="accountStatus-{{ $id }}" action="{{ route('admin.users.update.status', $id) }}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ $id }}">
    @if(!empty($settings))
    @if(json_decode($settings, true)['status'] == 0)
    <input required type="hidden" name="status" value="1" id="status">
    @else
    <input required type="hidden" name="status" value="0" id="status">
    @endif
    @else
    <input required type="hidden" name="status" value="0" id="status">
    @endif

</form>