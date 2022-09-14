<?php
$Active_nav_name = array("parent" => "Accounting", "child" => "Documents List");
$page_title = "Documents";
include("./master/header.php");

$company = new Company();
$document = new Document();

$allcurrency_data = $company->GetCompanyCurrency($user_data->company_id);
$allcurrency = $allcurrency_data->fetchAll(PDO::FETCH_OBJ);

$currencies = array("BD" => "BDT", "BE" => "EUR", "BF" => "XOF", "BG" => "BGN", "BA" => "BAM", "BB" => "BBD", "WF" => "XPF", "BL" => "EUR", "BM" => "BMD", "BN" => "BND", "BO" => "BOB", "BH" => "BHD", "BI" => "BIF", "BJ" => "XOF", "BT" => "BTN", "JM" => "JMD", "BV" => "NOK", "BW" => "BWP", "WS" => "WST", "BQ" => "USD", "BR" => "BRL", "BS" => "BSD", "JE" => "GBP", "BY" => "BYR", "BZ" => "BZD", "RU" => "RUB", "RW" => "RWF", "RS" => "RSD", "TL" => "USD", "RE" => "EUR", "TM" => "TMT", "TJ" => "TJS", "RO" => "RON", "TK" => "NZD", "GW" => "XOF", "GU" => "USD", "GT" => "GTQ", "GS" => "GBP", "GR" => "EUR", "GQ" => "XAF", "GP" => "EUR", "JP" => "JPY", "GY" => "GYD", "GG" => "GBP", "GF" => "EUR", "GE" => "GEL", "GD" => "XCD", "GB" => "GBP", "GA" => "XAF", "SV" => "USD", "GN" => "GNF", "GM" => "GMD", "GL" => "DKK", "GI" => "GIP", "GH" => "GHS", "OM" => "OMR", "TN" => "TND", "JO" => "JOD", "HR" => "HRK", "HT" => "HTG", "HU" => "HUF", "HK" => "HKD", "HN" => "HNL", "HM" => "AUD", "VE" => "VEF", "PR" => "USD", "PS" => "ILS", "PW" => "USD", "PT" => "EUR", "SJ" => "NOK", "PY" => "PYG", "IQ" => "IQD", "PA" => "PAB", "PF" => "XPF", "PG" => "PGK", "PE" => "PEN", "PK" => "PKR", "PH" => "PHP", "PN" => "NZD", "PL" => "PLN", "PM" => "EUR", "ZM" => "ZMK", "EH" => "MAD", "EE" => "EUR", "EG" => "EGP", "ZA" => "ZAR", "EC" => "USD", "IT" => "EUR", "VN" => "VND", "SB" => "SBD", "ET" => "ETB", "SO" => "SOS", "ZW" => "ZWL", "SA" => "SAR", "ES" => "EUR", "ER" => "ERN", "ME" => "EUR", "MD" => "MDL", "MG" => "MGA", "MF" => "EUR", "MA" => "MAD", "MC" => "EUR", "UZ" => "UZS", "MM" => "MMK", "ML" => "XOF", "MO" => "MOP", "MN" => "MNT", "MH" => "USD", "MK" => "MKD", "MU" => "MUR", "MT" => "EUR", "MW" => "MWK", "MV" => "MVR", "MQ" => "EUR", "MP" => "USD", "MS" => "XCD", "MR" => "MRO", "IM" => "GBP", "UG" => "UGX", "TZ" => "TZS", "MY" => "MYR", "MX" => "MXN", "IL" => "ILS", "FR" => "EUR", "IO" => "USD", "SH" => "SHP", "FI" => "EUR", "FJ" => "FJD", "FK" => "FKP", "FM" => "USD", "FO" => "DKK", "NI" => "NIO", "NL" => "EUR", "NO" => "NOK", "NA" => "NAD", "VU" => "VUV", "NC" => "XPF", "NE" => "XOF", "NF" => "AUD", "NG" => "NGN", "NZ" => "NZD", "NP" => "NPR", "NR" => "AUD", "NU" => "NZD", "CK" => "NZD", "XK" => "EUR", "CI" => "XOF", "CH" => "CHF", "CO" => "COP", "CN" => "CNY", "CM" => "XAF", "CL" => "CLP", "CC" => "AUD", "CA" => "CAD", "CG" => "XAF", "CF" => "XAF", "CD" => "CDF", "CZ" => "CZK", "CY" => "EUR", "CX" => "AUD", "CR" => "CRC", "CW" => "ANG", "CV" => "CVE", "CU" => "CUP", "SZ" => "SZL", "SY" => "SYP", "SX" => "ANG", "KG" => "KGS", "KE" => "KES", "SS" => "SSP", "SR" => "SRD", "KI" => "AUD", "KH" => "KHR", "KN" => "XCD", "KM" => "KMF", "ST" => "STD", "SK" => "EUR", "KR" => "KRW", "SI" => "EUR", "KP" => "KPW", "KW" => "KWD", "SN" => "XOF", "SM" => "EUR", "SL" => "SLL", "SC" => "SCR", "KZ" => "KZT", "KY" => "KYD", "SG" => "SGD", "SE" => "SEK", "SD" => "SDG", "DO" => "DOP", "DM" => "XCD", "DJ" => "DJF", "DK" => "DKK", "VG" => "USD", "DE" => "EUR", "YE" => "YER", "DZ" => "DZD", "US" => "USD", "UY" => "UYU", "YT" => "EUR", "UM" => "USD", "LB" => "LBP", "LC" => "XCD", "LA" => "LAK", "TV" => "AUD", "TW" => "TWD", "TT" => "TTD", "TR" => "TRY", "LK" => "LKR", "LI" => "CHF", "LV" => "EUR", "TO" => "TOP", "LT" => "LTL", "LU" => "EUR", "LR" => "LRD", "LS" => "LSL", "TH" => "THB", "TF" => "EUR", "TG" => "XOF", "TD" => "XAF", "TC" => "USD", "LY" => "LYD", "VA" => "EUR", "VC" => "XCD", "AE" => "AED", "AD" => "EUR", "AG" => "XCD", "AF" => "AFN", "AI" => "XCD", "VI" => "USD", "IS" => "ISK", "IR" => "IRR", "AM" => "AMD", "AL" => "ALL", "AO" => "AOA", "AQ" => "", "AS" => "USD", "AR" => "ARS", "AU" => "AUD", "AT" => "EUR", "AW" => "AWG", "IN" => "INR", "AX" => "EUR", "AZ" => "AZN", "IE" => "EUR", "ID" => "IDR", "UA" => "UAH", "QA" => "QAR", "MZ" => "MZN");

?>

<div class="contianer mt-2 p-2">

    <div class="row">
        <div class="col-md-6 col-sm-12">
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
                        <table class="table material-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Currency</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="currencyTable">
                                <?php
                                $counter = 1;
                                foreach ($allcurrency as $cur) {
                                    // get company transactions
                                    $Tres = $company->GetCompanyCurrencyTransactions($user_data->company_id,$cur->company_currency_id);

                                    $btn = "Main";
                                    if ($cur->mainCurrency !== '1') {
                                        if($Tres > 0)
                                        {
                                            $btn = "Cannot Delete";
                                        }
                                        else{
                                            $btn = "<button class='btn btn-sm btn-dark btndeletecurrency' id='$cur->company_currency_id'><span class='las la-trash la-2x text-white'></span><span class='las la-spinner spinner la-2x text-white d-none'></span></button>";
                                        }
                                    } else {
                                        $btn = "Main";
                                    }
                                    echo "<tr>
                                            <td class='counter'>$counter</td>
                                            <td>$cur->currency</td>
                                            <td>$btn</td>
                                        </tr>";
                                    $counter++;
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-12">
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
                                <label for="currency">Currency</label>
                                <select name="currency" id="currency" class="form-control">
                                    <option value="0">Select</option>
                                    <?php foreach ($currencies as $country => $currency) {
                                        echo "<option value='$currency'>$currency - $country</option>";
                                    } ?>
                                </select>
                            </div>

                            <div class="form-action">
                                <button type="button" class="btn btn-sm btn-dark" id="btnaddcurrency">
                                    <span class="las la-spinner spinner d-none"></span>
                                    <span class="las la-check"></span>
                                    Add
                                </button>
                            </div>
                        </form>
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
    $(document).ready(function(){
        
        $("#btnaddcurrency").on("click",function(e){
            e.preventDefault();
            ths = $(this);
    
            // get the lsat counter of the tabl
            counter = $(".counter").last().text();
            counter++;
    
            // get selected currency
            currency = $("#currency").children("option:selected").val();
    
            
            if(currency !== '0')
            {
                // button options
                $(ths).children("span:first-child()").removeClass("d-none");
                $(ths).children("span:last-child()").addClass("d-none");
                $(ths).attr("disabled",true);
    
                $.post("../app/Controllers/Company.php",{addcurrency:true,name:currency},function(data){
                    btn = `<button class='btn btn-sm btn-dark btndeletecurrency' id='${data}'><span class='las la-trash la-2x text-white'><span class='las la-spinner spinner la-2x text-white d-none'></span></span></button>`;
                    $("#currencyTable").append(`<tr>
                        <td>${counter}</td>
                        <td>${currency}</td>
                        <td>${btn}</td>
                    </tr>`);
                    $("#currency").children("option:selected").remove();
    
                    // button options
                    $(ths).children("span:first-child()").addClass("d-none");
                    $(ths).children("span:last-child()").removeClass("d-none");
                    $(ths).removeAttr("disabled");
                });
    
            }
        });

        // remove currency
        $(document).on("click",".btndeletecurrency",function(e){
            e.preventDefault();
            ths = $(this);
            ID = $(ths).attr("id");
            // options
            $(ths).children("span:first-child()").addClass("d-none");
            $(ths).children("span:last-child()").removeClass("d-none");
            $(ths).attr("disabled",true);

            $.post("../app/Controllers/Company.php",{removecurrency:true,id:ID},function(data){
                console.log(data);
                $(ths).parent().parent().remove();
            });

        });
    });
</script>