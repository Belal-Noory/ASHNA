<!-- Modal Single Pending Transaction -->
<div class="modal fade text-center" id="changemodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-4">
                <form class="form">
                    <div class="form-group text-left">
                        <label for="username">نام یا ایمیل</label>
                        <input type="text" class="form-control required" placeholder="نام یا ایمیل" id="chusername" name="username" value="<?php echo $loged_user->username; ?>" prevalue="<?php echo $loged_user->username; ?>"  />
                    </div>
                    <div class="form-group text-left">
                        <label for="passwrod">پاسورد</label>
                        <input type="text" class="form-control required" placeholder="پاسورد" id="chpasswrod" name="passwrod" value="<?php echo $loged_user->password; ?>"  prevalue="<?php echo $loged_user->password; ?>"  />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-blue" id="btnchangecredentials">
                    <span>تغیر</span>
                    <span class="las la-spinner spinner d-none"></span>
                </button>
            </div>
        </div>
    </div>
</div>
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
<script src="../business/assets/confirm/js/jquery-confirm.js"></script>
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
                window.location.replace("index.php");
            });
        });

        // show change username model
        $("#btnchangemodel").on("click",function(e){
            e.preventDefault();
            $("#changemodel").modal("show");
        });

        // change the password
        $("#btnchangecredentials").on("click",function(e){
            e.preventDefault();
            ths = $(this);
            // username
            username = $("#chusername").val();
            prevUsername = $("#chusername").attr("prevalue");
            // password
            password = $("#chpasswrod").val();
            prevPassword = $("#chpasswrod").attr("prevalue");

            if(prevPassword !== password || prevUsername !== username)
            {
                $(ths).children("span:last-child").removeClass("d-none");
                $(ths).attr("disabled");
                $.post("../app/Controllers/Saraf.php", {
                changeCredentials: "true",
                username: username,
                password: password
                }, (data) => {
                    $(ths).children("span:last-child").addClass("d-none");
                    $(ths).removeAttr("disabled");
                });
            }
            else{
                $(ths).children("span:last-child").addClass("d-none");
                $(ths).removeAttr("disabled");
            }
        });
    });
</script>

</html>