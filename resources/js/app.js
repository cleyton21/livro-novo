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
        
        var novoStatus = status;
        
        if(status == 2) {
            if(!confirm("Tem certeza que deseja mudar o status para transferido? Essa ação é irreversível e o usuário não poderá ser deletado do sistema porém seus dados ficarão preservados.")){
                return;
            }
        }

        $.ajax({
            type: "GET",
            url: "/user/autorizar/"+id,
            data: {"id": id, "novoStatus": novoStatus},
            dataType: "json",
            success: function(response) {
                alert(response.mensagem);
                location.reload();
            }, 
            error: function (response) {
                alert(response.mensagem);
            }
        });

    });
});
