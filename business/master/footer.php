<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light navbar-shadow">
    <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block">Copyright &copy; 2019 <a class="text-bold-800 grey darken-2" href="https://1.envato.market/modern_admin" target="_blank">PIXINVENT</a></span><span class="float-md-right d-none d-lg-block">Hand-crafted & Made with<i class="ft-heart pink"></i><span id="scroll-top"></span></span></p>
</footer>
<!-- END: Footer-->


<!-- BEGIN: Vendor JS-->
<script src="./app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="./app-assets/vendors/js/ui/jquery.sticky.js"></script>
<script src="./app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
<script src="./app-assets/vendors/js/charts/chart.min.js"></script>
<script src="./app-assets/vendors/js/charts/chartist.min.js"></script>
<script src="./app-assets/vendors/js/charts/chartist-plugin-tooltip.min.js"></script>
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
<script src="./app-assets/js/scripts/ui/breadcrumbs-with-stats.js"></script>
<script src="./app-assets/js/scripts/pages/dashboard-bank.js"></script>
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