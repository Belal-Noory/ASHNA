function print(data, baseUrl) {
    $("#printimg").attr("src", baseUrl + "/app-assets/images/logo/ashna_trans.png");
    $("#printtitle").text($(document).attr('title'));
    $("#pdate").text(data.date);

    // get current time
    var now = new Date(Date.now());
    var formatted = now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();
    $("#ptime").text(formatted);

    $("#plid").text(data.lid);
    // $("#prid").text(data.tid);
    $("#pcurrency").text(data.currency);
    $("#pamount").text(data.amount);

    $("#rfrom").text(data.from);
    $("#pdetiails").text(data.details);
    $("#wordamount").text(toWords(data.amount));

    $("#pby").text(data.pby);
    $("#vby").text(data.vby);

    // transfers
    if('sender' in data){
        $("#paddress").text(data.address);
        $("#ptcode").text(data.tcode);
        $("#psender").text(data.sender);
        $("#preceiver").text(data.receiver);
        $(".transfer").attr('style','display:inline-block');

        $("#rfromEtxt").text('Saraf Name');
        $("#rfromtxt").text('نام صراف');
    }

    $(".print").printThis({
        importCSS: false,
        importStyle: true,
    });
}
