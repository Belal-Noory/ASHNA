<?php
session_start();
require "../../init.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Login
    if(isset($_POST["login"])){
        $email = helper::test_input($_POST["email"]);
        $pass = helper::test_input($_POST["pass"]);
        if (!empty($email) && !empty($pass)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("location: ../../index.php?invalidEmail=true");
            } else {
                //login here
                $sysAdmin = new SystemAdmin();
                $res = $sysAdmin->login([$email, $pass]);
                if($res->rowCount() > 0)
                {
                    $admin_data_array = $res->fetchAll(PDO::FETCH_OBJ);
                    $admin_data = array();
                    foreach($admin_data_array as $info)
                    {
                        $admin_data['id'] = $info->id;
                        $admin_data['email'] = $info->email;
                        $admin_data['pass'] = $info->pass;
                        $admin_data['fname'] = $info->fname;
                        $admin_data['lname'] = $info->lname;
                    }

                    $_SESSION["sys_admin"] = json_encode($admin_data);
                    header("location: ../../admin/index.php");
                }
                else{
                    header("location: ../../index.php?notfound=true");
                }
            }
        } else {
            header("location: ../../index.php?empty=true");
        }
    }
    else if(isset($_POST["logout"]))
    {
        session_destroy();
        exit();
    }
    else{
        echo "Parameters did not send to server";
    }
}
else{
    echo "<h1>Something bad happend ;)</h1>";
}
