<?php
if ($_GET["op"] == "payment") {
    $Active_nav_name = array("parent" => "Payment & Expense", "child" => "Payment List");
}

if ($_GET["op"] == "expense") {
    $Active_nav_name = array("parent" => "Payment & Expense", "child" => "Expense List");
}

if ($_GET["op"] == "receipt") {
    $Active_nav_name = array("parent" => "Receipt & Revenue", "child" => "Receipt List");
}

if ($_GET["op"] == "revenue") {
    $Active_nav_name = array("parent" => "Receipt & Revenue", "child" => "Revenue List");
}

if ($_GET["op"] == "ot") {
    $Active_nav_name = array("parent" => "Receipt & Revenue", "child" => "Out Transference list");
}

if ($_GET["op"] == "in") {
    $Active_nav_name = array("parent" => "Payment & Expense", "child" => "In Transference list");
}

if ($_GET["op"] == "ex") {
    $Active_nav_name = array("parent" => "Banking", "child" => "Exchange List");
}

if ($_GET["op"] == "bt") {
    $Active_nav_name = array("parent" => "Banking", "child" => "Transfer List");
}

if ($_GET["op"] == "op") {
    $Active_nav_name = array("parent" => "Accounting", "child" => "Opening Balance");
}

if ($_GET["op"] == "cus") {
    $Active_nav_name = array("parent" => "Contact", "child" => "Contact List");
}

$page_title = "Edite";
include("./master/header.php");

$company = new Company();
$bussiness = new Bussiness();
$receipt = new Receipt();
$banks = new Banks();
$revenue = new Revenue();
$expense = new Expense();
$transfer = new Transfer();

$allcurrency_data = $company->GetCompanyCurrency($user_data->company_id);
$allcurrency = $allcurrency_data->fetchAll(PDO::FETCH_OBJ);

$allContacts_data = $bussiness->getCompanyCustomersWithAccounts($user_data->company_id, $user_data->user_id);
$allContacts = $allContacts_data->fetchAll(PDO::FETCH_OBJ);

$revenue_data = $revenue->getRevenueAccounts($user_data->company_id);
$revenue = $revenue_data->fetchAll(PDO::FETCH_OBJ);

$epxense_data = $expense->getExpenseAccounts($user_data->company_id);
$expenses = $epxense_data->fetchAll(PDO::FETCH_OBJ);

$all_saraf_data = $bussiness->getAllSarafs($user_data->company_id);
$all_saraf = $all_saraf_data->fetchAll(PDO::FETCH_OBJ);

$all_daily_cus_data = $bussiness->GetAllDailyCustomers();
$allDailyCus = $all_daily_cus_data->fetchAll(PDO::FETCH_OBJ);

// get all banks
$all_banks_data = $banks->getBanks($user_data->company_id);
$all_banks = $all_banks_data->fetchAll(PDO::FETCH_OBJ);

function recurSearch2($c, $parentID, $ID)
{
    $conn = new Connection();
    $query = "SELECT * FROM account_catagory 
    INNER JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
    WHERE parentID = ? AND chartofaccount.company_id = ?";
    $result = $conn->Query($query, [$parentID, $c]);
    $results = $result->fetchAll(PDO::FETCH_OBJ);
    foreach ($results as $item) {
        $selected = "";
        if ($item->chartofaccount_id == $ID) {
            $selected = "selected";
        }
        echo "<option class='$item->currency' value='$item->chartofaccount_id' $selected> $item->account_name</option>";
        if (checkChilds($item->account_catagory_id) > 0) {
            recurSearch2($c, $item->account_catagory_id, $ID);
        }
    }
}

function checkChilds($patne)
{
    $conn = new Connection();
    $query = "SELECT * FROM account_catagory WHERE parentID = ? AND useradded = ?";
    $result = $conn->Query($query, [$patne, 0]);
    $results = $result->rowCount();
    return $results;
}
?>

<style>
    .pulldown {
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .pulldown .pulldown-toggle-round {
        box-shadow: 0 4px 5px 0 rgba(0, 0, 0, .14), 0 1px 10px 0 rgba(0, 0, 0, .12), 0 2px 4px -1px rgba(0, 0, 0, .2)
    }

    /* Styles for our pulldown menus */

    .pulldown {
        position: relative;
    }

    .pulldown .pulldown-toggle {
        cursor: pointer;
    }

    .pulldown .pulldown-toggle-round {
        height: 50px;
        width: 50px;
        border-radius: 60px;
        cursor: pointer;
        text-align: center;
        background: #ff1744;
        -webkit-transition: .35s ease-in-out;
        -moz-transition: .35s ease-in-out;
        -o-transition: .35s ease-in-out;
    }

    .pulldown .pulldown-toggle.open {
        transform: rotate(270deg);
        background: #78909c;
    }

    .pulldown-toggle.pulldown-toggle-round i {
        line-height: 50px;
        color: #FFF;
        font-size: 30px;
    }

    .pulldown .pulldown-menu {
        position: absolute;
        top: 40px;
        left: 20%;
        width: 180px;
        background-color: #fff;
        border-radius: 1px;
        display: none;
        z-index: 10;
        box-shadow: 0px 2px 12px rgba(0, 0, 0, .2);
    }

    .pulldown-right .pulldown-menu {
        left: auto;
        right: 0px;
    }

    .pulldown-toggle.open+.pulldown-menu {
        display: block;
        -webkit-animation-name: openPullDown;
        animation-name: openPullDown;
        -webkit-animation-duration: 500ms;
        animation-duration: 500ms;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
        -webkit-transform-origin: left top;
        transform-origin: left top;
    }

    .pulldown-right .pulldown-toggle.open+.pulldown-menu {
        -webkit-transform-origin: right top;
        transform-origin: right top;
    }

    .pulldown-menu ul {
        list-style: none;
        padding: 0;
        margin: 8px 0;
        background: transparent;
        position: absolute;
        display: flex;
        flex-direction: row;

    }

    .pulldown-menu ul li {
        background-color: dodgerblue;
        padding: 0;
        margin: 4px;
        height: fit-content;
        width: fit-content;
        border-radius: 50%;
        padding: 6px;
    }

    .pulldown-menu ul li:hover {
        cursor: pointer;
        transform: scale(1.09);
    }

    @media (max-width: 550px) {
        .pulldown-toggle.open+.pulldown-menu {
            -webkit-animation-name: openPullDownMobile;
            animation-name: openPullDownMobile;
            -webkit-animation-duration: 200ms;
            animation-duration: 200ms;
        }
    }


    /*
    |
    | Grow from origin
    |
    */

    @-webkit-keyframes openPullDown {
        0% {
            opacity: 0;
            -webkit-transform: scale(.7);
            transform: scale(.7);
        }

        100% {
            opacity: 1;
            -webkit-transform: scale(1);
            transform: scale(1);
        }
    }

    @keyframes openPullDown {
        0% {
            opacity: 0;
            -webkit-transform: scale(.7);
            -ms-transform: scale(.7);
            transform: scale(.7);
        }

        100% {
            opacity: 1;
            -webkit-transform: scale(1);
            -ms-transform: scale(1);
            transform: scale(1);
        }
    }


    /*
    |
    | Slide up from bottom
    |
    */

    @-webkit-keyframes openPullDownMobile {
        0% {
            -webkit-transform: translate(0%, 100%);
            transform: translate(0%, 100%);
        }

        100% {
            -webkit-transform: translate(0%, 0%);
            transform: translate(0%, 0%);
        }
    }

    @keyframes openPullDownMobile {
        0% {
            -webkit-transform: translate(0%, 100%);
            -ms-transform: translate(0%, 100%);
            transform: translate(0%, 100%);
        }

        100% {
            -webkit-transform: translate(0%, 0%);
            -ms-transform: translate(0%, 0%);
            transform: translate(0%, 0%);
        }
    }
</style>

<?php if (isset($_GET["op"])) {
    if ($_GET["op"] == "ot") {
        $receipts_data = $transfer->getTransferByLeadgerID($_GET["edit"], $user_data->company_id);
        $receipts = $receipts_data->fetch(PDO::FETCH_OBJ);
        $account_details = $banks->getBankByID($receipts->recievable_id);
        $account = $account_details->fetch(PDO::FETCH_OBJ);

        // money sender
        $sender_data = $bussiness->GetDailyCustomerByID($receipts->money_sender);
        $sender = $sender_data->fetch(PDO::FETCH_OBJ);

        // money receiver
        $receiver_data = $bussiness->GetDailyCustomerByID($receipts->money_receiver);
        $receiver = $receiver_data->fetch(PDO::FETCH_OBJ);

?>
        <!-- BEGIN: Content-->
        <div class="container p-1" data-href="<?php echo $mainCurrency; ?>">
            <section id="basic-form-layouts">
                <div class="row match-height">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <form class="form">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label for="details">Description</label>
                                                <textarea id="details" class="form-control required" rows="1" placeholder="Description" name="details" style="border:none; border-bottom:1px solid gray"><?php echo $receipts->details ?></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="date">Date</label>
                                                        <input type="date" id="date" class="form-control required" placeholder="Date" name="date" value="<?php echo Date('Y-m-d', $receipts->reg_date) ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="date">Receiver Saraf</label>
                                                        <select class="form-control chosen required" name="rsaraf_ID" id="rsaraf_ID" data-placeholder="Choose a Saraf...">
                                                            <option value="" selected>Select</option>
                                                            <?php
                                                            foreach ($all_saraf as $saraf) {
                                                                $selected = "";
                                                                if ($saraf->chartofaccount_id == $receipts->payable_id) {
                                                                    $selected = "selected";
                                                                }
                                                                echo "<option class='$saraf->currency' value='$saraf->chartofaccount_id' data-href='$saraf->cutomer_id' $selected>$saraf->fname $saraf->lname</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="date">Transfer Code</label>
                                                        <input type="text" id="transfercode" class="form-control" placeholder="Transfer Code" name="transfercode" readonly value="<?php echo $receipts->transfer_code ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="date">Voucher Code</label>
                                                        <input type="text" id="vouchercode" class="form-control" placeholder="Voucher Code" name="vouchercode" value="<?php echo $receipts->voucher_code ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="currency">Currency</label>
                                                        <select type="text" id="currency" class="form-control" placeholder="Currency" name="currency">
                                                            <?php
                                                            foreach ($allcurrency as $currency) {
                                                                $selected = $currency->currency == $receipts->currency ? "selected" : "";
                                                                echo "<option value='$currency->company_currency_id' $selected>$currency->currency</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="currency">Amount</label>
                                                        <input type="number" id="amount" class="form-control required" placeholder="Amount" name="amount" value="<?php echo $receipts->amount ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="currency">My Commission</label>
                                                        <input type="number" id="mycommission" class="form-control required" placeholder="Amount" name="mycommission" prev="<?php echo $receipts->company_user_sender_commission ?>" value="<?php echo $receipts->company_user_sender_commission ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="currency">Saraf Commission</label>
                                                        <input type="number" id="sarafcommission" class="form-control required" placeholder="Amount" name="sarafcommission" prev="<?php echo $receipts->company_user_receiver_commission ?>" value="<?php echo $receipts->company_user_receiver_commission ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row pt-0 pb-0 pl-1 pr-1">
                                                <div class="col-lg-6 p-0 pr-1">
                                                    <div class="card bg-light p-0">
                                                        <h3 class="card-title text-center pt-1">Sender</h3>
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="currency">Phone Number</label>
                                                                <input type="text" class="form-control" name="sender_phone" id="sender_phone" placeholder="Phone Number" list="dailyCustomers" value="<?php echo $sender->personal_phone ?>" />
                                                                <datalist id="dailyCustomers">
                                                                    <?php
                                                                    foreach ($allDailyCus as $dailyCus) {
                                                                        echo "<option value='$dailyCus->personal_phone'>$dailyCus->fname $dailyCus->lname</option>";
                                                                    }
                                                                    ?>
                                                                </datalist>
                                                                <span class="la la-spinner spinner blue mt-1 d-none" style="font-size: 25px;"></span>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-md-6 col-xs-12">
                                                                    <label for="currency">First Name</label>
                                                                    <input type="text" class="form-control required" name="sender_fname" id="sender_fname" placeholder="First Name" value="<?php echo $sender->fname ?>" />
                                                                </div>
                                                                <div class="form-group col-md-6 col-xs-12">
                                                                    <label for="currency">Last Name</label>
                                                                    <input type="text" class="form-control" name="sender_lname" id="sender_lname" placeholder="Last Name" value="<?php echo $sender->lname ?>" />
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="form-group col-md-6 col-xs-12">
                                                                    <label for="currency">Father Name</label>
                                                                    <input type="text" class="form-control" name="sender_Fathername" id="sender_Fathername" placeholder="Father Name" value="<?php echo $sender->alies_name ?>" />
                                                                </div>
                                                                <div class="form-group col-md-6 col-xs-12">
                                                                    <label for="currency">NID</label>
                                                                    <input type="text" class="form-control" name="sender_nid" id="sender_nid" placeholder="NID" value="<?php echo $sender->NID ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="details">Description</label>
                                                                <textarea id="sender_details" class="form-control" rows="1" style="border:none; border-bottom:1px solid gray" placeholder="Description" name="sender_details"><?php echo $sender->details ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 p-0">
                                                    <div class="card bg-light p-0 pl-1">
                                                        <h3 class="card-title text-center pt-1">Receiver</h3>
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="currency">Phone Number</label>
                                                                <input type="text" list="dailyCustomers2" class="form-control" name="receiver_phone" id="receiver_phone" placeholder="Phone Number" value="<?php echo $receiver->personal_phone ?>" />
                                                                <datalist id="dailyCustomers2">
                                                                    <?php
                                                                    foreach ($allDailyCus as $dailyCus) {
                                                                        echo "<option value='$dailyCus->personal_phone'>$dailyCus->fname $dailyCus->lname</option>";
                                                                    }
                                                                    ?>
                                                                </datalist>
                                                                <span class="la la-spinner spinner blue mt-1 d-none" style="font-size: 25px;"></span>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-md-6 col-xs-12">
                                                                    <label for="currency">First Name</label>
                                                                    <input type="text" class="form-control required" name="receiver_fname" id="receiver_fname" placeholder="First Name" value="<?php echo $receiver->fname ?>" />
                                                                </div>
                                                                <div class="form-group col-md-6 col-xs-12">
                                                                    <label for="currency">Last Name</label>
                                                                    <input type="text" class="form-control" name="receiver_lname" id="receiver_lname" placeholder="Last Name" value="<?php echo $receiver->lname ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-md-6 col-xs-12">
                                                                    <label for="currency">Father Name</label>
                                                                    <input type="text" class="form-control" name="receiver_Fathername" id="receiver_Fathername" placeholder="Father Name" value="<?php echo $receiver->alies_name ?>" />
                                                                </div>
                                                                <div class="form-group col-md-6 col-xs-12">
                                                                    <label for="currency">NID</label>
                                                                    <input type="text" class="form-control" name="receiver_nid" id="receiver_nid" placeholder="NID" value="<?php echo $receiver->NID ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="details">Description</label>
                                                                <textarea id="receiver_details" class="form-control p-0" rows="1" style="border:none; border-bottom:1px solid gray" placeholder="Description" name="receiver_details"><?php echo $receiver->details ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 error d-none">
                                                    <span class="alert alert-danger"></span>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 mb-1 mt-0">
                                                <div class="pen-outer">
                                                    <div class="pulldown">
                                                        <h3 class="card-title mr-2">Payment Type</h3>
                                                        <div class="pulldown-toggle pulldown-toggle-round">
                                                            <i class="la la-plus"></i>
                                                        </div>
                                                        <div class="pulldown-menu">
                                                            <ul>
                                                                <li class="addreciptItem" item="bank">
                                                                    <i class="la la-bank" style="font-size:30px;color:white"></i>
                                                                </li>
                                                                <li class="addreciptItem" item="saif">
                                                                    <i class="la la-box" style="font-size:30px;color:white"></i>
                                                                </li>
                                                                <li class="addreciptItem" item="customer">
                                                                    <i class="la la-user" style="font-size:30px;color:white"></i>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="clac ml-2" style="display: flex;flex-direction:column">
                                                            <span>Sum: <span id="sum" style="color: dodgerblue; font-weight: bold;"></span></span>
                                                            <span>Rest: <span id="rest" style="color: tomato; font-weight: bold;">0</span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 paymentContainer">
                                                <div class="card bg-light">
                                                    <div class="card-header">
                                                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                                        <div class="heading-elements">
                                                            <ul class="list-inline mb-0">
                                                                <li><a class="deleteMore" href="#"><i class="ft-x"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="card-content">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-1"><i class="la la-bank" style="font-size: 50px;color:dodgerblue"></i></div>
                                                                <div class="col-lg-7">
                                                                    <div class="form-group">
                                                                        <label for="reciptItemID">Bank/Saif</label>
                                                                        <select class="form-control customer" name="reciptItemID" id="reciptItemID" data="bank">
                                                                            <option value="<?php echo $account->chartofaccount_id ?>" cur="<?php echo $receipts->currency_id ?>"><?php echo $account->account_name ?></option>
                                                                        </select><label class="d-none balance"></label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label for="reciptItemAmount">Amount</label>
                                                                        <input type="number" name="reciptItemAmount" id="reciptItemAmount" class="form-control required receiptamount" value="<?php echo $receipts->amount ?>" placeholder="Amount">
                                                                        <label class="d-none rate"></label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label for="reciptItemdetails">Details</label>
                                                                        <input type="text" name="reciptItemdetails" id="reciptItemdetails" class="form-control details" placeholder="Details" value="<?php echo $receipts->remarks ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <button type="button" id="btneditreceipt" class="btn btn-info waves-effect waves-light">
                                                <i class="la la-check-square-o"></i> Save
                                            </button>
                                            <button type="button" id="btnprint" class="btn btn-info waves-effect waves-light">
                                                <i class="la la-print"></i> Print
                                            </button>
                                        </div>
                                        <input type="hidden" name="<?php echo $_GET['op'] ?>" id="<?php echo $_GET['op'] ?>">
                                        <input type="hidden" name="LID" id="LID" value="<?php echo $_GET['edit'] ?>">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- END: Content-->
    <?php } else if ($_GET["op"] == "in") {
        $receipts_data = $transfer->getTransferByLeadgerID($_GET["edit"], $user_data->company_id);
        $receipts = $receipts_data->fetch(PDO::FETCH_OBJ);
        $account_details = $banks->getBankByID($receipts->recievable_id);
        $account = $account_details->fetch(PDO::FETCH_OBJ);

        // money sender
        $sender_data = $bussiness->GetDailyCustomerByID($receipts->money_sender);
        $sender = $sender_data->fetch(PDO::FETCH_OBJ);

        // money receiver
        $receiver_data = $bussiness->GetDailyCustomerByID($receipts->money_receiver);
        $receiver = $receiver_data->fetch(PDO::FETCH_OBJ); ?>
        <!-- BEGIN: Content-->
        <div class="container p-1" data-href="<?php echo $mainCurrency; ?>">
            <section id="basic-form-layouts">
                <div class="row match-height">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <form class="form">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label for="details">Description</label>
                                                <textarea id="details" class="form-control required" rows="1" placeholder="Description" name="details" style="border:none; border-bottom:1px solid gray"><?php echo $receipts->details ?></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="date">Date</label>
                                                        <input type="date" id="date" class="form-control required" placeholder="Date" name="date" value="<?php echo Date('Y-m-d', $receipts->reg_date) ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="date">Receiver Saraf</label>
                                                        <select class="form-control chosen required" name="rsaraf_ID" id="rsaraf_ID" data-placeholder="Choose a Saraf...">
                                                            <option value="" selected>Select</option>
                                                            <?php
                                                            foreach ($all_saraf as $saraf) {
                                                                $selected = "";
                                                                if ($saraf->chartofaccount_id == $receipts->payable_id) {
                                                                    $selected = "selected";
                                                                }
                                                                echo "<option class='$saraf->currency' value='$saraf->chartofaccount_id' data-href='$saraf->cutomer_id' $selected>$saraf->fname $saraf->lname</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="date">Transfer Code</label>
                                                        <input type="text" id="transfercode" class="form-control" placeholder="Transfer Code" name="transfercode" readonly value="<?php echo $receipts->transfer_code ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="date">Voucher Code</label>
                                                        <input type="text" id="vouchercode" class="form-control" placeholder="Voucher Code" name="vouchercode" value="<?php echo $receipts->voucher_code ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="currency">Currency</label>
                                                        <select type="text" id="currency" class="form-control" placeholder="Currency" name="currency">
                                                            <?php
                                                            foreach ($allcurrency as $currency) {
                                                                $selected = $currency->currency == $receipts->currency ? "selected" : "";
                                                                echo "<option value='$currency->company_currency_id' $selected>$currency->currency</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="currency">Amount</label>
                                                        <input type="number" id="amount" class="form-control required" placeholder="Amount" name="amount" value="<?php echo $receipts->amount ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="currency">Commission</label>
                                                        <input type="number" id="sarafcommission" class="form-control required" placeholder="Amount" name="sarafcommission" prev="<?php echo $receipts->company_user_receiver_commission ?>" value="<?php echo $receipts->company_user_receiver_commission ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row pt-0 pb-0 pl-1 pr-1">
                                                <div class="col-lg-6 p-0 pr-1">
                                                    <div class="card bg-light p-0">
                                                        <h3 class="card-title text-center pt-1">Sender</h3>
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="currency">Phone Number</label>
                                                                <input type="text" class="form-control" name="sender_phone" id="sender_phone" placeholder="Phone Number" list="dailyCustomers" value="<?php echo $sender->personal_phone ?>" />
                                                                <datalist id="dailyCustomers">
                                                                    <?php
                                                                    foreach ($allDailyCus as $dailyCus) {
                                                                        echo "<option value='$dailyCus->personal_phone'>$dailyCus->fname $dailyCus->lname</option>";
                                                                    }
                                                                    ?>
                                                                </datalist>
                                                                <span class="la la-spinner spinner blue mt-1 d-none" style="font-size: 25px;"></span>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-md-6 col-xs-12">
                                                                    <label for="currency">First Name</label>
                                                                    <input type="text" class="form-control required" name="sender_fname" id="sender_fname" placeholder="First Name" value="<?php echo $sender->fname ?>" />
                                                                </div>
                                                                <div class="form-group col-md-6 col-xs-12">
                                                                    <label for="currency">Last Name</label>
                                                                    <input type="text" class="form-control" name="sender_lname" id="sender_lname" placeholder="Last Name" value="<?php echo $sender->lname ?>" />
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="form-group col-md-6 col-xs-12">
                                                                    <label for="currency">Father Name</label>
                                                                    <input type="text" class="form-control" name="sender_Fathername" id="sender_Fathername" placeholder="Father Name" value="<?php echo $sender->alies_name ?>" />
                                                                </div>
                                                                <div class="form-group col-md-6 col-xs-12">
                                                                    <label for="currency">NID</label>
                                                                    <input type="text" class="form-control" name="sender_nid" id="sender_nid" placeholder="NID" value="<?php echo $sender->NID ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="details">Description</label>
                                                                <textarea id="sender_details" class="form-control" rows="1" style="border:none; border-bottom:1px solid gray" placeholder="Description" name="sender_details"><?php echo $sender->details ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 p-0">
                                                    <div class="card bg-light p-0 pl-1">
                                                        <h3 class="card-title text-center pt-1">Receiver</h3>
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="currency">Phone Number</label>
                                                                <input type="text" list="dailyCustomers2" class="form-control" name="receiver_phone" id="receiver_phone" placeholder="Phone Number" value="<?php echo $receiver->personal_phone ?>" />
                                                                <datalist id="dailyCustomers2">
                                                                    <?php
                                                                    foreach ($allDailyCus as $dailyCus) {
                                                                        echo "<option value='$dailyCus->personal_phone'>$dailyCus->fname $dailyCus->lname</option>";
                                                                    }
                                                                    ?>
                                                                </datalist>
                                                                <span class="la la-spinner spinner blue mt-1 d-none" style="font-size: 25px;"></span>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-md-6 col-xs-12">
                                                                    <label for="currency">First Name</label>
                                                                    <input type="text" class="form-control required" name="receiver_fname" id="receiver_fname" placeholder="First Name" value="<?php echo $receiver->fname ?>" />
                                                                </div>
                                                                <div class="form-group col-md-6 col-xs-12">
                                                                    <label for="currency">Last Name</label>
                                                                    <input type="text" class="form-control" name="receiver_lname" id="receiver_lname" placeholder="Last Name" value="<?php echo $receiver->lname ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-md-6 col-xs-12">
                                                                    <label for="currency">Father Name</label>
                                                                    <input type="text" class="form-control" name="receiver_Fathername" id="receiver_Fathername" placeholder="Father Name" value="<?php echo $receiver->alies_name ?>" />
                                                                </div>
                                                                <div class="form-group col-md-6 col-xs-12">
                                                                    <label for="currency">NID</label>
                                                                    <input type="text" class="form-control" name="receiver_nid" id="receiver_nid" placeholder="NID" value="<?php echo $receiver->NID ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="details">Description</label>
                                                                <textarea id="receiver_details" class="form-control p-0" rows="1" style="border:none; border-bottom:1px solid gray" placeholder="Description" name="receiver_details"><?php echo $receiver->details ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 error d-none">
                                                    <span class="alert alert-danger"></span>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 mb-1 mt-0">
                                                <div class="pen-outer">
                                                    <div class="pulldown">
                                                        <h3 class="card-title mr-2">Payment Type</h3>
                                                        <div class="pulldown-toggle pulldown-toggle-round">
                                                            <i class="la la-plus"></i>
                                                        </div>
                                                        <div class="pulldown-menu">
                                                            <ul>
                                                                <li class="addreciptItem" item="bank">
                                                                    <i class="la la-bank" style="font-size:30px;color:white"></i>
                                                                </li>
                                                                <li class="addreciptItem" item="saif">
                                                                    <i class="la la-box" style="font-size:30px;color:white"></i>
                                                                </li>
                                                                <li class="addreciptItem" item="customer">
                                                                    <i class="la la-user" style="font-size:30px;color:white"></i>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="clac ml-2" style="display: flex;flex-direction:column">
                                                            <span>Sum: <span id="sum" style="color: dodgerblue; font-weight: bold;"></span></span>
                                                            <span>Rest: <span id="rest" style="color: tomato; font-weight: bold;">0</span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 paymentContainer">
                                                <div class="card bg-light">
                                                    <div class="card-header">
                                                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                                        <div class="heading-elements">
                                                            <ul class="list-inline mb-0">
                                                                <li><a class="deleteMore" href="#"><i class="ft-x"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="card-content">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-1"><i class="la la-bank" style="font-size: 50px;color:dodgerblue"></i></div>
                                                                <div class="col-lg-7">
                                                                    <div class="form-group">
                                                                        <label for="reciptItemID">Bank/Saif</label>
                                                                        <select class="form-control customer" name="reciptItemID" id="reciptItemID" data="bank">
                                                                            <option value="<?php echo $account->chartofaccount_id ?>" cur="<?php echo $receipts->currency_id ?>"><?php echo $account->account_name ?></option>
                                                                        </select><label class="d-none balance"></label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label for="reciptItemAmount">Amount</label>
                                                                        <input type="number" name="reciptItemAmount" id="reciptItemAmount" class="form-control required receiptamount" value="<?php echo $receipts->amount ?>" placeholder="Amount">
                                                                        <label class="d-none rate"></label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label for="reciptItemdetails">Details</label>
                                                                        <input type="text" name="reciptItemdetails" id="reciptItemdetails" class="form-control details" placeholder="Details" value="<?php echo $receipts->remarks ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <button type="button" id="btneditreceipt" class="btn btn-info waves-effect waves-light">
                                                <i class="la la-check-square-o"></i> Save
                                            </button>
                                            <button type="button" id="btnprint" class="btn btn-info waves-effect waves-light">
                                                <i class="la la-print"></i> Print
                                            </button>
                                        </div>
                                        <input type="hidden" name="<?php echo $_GET['op'] ?>" id="<?php echo $_GET['op'] ?>">
                                        <input type="hidden" name="LID" id="LID" value="<?php echo $_GET['edit'] ?>">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- END: Content-->
    <?php } else if ($_GET["op"] == "ex") {
        $receipts_data = $banks->getExchangeMoney($_GET["edit"]);
        $receipts = $receipts_data->fetch(PDO::FETCH_OBJ);
        // account from
        $acc_from_data = $banks->getSystemAccount($receipts->payable_id);
        $acc_from = $acc_from_data->fetch(PDO::FETCH_OBJ);

        // get account from money
        $money_to_data = $banks->getMoney($receipts->payable_id, $receipts->leadger_id);
        $money_to = $money_to_data->fetch(PDO::FETCH_OBJ);
        // account to
        $acc_to_data = $banks->getSystemAccount($receipts->recievable_id);
        $acc_to = $acc_to_data->fetch(PDO::FETCH_OBJ);

        // get account from money
        $money_from_data = $banks->getMoney($receipts->recievable_id, $receipts->leadger_id);
        $money_from = $money_from_data->fetch(PDO::FETCH_OBJ);
    ?>
        <!-- BEGIN: Content-->
        <div class="container pt-5">
            <section id="basic-form-layouts">
                <div class="row match-height">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <form class="form">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="date">Date</label>
                                                        <input type="date" id="date" class="form-control required" placeholder="Date" name="date" value="<?php echo Date('Y-m-d', $receipts->reg_date) ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="form-group">
                                                        <label for="details">Description</label>
                                                        <textarea id="details" class="form-control required" placeholder="Description" rows="1" name="details" style="border:0;border-bottom:1px solid gray"><?php echo $receipts->remarks; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="currencyfrom">Currency From</label>
                                                        <select type="text" id="currencyfrom" class="form-control required" placeholder="Currency From" name="currencyfrom">
                                                            <option value="0">Select</option>
                                                            <?php
                                                            foreach ($allcurrency as $currency) {
                                                                $selected = $currency->company_currency_id == $money_to->currency ? "selected" : '';
                                                                echo "<option value='$currency->company_currency_id' $selected>$currency->currency</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="eamount">Amount</label>
                                                        <input type="number" id="eamount" class="form-control required" placeholder="amount" name="eamount" value="<?php echo $money_to->amount ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="bankfrom">Siaf/Bank</label>
                                                        <input type="text" name="bankfrom" id="bankfrom" placeholder="<?php echo $acc_from->account_name ?>" autocomplete="off" class="form-control" />
                                                        <label class="d-none" id="balance"></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="currencyto">Currency To</label>
                                                        <select type="text" id="exchangecurrencyto" class="form-control required" placeholder="Currency To" name="exchangecurrencyto">
                                                            <option value="0">Select</option>
                                                            <?php
                                                            foreach ($allcurrency as $currency) {
                                                                $selected = $currency->company_currency_id == $money_from->currency ? "selected" : '';
                                                                echo "<option value='$currency->company_currency_id' $selected>$currency->currency</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="rate">Exchange Rate</label>
                                                        <input type="number" id="rate" class="form-control required" placeholder="Exchange Rate" name="rate" value="<?php echo $receipts->currency_rate ?>" />
                                                        <span class="badge badge-primary mt-1" id="namount"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="bankto">Siaf/Bank</label>
                                                        <input type="text" name="bankto" id="bankto" placeholder="<?php echo $acc_to->account_name ?>" autocomplete="off" class="form-control" />
                                                        <label class="d-none" id="balance"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button type="button" id="btneditreceipt" class="btn btn-info waves-effect waves-light">
                                                <i class="la la-check-square-o"></i> Save
                                            </button>
                                            <button type="reset" class="btn btn-info waves-effect waves-light">
                                                <i class="la la-check-square-o"></i> Cancel
                                            </button>
                                        </div>

                                        <input type="hidden" name="<?php echo $_GET['op'] ?>" id="<?php echo $_GET['op'] ?>">
                                        <input type="hidden" name="LID" id="LID" value="<?php echo $_GET['edit'] ?>">
                                        <input type="hidden" name="banktoto" id="banktoto" value="<?php echo $acc_to->chartofaccount_id ?>">
                                        <input type="hidden" name="bankfromfrom" id="bankfromfrom" value="<?php echo $acc_from->chartofaccount_id ?>">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- END: Content-->
    <?php } else if ($_GET["op"] == "bt") {
        $receipts_data = $banks->getLeadger($_GET["edit"]);
        $receipts = $receipts_data->fetch(PDO::FETCH_OBJ);
        // Account from
        $acc_from_data = $banks->getSystemAccount($receipts->payable_id);
        $acc_from = $acc_from_data->fetch(PDO::FETCH_OBJ);

        // get account from money
        $money_from_data = $banks->getMoney($receipts->payable_id, $receipts->leadger_id);
        $money_from = $money_from_data->fetch(PDO::FETCH_OBJ);

        // Account to
        $acc_to_data = $banks->getSystemAccount($receipts->recievable_id);
        $acc_to = $acc_to_data->fetch(PDO::FETCH_OBJ);

        // get account from to
        $money_to_data = $banks->getMoney($receipts->recievable_id, $receipts->leadger_id);
        $money_to = $money_to_data->fetch(PDO::FETCH_OBJ);
    ?>
        <!-- BEGIN: Content-->
        <div class="container pt-5">
            <section id="basic-form-layouts">
                <div class="row match-height">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <form class="form">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="date">Date</label>
                                                        <input type="date" id="date" class="form-control required" placeholder="Date" name="date" value="<?php echo Date('Y-m-d', $receipts->reg_date) ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="form-group">
                                                        <label for="details">Description</label>
                                                        <textarea id="details" class="form-control required" placeholder="Description" rows="1" name="details" style="border:0;border-bottom:1px solid gray"><?php echo $receipts->remarks; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="currencyfrom">Currency From</label>
                                                        <select type="text" id="currencyfrom" class="form-control required" placeholder="Currency From" name="currencyfrom">
                                                            <option value="0">Select</option>
                                                            <?php
                                                            foreach ($allcurrency as $currency) {
                                                                $selected = $currency->company_currency_id == $money_to->currency ? "selected" : '';
                                                                echo "<option value='$currency->company_currency_id' $selected>$currency->currency</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="eamount">Amount</label>
                                                        <input type="number" id="eamount" class="form-control required" placeholder="amount" name="eamount" value="<?php echo $money_to->amount ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="bankfrom">Siaf/Bank</label>
                                                        <input type="text" name="bankfrom" id="bankfrom" placeholder="<?php echo $acc_from->account_name ?>" autocomplete="off" class="form-control" />
                                                        <label class="d-none" id="balance"></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="currencyto">Currency To</label>
                                                        <select type="text" id="exchangecurrencyto" class="form-control required" placeholder="Currency To" name="exchangecurrencyto">
                                                            <option value="0">Select</option>
                                                            <?php
                                                            foreach ($allcurrency as $currency) {
                                                                $selected = $currency->company_currency_id == $money_from->currency ? "selected" : '';
                                                                echo "<option value='$currency->company_currency_id' $selected>$currency->currency</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="rate">Exchange Rate</label>
                                                        <input type="number" id="rate" class="form-control required" placeholder="Exchange Rate" name="rate" value="<?php echo $receipts->currency_rate ?>" />
                                                        <span class="badge badge-primary mt-1" id="namount"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="bankto">Siaf/Bank</label>
                                                        <input type="text" name="bankto" id="bankto" placeholder="<?php echo $acc_to->account_name ?>" autocomplete="off" class="form-control" />
                                                        <label class="d-none" id="balance"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button type="button" id="btneditreceipt" class="btn btn-info waves-effect waves-light">
                                                <i class="la la-check-square-o"></i> Save
                                            </button>
                                            <button type="reset" class="btn btn-info waves-effect waves-light">
                                                <i class="la la-check-square-o"></i> Cancel
                                            </button>
                                        </div>

                                        <input type="hidden" name="<?php echo $_GET['op'] ?>" id="<?php echo $_GET['op'] ?>">
                                        <input type="hidden" name="LID" id="LID" value="<?php echo $_GET['edit'] ?>">
                                        <input type="hidden" name="banktoto" id="banktoto" value="<?php echo $acc_to->chartofaccount_id ?>">
                                        <input type="hidden" name="bankfromfrom" id="bankfromfrom" value="<?php echo $acc_from->chartofaccount_id ?>">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- END: Content-->
    <?php } else if ($_GET["op"] == "cus") { ?>
        <div class="app-content content">
            <div class="content-overlay"></div>
            <div class="content-wrapper">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <div class="card">
                        <div class="card-header">
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <form action="#" class="form" id="steps-validation" enctype="multipart/form-data" novalidate="novalidate">
                                    <input type="hidden" name="addcustomers" id="addcustomers">
                                    <h4 class="form-section"><i class="ft-user"></i> Basic Info</h4>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="fname" style="font-variant:small-caps">
                                                    fname:
                                                    <span class="danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="fname" name="fname" placeholder="FNAME">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="lname" style="font-variant:small-caps">
                                                    lname:
                                                    <span class="danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="lname" name="lname" placeholder="LNAME">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="alies_name" style="font-variant:small-caps">
                                                    alies name:
                                                    <span class="danger">*</span>
                                                </label>
                                                <input type="text" class="form-control required" id="alies_name" name="alies_name" placeholder="ALIES NAME" required="required">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="gender" style="font-variant:small-caps">
                                                    gender:
                                                    <span class="danger">*</span>
                                                </label>
                                                <select id="gender" name="gender" class="form-control">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="email" style="font-variant:small-caps">
                                                    email:
                                                    <span class="danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="email" name="email" placeholder="EMAIL">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="NID" style="font-variant:small-caps">
                                                    NID:
                                                    <span class="danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="NID" name="NID" placeholder="NID">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="TIN" style="font-variant:small-caps">
                                                    TIN:
                                                    <span class="danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="TIN" name="TIN" placeholder="TIN">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="office_address" style="font-variant:small-caps">
                                                    office address:
                                                    <span class="danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="office_address" name="office_address" placeholder="OFFICE ADDRESS">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="office_details" style="font-variant:small-caps">
                                                    office details:
                                                    <span class="danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="office_details" name="office_details" placeholder="OFFICE DETAILS">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="official_phone" style="font-variant:small-caps">
                                                    official phone:
                                                    <span class="danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="official_phone" name="official_phone" placeholder="OFFICIAL PHONE">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="personal_phone" style="font-variant:small-caps">
                                                    personal phone:
                                                    <span class="danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="personal_phone" name="personal_phone" placeholder="PERSONAL PHONE">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="personal_phone_second" style="font-variant:small-caps">
                                                    personal phone second:
                                                    <span class="danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="personal_phone_second" name="personal_phone_second" placeholder="PERSONAL PHONE SECOND">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="fax" style="font-variant:small-caps">
                                                    fax:
                                                    <span class="danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="fax" name="fax" placeholder="FAX">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="website" style="font-variant:small-caps">
                                                    website:
                                                    <span class="danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="website" name="website" placeholder="WEBSITE">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="note" style="font-variant:small-caps">
                                                    note:
                                                    <span class="danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="note" name="note" placeholder="NOTE">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="person_type" style="font-variant:small-caps">
                                                    person type:
                                                    <span class="danger">*</span>
                                                </label>
                                                <select id="person_type" name="person_type" class="form-control">
                                                    <option value="Legal Entity">Legal Entity</option>
                                                    <option value="Indivitual">Indivitual</option>
                                                    <option value="Saraf">Saraf</option>
                                                    <option value="Share holders">Share holders</option>
                                                    <option value="user">user</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="details" style="font-variant:small-caps">
                                                    details:
                                                    <span class="danger">*</span>
                                                </label>
                                                <textarea class="form-control" id="details" name="details" placeholder="DETAILS"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div data="customeraddress" class="mt-2">
                                        <h4 class="form-section"><i class="ft-user"></i> Customer Address</h4>
                                        <input type="hidden" value="0" name="customeraddresscount" class="counter">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="address_type" style="font-variant:small-caps">
                                                        address_type:
                                                        <span class="danger">*</span>
                                                    </label>
                                                    <select id="address_type" name="address_type" class="form-control">
                                                        <option value="Current">Current</option>
                                                        <option value="Permenant">Permenant</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="detail_address" style="font-variant:small-caps">
                                                        detail_address:
                                                        <span class="danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control" id="detail_address" name="detail_address" placeholder="DETAIL_ADDRESS">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="province" style="font-variant:small-caps">
                                                        province:
                                                        <span class="danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control" id="province" name="province" placeholder="PROVINCE">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="district" style="font-variant:small-caps">
                                                        district:
                                                        <span class="danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control" id="district" name="district" placeholder="DISTRICT">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <a href="#" class="btn btn-sm btn-info btnaddmulti waves-effect waves-light">
                                                <span class="la la-plus"></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div data="customersbankdetails" class="mt-2">
                                        <h4 class="form-section"><i class="ft-user"></i> Customer Bank Details</h4>
                                        <input type="hidden" value="0" name="customersbankdetailscount" class="counter">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="bank_name" style="font-variant:small-caps">
                                                        bank_name:
                                                        <span class="danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="BANK_NAME">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="account_number" style="font-variant:small-caps">
                                                        account_number:
                                                        <span class="danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control" id="account_number" name="account_number" placeholder="ACCOUNT_NUMBER">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="currency" style="font-variant:small-caps">
                                                        currency:
                                                        <span class="danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control" id="currency" name="currency" placeholder="CURRENCY">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="details" style="font-variant:small-caps">
                                                        details:
                                                        <span class="danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control" id="details" name="details" placeholder="DETAILS">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <a href="#" class="btn btn-sm btn-info btnaddmulti waves-effect waves-light">
                                                <span class="la la-plus"></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div data="customersattacment" class="mt-2">
                                        <h4 class="form-section"><i class="ft-user"></i> Customer Attachments</h4>
                                        <input type="hidden" value="0" name="customersattacmentcount" class="counter">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="attachment_type" style="font-variant:small-caps">
                                                        attachment_type:
                                                        <span class="danger">*</span>
                                                    </label>
                                                    <select id="attachment_type" name="attachment_type" class="form-control">
                                                        <option value="NID">NID</option>
                                                        <option value="profile">profile</option>
                                                        <option value="signature">signature</option>
                                                        <option value="other">other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="details" style="font-variant:small-caps">
                                                        details:
                                                        <span class="danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control" id="details" name="details" placeholder="DETAILS">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group attachement">
                                                    <label for="attachment">
                                                        <span class="las la-file-upload blue"></span>
                                                    </label>
                                                    <i id="filename">filename</i>
                                                    <input type="file" class="form-control required d-none attachInput" id="attachment" name="attachment">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <a href="#" class="btn btn-sm btn-info btnaddmulti waves-effect waves-light">
                                                <span class="la la-plus"></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="reset" class="btn btn-danger mr-1 waves-effect waves-light">
                                            <i class="ft-x"></i> Cancel
                                        </button>
                                        <button type="submite" class="btn btn-blue waves-effect waves-light">
                                            <i class="la la-check-square-o"></i> Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- Form wzard with step validation section start -->
        </div>

    <?php } else { ?>
        <!-- BEGIN: Content-->
        <div class="container pt-5" data-href="<?php echo $mainCurrency; ?>">
            <section id="basic-form-layouts">
                <div class="row match-height">
                    <?php if (isset($_GET["edit"])) {
                        $receipts_data = $banks->getLeadger($_GET["edit"]);
                        $receipts = $receipts_data->fetch(PDO::FETCH_OBJ);

                        $account_details = $banks->getBankByID($receipts->recievable_id);
                        $account = $account_details->fetch(PDO::FETCH_OBJ);
                    ?>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form">
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label for="details">Description</label>
                                                    <textarea id="details" class="form-control required" placeholder="Description" name="details"><?php echo $receipts->remarks; ?></textarea>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="date">Date</label>
                                                            <input type="date" id="date" class="form-control required" placeholder="Date" name="date" value="<?php echo Date('Y-m-d', $receipts->reg_date) ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="currency">Currency</label>
                                                            <select type="text" id="currency" class="form-control" placeholder="Currency" name="currency">
                                                                <?php
                                                                foreach ($allcurrency as $currency) {
                                                                    $selected = "";
                                                                    if ($currency->company_currency_id == $receipts->currency_id) {
                                                                        $selected = "selected";
                                                                    }
                                                                    echo "<option value='$currency->company_currency_id' $selected>$currency->currency</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card bg-light">
                                                    <div class="card-header">
                                                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                                    </div>
                                                    <div class="card-content">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-1">
                                                                    <i class="la la-user" style="font-size: 50px;color:dodgerblue"></i>
                                                                </div>
                                                                <?php if ($_GET["op"] == "revenue") { ?>
                                                                    <div class="col-lg-7">
                                                                        <div class="form-group">
                                                                            <label for="rev_ID">Revenue</label>
                                                                            <select class="form-control chosen required" name="rev_ID" id="rev_ID" data-placeholder="Choose a Revenue...">
                                                                                <option value="">Select</option>
                                                                                <?php
                                                                                foreach ($revenue as $rev) {
                                                                                    $selected = "";
                                                                                    if ($rev->chartofaccount_id == $receipts->payable_id) {
                                                                                        $selected = "selected";
                                                                                    }
                                                                                    echo "<option class='$rev->currency' value='$rev->chartofaccount_id' $selected>$rev->account_name</option>";
                                                                                    if (checkChilds($rev->account_catagory_id) > 0) {
                                                                                        recurSearch2($user_data->company_id, $rev->account_catagory_id, $receipts->payable_id);
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <label class="d-none" id="balance"></label>
                                                                        </div>
                                                                    </div>
                                                                <?php } else if ($_GET["op"] == "expense") { ?>
                                                                    <div class="col-lg-7">
                                                                        <div class="form-group">
                                                                            <label for="rev_ID">Expense</label>
                                                                            <select class="form-control chosen required" name="rev_ID" id="rev_ID" data-placeholder="Choose a Revenue...">
                                                                                <option value="" selected>Select</option>
                                                                                <?php
                                                                                foreach ($expenses as $contact) {
                                                                                    $selected = "";
                                                                                    if ($contact->chartofaccount_id == $receipts->payable_id) {
                                                                                        $selected = "selected";
                                                                                    }
                                                                                    echo "<option class='$contact->currency' value='$contact->chartofaccount_id' $selected>$contact->account_name</option>";
                                                                                    if (checkChilds($contact->account_catagory_id) > 0) {
                                                                                        recurSearch2($user_data->company_id, $contact->account_catagory_id, $receipts->payable_id);
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <label class="d-none" id="balance"></label>
                                                                        </div>
                                                                    </div>
                                                                <?php } else { ?>
                                                                    <div class="col-lg-7">
                                                                        <div class="form-group">
                                                                            <label for="customer">Contact</label>
                                                                            <select type="text" class="form-control chosen required" name="customer" id="customer" data-placeholder="Choose a Customer...">
                                                                                <option value="" selected>Select</option>
                                                                                <?php
                                                                                foreach ($allContacts as $contact) {
                                                                                    $selected = "";
                                                                                    if ($contact->chartofaccount_id == $receipts->payable_id) {
                                                                                        $selected = "selected";
                                                                                    }
                                                                                    echo "<option class='$contact->currency' value='$contact->chartofaccount_id' $selected>$contact->account_name</option>";
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <label class="d-none" id="balance"></label>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label for="amount">Amount</label>
                                                                        <input type="number" name="amount" id="amount" class="form-control required" placeholder="Amount" value="<?php echo $receipts->amount; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label for="accountdetails">Details</label>
                                                                        <input type="text" name="accountdetails" id="accountdetails" class="form-control" placeholder="Details" value="<?php echo $receipts->remarks; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 mb-2">
                                                    <div class="pen-outer">
                                                        <div class="pulldown">
                                                            <h3 class="card-title mr-2">Add Receipt Items</h3>
                                                            <div class="pulldown-toggle pulldown-toggle-round">
                                                                <i class="la la-plus"></i>
                                                            </div>
                                                            <div class="pulldown-menu">
                                                                <ul>
                                                                    <li class="addreciptItem" item="bank">
                                                                        <i class="la la-bank" style="font-size:30px;color:white"></i>
                                                                    </li>
                                                                    <li class="addreciptItem" item="saif">
                                                                        <i class="la la-box" style="font-size:30px;color:white"></i>
                                                                    </li>
                                                                    <li class="addreciptItem" item="customer">
                                                                        <i class="la la-user" style="font-size:30px;color:white"></i>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="clac ml-2" style="display: flex;flex-direction:column">
                                                                <span>Sum: <span id="sum" style="color: dodgerblue; font-weight: bold;"></span></span>
                                                                <span>Rest: <span id="rest" style="color: tomato; font-weight: bold;">0</span></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 receiptItemsContainer">
                                                    <div class="card bg-light">
                                                        <div class="card-header">
                                                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                                            <div class="heading-elements">
                                                                <ul class="list-inline mb-0">
                                                                    <li><a class="deleteMore" href="#"><i class="ft-x"></i></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="card-content">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-lg-1"><i class="la la-bank" style="font-size: 50px;color:dodgerblue"></i></div>
                                                                    <div class="col-lg-7">
                                                                        <div class="form-group">
                                                                            <label for="reciptItemID">Bank/Saif</label>
                                                                            <select class="form-control customer" name="reciptItemID" id="reciptItemID" data="bank">
                                                                                <option value="<?php echo $account->chartofaccount_id ?>" cur="<?php echo $receipts->currency_id ?>"><?php echo $account->account_name ?></option>
                                                                            </select><label class="d-none balance"></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label for="reciptItemAmount">Amount</label>
                                                                            <input type="number" name="reciptItemAmount" id="reciptItemAmount" class="form-control required receiptamount" value="<?php echo $receipts->amount ?>" placeholder="Amount">
                                                                            <label class="d-none rate"></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <label for="reciptItemdetails">Details</label>
                                                                            <input type="text" name="reciptItemdetails" id="reciptItemdetails" class="form-control details" placeholder="Details" value="<?php echo $receipts->remarks ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-actions">
                                                <button type="button" id="btneditreceipt" class="btn btn-info waves-effect waves-light">
                                                    <i class="la la-check-square-o"></i> Save
                                                </button>
                                                <button type="button" id="btnprint" class="btn btn-info waves-effect waves-light">
                                                    <i class="la la-print"></i> Print
                                                </button>
                                            </div>
                                            <input type="hidden" name="receptItemCounter" id="receptItemCounter" value="0">
                                            <input type="hidden" name="rate" id="rate" value="0">
                                            <input type="hidden" name="<?php echo $_GET['op'] ?>" id="<?php echo $_GET['op'] ?>">
                                            <input type="hidden" name="LID" id="LID" value="<?php echo $_GET['edit'] ?>">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </section>
        </div>
        <!-- END: Content-->
<?php }
} ?>

<!-- Modal -->
<div class="modal fade text-center" id="show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body p-2">
                <div class="container container-waiting">
                    <div class="loader-wrapper">
                        <div class="loader-container">
                            <div class="ball-clip-rotate loader-primary">
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container container-done d-none">
                    <i class="font-large-2 icon-line-height la la-check" style="color: seagreen;"></i>
                    <h5>Updated</h5>
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
        var SampleJSONData2 = []
        combofrom = $('#bankfrom');
        comboto = $('#bankto');

        $("#exchangecurrencyto").on("change", function() {
            from = $("#currencyfrom option:selected").text();
            to = $("#exchangecurrencyto option:selected").text();
            if (from !== to) {
                if (from != "Select" && to != "Select") {
                    $.get("../app/Controllers/banks.php", {
                        "getExchange": true,
                        "from": from,
                        "to": to
                    }, function(data) {
                        ndata = $.parseJSON(data);
                        if (ndata.currency_from === from) {
                            $("#rate").val(ndata.rate);
                            $("#namount").text((ndata.rate) * $("#eamount").val() + " - " + to);
                        } else {
                            $("#rate").val((1 / ndata.rate));
                            $("#namount").text((1 / ndata.rate) * $("#eamount").val() + " - " + to);
                        }
                    });
                }
            } else {
                $("#rate").val(0);
                $("#namount").text("");
            }
        });

        $.get("../app/Controllers/banks.php", {
            "getcompanyBanks": true
        }, function(data) {
            newdata = $.parseJSON(data);
            banks = {
                id: 1,
                title: "Banks",
                subs: []
            }
            tempSubs = [];
            newdata.forEach(element => {
                tempSubs.push({
                    id: element.chartofaccount_id,
                    title: element.account_name
                });
            });
            banks.subs = tempSubs;
            SampleJSONData2.push(banks);
            $.get("../app/Controllers/banks.php", {
                "getcompanySafis": true
            }, function(data) {
                newdata = $.parseJSON(data);
                saifs = {
                    id: 2,
                    title: "Saifs",
                    subs: []
                }
                tempsifs = [];
                newdata.forEach(element => {
                    tempsifs.push({
                        id: element.chartofaccount_id,
                        title: element.account_name
                    });
                });
                saifs.subs = tempsifs;
                SampleJSONData2.push(saifs);

                combofrom = $('#bankfrom').comboTree({
                    source: SampleJSONData2,
                    isMultiple: false,
                });

                comboto = $('#bankto').comboTree({
                    source: SampleJSONData2,
                    isMultiple: false,
                });

                combofrom.onChange(function() {
                    $('#bankfromfrom').val(combofrom.getSelectedIds());
                });

                comboto.onChange(function() {
                    $('#banktoto').val(comboto.getSelectedIds());
                });
            });
        });

        let Selected_Customer_Currency = "";
        // Load customer balance
        $("#customer").on("change", function() {
            text = $("#customer option:selected").text();
            currency = text.substring(text.lastIndexOf("-") + 1);
            Selected_Customer_Currency = currency;
            if ($(this).val() != "") {
                $.get("../app/Controllers/banks.php", {
                    "getCustomerBalance": true,
                    "cusID": $(this).val()
                }, function(data) {
                    res = $.parseJSON(data);
                    if (res.length <= 0) {
                        $("#balance").removeClass("d-none").text("Balance: 0");
                        Selected_Customer_Currency = currency;
                    } else {
                        debet = 0;
                        crediet = 0;

                        res.forEach(element => {
                            if (element.ammount_type == "Debet") {
                                debet += parseFloat(element.amount);
                            } else {
                                crediet += parseFloat(element.amount);
                            }
                        });
                        $("#balance").removeClass("d-none").text("Balance: " + (debet - crediet));
                    }
                });
            } else {
                $("#balance").addClass("d-none")
            }
        });

        // Edit recept
        printData = null;
        $("#btneditreceipt").on("click", function() {
            var getUrl = window.location;
            var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
            if ($(".form").valid()) {
                totalamount = $("#rest").text();
                if (totalamount == 0) {
                    if ($("#currency").val() == $(".customer option:selected").attr("cur")) {
                        $("#show").modal("show");
                        $.post("../app/Controllers/edite.php", $(".form").serialize(), function(data) {
                            console.log(data);
                            if (data != "done") {
                                printData = $.parseJSON(data);
                                printData.from = $("#customer option:selected").text();
                                print(printData, baseUrl);
                            }
                            $(".container-waiting").addClass("d-none");
                            $(".container-done").removeClass("d-none");
                            setTimeout(function() {
                                $("#show").modal("hide");
                            }, 2000);
                            $(".form")[0].reset();
                            $(".receiptItemsContainer").html("");
                        });
                    } else {
                        $(".receiptItemsContainer").append("<div class='alert alert-danger'>Please select same bank/saif as currency</div>");
                    }
                } else {
                    $(".receiptItemsContainer").append("<div class='alert alert-danger'>Recipt Amount can not be greater or smaller then the paid amount</div>");
                }

            }
        });

        // print 
        $("#btnprint").on("click", function() {
            var getUrl = window.location;
            var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
            if (printData != null) {
                print(printData, baseUrl);
            }
        });

    });

    // Initialize validation
    $(".form").validate({
        ignore: 'input[type=hidden]', // ignore hidden fields
        errorClass: 'danger',
        successClass: 'success',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        rules: {
            email: {
                email: true
            }
        }
    });
</script>