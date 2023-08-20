<x-app-layout>

    <div class="container" style="padding: 15px;">
        <div class="row">
            <div class="col-md-12">
                
                <table id="table-livro" class="table table-striped table-hover table-bordered" style="width:100%">
                <thead>
                 <a class="btn btn-success btn-block mb-10" role="button"
                    href=""
                    >
                    Preencher o Livro
                    <i class="fas fa-pencil-alt"></i>
                    <i class="fas fa-book"></i>
                 </a>
                    <tr>
                        <th>Ord</th>
                        <th>Usuário</th>
                        <th>Data Inicial</th>
                        <th>Data Final</th>
                        <th>Nrº Dias</th>
                        <th>Motivo</th>
                        <th>Salary</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                    @endphp
                    @foreach ($livros as $livro)
                    <tr>
                        <td>{{ $count }}</td>
                        <td>{{ $livro->usuario->postograd . " " . $livro->usuario->nome_guerra }}</td>
                        <td>{{ \Carbon\Carbon::parse($livro->dt_ini)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($livro->dt_end)->format('d/m/Y') }}</td>
                        <td style="text-align: center">{{ \Carbon\Carbon::parse($livro->dt_end)->diffInDays($livro->dt_ini) }}</td>
                        <td>{{ Str::limit($livro->texto, 50) }}</td>
                        <td>$320,800</td>
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