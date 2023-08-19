<x-app-layout>

    <div id="mensagem"></div>

    <div class="container" style="padding: 15px;">
        <div class="row">
            <div class="col-md-12">
            <table id="example" class="table table-striped table-hover table-bordered" style="width:100%">
                <thead>
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
                    @foreach ($users as $user)
                    <tr @if($user->status == 2) class="table-success" @endif>
                        <td>{{ $count }}</td>
                        <td>{{ $user->postograd }}</td>
                        <td>{{ $user->nome_guerra }}</td>
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
                            Cadastrado
                        </td>
                        @endif

                        @if($user->status == 1)
                        <td>
                            Autorizado
                        </td>
                        @endif

                        @if($user->status == 2)
                        <td>
                            Transferido
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

                                    <a class="dropdown-item" href="#">Editar</a>
                                  </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @php
                    $count++
                    @endphp
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>

</x-app-layout>
