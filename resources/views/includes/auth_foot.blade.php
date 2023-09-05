 <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
     <script src="{{ asset('app-assets/vendors/js/forms/validation/jqBootstrapValidation.js') }}"></script>
    <!-- END: Page Vendor JS-->


    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('app-assets/js/core/app.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/components.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/extensions/toastr.js') }}"></script>

    <script type="text/javascript">
        var type = "{{ Session::get('type') }}";
        switch (type) {
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;

        }
    </script>
     <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/forms/validation/form-validation.js') }}"></script>


    <script src="{{ asset('app-assets/js/waitMe.js') }}"></script>
    <!-- END: Page JS-->
