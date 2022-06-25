<!-- BEGIN: Vendor JS-->
<script src="app-assets/vendors/js/vendors.min.js"></script>
<!-- <script src="app-assets/vendors/js/material-vendors.min.js"></script> -->
<!-- BEGIN Vendor JS-->
<script src="app-assets/js/core/libraries/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>

<!-- BEGIN: Page Vendor JS-->
<script src="app-assets/vendors/js/ui/jquery.sticky.js"></script>
<script src="app-assets/vendors/js/forms/extended/card/jquery.card.js"></script>
<script src="app-assets/vendors/js/extensions/moment.min.js"></script>
<script src="app-assets/vendors/js/extensions/underscore-min.js"></script>
<script src="app-assets/vendors/js/extensions/clndr.min.js"></script>
<script src="app-assets/vendors/js/extensions/jquery.steps.min.js"></script>
<script src="app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="app-assets/js/scripts/pages/material-app.js"></script>
<script src="app-assets/js/scripts/modal/components-modal.js"></script>
<script src="app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="app-assets/js/scripts/navs/navs.js"></script>
<script src="app-assets/js/scripts/tables/material-datatable.js"></script>
<script src="app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js"></script>
<script src="app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<script src="app-assets/vendors/js/ui/jquery.sticky.js"></script>
<script src="app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
<script src="app-assets/vendors/js/extensions/jquery.knob.min.js"></script>
<script src="app-assets/vendors/js/charts/raphael-min.js"></script>
<script src="app-assets/vendors/js/charts/morris.min.js"></script>
<!-- END: Page JS-->


<!-- JS -->
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.jquery.min.js"></script>
</body>
<!-- END: Body-->
<script>
    $(document).ready(function() {
        // user logout
        $("#btnbusinesslogout").on("click", function(e) {
            e.preventDefault();
            $.post("../app/Controllers/Company.php", {
                "bussinessLogout": "true"
            }, (data) => {
                window.location.replace("index.php");
            });
        });
    });
</script>

</html>