@extends('admin.index')
@section('content')


<div class="d-flex font-large-2 text-uppercase" style="height: 75vh;"><div class="m-auto">under construction</div> </div>



@push('scripts')

<script src="{{ url('design') }}/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
<script src="{{ url('design') }}/app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js"></script>
<script src="{{ url('design') }}/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
<script src="{{ url('design') }}/app-assets/vendors/js/tables/datatable/responsive.bootstrap5.js"></script>

@endpush

@push('header')


<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/vendors/css/vendors-rtl.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">



<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/css-rtl/bootstrap.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/css-rtl/bootstrap-extended.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/css-rtl/colors.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/css-rtl/components.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/css-rtl/themes/dark-layout.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/css-rtl/themes/bordered-layout.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/css-rtl/themes/semi-dark-layout.css">


<style>
    table.dataTable>thead .sorting:before, table.dataTable>thead .sorting_asc:before, table.dataTable>thead .sorting_desc:before, table.dataTable>thead .sorting_asc_disabled:before, table.dataTable>thead .sorting_desc_disabled:before {
    right: 0.45rem;
}
</style>
@endpush
@endsection