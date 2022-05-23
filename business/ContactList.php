<?php
$Active_nav_name = array("parent" => "Contact", "child" => "Contact List");
include("./master/header.php");
?>

<style>
    #DataTables_Table_0_info {
        display: none;
    }

    #DataTables_Table_0_wrapper .row:first-child {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    #DataTables_Table_0_wrapper .row:first-child label {
        text-align: center;
    }
</style>

<!-- END: Main Menu-->
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <h2>Contacts List</h2>

            <div class="row">
                <div class="col-lg-9">

                </div>

                <div class="col-lg-3">
                    <!-- Material Data Tables -->
                    <section id="material-datatables">
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-0">
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
                                    <div class="card-content collapse show">
                                        <div class="card-body">
                                            <table class="table material-table text-right">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><a href="#" class="showcustomerdetails">test</a></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Material Data Tables -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->
<?php
include("./master/footer.php");
?>