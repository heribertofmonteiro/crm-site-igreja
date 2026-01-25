<div class="row">
    <div class="col-md-12">
        <h4>Análise de Performance das Consultas</h4>

        <div class="card">
            <div class="card-header">
                <h5>Queries Lentas</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Query</th>
                            <th>Execuções</th>
                            <th>Tempo Médio (s)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($slowQueries as $query)
                        <tr>
                            <td><code>{{ Str::limit($query->sql_text, 100) }}</code></td>
                            <td>{{ $query->exec_count }}</td>
                            <td>{{ number_format($query->avg_time_sec, 4) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">Nenhuma query lenta detectada</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5>Problemas N+1 Detectados</h5>
            </div>
            <div class="card-body">
                @if(count($nPlusOneQueries) > 0)
                <ul class="list-group">
                    @foreach($nPlusOneQueries as $issue)
                    <li class="list-group-item">{{ $issue }}</li>
                    @endforeach
                </ul>
                @else
                <p class="text-success">Nenhum problema N+1 detectado.</p>
                @endif
            </div>
        </div>
    </div>
</div>