import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// tradução do datatable
var table = new DataTable('#table-user', {
    language: {
        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json',
    },
});

var table = new DataTable('#table-livro', {
    language: {
        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json',
    },
});

// mudança de status de usuario
$(document).ready(function () {

    $('#table-user').on('click', '.btn-autorizar', function (e) {
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

// cadastro de usuario
// $(document).ready(function () {
//     $('form').on('click', '#gravar-livro', function (e) {
//         e.preventDefault();
//         // alert('teste');
//         var data = {
//             dt_ini: $('#dt_ini').val(),
//             dt_end: $('#dt_end').val(),
//             texto: $('#texto').val(),
//         };

//         $.ajax({
//             type: 'POST',
//             url: "{{ route('livro.store') }}", // Rota que criamos
//             data: data,
//             dataType: 'json',
//             success: function(response) {
//                 alert(response.message);
//                 // Redireciona para a URL especificada na resposta
//                 window.location.href = response.redirect_url;
//             },
//             error: function(xhr, status, error) {
//                 console.log(error);
//             }
//         });
//     });
// });
