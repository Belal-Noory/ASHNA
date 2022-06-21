<!-- BEGIN: Vendor JS-->
<script src="../business/app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->
<!-- BEGIN: Page Vendor JS-->
<script src="../business/app-assets/vendors/js/ui/jquery.sticky.js"></script>
<!-- END: Page Vendor JS-->
<script src="../business/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="../business/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>


<!-- BEGIN: Theme JS-->
<script src="../business/app-assets/js/core/app-menu.js"></script>
<script src="../business/app-assets/js/core/app.js"></script>

<script src="../business/app-assets/js/scripts/navs/navs.js"></script>
<script src="../business/app-assets/js/scripts/tables/datatables/datatable-basic.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<!-- END: Theme JS-->
</body>
<!-- END: Body-->

<script>
    $(document).ready(function() {
        // user logout
        $("#btnsaraflogout").on("click", function() {
            $.post("../app/Controllers/Saraf.php", {
                "sarafLogout": "true"
            }, (data) => {
                window.location.replace("index");
            });
        });
    });
</script>

</html>