<?php
session_start();
require "../../init.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Company Model object
    $company = new Company();
    // Bussiness
    $bussiness = new Bussiness();
    // banks
    $bank = new Banks();

    if (isset($_SESSION["bussiness_user"])) {
        $loged_user = json_decode($_SESSION["bussiness_user"]);
        $allcurrency_data = $company->GetCompanyCurrency($loged_user->company_id);
        $allcurrency = $allcurrency_data->fetchAll(PDO::FETCH_OBJ);
        $mainCurrencyID = "";
        $mainCurrency = 0;
        foreach ($allcurrency as $crn) {
            if ($crn->mainCurrency == 1) {
                $mainCurrency = $crn->currency;
                $mainCurrencyID = $crn->company_currency_id;
            }
        }
    }


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

        $res = $company->addCompany([$cname, $clegalname, $ctype, $liscen, $cTIN, $creginum, $ccountry, $cprovince, $cdistrict, $cpostalcode, $cphone, $cfax, $caddress, $cwebsite, $cemail, time()]);
        $companyID = $res;

        // Add Company main currency
        $company->addCompanyCurrency([$companyID, $maincurrency, 1]);

        // Add Multi currency
        if ($_POST["currencyCount"] > 0) {
            for ($i = 1; $i <= $_POST["currencyCount"]; $i++) {
                $company->addCompanyCurrency([$companyID, $_POST[("ccurrency" . $i)], 0]);
            }
        }

        // Add Company Contract
        $contract_end_date = new DateTime($_POST["end_contract"]);
        $company->addCompanyContract([$companyID, time(), $contract_end_date->getTimestamp()]);

        // Add financial term
        // $fdate = new DateTime();
        // $ddates = $fdate->format('Y-m-d');
        // $fy = $company->openFY([$companyID, $ddates , $contract_end_date, "Financial Term", time(), 1]);


        // Add Company user for logging
        $fname = helper::test_input($_POST["fname"]);
        $lname = helper::test_input($_POST["lname"]);
        $username = helper::test_input($_POST["email"]);
        $password = helper::test_input($_POST["pass"]);

        // Add company customer first
        $customerID = $company->addCompanyCustomer([$companyID, $fname, $lname, "admin", "admin", time()], "company_id,fname,lname,alies_name,person_type,added_date", "?,?,?,?,?,?");
        $res = $company->addCompanyUser([$companyID, $customerID, $username, $password]);

        if ($_FILES['attachment']['size'] != 0) {
            // add attachments
            $fileNAme = time() . $_FILES['attachment']['name'];
            if (move_uploaded_file($_FILES['attachment']['tmp_name'], "../../business/uploadedfiles/company/" . $fileNAme)) {
                $company->addCompanyAttachment([$companyID, $fileNAme]);
            }
        }

        // if more attachment is submitted
        if ($_POST["attachCounter"] > 0) {
            $totalAttachemnts = $_POST["attachCounter"];
            for ($i = 0; $i <= $totalAttachemnts; $i++) {
                if ($_FILES[('attachment' . $i)]['size'] != 0) {
                    $fileName = time() . $_FILES[('attachment') . $i]['name'];
                    if (move_uploaded_file($_FILES[('attachment' . $i)]['tmp_name'], "../../business/uploadedfiles/company/" . $fileName)) {
                        $company->addCompanyAttachment([$companyID, $fileName]);
                    }
                }
            }
        }

        // add chart of accounts
        $allcats_data = $company->getAllCatagory();
        $allcats = $allcats_data->fetchAll(PDO::FETCH_OBJ);
        foreach ($allcats as $cat) {
            $bank->addCatagoryAccount([$cat->account_catagory_id, $cat->catagory, "NA", $maincurrency, time(), $companyID, 0, $cat->catagory, 0, 0]);
        }

        echo $companyID;
    }

    // update company
    if (isset($_POST["updatecompany"])) {
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
        $query = "UPDATE company SET company_name = ?,legal_name=?,company_type=?,license_number=?,TIN=?,register_number=?,country=?,province=?,district=?,postal_code=?,phone=?,fax=?,addres=?,website=?,email=? 
        WHERE company_id = ?";
        $parasm = [$cname, $clegalname, $ctype, $liscen, $cTIN, $creginum, $ccountry, $cprovince, $cdistrict, $cpostalcode, $cphone, $cfax, $caddress, $cwebsite, $cemail, $loged_user->company_id];
        $res = $company->updateCompany($query, $parasm);
        echo $res;
    }

    // Delete Company
    if (isset($_POST["deleteCompany"])) {
        $companyID = $_POST["companyID"];
        $company->deleteCompanyCurrency($companyID);
        $company->deleteCompanyContract($companyID);
        $bank->deleteCatagoryAccount($companyID);
        $company->deleteCompanyUser($companyID);
        $company->deleteCompany($companyID);
        echo "done";
    }

    // Add Company modules
    if (isset($_POST["addmodel"])) {
        $modelname = helper::test_input($_POST["modelname"]);
        $companyID = helper::test_input($_POST["userID"]);

        // Add company model
        $res = $company->addCompanyModel([$companyID, $modelname]);
        echo $res;
    }

    // Add Company User modules
    if (isset($_POST["addUserDenyModel"])) {
        $modelname = helper::test_input($_POST["modelname"]);
        $cusID = helper::test_input($_POST["cusID"]);

        $res1 = $company->getCompanyUserByCustomerID($cusID);
        $res_ID = $res1->fetch(PDO::FETCH_OBJ);

        // Add company model
        $res = $company->addCompanyUserModel([$res_ID->user_id, $modelname]);

        // Block every child of the model as well.
        $all_cheldren_data = $company->getCompanyModelAllChilds($modelname);
        $all_cheldren = $all_cheldren_data->fetchAll(PDO::FETCH_OBJ);
        foreach ($all_cheldren as $child) {
            // Add company model
            $company->addCompanyUserSubModel([$res_ID->user_id, $child->id]);
        }
        echo $res;
    }

    // Add Company User Sub modules
    if (isset($_POST["addUserSubDenyModel"])) {
        $modelname = helper::test_input($_POST["modelname"]);
        $cusID = helper::test_input($_POST["cusID"]);

        $res1 = $company->getCompanyUserByCustomerID($cusID);
        $res_ID = $res1->fetch(PDO::FETCH_OBJ);

        // Add company model
        $res = $company->addCompanyUserSubModel([$res_ID->user_id, $modelname]);
        echo $res;
    }

    // Remove Company Model
    if (isset($_POST["removeCompanyModel"])) {
        $modelID = helper::test_input($_POST["modelID"]);
        $res = $company->deleteCompanyModel($modelID);
        echo $res;
    }

    // Remove Company User Model
    if (isset($_POST["removeCompanyUserModel"])) {
        $modelID = helper::test_input($_POST["modelID"]);
        $userID = $_POST["cusID"];

        $res1 = $company->getCompanyUserByCustomerID($userID);
        $res_ID = $res1->fetch(PDO::FETCH_OBJ);

        // get Model details
        $details_data = $company->getCompanyUserModel($modelID);
        $details = $details_data->fetch(PDO::FETCH_OBJ);
        // Unblock every child of the model as well.
        $all_cheldren_data = $company->getCompanyModelAllChilds($details->company_model_id);
        $all_cheldren = $all_cheldren_data->fetchAll(PDO::FETCH_OBJ);
        foreach ($all_cheldren as $child) {
            // Remove company model
            $company->deleteCompanyUserSubModelByUser($child->id, $res_ID->user_id);
        }

        $res = $company->deleteCompanyUserModel($modelID, $res_ID->user_id);
        echo $modelID;
    }

    // Remove Company User Sub Model
    if (isset($_POST["removeCompanyUserSubModel"])) {
        $ID = $_POST["ID"];
        $res = $company->deleteCompanyUserSubModel($ID);
        echo $res;
    }

    // Add company users for loging in business panel
    if (isset($_POST["addnewuser"])) {
        $fname = helper::test_input($_POST["fname"]);
        $lname = helper::test_input($_POST["lname"]);
        $username = helper::test_input($_POST["email"]);
        $password = helper::test_input($_POST["pass"]);
        $companyID = helper::test_input($_POST["company"]);

        // Add company customer first
        $customerID = $company->addCompanyCustomer([$companyID, $fname, $lname, "admin", "admin", time()], "company_id,fname,lname,alies_name,person_type,added_date", "?,?,?,?,?,?");
        $res = $company->addCompanyUser([$companyID, $customerID, $username, $password]);
        echo $res->rowCount();
    }

    // add company user for loging
    if (isset($_POST["addcompanyLoginUser"])) {
        $cusID = $_POST["cusID"];
        $username = helper::test_input($_POST["username"]);
        $password = helper::generateRandomPass(10);
        $companyID = $loged_user->company_id;
        $res = $company->addCompanyUser([$companyID, $cusID, $username, $password]);
        if ($res->rowCount() > 0) {
            echo $password;
        } else {
            echo "error";
        }
    }

    // open new fiscal year
    if (isset($_POST["addcompany_financial_terms"])) {
        $banks = new Banks();
        $company = new Company();
        $bussiness = new Bussiness();

        $fiscal_year_start = helper::test_input($_POST["fiscal_year_start"]);
        $fiscal_year_end = helper::test_input($_POST["fiscal_year_end"]);
        $fiscal_year_title = helper::test_input($_POST["title"]);
        $company_ft = $_POST["company_ft"];
        // check current fiscal year
        $current_FY_data = $company->checkFY($loged_user->company_id);
        if ($current_FY_data->rowCount() > 0) {
            // get the ID of current FY
            $current_FY = $current_FY_data->fetch(PDO::FETCH_OBJ);
            $current_FY_ID = $current_FY->term_id;

            // close the current year and add new
            $company->closeFY($loged_user->company_id);

            // add new one
            $res = $company->openFY([$loged_user->company_id, $fiscal_year_start, $fiscal_year_end, $fiscal_year_title, time(), 1]);

            // get company Currency
            $currency_data = $company->GetCompanyCurrency($loged_user->company_id);
            $currency = $currency_data->fetchAll(PDO::FETCH_OBJ);
            $maincurrency = "";
            foreach ($currency as $crncy) {
                if ($crncy->mainCurrency) {
                    $maincurrency = $crncy->company_currency_id;
                    break;
                }
            }

            $totalAssets = 0;
            // ==================== Banks Balance ======================
            $banks_data = $banks->getBanks($loged_user->company_id);
            $banks_details = $banks_data->fetchAll(PDO::FETCH_OBJ);
            foreach ($banks_details as $bank) {
                // get bank money
                $bank_money_data = $banks->getBankSaifMoney($loged_user->company_id, $bank->chartofaccount_id, $company_ft);
                $bank_money = $bank_money_data->fetchAll(PDO::FETCH_OBJ);
                $btotal = 0;
                $rate = 0;
                $debit = 0;
                $credit = 0;
                foreach ($bank_money as $money) {
                    // get account currency details
                    $acc_currency_data = $company->GetCurrencyDetails($money->currency);
                    $acc_currency = $acc_currency_data->fetch(PDO::FETCH_OBJ);
                    if ($money->currency != $mainCurrencyID) {
                        $currency_exchange_data = $banks->getExchangeConversion($mainCurrency, $acc_currency->currency, $loged_user->company_id);
                        $currency_exchange = $currency_exchange_data->fetch(PDO::FETCH_OBJ);
                        if ($currency_exchange->currency_from == $mainCurrency) {
                            $rate = 1 / $currency_exchange->rate;
                        } else {
                            $rate = $currency_exchange->rate;
                        }
                        if ($money->ammount_type == "Crediet") {
                            $credit += $money->amount * $rate;
                        } else {
                            $debit += $money->amount * $rate;
                        }
                    } else {
                        $rate = 1;
                        if ($money->ammount_type == "Crediet") {
                            $credit += $money->amount * $rate;
                        } else {
                            $debit += $money->amount * $rate;
                        }
                    }
                    $btotal += round($debit - $credit);
                }

                // get bank currency
                $bank_currency = json_decode($company->GetCurrencyByName($bank->currency, $loged_user->company_id));

                // Get current rate
                $nrate = 0;
                // if ($bank_currency->currency != $mainCurrency) {
                //     $recent_exchange_data = $banks->getExchangeConversion($maincurrency, $bank_currency->currency, $loged_user->company_id);
                //     $recent_exchange = $recent_exchange_data->fetch(PDO::FETCH_OBJ);
                //     if($recent_exchange)
                //     {
                //         if ($recent_exchange->currency_from == $mainCurrency) {
                //             $nrate = 1 / $currency_exchange->rate;
                //             echo $nrate;
                //         } else {
                //             $nrate = $currency_exchange->rate;
                //             echo $nrate;
                //         }
                //     }
                //     echo $recent_exchange;
                // } else {
                //     $nrate = 0;
                // }
                if ($btotal > 0 || $btotal < 0) {
                    // Get Last Leadger ID of company
                    $LastLID = $company->getLeadgerID($loged_user->company_id, "Opening Balance");
                    $LastLID = "OPB-" . $LastLID;
                    // Debit the current amount from bank
                    $banks->addOpeningBalanceLeadger([$LastLID, $bank->chartofaccount_id, $bank->chartofaccount_id, $bank_currency->company_currency_id, 'Opening Balance', $current_FY_ID, time(), 1, $loged_user->user_id, 0, 'Opening Balance', $loged_user->company_id]);
                    $banks->addTransferMoney([$bank->chartofaccount_id, $LastLID, $btotal, "Crediet", $loged_user->company_id, 'Opening Balance', 0, $bank_currency->company_currency_id, $nrate]);
                    // array_push($total_banks, ["bankID" => $bank->chartofaccount_id, "name" => $bank->account_name, "amount" => $total]);Crediet

                    // Get Last Leadger ID of company
                    $LastLID = $company->getLeadgerID($loged_user->company_id, "Opening Balance");
                    $LastLID = "OPB-" . $LastLID;
                    // Credit the current amount of bank to new financial term
                    $banks->addOpeningBalanceLeadger([$LastLID, $bank->chartofaccount_id, $bank->chartofaccount_id, $bank_currency->company_currency_id, 'Opening Balance', $res, time(), 1, $loged_user->user_id, 0, 'Opening Balance', $loged_user->company_id]);
                    $banks->addTransferMoney([$bank->chartofaccount_id, $LastLID, $btotal, "Debet", $loged_user->company_id, 'Opening Balance', 0, $bank_currency->company_currency_id, $nrate]);
                }
                $totalAssets += $btotal;
            }

            // ==================== Saif Balance ======================
            $banks_data = $banks->getSaifs($loged_user->company_id);
            $banks_details = $banks_data->fetchAll(PDO::FETCH_OBJ);
            foreach ($banks_details as $bank) {
                // get bank money
                $bank_money_data = $banks->getBankSaifMoney($loged_user->company_id, $bank->chartofaccount_id, $company_ft);
                $bank_money = $bank_money_data->fetchAll(PDO::FETCH_OBJ);
                $stotal = 0;
                $rate = 0;
                $debit = 0;
                $credit = 0;
                foreach ($bank_money as $money) {
                    // get account currency details
                    $acc_currency_data = $company->GetCurrencyDetails($money->currency);
                    $acc_currency = $acc_currency_data->fetch(PDO::FETCH_OBJ);
                    if ($money->currency != $mainCurrencyID) {
                        $currency_exchange_data = $banks->getExchangeConversion($mainCurrency, $acc_currency->currency, $loged_user->company_id);
                        $currency_exchange = $currency_exchange_data->fetch(PDO::FETCH_OBJ);
                        if ($currency_exchange->currency_from == $mainCurrency) {
                            $rate = 1 / $currency_exchange->rate;
                        } else {
                            $rate = $currency_exchange->rate;
                        }
                        if ($money->ammount_type == "Crediet") {
                            $credit += $money->amount * $rate;
                        } else {
                            $debit += $money->amount * $rate;
                        }
                    } else {
                        $rate = 1;
                        if ($money->ammount_type == "Crediet") {
                            $credit += $money->amount * $rate;
                        } else {
                            $debit += $money->amount * $rate;
                        }
                    }
                    $stotal += round($debit - $credit);
                }

                // get bank currency
                $bank_currency = json_decode($company->GetCurrencyByName($bank->currency, $loged_user->company_id));

                // Get current rate
                $nrate = 0;
                // $recent_exchange_data = $banks->getExchangeConversion($maincurrency, $bank_currency->currency, $loged_user->company_id);
                // $recent_exchange = $recent_exchange_data->fetch(PDO::FETCH_OBJ);
                // if ($bank->currency != $mainCurrencyID) {
                //     if ($recent_exchange->currency_from == $mainCurrency) {
                //         $nrate = 1 / $currency_exchange->rate;
                //     } else {
                //         $nrate = $currency_exchange->rate;
                //     }
                // } else {
                //     $nrate = 0;
                // }

                if ($stotal > 0 || $stotal < 0) {
                    // Get Last Leadger ID of company
                    $LastLID = $company->getLeadgerID($loged_user->company_id, "Opening Balance");
                    $LastLID = "OPB-" . $LastLID;
                    // Debit the current amount from bank
                    $banks->addOpeningBalanceLeadger([$LastLID, $bank->chartofaccount_id, $bank->chartofaccount_id, $bank_currency->company_currency_id, 'Opening Balance', $current_FY_ID, time(), 1, $loged_user->user_id, 0, 'Opening Balance', $loged_user->company_id]);
                    $banks->addTransferMoney([$bank->chartofaccount_id, $LastLID, $stotal, "Crediet", $loged_user->company_id, 'Opening Balance', 0, $bank_currency->company_currency_id, $nrate]);
                    // array_push($total_banks, ["bankID" => $bank->chartofaccount_id, "name" => $bank->account_name, "amount" => $total]);Crediet

                    // Get Last Leadger ID of company
                    $LastLID = $company->getLeadgerID($loged_user->company_id, "Opening Balance");
                    $LastLID = "OPB-" . $LastLID;
                    // Credit the current amount of bank to new financial term
                    $banks->addOpeningBalanceLeadger([$LastLID, $bank->chartofaccount_id, $bank->chartofaccount_id, $bank_currency->company_currency_id, 'Opening Balance', $res, time(), 1, $loged_user->user_id, 0, 'Opening Balance', $loged_user->company_id]);
                    $banks->addTransferMoney([$bank->chartofaccount_id, $LastLID, $stotal, "Debet", $loged_user->company_id, 'Opening Balance', 0, $bank_currency->company_currency_id, $nrate]);
                    // array_push($total_saif, ["bankID" => $bank->chartofaccount_id, "name" => $bank->account_name, "amount" => $total]);
                }
                $totalAssets += $stotal;
            }

            $totalLibs = 0;
            // ==================== Customer Balance ======================
            $banks_data = $bussiness->getCompanyCustomers($loged_user->company_id);
            $banks_details = $banks_data->fetchAll(PDO::FETCH_OBJ);
            foreach ($banks_details as $bank) {
                // get customer payable account
                $payable_data = $bussiness->getPayableAccount($loged_user->company_id, $bank->customer_id);
                $payable = $payable_data->fetch(PDO::FETCH_OBJ);
                // get customer money
                $bank_money_data = $banks->getBankSaifMoney($loged_user->company_id, $payable->chartofaccount_id, $company_ft);
                $bank_money = $bank_money_data->fetchAll(PDO::FETCH_OBJ);
                $pamount = 0;
                $prate = 0;
                $ptotal = 0;
                foreach ($bank_money as $p_acc) {
                    // get account currency details
                    $acc_currency_data = $company->GetCurrencyDetails($p_acc->currency);
                    $acc_currency = $acc_currency_data->fetch(PDO::FETCH_OBJ);
                    if ($p_acc->currency != $mainCurrencyID) {
                        $currency_exchange_data = $banks->getExchangeConversion($mainCurrency, $acc_currency->currency, $loged_user->company_id);
                        $currency_exchange = $currency_exchange_data->fetch(PDO::FETCH_OBJ);
                        if ($currency_exchange->currency_from == $mainCurrency) {
                            $rate = 1 / $currency_exchange->rate;
                        } else {
                            $rate = $currency_exchange->rate;
                        }
                        $pamount += $p_acc->amount * $rate;
                    } else {
                        $pamount += $p_acc->amount;
                    }
                }

                // get customer receivable account
                $receivable_data = $bussiness->getRecivableAccount($loged_user->company_id, $bank->customer_id);
                $receivable = $receivable_data->fetch(PDO::FETCH_OBJ);

                // get customer money
                $bank_money_data1 = $banks->getBankSaifMoney($loged_user->company_id, $receivable->chartofaccount_id, $company_ft);
                $bank_money1 = $bank_money_data1->fetchAll(PDO::FETCH_OBJ);
                $rtotal = 0;
                $rrate = 0;
                $rdebit = 0;
                $rcredit = 0;
                foreach ($bank_money1 as $r_acc) {
                    // get account currency details
                    $acc_currency_data = $company->GetCurrencyDetails($r_acc->currency);
                    $acc_currency = $acc_currency_data->fetch(PDO::FETCH_OBJ);
                    if ($r_acc->currency != $mainCurrencyID) {
                        $currency_exchange_data = $banks->getExchangeConversion($mainCurrency, $acc_currency->currency, $loged_user->company_id);
                        $currency_exchange = $currency_exchange_data->fetch(PDO::FETCH_OBJ);
                        if ($currency_exchange->currency_from == $mainCurrency) {
                            $rate = 1 / $currency_exchange->rate;
                        } else {
                            $rate = $currency_exchange->rate;
                        }
                        if ($r_acc->ammount_type == "Crediet") {
                            $rcredit += $r_acc->amount * $rate;
                        } else {
                            $rdebit += $r_acc->amount * $rate;
                        }
                    } else {
                        $rate = 1;
                        if ($r_acc->ammount_type == "Crediet") {
                            $rcredit += $r_acc->amount * $rate;
                        } else {
                            $rdebit += $r_acc->amount * $rate;
                        }
                    }
                }
                $rtotal += round($rdebit - $rcredit);
                $ptotal += round($pamount);
                $totalAssets += $rtotal;
                $totalLibs += $ptotal;
                $custotal = $rtotal - $ptotal;
                if ($custotal > 0) {
                    
                    // get bank currency
                    $bank_currency = json_decode($company->GetCurrencyByName($receivable->currency, $loged_user->company_id));
                    // Get current rate
                    $nrate = 0;
                    // $recent_exchange_data = $banks->getExchangeConversion($maincurrency, $bank_currency->currency, $loged_user->company_id);
                    // $recent_exchange = $recent_exchange_data->fetch(PDO::FETCH_OBJ);
                    // if ($receivable->currency != $mainCurrency) {
                    //     if ($recent_exchange->currency_from == $mainCurrency) {
                    //         $nrate = 1 / $currency_exchange->rate;
                    //     } else {
                    //         $nrate = $currency_exchange->rate;
                    //     }
                    // } else {
                    //     $nrate = 0;
                    // }

                    // Get Last Leadger ID of company
                    $LastLID = $company->getLeadgerID($loged_user->company_id, "Opening Balance");
                    $LastLID = "OPB-" . $LastLID;
                    // Debit the current amount from bank
                    $banks->addOpeningBalanceLeadger([$LastLID, $receivable->chartofaccount_id, $receivable->chartofaccount_id, $bank_currency->company_currency_id, 'Opening Balance', $current_FY_ID, time(), 1, $loged_user->user_id, 0, 'Opening Balance', $loged_user->company_id]);
                    $banks->addTransferMoney([$bank->chartofaccount_id, $LastLID, $custotal, "Crediet", $loged_user->company_id, 'Opening Balance', 0, $bank_currency->company_currency_id, $nrate]);

                    // Get Last Leadger ID of company
                    $LastLID = $company->getLeadgerID($loged_user->company_id, "Opening Balance");
                    $LastLID = "OPB-" . $LastLID;
                    // Credit the current amount of bank to new financial term
                    $banks->addOpeningBalanceLeadger([$LastLID, $receivable->chartofaccount_id, $receivable->chartofaccount_id, $bank_currency->company_currency_id, 'Opening Balance', $res, time(), 1, $loged_user->user_id, 0, 'Opening Balance', $loged_user->company_id]);
                    $banks->addTransferMoney([$receivable->chartofaccount_id, $LastLID, $custotal, "Debet", $loged_user->company_id, 'Opening Balance', 0, $bank_currency->company_currency_id, $nrate]);
                    // array_push($total_customer, ["name" => $bank->fname . " " . $bank->lname, "amount" => ($rtotal - $ptotal)]);
                }

                if ($custotal < 0) {
                    // Get Last Leadger ID of company
                    $LastLID = $company->getLeadgerID($loged_user->company_id, "Opening Balance");
                    $LastLID = "OPB-" . $LastLID;
                    // get bank currency
                    $bank_currency = json_decode($company->GetCurrencyByName($payable->currency, $loged_user->company_id));
                    // Get current rate
                    $nrate = 0;
                    // $recent_exchange_data = $banks->getExchangeConversion($maincurrency, $bank_currency->currency, $loged_user->company_id);
                    // $recent_exchange = $recent_exchange_data->fetch(PDO::FETCH_OBJ);
                    // if ($receivable->currency != $mainCurrency) {
                    //     if ($recent_exchange->currency_from == $mainCurrency) {
                    //         $nrate = 1 / $currency_exchange->rate;
                    //     } else {
                    //         $nrate = $currency_exchange->rate;
                    //     }
                    // } else {
                    //     $nrate = 0;
                    // }
                    // Get Last Leadger ID of company
                    $LastLID = $company->getLeadgerID($loged_user->company_id, "Opening Balance");
                    $LastLID = "OPB-" . $LastLID;
                    // Debit the current amount from bank
                    $banks->addOpeningBalanceLeadger([$LastLID, $receivable->chartofaccount_id, $receivable->chartofaccount_id, $bank_currency->company_currency_id, 'Opening Balance', $current_FY_ID, time(), 1, $loged_user->user_id, 0, 'Opening Balance', $loged_user->company_id]);
                    $banks->addTransferMoney([$bank->chartofaccount_id, $LastLID, abs($custotal), "Debet", $loged_user->company_id, 'Opening Balance', 0, $bank_currency->company_currency_id, $nrate]);

                    // Get Last Leadger ID of company
                    $LastLID = $company->getLeadgerID($loged_user->company_id, "Opening Balance");
                    $LastLID = "OPB-" . $LastLID;
                    // Credit the current amount of bank to new financial term
                    $banks->addOpeningBalanceLeadger([$LastLID, $payable->chartofaccount_id, $payable->chartofaccount_id, $bank_currency->company_currency_id, 'Opening Balance', $res, time(), 1, $loged_user->user_id, 0, 'Opening Balance', $loged_user->company_id]);
                    $banks->addTransferMoney([$payable->chartofaccount_id, $LastLID, abs($custotal), "Crediet", $loged_user->company_id, 'Opening Balance', 0, $bank_currency->company_currency_id, $nrate]);
                    // array_push($total_customer, ["name" => $bank->fname . " " . $bank->lname, "amount" => ($rtotal - $ptotal)]);
                }
            }

            // share holders profit and losses
            $holder_counter = $_POST["holdersCount"];
            for ($i = 1; $i <= $holder_counter; $i++) {
                $h_name = explode('-', $_POST[("holder" . $i)]);
                $h_percent = $_POST[("percent" . $i)];
                $h_profit = $_POST[("profit" . $i)];

                if ($h_profit > 0 || $h_profit < 0) {
                    // get shareholder receivable accounts
                    // get customer receivable account
                    $holder_receivable_data = $bussiness->getRecivableAccount($loged_user->company_id, $h_name[0]);
                    $holder_receivable = $holder_receivable_data->fetch(PDO::FETCH_OBJ);

                    $op_type = $h_profit <= 0 ? "LOSE" : "PROFIT";
                    // Get Last Leadger ID of company
                    $LastLID = $company->getLeadgerID($loged_user->company_id, $op_type);
                    $LastLID = $op_type . "-" . $LastLID;
                    // Add leadger for each holder in their receivable account
                    $banks->addOpeningBalanceLeadger([$LastLID, $holder_receivable->chartofaccount_id, $holder_receivable->chartofaccount_id, $bank_currency->company_currency_id, $op_type, $res, time(), 1, $loged_user->user_id, 0, $op_type, $loged_user->company_id]);
                    $banks->addTransferMoney([$holder_receivable->chartofaccount_id, $LastLID, $h_profit, $op_type, $loged_user->company_id, $h_percent, 0, $bank_currency->company_currency_id, 0]);
                }
            }

            // add capital
            // Get Last Leadger ID of company
            $LastLID = $company->getLeadgerID($loged_user->company_id, "Opening Balance");
            $LastLID = "OPB-". $LastLID;
             
            // get initial investment account
            $capital_acc_data = $banks->getAccountByName($loged_user->company_id,"Initial Investment");
            $capital_acc = $capital_acc_data->fetch(PDO::FETCH_OBJ);

            $banks->addOpeningBalanceLeadger([$LastLID, $capital_acc->chartofaccount_id, $capital_acc->chartofaccount_id, $mainCurrencyID, "Opening Balance", $res, time(), 1, $loged_user->user_id, 0, "Opening Balance", $loged_user->company_id]);
            $banks->addTransferMoney([$capital_acc->chartofaccount_id, $LastLID,($totalLibs-$totalAssets),"Debet",$loged_user->company_id,"Opening Balance", 0, $mainCurrencyID, 0]);
            echo $res;
        } else {
            // add new fiscal year
            $res = $company->openFY([$loged_user->company_id, $fiscal_year_start, $fiscal_year_end, $fiscal_year_title, time(), 1]);
            echo $res;
        }
    }

    // Business Related Login
    // ===========================================

    // Login users for bussiness panel
    if (isset($_POST["bussinessLogin"])) {
        $username = helper::test_input($_POST["username"]);
        $passowrd = helper::test_input($_POST["password"]);

        $login = $company->login($username, $passowrd);
        if ($login->rowCount() > 0) {
            $loginData = $login->fetch(PDO::FETCH_ASSOC);
            // If company contract is expired 
            if ($loginData["disable"] == 1) {
                echo "renewContract";
            } else {
                // Add login logs
                $company->login_logs($loginData["user_id"], "login");

                // Make user online
                $res = $company->makeOnline($loginData["user_id"], 1);

                // if login is success
                $_SESSION["bussiness_user"] = json_encode($loginData);
                echo "logedin";
            }
        } else {
            echo "Notregisterd";
        }
    }

    // logout users from business panel
    if (isset($_POST["bussinessLogout"])) {
        // Logged in user info
        $loged_user = json_decode($_SESSION["bussiness_user"]);
        // Add login logs
        $company->login_logs($loged_user->user_id, "logout");

        // Make user online
        $company->makeOnline($loged_user->user_id, 0);
        session_destroy();
    }

    // Block login on a user
    if (isset($_POST["blockLogin"])) {
        $cusID = $_POST["cusID"];
        $res = $bussiness->blockCompanyLogin($cusID);
        echo $res->rowCount();
    }

    // Unblock login on a user
    if (isset($_POST["unblockLogin"])) {
        $cusID = $_POST["cusID"];
        $res = $bussiness->unBlockCompanyLogin($cusID);
        echo $res->rowCount();
    }

    // renew company contract
    if (isset($_POST["newcontract"])) {
        $sdate = strtotime($_POST["sdate"]);
        $edate = strtotime($_POST["edate"]);
        $CID = $_POST["CID"];
        $company->updateCompanyContract($CID);
        $company->addCompanyContract([$CID, $sdate, $edate]);
    }

    // add new currency to company
    if (isset($_POST["addcurrency"])) {
        $name = $_POST["name"];
        // Add Company main currency
        $res = $company->addCompanyCurrency([$loged_user->company_id, $name, 0]);
        echo $res;
    }

    // remove currency to company
    if (isset($_POST["removecurrency"])) {
        $id = $_POST["id"];
        // Add Company main currency
        $res = $company->deleteCurrency($id);
        echo $res;
    }
}



if ($_SERVER["REQUEST_METHOD"] == "GET") {

    // Company Model object
    $company = new Company();

    if (isset($_SESSION["bussiness_user"])) {
        // Logged in user info
        $loged_user = json_decode($_SESSION["bussiness_user"]);
    }

    // Get Company models : models that are not allowed to be used by company
    if (isset($_GET["getCompanyDenyModel"])) {
        $companyID = helper::test_input($_GET["companyID"]);
        $res = $company->getCompanyDenyModel($companyID);
        $models_data = $res->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($models_data);
    }

    // Get Company Models 
    if (isset($_GET["getcompanymodels"])) {
        $cusID = $_GET["cusID"];

        $res1 = $company->getCompanyUserByCustomerID($cusID);
        $res_ID = $res1->fetch(PDO::FETCH_OBJ);

        $res = $company->getCompanyModel($res_ID->user_id, $loged_user->company_id);
        $models_data = $res->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($models_data);
    }

    // Get Company Sub Models 
    if (isset($_GET["getcompanySubmodels"])) {
        $cusID = $_GET["cusID"];

        $res1 = $company->getCompanyUserByCustomerID($cusID);
        $res_ID = $res1->fetch(PDO::FETCH_OBJ);

        $res = $company->getCompanySubModel($res_ID->user_id, $loged_user->company_id);
        $models_data = $res->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($models_data);
    }

    // Get Company users models : models that are not allowed to be used by company users
    if (isset($_GET["getCompanyUserDenyModel"])) {
        $cusID = helper::test_input($_GET["cusID"]);

        $res1 = $company->getCompanyUserByCustomerID($cusID);
        $res_ID = $res1->fetch(PDO::FETCH_OBJ);

        $res = $company->getCompanyUserDenyModel($res_ID->user_id);
        $models_data = $res->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($models_data);
    }

    // Get Company users models : models that are not allowed to be performed CRUID by company users
    if (isset($_GET["getCompanyUserCRUIDModel"])) {
        $cusID = helper::test_input($_GET["cusID"]);

        $res1 = $company->getCompanyUserByCustomerID($cusID);
        $res_ID = $res1->fetch(PDO::FETCH_OBJ);

        $res = $company->getCompanyUserCRUIDModel($res_ID->user_id);
        $models_data = $res->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($models_data);
    }
}
