<?php
session_start();
require "../../init.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Add Company
    if (isset($_POST["addcompany"])) {
        $cname = helper::test_input($_POST["cname"]);
        $clegalname = helper::test_input($_POST["clegalname"]);
        $ctype = helper::test_input($_POST["ctype"]);
        $liscen = helper::test_input($_POST["clicense"]);
        $cTIN = helper::test_input($_POST["cTIN"]);
        $creginum = helper::test_input($_POST["creginum"]);
        $ccountry = helper::test_input($_POST["ccountry"]);
        $cprovince = helper::test_input($_POST["cprovince"]);
        $cdistrict = helper::test_input($_POST["cdistrict"]);
        $cemail = helper::test_input($_POST["cemail"]);
        $cpostalcode = helper::test_input($_POST["cpostalcode"]);
        $cphone = helper::test_input($_POST["cphone"]);
        $cfax = helper::test_input($_POST["cfax"]);
        $cwebsite = helper::test_input($_POST["cwebsite"]);
        $caddress = helper::test_input($_POST["caddress"]);

        $maincurrency = helper::test_input($_POST["maincurrency"]);
        $fiscal_year_start = helper::test_input($_POST["fiscal_year_start"]);
        $fiscal_year_end = helper::test_input($_POST["fiscal_year_end"]);
        $fiscal_year_title = helper::test_input($_POST["fiscal_year_title"]);

        $company = new Company();
        $res = $company->addCompany([$cname, $clegalname, $ctype, $liscen, $cTIN, $creginum, $ccountry, $cprovince, $cdistrict, $cemail, $cpostalcode, $cphone, $cfax, $cwebsite, $caddress,$maincurrency,$fiscal_year_start,$fiscal_year_end,$fiscal_year_title]);
        echo $res->rowCount();
    } else {
        echo "Parameters did not send to server";
    }
} else {
    echo "<h1>Something bad happend ;)</h1>";
}
