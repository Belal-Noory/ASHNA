<?php
include("../init.php");

$menu = array(
    array("name" => "صفحه عمومی", "url" => "dashboard.php", "icon" => "la-chart-area", "status" => "", "open" => "", "child" => array()),
    array("name" => "تجارت ", "url" => "", "icon" => "la-business-time", "status" => "", "open" => "open", "child" => array(array("name" => "تجارت جدید", "url" => "business.php", "status" => "active"), array("name" => "لیست تجارت ها", "url" => "businessList.php", "status" => ""))),
    array("name" => "ویب سایت ", "url" => "website.php", "icon" => "la-cogs", "status" => "", "open" => "", "child" => array())
);

$page_title = "تجارت جدید";

$currencies = array("BD" => "BDT", "BE" => "EUR", "BF" => "XOF", "BG" => "BGN", "BA" => "BAM", "BB" => "BBD", "WF" => "XPF", "BL" => "EUR", "BM" => "BMD", "BN" => "BND", "BO" => "BOB", "BH" => "BHD", "BI" => "BIF", "BJ" => "XOF", "BT" => "BTN", "JM" => "JMD", "BV" => "NOK", "BW" => "BWP", "WS" => "WST", "BQ" => "USD", "BR" => "BRL", "BS" => "BSD", "JE" => "GBP", "BY" => "BYR", "BZ" => "BZD", "RU" => "RUB", "RW" => "RWF", "RS" => "RSD", "TL" => "USD", "RE" => "EUR", "TM" => "TMT", "TJ" => "TJS", "RO" => "RON", "TK" => "NZD", "GW" => "XOF", "GU" => "USD", "GT" => "GTQ", "GS" => "GBP", "GR" => "EUR", "GQ" => "XAF", "GP" => "EUR", "JP" => "JPY", "GY" => "GYD", "GG" => "GBP", "GF" => "EUR", "GE" => "GEL", "GD" => "XCD", "GB" => "GBP", "GA" => "XAF", "SV" => "USD", "GN" => "GNF", "GM" => "GMD", "GL" => "DKK", "GI" => "GIP", "GH" => "GHS", "OM" => "OMR", "TN" => "TND", "JO" => "JOD", "HR" => "HRK", "HT" => "HTG", "HU" => "HUF", "HK" => "HKD", "HN" => "HNL", "HM" => "AUD", "VE" => "VEF", "PR" => "USD", "PS" => "ILS", "PW" => "USD", "PT" => "EUR", "SJ" => "NOK", "PY" => "PYG", "IQ" => "IQD", "PA" => "PAB", "PF" => "XPF", "PG" => "PGK", "PE" => "PEN", "PK" => "PKR", "PH" => "PHP", "PN" => "NZD", "PL" => "PLN", "PM" => "EUR", "ZM" => "ZMK", "EH" => "MAD", "EE" => "EUR", "EG" => "EGP", "ZA" => "ZAR", "EC" => "USD", "IT" => "EUR", "VN" => "VND", "SB" => "SBD", "ET" => "ETB", "SO" => "SOS", "ZW" => "ZWL", "SA" => "SAR", "ES" => "EUR", "ER" => "ERN", "ME" => "EUR", "MD" => "MDL", "MG" => "MGA", "MF" => "EUR", "MA" => "MAD", "MC" => "EUR", "UZ" => "UZS", "MM" => "MMK", "ML" => "XOF", "MO" => "MOP", "MN" => "MNT", "MH" => "USD", "MK" => "MKD", "MU" => "MUR", "MT" => "EUR", "MW" => "MWK", "MV" => "MVR", "MQ" => "EUR", "MP" => "USD", "MS" => "XCD", "MR" => "MRO", "IM" => "GBP", "UG" => "UGX", "TZ" => "TZS", "MY" => "MYR", "MX" => "MXN", "IL" => "ILS", "FR" => "EUR", "IO" => "USD", "SH" => "SHP", "FI" => "EUR", "FJ" => "FJD", "FK" => "FKP", "FM" => "USD", "FO" => "DKK", "NI" => "NIO", "NL" => "EUR", "NO" => "NOK", "NA" => "NAD", "VU" => "VUV", "NC" => "XPF", "NE" => "XOF", "NF" => "AUD", "NG" => "NGN", "NZ" => "NZD", "NP" => "NPR", "NR" => "AUD", "NU" => "NZD", "CK" => "NZD", "XK" => "EUR", "CI" => "XOF", "CH" => "CHF", "CO" => "COP", "CN" => "CNY", "CM" => "XAF", "CL" => "CLP", "CC" => "AUD", "CA" => "CAD", "CG" => "XAF", "CF" => "XAF", "CD" => "CDF", "CZ" => "CZK", "CY" => "EUR", "CX" => "AUD", "CR" => "CRC", "CW" => "ANG", "CV" => "CVE", "CU" => "CUP", "SZ" => "SZL", "SY" => "SYP", "SX" => "ANG", "KG" => "KGS", "KE" => "KES", "SS" => "SSP", "SR" => "SRD", "KI" => "AUD", "KH" => "KHR", "KN" => "XCD", "KM" => "KMF", "ST" => "STD", "SK" => "EUR", "KR" => "KRW", "SI" => "EUR", "KP" => "KPW", "KW" => "KWD", "SN" => "XOF", "SM" => "EUR", "SL" => "SLL", "SC" => "SCR", "KZ" => "KZT", "KY" => "KYD", "SG" => "SGD", "SE" => "SEK", "SD" => "SDG", "DO" => "DOP", "DM" => "XCD", "DJ" => "DJF", "DK" => "DKK", "VG" => "USD", "DE" => "EUR", "YE" => "YER", "DZ" => "DZD", "US" => "USD", "UY" => "UYU", "YT" => "EUR", "UM" => "USD", "LB" => "LBP", "LC" => "XCD", "LA" => "LAK", "TV" => "AUD", "TW" => "TWD", "TT" => "TTD", "TR" => "TRY", "LK" => "LKR", "LI" => "CHF", "LV" => "EUR", "TO" => "TOP", "LT" => "LTL", "LU" => "EUR", "LR" => "LRD", "LS" => "LSL", "TH" => "THB", "TF" => "EUR", "TG" => "XOF", "TD" => "XAF", "TC" => "USD", "LY" => "LYD", "VA" => "EUR", "VC" => "XCD", "AE" => "AED", "AD" => "EUR", "AG" => "XCD", "AF" => "AFN", "AI" => "XCD", "VI" => "USD", "IS" => "ISK", "IR" => "IRR", "AM" => "AMD", "AL" => "ALL", "AO" => "AOA", "AQ" => "", "AS" => "USD", "AR" => "ARS", "AU" => "AUD", "AT" => "EUR", "AW" => "AWG", "IN" => "INR", "AX" => "EUR", "AZ" => "AZN", "IE" => "EUR", "ID" => "IDR", "UA" => "UAH", "QA" => "QAR", "MZ" => "MZN");

include("./master/header.php");
?>

<div class="app-content content">
    <div class="content-header row">
    </div>
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">ایجاد تجارت/کمپنی چدید</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <form class="form">
                            <!-- Step 1 -->
                            <h4 class='form-section'><i class='ft-user'></i>معلومات کسب و کار</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cname">
                                            نام :
                                            <span class="danger">*</span>
                                        </label>
                                        <input type="text" class="form-control  " id="cname" name="cname" placeholder="نام">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="clegalname">
                                            نام قانونی :
                                            <span class="danger">*</span>
                                        </label>
                                        <input type="text" class="form-control  " id="clegalname" name="clegalname" placeholder="نام قانونی">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ctype">
                                            نوعیت تجارت :
                                            <span class="danger">*</span>
                                        </label>
                                        <select class="c-select form-control  " id="ctype" name="ctype">
                                            <option value=" صرافی">صرافی</option>
                                            <option value="خدمات پولی">خدمات پولی</option>
                                            <option value=" صرافی و خدمات پولی ">صرافی و خدمات پولی</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <h4 class='form-section'><i class='ft-user'></i>معلومات افتصادی</h4>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="clicense">
                                            لیسانس نمبر :
                                            <span class="danger">*</span>
                                        </label>
                                        <input type="text" class="form-control  " id="clicense" name="clicense" placeholder="لیسانس نمبر">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="maincurrency">واحد پولی اصلی :</label>
                                        <select class="c-select form-control  " id="maincurrency" name="maincurrency">
                                            <?php foreach ($currencies as $country => $currency) {
                                                echo "<option value='$currency'>$currency - $country</option>";
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cTIN">نمبر تشخیصه :</label>
                                        <input type="tel" class="form-control" id="cTIN" name="cTIN" placeholder="نمبر تشخیصه">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="creginum">شماره ثبت :</label>
                                        <input type="text" class="form-control" id="creginum" name="creginum" placeholder="شماره ثبت">
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <h4 class='form-section'><i class='ft-user'></i>معلومات تماس</h4>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ccountry">
                                            کشور :
                                            <span class="danger">*</span>
                                        </label>
                                        <select class="c-select form-control  " id="ccountry" name="ccountry">
                                            <option value="افغانستان">افغانستان</option>
                                            <option value=" پاکستان">پاکستان</option>
                                            <option value=" ایران ">ایران</option>
                                            <option value=" ترکیه ">ترکیه</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cprovince">
                                            ولایت :
                                            <span class="danger">*</span>
                                        </label>
                                        <input type="text" class="form-control  " id="cprovince" name="cprovince" placeholder="ولایت">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cdistrict">
                                            ولسوالی :
                                            <span class="danger">*</span>
                                        </label>
                                        <input type="text" class="form-control  " id="cdistrict" name="cdistrict" placeholder="ولسوالی">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cemail">
                                            ایمیل :
                                            <span class="danger">*</span>
                                        </label>
                                        <input type="email" class="form-control" id="cemail" name="cemail" placeholder="ایمیل">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cpostalcode">
                                            کدپوستی :
                                            <span class="danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="cpostalcode" name="cpostalcode" placeholder="کدپوستی">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cphone">
                                            شماره تماس :
                                            <span class="danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="cphone" name="cphone" placeholder="شماره تماس">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cfax">
                                            فکس :
                                            <span class="danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="cfax" name="cfax" placeholder="فکس">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cwebsite">
                                            ویب سایت :
                                            <span class="danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="cwebsite" name="cwebsite" placeholder="ویب سایت">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="caddress">
                                            ادرس :
                                            <span class="danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="caddress" name="caddress" placeholder="ادرس">
                                    </div>
                                </div>
                                <input type="hidden" name="addcompany" id="addcompany">
                            </div>

                            <!-- Step 3 -->
                            <h4 class='form-section'><i class='ft-user'></i>معلومات قرار داد</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_contract">
                                            پایان قرارداد :
                                            <span class="danger">*</span>
                                        </label>
                                        <input type="date" class="form-control required" id="end_contract" name="end_contract">
                                    </div>
                                </div>
                                <div class="attachContainer col-md-6">
                                    <div class='form-group attachement'>
                                        <label for='attachment' style="font-size:24px">
                                            <span class='las la-file-upload blue'></span>
                                        </label>
                                        <i id='filename'>filename</i>
                                        <input type='file' class='form-control required d-none attachInput' id='attachment' name='attachment' />
                                    </div>
                                    <button type="button" class="btn btn-blue" id="btnaddattach"><span class="las la-plus"></span></button>
                                </div>
                            </div>

                            <h4 class='form-section'><i class='ft-user'></i>معلومات یوزر</h4>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="fname">اسم</label>
                                        <input type="text" id="fname" class="form-control required" placeholder="اسم" name="fname">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="lname">تخلص</label>
                                        <input type="text" id="lname" class="form-control required" placeholder="تخلص" name="lname">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">ایمیل یا یوزر نیم</label>
                                        <input type="text" id="email" class="form-control required" placeholder="ایمیل یا یوزر نیم" name="email">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="pass">رمز عبور/پاسورد</label>
                                        <input type="password" id="pass" class="form-control required" placeholder="رمز عبور/پاسورد" name="pass">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div style="display: flex;">
                                    <label for="multiCurrency">
                                        چندین واحد پولی؟:
                                    </label>
                                    <input type="checkbox" id="multiCurrency" style="width:25px; height:25px; margin:0px 5px" />
                                </div>
                                <div class="form-group d-none" id="ccontainer">
                                    <label for="multiCurrency">
                                        واحد پولی:
                                    </label>
                                    <select class="form-control" name="ccurrency1">
                                        <?php foreach ($currencies as $country => $currency) {
                                            echo "<option value='$currency'>$currency - $country</option>";
                                        } ?>
                                    </select>
                                </div>
                                <button type="button" class="btn btn-info mt-2 d-none" id="addmorecurrency">
                                    <span class="la la-plus"></span>
                                </button>
                            </div>

                            <input type="hidden" name="addcompany" id="addcompany">
                            <input type="hidden" name="attachCounter" id="attachCounter" value="0">
                            <input type="hidden" name="currencyCount" id="currencyCount" value="0">

                            <div class="form-actions">
                                <button type="submit" class="btn btn-info waves-effect waves-light">
                                    <i class="la la-check-square-o"></i> Save
                                </button>
                                <button type="reset" class="btn btn-danger waves-effect waves-light">
                                    <i class="la la-check-square-o"></i> Cancel
                                </button>
                            </div>
                        </form>

                        <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mt-2 mb-2 d-none" role="alert" id="caddedalert">
                            <span class="alert-icon"><i class="la la-thumbs-o-down"></i></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <strong id="addbusinessErrorText"></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- END: Content-->

<!-- Modal -->
<div class="modal fade text-center" id="show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body p-2">
                <div class="container container-waiting">
                    <i class="la la-circle-o-notch spinner blue" style="font-size: 30px;"></i>
                </div>

                <div class="container container-done d-none">
                    <i class="font-large-2 icon-line-height la la-check" style="color: seagreen;"></i>
                    <h5>کسب و کار موفقانه درج شد تشکر</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<?php include("./master/footer.php"); ?>

<script>
    $(document).ready(() => {
        // Add Out Transfere
        $(document).on("submit", ".form", function(e) {
            e.preventDefault();
            if ($(".form").valid()) {
                $.ajax({
                    url: "../app/Controllers/Company.php",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#show").modal("show");
                    },
                    success: function(data) {
                        console.log(data);
                        $(".container-waiting").addClass("d-none");
                        $(".container-done").removeClass("d-none");
                        $(".form")[0].reset();
                    },
                    error: function(e) {
                        $(".container-waiting").addClass("d-none");
                        $(".container-done").removeClass("d-none");
                        $(".container-done").html(e);
                    }
                });
            }
        });

        currencyIndex = 0;
        $("#addmorecurrency").on("click", function() {
            $(this).prev("div").append("<select class='form-control mt-2' name='ccurrency" + currencyIndex + "'><option value='BDT'>BDT - BD</option><option value='EUR'>EUR - BE</option><option value='XOF'>XOF - BF</option><option value='BGN'>BGN - BG</option><option value='BAM'>BAM - BA</option><option value='BBD'>BBD - BB</option><option value='XPF'>XPF - WF</option><option value='EUR'>EUR - BL</option><option value='BMD'>BMD - BM</option><option value='BND'>BND - BN</option><option value='BOB'>BOB - BO</option><option value='BHD'>BHD - BH</option><option value='BIF'>BIF - BI</option><option value='XOF'>XOF - BJ</option><option value='BTN'>BTN - BT</option><option value='JMD'>JMD - JM</option><option value='NOK'>NOK - BV</option><option value='BWP'>BWP - BW</option><option value='WST'>WST - WS</option><option value='USD'>USD - BQ</option><option value='BRL'>BRL - BR</option><option value='BSD'>BSD - BS</option><option value='GBP'>GBP - JE</option><option value='BYR'>BYR - BY</option><option value='BZD'>BZD - BZ</option><option value='RUB'>RUB - RU</option><option value='RWF'>RWF - RW</option><option value='RSD'>RSD - RS</option><option value='USD'>USD - TL</option><option value='EUR'>EUR - RE</option><option value='TMT'>TMT - TM</option><option value='TJS'>TJS - TJ</option><option value='RON'>RON - RO</option><option value='NZD'>NZD - TK</option><option value='XOF'>XOF - GW</option><option value='USD'>USD - GU</option><option value='GTQ'>GTQ - GT</option><option value='GBP'>GBP - GS</option><option value='EUR'>EUR - GR</option><option value='XAF'>XAF - GQ</option><option value='EUR'>EUR - GP</option><option value='JPY'>JPY - JP</option><option value='GYD'>GYD - GY</option><option value='GBP'>GBP - GG</option><option value='EUR'>EUR - GF</option><option value='GEL'>GEL - GE</option><option value='XCD'>XCD - GD</option><option value='GBP'>GBP - GB</option><option value='XAF'>XAF - GA</option><option value='USD'>USD - SV</option><option value='GNF'>GNF - GN</option><option value='GMD'>GMD - GM</option><option value='DKK'>DKK - GL</option><option value='GIP'>GIP - GI</option><option value='GHS'>GHS - GH</option><option value='OMR'>OMR - OM</option><option value='TND'>TND - TN</option><option value='JOD'>JOD - JO</option><option value='HRK'>HRK - HR</option><option value='HTG'>HTG - HT</option><option value='HUF'>HUF - HU</option><option value='HKD'>HKD - HK</option><option value='HNL'>HNL - HN</option><option value='AUD'>AUD - HM</option><option value='VEF'>VEF - VE</option><option value='USD'>USD - PR</option><option value='ILS'>ILS - PS</option><option value='USD'>USD - PW</option><option value='EUR'>EUR - PT</option><option value='NOK'>NOK - SJ</option><option value='PYG'>PYG - PY</option><option value='IQD'>IQD - IQ</option><option value='PAB'>PAB - PA</option><option value='XPF'>XPF - PF</option><option value='PGK'>PGK - PG</option><option value='PEN'>PEN - PE</option><option value='PKR'>PKR - PK</option><option value='PHP'>PHP - PH</option><option value='NZD'>NZD - PN</option><option value='PLN'>PLN - PL</option><option value='EUR'>EUR - PM</option><option value='ZMK'>ZMK - ZM</option><option value='MAD'>MAD - EH</option><option value='EUR'>EUR - EE</option><option value='EGP'>EGP - EG</option><option value='ZAR'>ZAR - ZA</option><option value='USD'>USD - EC</option><option value='EUR'>EUR - IT</option><option value='VND'>VND - VN</option><option value='SBD'>SBD - SB</option><option value='ETB'>ETB - ET</option><option value='SOS'>SOS - SO</option><option value='ZWL'>ZWL - ZW</option><option value='SAR'>SAR - SA</option><option value='EUR'>EUR - ES</option><option value='ERN'>ERN - ER</option><option value='EUR'>EUR - ME</option><option value='MDL'>MDL - MD</option><option value='MGA'>MGA - MG</option><option value='EUR'>EUR - MF</option><option value='MAD'>MAD - MA</option><option value='EUR'>EUR - MC</option><option value='UZS'>UZS - UZ</option><option value='MMK'>MMK - MM</option><option value='XOF'>XOF - ML</option><option value='MOP'>MOP - MO</option><option value='MNT'>MNT - MN</option><option value='USD'>USD - MH</option><option value='MKD'>MKD - MK</option><option value='MUR'>MUR - MU</option><option value='EUR'>EUR - MT</option><option value='MWK'>MWK - MW</option><option value='MVR'>MVR - MV</option><option value='EUR'>EUR - MQ</option><option value='USD'>USD - MP</option><option value='XCD'>XCD - MS</option><option value='MRO'>MRO - MR</option><option value='GBP'>GBP - IM</option><option value='UGX'>UGX - UG</option><option value='TZS'>TZS - TZ</option><option value='MYR'>MYR - MY</option><option value='MXN'>MXN - MX</option><option value='ILS'>ILS - IL</option><option value='EUR'>EUR - FR</option><option value='USD'>USD - IO</option><option value='SHP'>SHP - SH</option><option value='EUR'>EUR - FI</option><option value='FJD'>FJD - FJ</option><option value='FKP'>FKP - FK</option><option value='USD'>USD - FM</option><option value='DKK'>DKK - FO</option><option value='NIO'>NIO - NI</option><option value='EUR'>EUR - NL</option><option value='NOK'>NOK - NO</option><option value='NAD'>NAD - NA</option><option value='VUV'>VUV - VU</option><option value='XPF'>XPF - NC</option><option value='XOF'>XOF - NE</option><option value='AUD'>AUD - NF</option><option value='NGN'>NGN - NG</option><option value='NZD'>NZD - NZ</option><option value='NPR'>NPR - NP</option><option value='AUD'>AUD - NR</option><option value='NZD'>NZD - NU</option><option value='NZD'>NZD - CK</option><option value='EUR'>EUR - XK</option><option value='XOF'>XOF - CI</option><option value='CHF'>CHF - CH</option><option value='COP'>COP - CO</option><option value='CNY'>CNY - CN</option><option value='XAF'>XAF - CM</option><option value='CLP'>CLP - CL</option><option value='AUD'>AUD - CC</option><option value='CAD'>CAD - CA</option><option value='XAF'>XAF - CG</option><option value='XAF'>XAF - CF</option><option value='CDF'>CDF - CD</option><option value='CZK'>CZK - CZ</option><option value='EUR'>EUR - CY</option><option value='AUD'>AUD - CX</option><option value='CRC'>CRC - CR</option><option value='ANG'>ANG - CW</option><option value='CVE'>CVE - CV</option><option value='CUP'>CUP - CU</option><option value='SZL'>SZL - SZ</option><option value='SYP'>SYP - SY</option><option value='ANG'>ANG - SX</option><option value='KGS'>KGS - KG</option><option value='KES'>KES - KE</option><option value='SSP'>SSP - SS</option><option value='SRD'>SRD - SR</option><option value='AUD'>AUD - KI</option><option value='KHR'>KHR - KH</option><option value='XCD'>XCD - KN</option><option value='KMF'>KMF - KM</option><option value='STD'>STD - ST</option><option value='EUR'>EUR - SK</option><option value='KRW'>KRW - KR</option><option value='EUR'>EUR - SI</option><option value='KPW'>KPW - KP</option><option value='KWD'>KWD - KW</option><option value='XOF'>XOF - SN</option><option value='EUR'>EUR - SM</option><option value='SLL'>SLL - SL</option><option value='SCR'>SCR - SC</option><option value='KZT'>KZT - KZ</option><option value='KYD'>KYD - KY</option><option value='SGD'>SGD - SG</option><option value='SEK'>SEK - SE</option><option value='SDG'>SDG - SD</option><option value='DOP'>DOP - DO</option><option value='XCD'>XCD - DM</option><option value='DJF'>DJF - DJ</option><option value='DKK'>DKK - DK</option><option value='USD'>USD - VG</option><option value='EUR'>EUR - DE</option><option value='YER'>YER - YE</option><option value='DZD'>DZD - DZ</option><option value='USD'>USD - US</option><option value='UYU'>UYU - UY</option><option value='EUR'>EUR - YT</option><option value='USD'>USD - UM</option><option value='LBP'>LBP - LB</option><option value='XCD'>XCD - LC</option><option value='LAK'>LAK - LA</option><option value='AUD'>AUD - TV</option><option value='TWD'>TWD - TW</option><option value='TTD'>TTD - TT</option><option value='TRY'>TRY - TR</option><option value='LKR'>LKR - LK</option><option value='CHF'>CHF - LI</option><option value='EUR'>EUR - LV</option><option value='TOP'>TOP - TO</option><option value='LTL'>LTL - LT</option><option value='EUR'>EUR - LU</option><option value='LRD'>LRD - LR</option><option value='LSL'>LSL - LS</option><option value='THB'>THB - TH</option><option value='EUR'>EUR - TF</option><option value='XOF'>XOF - TG</option><option value='XAF'>XAF - TD</option><option value='USD'>USD - TC</option><option value='LYD'>LYD - LY</option><option value='EUR'>EUR - VA</option><option value='XCD'>XCD - VC</option><option value='AED'>AED - AE</option><option value='EUR'>EUR - AD</option><option value='XCD'>XCD - AG</option><option value='AFN'>AFN - AF</option><option value='XCD'>XCD - AI</option><option value='USD'>USD - VI</option><option value='ISK'>ISK - IS</option><option value='IRR'>IRR - IR</option><option value='AMD'>AMD - AM</option><option value='ALL'>ALL - AL</option><option value='AOA'>AOA - AO</option><option value=''> - AQ</option><option value='USD'>USD - AS</option><option value='ARS'>ARS - AR</option><option value='AUD'>AUD - AU</option><option value='EUR'>EUR - AT</option><option value='AWG'>AWG - AW</option><option value='INR'>INR - IN</option><option value='EUR'>EUR - AX</option><option value='AZN'>AZN - AZ</option><option value='EUR'>EUR - IE</option><option value='IDR'>IDR - ID</option><option value='UAH'>UAH - UA</option><option value='QAR'>QAR - QA</option><option value='MZN'>MZN - MZ</option></select>");
            $("#currencyCount").val(currencyIndex);
            currencyIndex++;
        });

        $("#multiCurrency").on("change", function() {
            if ($(this).is(":checked")) {
                $("#ccontainer").removeClass("d-none");
                $("#addmorecurrency").removeClass("d-none");
                $("#currencyCount").val("1");
            } else {
                $("#ccontainer").addClass("d-none");
                $("#addmorecurrency").addClass("d-none");
                $("#currencyCount").val("0");
            }
        });

        // get upload file name
        $(document).on("change", ".attachInput", function() {
            $(this).parent().children("#filename").text($(this).val().substr($(this).val().lastIndexOf("\\") + 1));
        });

        senderCounter = 1;
        $("#btnaddattach").on("click", function() {
            name = "attachment" + senderCounter;
            form = `<div class='form-group attachement'>
                            <label for='${name}' style="font-size:24px">
                                <span class='las la-file-upload blue'></span>
                            </label>
                            <i id='filename'>filename</i>
                            <input type='file' class='form-control required d-none attachInput' id='${name}' name='${name}' />
                            <a href='#' class='deletattach' style='font-size:25px'><span class='las la-trash danger'></span></a>
                        </div>`;
            $(this).prev().append(form);
            $("#attachCount").val(senderCounter);
            $("#attachCounter").val(senderCounter);
            senderCounter++;
        });

        // Delete daily sender customer attachment
        $(document).on("click", ".deletattach", function(e) {
            e.preventDefault();
            inputcounter = $("#attachCounter").val();
            inputcounter--;
            $("#attachCounter").val(inputcounter);
            senderCounter--;
            $(this).parent().fadeOut();
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