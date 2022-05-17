
    <!-- BEGIN: Vendor JS-->
    <script src="../app-assets/vendors/js/vendors.min.js"></script>
    <script src="../app-assets/vendors/js/material-vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Business Page JS-->
    <script src="../app-assets/vendors/js/extensions/jquery.steps.min.js"></script>
    <script src="../app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js"></script>
    <script src="../app-assets/vendors/js/pickers/daterange/daterangepicker.js"></script>
    <script src="../app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <script src="../app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <!-- END: Business Page JS-->

    <!-- BEGIN: Theme JS-->
    <script src="../app-assets/js/core/app-menu.js"></script>
    <script src="../app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <script src="../app-assets/js/scripts/pages/material-app.js"></script>
    <script src="../app-assets/js/scripts/tables/material-datatable.js"></script>
    <script src="../app-assets/js/scripts/modal/components-modal.js"></script>

    <script>
        $(document).ready(()=>{
            $("#btnlogout").on("click", ()=>{
                $.post("../app/Controllers/SystemAdmin.php",{logout:"true"},function(data){
                    window.location.reload();
                });
            });
        });
    </script>

</body>
<!-- END: Body-->

</html>