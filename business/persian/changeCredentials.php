<?php
$Active_nav_name = array("parent" => "Settings", "child" => "Change Credentials");
$page_title = "Change Credentials";
include("./master/header.php");
// Logged in user info 
$bank = new Banks();
$banks = $bank->getBanks($user_data->company_id);
$banks_data = $banks->fetchAll(PDO::FETCH_OBJ);
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="container p-2">
                <div class="card">
                    <div class="card-header">
                        <a class="heading-elements-toggle">
                            <i class="la la-ellipsis-v font-medium-3"></i>
                        </a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form">
                                <div class="form-group">
                                    <label for="username">نام کاربری</label>
                                    <input class="form-control" type="text" name="username" id="username" value="<?php echo $user_data->username; ?>" prevalue="<?php echo $user_data->username; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="pass">گذر واژه</label>
                                    <input class="form-control" type="password" name="pass" id="pass" value="<?php echo $user_data->password; ?>" prevalue="<?php echo $user_data->password; ?>">
                                </div>
                                <div class="form-action">
                                    <button type="button" class="btn btn-blue" id="btnchangecredentials">
                                        <span class="las la-spinner spinner d-none"></span>
                                        <span class="las la-check"></span> تغیر
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("./master/footer.php");
?>

<script>
    $(document).ready(function() {
        // change credentials
        $("#btnchangecredentials").on("click", function(e) {
            e.preventDefault();
            ths = $(this);

            username = $("#username").val();
            usernamePrev = $("#username").attr("prevalue");
            pass = $("#pass").val();
            passPrev = $("#pass").attr("prevalue");

            if (username !== usernamePrev || pass !== passPrev) {
                $(ths).children("span:last-child()").addClass("d-none");
                $(ths).children("span:first-child()").removeClass("d-none");

                $.post("../app/Controllers/Bussiness.php", {
                    changeCredential: true,
                    user: username,
                    pas: pass
                }, function(data) {
                    window.location.reload();
                });
            }
        });
    });
</script>