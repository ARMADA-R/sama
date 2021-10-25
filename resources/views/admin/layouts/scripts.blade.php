<!-- BEGIN: Vendor JS-->
<script src="{{ url('design') }}/app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{ url('design') }}/app-assets/vendors/js/charts/apexcharts.min.js"></script>
<script src="{{ url('design') }}/app-assets/vendors/js/extensions/toastr.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ url('design') }}/app-assets/js/core/app-menu.js"></script>
<script src="{{ url('design') }}/app-assets/js/core/app.js"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<!-- <script src="{{ url('design') }}/app-assets/js/scripts/pages/dashboard-ecommerce.js"></script> -->
<!-- END: Page JS-->

<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    });
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "9000",
        "extendedTimeOut": "5000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "slideDown",
        "hideMethod": "slideUp",
        "toastClass": 'toastr'
    };
</script>
<script>
    function json2array(json) {
        if (typeof json == 'string') {
            return (json);
        }

        var result = [];
        var keys = Object.keys(json);
        keys.forEach(function(key) {
            if (json != null && typeof json == 'object') {
                result.push(json2array(json[key]));
            } else
                result.push(json[key]);
        });
        return result;
    }

    function showErrors(data) {
        if (Array.isArray(data)) {
            data.forEach(element => {
                showErrors(element)
            });
        } else {
            toastr.error(data);
        }
    }


    function showSuccess(data) {
        if (Array.isArray(data)) {
            data.forEach(element => {
                showSuccess(element)
            });
        } else if (data != '') {
            toastr.success(data);
        }
    }

    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        let name = cname + "=";
        let ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }


    console.log(document.cookie);
    // setCookie('darkMood', 1, 365);

    // if (getCookie('darkMood')) {

    //     var currentLayout = getCurrentLayout(),
    //         switchToLayout = '',
    //         prevLayout = localStorage.getItem(dataLayout + '-prev-skin', currentLayout);

    //     // If currentLayout is not dark layout
    //     if (currentLayout !== 'dark-layout') {
    //         // Switch to dark
    //         switchToLayout = 'dark-layout';
    //     } else {
    //         // Switch to light
    //         // switchToLayout = prevLayout ? prevLayout : 'light-layout';
    //         if (currentLayout === prevLayout) {
    //             switchToLayout = 'light-layout';
    //         } else {
    //             switchToLayout = prevLayout ? prevLayout : 'light-layout';
    //         }
    //     }
    //     // Set Previous skin in local db
    //     localStorage.setItem(dataLayout + '-prev-skin', currentLayout);
    //     // Set Current skin in local db
    //     localStorage.setItem(dataLayout + '-current-skin', switchToLayout);

    //     // Call set layout
    //     setLayout(switchToLayout);

    //     // ToDo: Customizer fix
    //     $('.horizontal-menu .header-navbar.navbar-fixed').css({
    //         background: 'inherit',
    //         'box-shadow': 'inherit'
    //     });
    //     $('.horizontal-menu .horizontal-menu-wrapper.header-navbar').css('background', 'inherit');

    // }
    // console.log(getCookie('darkMood'));
</script>
@include("admin.layouts.message")

@stack('scripts')