<div class="row">
    <div class="col-md-12">
        <h4>Slow Query Log Visualizer</h4>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Query</th>
                            <th>Execuções</th>
                            <th>Tempo Médio (s)</th>
                            <th>Tempo Máximo (s)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($slowQueries as $query)
                        <tr>
                            <td>
                                <details>
                                    <summary>Ver Query Completa</summary>
                                    <code class="d-block mt-2 p-2 bg-light">{{ $query->sql_text }}</code>
                                </details>
                            </td>
                            <td>{{ $query->exec_count }}</td>
                            <td>{{ number_format($query->avg_time_sec, 4) }}</td>
                            <td>{{ number_format($query->max_time_sec, 4) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Nenhuma query lenta encontrada (> 1s)</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5>Configuração do Slow Query Log</h5>
            </div>
            <div class="card-body">
                <p>Para habilitar o slow query log no MySQL:</p>
                <pre><code>SET GLOBAL slow_query_log = 'ON';
SET GLOBAL long_query_time = 1; -- 1 segundo
SET GLOBAL slow_query_log_file = '/var/log/mysql/mysql-slow.log';</code></pre>
            </div>
        </div>
    </div>
</div>