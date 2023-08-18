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
                        <th>Email</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                    @endphp
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $count }}</td>
                        <td>{{ $user->postograd }}</td>
                        <td>{{ $user->nome_guerra }}</td>
                        <td>{{ $user->nome_completo }}</td>
                        <td>{{ $user->email }}</td>
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
                        <td>
                            {{-- <button class="btn btn-sm btn-primary">Primary</button> --}}
                            <div class="btn-group" role="group" aria-label="Grupo de botões com dropdown aninhado">
                                <div class="btn-group" role="group">
                                  <button class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Ação
                                    <i class="fas fa-cog"></i>
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <a class="dropdown-item btn-atualizar" 
                                        id="botao-atualizar" data-id="{{ $user->id }}"
                                        {{-- href="{{ route('autorizar',['id' => $user->id]) }}"> --}}
                                        href="">
                                        Autorizar
                                    </a>
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
