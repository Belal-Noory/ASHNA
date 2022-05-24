<!-- BEGIN: Vendor JS-->
<script src="./app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="./app-assets/vendors/js/ui/jquery.sticky.js"></script>
<script src="./app-assets/vendors/js/forms/extended/card/jquery.card.js"></script>
<script src="./app-assets/vendors/js/extensions/moment.min.js"></script>
<script src="./app-assets/vendors/js/extensions/underscore-min.js"></script>
<script src="./app-assets/vendors/js/extensions/clndr.min.js"></script>
<script src="../app-assets/vendors/js/extensions/jquery.steps.min.js"></script>
<script src="../app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>

<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="./app-assets/js/core/app-menu.js"></script>
<script src="./app-assets/js/core/app.js"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="./app-assets/js/scripts/pages/material-app.js"></script>
<script src="./app-assets/js/scripts/tables/material-datatable.js"></script>
<script src="./app-assets/js/scripts/modal/components-modal.js"></script>
<script src="./app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="./app-assets/js/scripts/navs/navs.js"></script>

<!-- END: Page JS-->

</body>
<!-- END: Body-->
<script>
    $(document).ready(function() {
        // user logout
        $("#btnbusinesslogout").on("click", function() {
            $.post("../app/Controllers/Company.php", {
                "bussinessLogout": "true"
            }, (data) => {
                window.location.replace("index.php");
            });
        });
    });
</script>

</html>