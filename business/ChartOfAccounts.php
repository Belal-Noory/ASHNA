<?php
$Active_nav_name = array("parent" => "Accounting", "child" => "Chart Of Accounts");
$page_title = "Chart Of Accounts";
include("./master/header.php");

$company = new Company();
$banks = new Banks();

$allcurrency_data = $company->GetCompanyCurrency($user_data->company_id);
$allcurrency = $allcurrency_data->fetchAll(PDO::FETCH_OBJ);


$Catagory_data = $banks->getAllAccountsCatagory();
$Catagories = $Catagory_data->fetchAll(PDO::FETCH_OBJ);

function recurSearch($company)
{
    $conn = new Connection();
    $query = "SELECT * FROM account_catagory INNER JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory WHERE parentID = ? AND account_catagory.company_id = ?";
    $result = $conn->Query($query, [0,$company]);
    $results = $result->fetchAll(PDO::FETCH_OBJ);
    foreach ($results as $item) {
        $q = "SELECT * FROM general_leadger 
        LEFT JOIN account_money ON general_leadger.leadger_id = account_money.leadger_ID 
        WHERE general_leadger.recievable_id = ? OR general_leadger.payable_id = ?";
        $r = $conn->Query($q, [$item->chartofaccount_id,$item->chartofaccount_id]);
        $RES = $r->fetchAll(PDO::FETCH_OBJ);
        $debet = 0;
        $credit = 0;

        foreach ($RES as $RE) {
            $rate = $RE->currency_rate;
            if($RE->ammount_type == "Debet")
            {
                $rate == 0? $debet += $RE->amount: $debet += ($RE->amount * $rate);
            }
            else{
                $rate == 0? $credit += $RE->amount: $credit += ($RE->amount * $rate);
            }
        }
        if (checkChilds($item->account_catagory_id) > 0) {
            echo "<li><span class='caret'>$item->catagory</span> <span class='badge badge-danger'>Total Debets: $debet </span> <span class='badge badge-blue'>Total Credits: $credit </span><ul class='nested'>";
            recurSearch2($company, $item->account_catagory_id);
            echo "</ul></li>";
        } else {
            echo "<li>- $item->catagory <span class='badge badge-danger'>Total Debets: $debet </span> <span class='badge badge-blue'>Total Credits: $credit </span></li>";
        }
    }
}

function recurSearch2($company, $parentID)
{
    $conn = new Connection();
    $query = "SELECT * FROM account_catagory INNER JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory WHERE parentID = ? AND account_catagory.company_id = ? AND chartofaccount.useradded = ?";
    $result = $conn->Query($query, [$parentID, $company,0]);
    $results = $result->fetchAll(PDO::FETCH_OBJ);
    foreach ($results as $item) {
        $accountID = $item->account_catagory_id;
        $q = "SELECT * FROM general_leadger 
        LEFT JOIN account_money ON general_leadger.leadger_id = account_money.leadger_ID 
        WHERE general_leadger.recievable_id = ? OR general_leadger.payable_id = ?";
        $r = $conn->Query($q, [$item->chartofaccount_id,$item->chartofaccount_id]);
        $RES = $r->fetchAll(PDO::FETCH_OBJ);
        $debet = 0;
        $credit = 0;

        foreach ($RES as $RE) {
            $rate = $RE->currency_rate;
            if($RE->ammount_type == "Debet")
            {
                $rate == 0? $debet += $RE->amount: $debet += ($RE->amount * $rate);
            }
            else{
                $rate == 0? $credit += $RE->amount: $credit += ($RE->amount * $rate);
            }
        }
        if (checkChilds($item->account_catagory_id) > 0) {
            echo "<li><span class='caret'>$item->catagory</span> <span class='badge badge-danger'>Total Debets: $debet </span> <span class='badge badge-blue'>Total Credits: $credit </span><ul class='nested'>";
            recurSearch2($company, $item->account_catagory_id);
            echo "</ul></li>";
        } else {
            echo "<li>- $item->catagory <span class='badge badge-danger'>Total Debets: $debet </span> <span class='badge badge-blue'>Total Credits: $credit </span></li>";
        }
    }
}

function checkChilds($patne)
{
    $conn = new Connection();
    $query = "SELECT * FROM account_catagory WHERE parentID = ?";
    $result = $conn->Query($query, [$patne]);
    return $result->rowCount();
}

// $all_catagory_withAccounts_data = $banks->getCatagoryListWithChildred($user_data->company_id);

?>

<style>
    /* Remove default bullets */
    ul,
    #myUL {
        list-style-type: none;
    }

    /* Remove margins and padding from the parent ul */
    #myUL {
        margin: 0;
        padding: 0;
    }

    #myUL li{
       padding: 8px;
       background-color: lightslategray;
       font-weight: bold;
       color: white;
    }

    /* Style the caret/arrow */
    .caret {
        cursor: pointer;
        user-select: none;
        font-weight: bold;
        margin-right: 8px;
        /* Prevent text selection */
    }

    /* Create the caret/arrow with a unicode, and style it */
    .caret::before {
        content: "\25B6";
        color: black;
        display: inline-block;
        margin-right: 6px;
    }

    /* Rotate the caret/arrow icon when clicked on (using JavaScript) */
    .caret-down::before {
        transform: rotate(90deg);
    }

    /* Hide the nested list */
    .nested {
        display: none;
    }

    /* Show the nested list when the user clicks on the caret/arrow (with JavaScript) */
    .active {
        display: block;
    }
</style>

<div class="container pt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="btn-group" role="group" aria-label="Third Group">
                <button type="button" class="btn btn-icon btn-dark waves-effect waves-light" data-toggle="modal" data-target="#add"><i class="la la-plus"></i></button>
            </div>
        </div>

        <div class="col-lg-12 mt-3">
            <ul id="myUL">
                <?php
                recurSearch($user_data->company_id);
                ?>
            </ul>
        </div>
    </div>
</div>

<!-- Add New Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body p-2">
                <form class="form">
                    <div class="form-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" class="form-control" placeholder="Name..." name="name" require>
                        </div>

                        <div class="form-group">
                            <label for="subaccount">Sub Account</label>
                            <select type="text" id="subaccount" class="form-control chosen" placeholder="Sub Account..." name="subaccount">
                                <option selected value="0">None</option>
                                <?php
                                foreach ($Catagories as $catagory) {
                                    echo "<option value='$catagory->account_catagory_id'>$catagory->catagory</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <input type="hidden" name="addchartofaccounts">
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-primary waves-effect waves-light" id="addaccount">
                            <i class="la la-check-square-o"></i> Save
                        </button>
                        <i class="la la-spinner spinner blue d-none" style="font-size: 30px;"></i>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include("./master/footer.php");
?>

<script>
    $(document).ready(function() {
        formReady = false;

        $('.chosen').chosen();
        $(".chosen-container").removeAttr("style");
        $(".chosen-container").addClass("form-control").addClass("p-0");
        $(".chosen-single").css({
            "height": "100%",
            "width": "100%",
            "border": "0px",
            "outline": "0px"
        });
        $(".chosen-single span").css({
            "height": "100%",
            "width": "100%",
            "padding-top": "5px",
            "padding-left": "5px",
        });

        // add chart of account
        $("#addaccount").on("click", function() {
            if ($("#name").val() != "") {
                $(this).hide();
                ths = $(this);
                $(".spinner").removeClass("d-none");
                $.post("../app/Controllers/banks.php", $(".form").serialize(), function(data) {
                    window.location.reload();
                });
            }
        });
    });

    var toggler = document.getElementsByClassName("caret");
    var i;

    for (i = 0; i < toggler.length; i++) {
        toggler[i].addEventListener("click", function() {
            this.parentElement.querySelector(".nested").classList.toggle("active");
            this.classList.toggle("caret-down");
        });
    }
</script>