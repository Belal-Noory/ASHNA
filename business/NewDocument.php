<?php
$Active_nav_name = array("parent" => "Accounting", "child" => "New Document");
$page_title = "New Document";
include("./master/header.php");

$company = new Company();
$revenue = new Expense();

$allcurrency_data = $company->GetCompanyCurrency($user_data->company_id);
$allcurrency = $allcurrency_data->fetchAll(PDO::FETCH_OBJ);
?>

<div class="container pt-5">
    <section id="material-datatables">
        <div class="card">
            <div class="card-header">
                <a class="heading-elements-toggle">
                    <i class="la la-ellipsis-v font-medium-3"></i>
                </a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" id="date" class="form-control required" placeholder="Date" name="date">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="details">Description</label>
                                <textarea id="details" class="form-control required" placeholder="Description" name="details" rows="1"></textarea>
                            </div>
                        </div>
                    </div>
                    <table class="table" id="customersTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Account</th>
                                <th>Sub Account</th>
                                <th>Description</th>
                                <th>Currency</th>
                                <th>Debet</th>
                                <th>Credit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                    <select id="account" class="form-control account" name="account">
                                        <option value="NA">Select</option>
                                        <option value="cus">Contact</option>
                                        <option value="cus">Bank</option>
                                        <option value="cus">Saif</option>
                                        <option value="Revenue">Revenue</option>
                                        <option value="Expense">Expense</option>
                                        <option value="Assets">Assets</option>
                                        <option value="Liablity">Liablity</option>
                                        <option value="Capital">Capital</option>
                                    </select>
                                </td>
                                <td>
                                    <select id="subaccount" class="form-control" name="subaccount">

                                    </select>
                                </td>
                                <td>
                                    <textarea name="details" id="details" rows="1" placeholder="Details" class="form-control"></textarea>
                                </td>
                                <td>
                                    <select type="text" id="currency" class="form-control currency" placeholder="Currency" name="currency">
                                        <?php
                                        foreach ($allcurrency as $currency) {
                                            echo "<option value='$currency->company_currency_id'>$currency->currency</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="debetamount" id="debetamount" placeholder="Debet" class="form-control debet">
                                </td>
                                <td>
                                    <input type="number" name="creditamount" id="creditamount" placeholder="Credit" class="form-control credit">
                                </td>
                                <td>
                                    <a href="#" class="deleteRow"><span class="las la-trash red" style="font-size: 25px;"></span></a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- Material Data Tables -->
</div>

<?php
include("./master/footer.php");
?>

<script>
    $(document).ready(function() {
        $(document).on("click", ".deleteRow", function(e) {
            e.preventDefault();
            $(this).parent().parent().fadeOut();
        });
    });
</script>