<x-app-layout>

    <div class="container" style="padding: 15px;">
        <div class="row">
            <div class="col-md-12">
                
                <table id="table-livro" class="table table-striped table-hover table-bordered" style="width:100%">
                <thead>

                 <a class="btn btn-success btn-block mb-10" role="button"
                    href="{{ route('livro.create') }}"
                    >
                    Preencher o Livro
                    <i class="fas fa-pencil-alt"></i>
                    <i class="fas fa-book"></i>
                 </a>
                 
                 <div class="text-center">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }} <i class="fas fa-thumbs-up"></i>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }} <i class="fas fa-thumbs-down"></i>
                        </div>
                    @endif
                </div>

                    <tr>
                        <th>Ord</th>
                        <th>Usuário</th>
                        <th>Data Inicial</th>
                        <th>Data Final</th>
                        <th>Nrº Dias</th>
                        <th>Motivo</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                    @endphp
                    @foreach ($livros as $livro)
                    <tr>
                        <td>{{ $count }}</td>
                        <td>{{ $livro->users->postograd . " " . $livro->users->nome_guerra }}</td>
                        <td>{{ \Carbon\Carbon::parse($livro->dt_ini)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($livro->dt_end)->format('d/m/Y') }}</td>
                        <td style="text-align: center">{{ \Carbon\Carbon::parse($livro->dt_end)->diffInDays($livro->dt_ini) }}</td>
                        <td>
                            {{ Str::limit($livro->texto, 50) }}
                            @if (strlen($livro->texto) > 50)
                                <a href="#" data-toggle="modal" data-target="#myModal">
                                    + Leia mais
                                </a>
                            @endif
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

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Motivo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div id="modal-content">
                        {{ $livro->texto }}
                    </div> <!-- Usamos uma div em vez de um parágrafo -->
                </div>
            </div>
        </div>
    </div>
    
    

</x-app-layout>