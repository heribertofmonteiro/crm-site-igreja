<div class="row">
    <div class="col-md-12">
        <h4>Monitoramento do Cache (Redis)</h4>

        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>Hits</h5>
                        <h2 class="text-success">{{ $cacheInfo['hits'] ?? 'N/A' }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>Misses</h5>
                        <h2 class="text-warning">{{ $cacheInfo['misses'] ?? 'N/A' }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>Chaves</h5>
                        <h2 class="text-info">{{ $cacheInfo['keys'] ?? 'N/A' }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>Uso de Memória</h5>
                        <h2 class="text-primary">{{ $cacheInfo['memory_usage'] ?? 'N/A' }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5>Taxa de Acerto do Cache</h5>
            </div>
            <div class="card-body">
                @php
                $total = ($cacheInfo['hits'] ?? 0) + ($cacheInfo['misses'] ?? 0);
                $hitRate = $total > 0 ? round(($cacheInfo['hits'] ?? 0) / $total * 100, 2) : 0;
                @endphp
                <div class="progress">
                    <div class="progress-bar bg-success" style="width: {{ $hitRate }}%">{{ $hitRate }}%</div>
                </div>
                <p class="mt-2">Taxa de acerto: {{ $hitRate }}%</p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5>Ações do Cache</h5>
            </div>
            <div class="card-body">
                <button class="btn btn-warning" onclick="clearCache()">Limpar Cache</button>
                <button class="btn btn-info ml-2" onclick="refreshStats()">Atualizar Estatísticas</button>
            </div>
        </div>
    </div>
</div>

<script>
function clearCache() {
    if (confirm('Tem certeza que deseja limpar todo o cache?')) {
        // Implementar chamada AJAX para limpar cache
        alert('Cache limpo com sucesso!');
    }
}

function refreshStats() {
    location.reload();
}
</script>