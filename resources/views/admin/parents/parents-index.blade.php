@extends('admin.index')
@section('content')

<!-- Responsive Datatable -->
<section id="responsive-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">{{ trans("general.parents") }}</h4>
                    <div>
                        <a href="{{ route('admin.parents.create') }}" class="btn btn-outline-primary waves-effect">{{ trans("general.add_parent") }}</a>
                        <a href="{{ route('admin.parents.deactivated') }}" class="btn btn-outline-primary waves-effect">{{ trans("general.deactivated_accounts") }}</a>
                    </div>
                </div>
                <div class="card-datatable">
                    {{ $dataTable->table([
                    "class" => "dt-responsive table",
                    "style" => ""
                        ])
                    }}
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ Responsive Datatable -->




@push('scripts')

{!! $dataTable->scripts() !!}
<script src="{{ url('design') }}/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
<script src="{{ url('design') }}/app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js"></script>
<script src="{{ url('design') }}/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
<script src="{{ url('design') }}/app-assets/vendors/js/tables/datatable/responsive.bootstrap5.js"></script>

<script>
    
</script>

@endpush

@push('header')

<!-- BEGIN: Vendor CSS-->
<!-- <link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/vendors/css/vendors-rtl.min.css"> -->
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
<!-- <link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css"> -->
<!-- END: Vendor CSS-->

<!-- BEGIN: Theme CSS-->
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/css-rtl/bootstrap.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/css-rtl/bootstrap-extended.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/css-rtl/colors.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/css-rtl/components.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/css-rtl/themes/dark-layout.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/css-rtl/themes/bordered-layout.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/css-rtl/themes/semi-dark-layout.css">

<!-- BEGIN: Custom CSS-->
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/app-assets/css-rtl/custom-rtl.css">
<link rel="stylesheet" type="text/css" href="{{ url('design') }}/assets/css/style-rtl.css">
<!-- END: Custom CSS-->
@endpush
@endsection