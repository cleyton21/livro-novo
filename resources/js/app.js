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

// mudança de perfil de usuario
$(document).ready(function () {

    $('#table-user').on('click', '.btn-mudar-perfil', function (e) {
        e.preventDefault();
       
        var id = $(this).data('id');
        var perfil = $(this).data('perfil');

        var novoPerfil = perfil;

        if(!confirm("Tem certeza que deseja mudar o perfil deste usuário.")){
            return;
        }
        
        $.ajax({
            type: "GET",
            url: "/user/mudarperfil/"+id,
            data: {"id": id, "novoPerfil": novoPerfil},
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

// deletar usuario
$(document).ready(function () {
    $('.delete-user').click(function (e) {
        e.preventDefault();

        // var livroId = $(this).data('id');
        var url = $(this).attr('href');

        // Verifica se o link possui a classe 'disabled-link'
        if ($(this).hasClass('disabled-link')) {
            e.preventDefault(); // Impede que o link seja clicado
        }

        if (confirm('Tem certeza que deseja excluir o usuário?')) {
            $.ajax({
                type: 'DELETE',
                url: url,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // alert(response.message);
                    // location.reload();

                    if (response.success === true) {
                        // Exibe mensagem de sucesso com alert
                        alert(response.message);
                        location.reload();
                    } else {
                        // Exibe mensagem de erro com alert
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // alert('Erro ao excluir o usuário: ' + error);
                    alert('Erro ao excluir o usuário: procure um administrador, provavelmente o mesmo já preencheu o livro e não é possível excluir seus dados');
                }
            });
        }
    });
});

// desabilitar botao excluir do usuario
// $(document).ready(function () {
//     $('.delete-user').click(function (e) {
//         // Verifica se o link possui a classe 'disabled-link'
//         if ($(this).hasClass('disabled-link')) {
//             e.preventDefault(); // Impede que o link seja clicado
//         } else if (confirm('Tem certeza que deseja excluir o usuário?')) {
//             // Restante do código da sua solicitação Ajax
//             // ...
//         }
//     });
// });
