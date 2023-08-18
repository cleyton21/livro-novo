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

    $('#example').on('click', '.btn-autorizar', function (e) {
        e.preventDefault();
       
        var id = $(this).data('id');
        var status = $(this).data('status');
        if(status == 0){
            var novoStatus = 1;
        }else{
            var novoStatus = 0;
        }
        // console.log(id);

        $.ajax({
            type: "GET",
            url: "/user/autorizar/"+id,
            data: {"id": id, "novoStatus": novoStatus},
            dataType: "json",
            success: function(response) {
                alert(response.mensagem);
                location.reload();
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
