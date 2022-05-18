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
                    exit();
                }
                else{
                    header("location: ../../index.php?notfound=true");
                }
            }
        } else {
            header("location: ../../index.php?empty=true");
        }
    }
    
    // Logout
    if(isset($_POST["logout"]))
    {
        session_destroy();
        exit();
    }
    
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sysAdmin = new SystemAdmin();
    
    // Get Models that are not assigned to a company
    if(isset($_GET["getcompanymodels"]))
    {
        $companyID = $_GET["companyID"];
        $models = $sysAdmin->getCompanyModel($companyID);
        $models_data = $models->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($models_data);
    }
}



