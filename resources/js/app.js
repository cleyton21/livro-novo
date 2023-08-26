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

// atualizar senha
$(document).ready(function() {

    var id;

    $('.open-modal-button').click(function() {
        id = $(this).data('id');
        // $("#myModal").attr("data-id", id);
        $("#myModal").data("id", id);
    });

    $('#myModal').on('hidden.bs.modal', function() {
        // Limpar os campos do formulário
        $('#nova_senha').val('');
        $('#confirmar_senha').val('');
    });

    $('#salvarSenhaBtn').click(function() {
        var nova_senha = $('#nova_senha').val();
        var confirmarSenha = $('#confirmar_senha').val();

        var id = $("#myModal").data("id");
        // alert(nova_senha);
        // alert(id);
        // return;

        // Validar se as senhas estão preenchidas
        if (nova_senha.trim() === '' || confirmarSenha.trim() === '') {
            alert("Preencha ambos os campos de senha.");
            return;
        }

        if (nova_senha.length < 8) {
            alert("A nova senha deve ter pelo menos 8 caracteres.");
            return;
        }

        // Validar se a senha não é uma sequência numérica de 1 a 8 ou de 8 a 1
        if (/12345678|87654321/.test(nova_senha)) {
            alert("A senha não pode ser uma sequência numérica de 1 a 8 ou de 8 a 1.");
            return;
        }

        if (nova_senha === confirmarSenha) {
            $.ajax({
                type: "POST", 
                url: "/user/updatepassword/"+id,
                data: {
                    'id': id, 
                    'nova_senha': nova_senha,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Lógica para lidar com a resposta de sucesso
                    alert(response.mensagem);
                    location.reload(); // Recarrega a página
                    $('#myModal').modal('hide');
                },
                error: function(response) {
                    // console.log(response.mensagem);
                    alert("Ocorreu um erro durante a solicitação. Verifique o console para mais detalhes.");
                },
            });
        } else {
            // Lógica para lidar com senhas diferentes
            alert("As senhas não coincidem.");
        }
    });
     // Limpar campos do formulário quando o modal for fechado
     $('#myModal').on('hidden.bs.modal', function () {
        $('#nova_senha').val('');
        $('#confirmar_senha').val('');
    });
});

