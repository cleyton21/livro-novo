<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- {{ __("You're logged in!") }} --}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="bg-primary text-white p-4 rounded">
                                <h4>Total de Usuários</h4>
                                <p>{{ $totalUsuarios }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-success text-white p-4 rounded">
                                <h4>Livros Preenchidos</h4>
                                <p>{{ $totalLivros }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-info text-white p-4 rounded">
                                <h4>Usuários Desautorizados</h4>
                                <p>{{ $totalUsuariosStatusZero }}</p>
                            </div>
                        </div>

                        <div class="col-md-12 text-center mt-10">
                            {{-- <h2>Gráfico de Donuts</h2> --}}
                            <div class="d-flex justify-content-center align-items-center" style="height: 300px;"> <!-- Centralização flexível -->
                                <canvas id="donutChart" width="600" height="300"></canvas>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>

    </div>
</x-app-layout>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('donutChart').getContext('2d');

    var postoGradData = @json($postoGradData);
    var postoGradLabels = @json($postoGradLabels);
    
    var colors = [
    '#007BFF', '#28A745', '#17A2B8', '#DC3545', '#FFC107', '#6C757D', '#6610F2',
    '#28A745', '#20C997', '#FF6B6B', '#007BFF', '#17A2B8', '#F0AD4E', '#6C757D',
    '#6610F2'
    ];

    var donutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            // labels: ['Usuários', 'Livros', 'Desautorizados'],
            labels: postoGradLabels,
            datasets: [{
                // data: [{{ $totalUsuarios }}, {{ $totalLivros }}, {{ $totalUsuariosStatusZero }}],
                data: postoGradData,
                // backgroundColor: ['#007BFF', '#28A745', '#17A2B8'],
                backgroundColor: colors.slice(0, Object.keys(postoGradData).length),
            }],
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                },
            },
        },
    });
</script>
