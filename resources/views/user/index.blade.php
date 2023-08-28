<x-app-layout>

    <div id="mensagem"></div>

    <div class="container" style="padding: 15px;">

       <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Troca de Senha</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulário para a troca de senha -->
                        <form id="modal-form" method="post">

                            @csrf

                            <div class="form-group">
                                <label for="nova_senha">Nova Senha</label>
                                <input type="password" class="form-control" id="nova_senha" name="nova_senha" required>
                            </div>
                            <div class="form-group">
                                <label for="confirmar_senha">Confirmar Nova Senha</label>
                                <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary" id="salvarSenhaBtn">Salvar Senha</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="text-center">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }} <i class="fas fa-thumbs-up"></i>
                </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }} <i class="fas fa-thumbs-down"></i></li>
                            @endforeach
                        </ul>
                    </div>
                @endif   
                </div>         

            <table id="table-user" class="table table-striped table-hover table-bordered" style="width:100%">
                <thead>
                    <a class="btn btn-primary btn-block mb-10" role="button"
                        href="{{ route('user.create') }}"
                        >
                        Adicionar Usuário
                        <i class="fas fa-user-plus"></i>
                    </a>

                    <tr>
                        <th>Ord</th>
                        <th>Posto/Grad</th>
                        <th>Nome de Guerra</th>
                        <th>Nome Completo</th>
                        <th>Email / Cel</th>
                        <th>Perfil</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                    @endphp
                    @foreach ($usersChunked as $users)
                        @foreach ($users as $user)
                        <tr @if($user->status == 2) class="table-success" @endif>
                            <td>{{ $count }}</td>
                            <td>{{ $user->postograd }}</td>
                            <td>{{ $user->nome_guerra }}
                                @if ($user->livros->isNotEmpty())
                                    <i class="fas fa-star text-warning" title="Este usuário possui um ou mais livros preenchidos"></i>
                                @endif
                            </td>
                            <td>{{ $user->nome_completo }}</td>
                            <td>
                                {{ $user->email }}
                                /
                                <br>
                                Cel: {{ $user->cel }}
                            </td>
                            <td>{{ $user->perfil }}</td>
                            @if($user->status == 0)
                            <td style="color: red">
                                <i>Cadastrado</i>
                            </td>
                            @endif

                            @if($user->status == 1)
                            <td>
                                <i>Autorizado</i>
                            </td>
                            @endif

                            @if($user->status == 2)
                            <td>
                                <i>Transferido</i>
                            </td>
                            @endif
                            <td>
                                <div class="btn-group" role="group">
                                    <div class="btn-group" role="group">
                                    <button {{ $user->status == 2 ? 'disabled' : '' }} class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ação
                                        <i class="fas fa-cog"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        {{-- mudança de perfil --}}
                                        @php
                                        $profile = Auth()->user()->perfil;
                                        $profilesToOptions = [
                                            'Admin' => ['Admin', 'Secretaria', 'Sargenteante', 'Usuário Comum'],
                                            'Secretaria' => ['Sargenteante', 'Usuário Comum'],
                                            'Sargenteante' => ['Usuário Comum'],
                                            'Usuário Comum' => []
                                        ];
                                        @endphp

                                        @foreach ($profilesToOptions[$profile] as $option)
                                        @if ($option != $user->perfil)
                                            <a class="dropdown-item btn-mudar-perfil" 
                                                data-id="{{ $user->id }}"
                                                data-perfil="{{ $option }}"
                                                href="">
                                                Mudar para {{ $option }}
                                            </a>
                                        @endif
                                        @endforeach
                                        {{-- fim --}}


                                        @if($user->status == 0)
                                        <a class="dropdown-item btn-autorizar" 
                                            data-id="{{ $user->id }}"
                                            data-status="1"
                                            href="">
                                            Autorizar
                                        </a>
                                        @endif

                                        @if($user->status == 1)
                                        <a class="dropdown-item btn-autorizar" 
                                            data-id="{{ $user->id }}"
                                            data-status="0"
                                            href="">
                                            Negar Acesso    
                                        </a>

                                        <a class="dropdown-item btn-autorizar" 
                                            data-id="{{ $user->id }}"
                                            data-status="2"
                                            href="">
                                            Transferido    
                                        </a>
                                        @endif

                                       <!-- Botão que aciona o modal -->
                                       <a class="dropdown-item open-modal-button" 
                                       data-id="{{ $user->id }}"
                                       data-toggle="modal" 
                                       href=""
                                       data-target="#myModal">
                                       Trocar Senha
                                        </a>

                                    </div>
                                    </div>
                                </div>

                                @if ($user->nome_guerra != 'sti')
                                <a href="{{ route('user.destroy', $user->id) }}" class="btn btn-sm btn-danger delete-user @if($user->status == 2) disabled-link @endif" data-id="{{ $user->id }}">
                                    Excluir
                                    <i class="fas fa-trash"></i>
                                </a>
                                @endif
                                
                            </td>
                        </tr>
                        @php
                        $count++
                        @endphp

                        @endforeach
                    @endforeach
                </tbody>
            </table>

           
            <style>
                /* Arredondar os cantos dos inputs */
                .form-control {
                    border-radius: 10px;
                }

                /* Alterar a cor das letras das labels para cinza */
                .form-group label {
                    color: #808080; /* Cor cinza */
                }
            </style>

            </div>
        </div>
    </div>

</x-app-layout>
