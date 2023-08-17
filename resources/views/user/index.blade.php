<x-app-layout>

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
                            <button class="btn btn-sm btn-primary">Primary</button>
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