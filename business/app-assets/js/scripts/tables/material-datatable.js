/*=========================================================================================
    File Name: material-datatables.js
    Description: Material Datatable
    ----------------------------------------------------------------------------------------
    Item Name: Modern Admin - Clean Bootstrap 4 Dashboard HTML Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function () {
    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    $('.material-table').DataTable({
        dom: 'Bfrtip',
        stateSave: true,
        colReorder: true,
        select: true,
        autoWidth: false,
        buttons: [
            'excel', {
                extend: 'pdf',
                customize: function (doc) {
                    doc.content[1].table.widths =
                        Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                }
            }, {
                extend: 'print',
                customize: function (win) {
                    $(win.document.body)
                        .css("margin", "40pt 20pt 20pt 20pt")
                        .prepend(
                            `<div style='display:flex;flex-direction:column;justify-content:center;align-items:center'><img src="${baseUrl}/app-assets/images/logo/ashna_trans.png" style='width:60pt' /><span>ASHNA Company</span></div>`
                        );

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }, 'colvis'
        ]
    });
});