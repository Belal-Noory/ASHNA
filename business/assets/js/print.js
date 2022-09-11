function print(data, baseUrl) {
    $("#printimg").attr("src", baseUrl + "/app-assets/images/logo/ashna_trans.png");
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
    $("#vby").text(data.vby);

    $(".print").printThis({
        importCSS: false,
        importStyle: true,
    });
}
