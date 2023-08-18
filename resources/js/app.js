import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// tradução do datatable
var table = new DataTable('#example', {
    language: {
        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json',
    },
});

$(document).ready(function () {

    $('#example').on('click', '.btn-atualizar', function (e) {
        e.preventDefault();
       
        var id = $(this).data('id');
        console.log(id);

        $.ajax({
            type: "GET",
            url: "/autorizar/"+id,
            data: {"id": id},
            dataType: "json",
            success: function(response) {
                console.log(response);
                // if(response.status == 404) {
                //     $("#mensagem").html("");
                //     $("#mensagem").addClass('alert alert-danger');
                //     $("#mensagem").text(response.message);
                // } else {
                //     $("#mensagem").html("");
                //     $("#mensagem").addClass('alert alert-success mt-10');
                //     $("#mensagem").text(response.item);
                // }
            }
        });

    });
});
