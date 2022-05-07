
    <!-- BEGIN: Vendor JS-->
    <script src="../app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="../app-assets/vendors/js/charts/chartist.min.js"></script>
    <script src="../app-assets/vendors/js/charts/chartist-plugin-tooltip.min.js"></script>
    <script src="../app-assets/vendors/js/charts/raphael-min.js"></script>
    <script src="../app-assets/vendors/js/charts/morris.min.js"></script>
    <script src="../app-assets/vendors/js/timeline/horizontal-timeline.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="../app-assets/js/core/app-menu.js"></script>
    <script src="../app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="../app-assets/js/scripts/pages/dashboard-ecommerce.js"></script>
    <!-- END: Page JS-->

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