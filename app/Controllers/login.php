<?php
session_start();
require "../../init.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["login"])){
        $email = helper::test_input($_POST["email"]);
        $pass = helper::test_input($_POST["password"]);
        if (!empty($email) && !empty($pass)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Invalid email format";
            } else {
                //login here
                $staff = new staff();
                $res = $staff->login($email, $pass);
                if ($res["msg"] == "found") {
                    $_SESSION["user"] = $res;
                    header("location: ../../CMS/dashboard.php?welcome=true");
                }
            }
        } else {
            header("location: ../../CMS/index.php?fill=true");
        }
    }
    else if(isset($_POST["logout"]))
    {
        session_destroy();
        echo "done";
        exit();
    }
    else{
        echo "Parameters did not send to server";
    }
}
else{
    echo "<h1>Something bad happend ;)</h1>";
}
