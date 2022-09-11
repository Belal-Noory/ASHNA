function print(data) {
    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    path = baseUrl + '/bussiness/assets/css/print.css';
    $("#printimg").attr("src", baseUrl + "/business/app-assets/images/logo/ashna_trans.png");
    if ($(".customer").length > 0) {
        $("#printtitle").text($(document).attr('title'));
        $("#pdate").text(data.date);

        // get current time
        var now = new Date(Date.now());
        var formatted = now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();
        $("#ptime").text(formatted);

        $("#plid").text(data.lid);
        $("#prid").text(data.tid);
        $("#pcurrency").text(data.currency);
        $("#pamount").text(data.amount);

        $("#rfrom").text(data.from);
        $("#pdetiails").text(data.details);
        $("#wordamount").text(toWords(data.amount));

        $("#pby").text(data.pby);
        // $("#vby").text(data.vby);

        $(".print").printThis({
            importCSS: false,
            importStyle: true,
        });
    }
}