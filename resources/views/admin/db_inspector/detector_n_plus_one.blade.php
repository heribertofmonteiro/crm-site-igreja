<div class="row">
    <div class="col-md-12">
        <h4>Detector de Problemas N+1</h4>

        <div class="card">
            <div class="card-body">
                @if(count($nPlusOneIssues) > 0)
                <div class="alert alert-warning">
                    <strong>Problemas N+1 Detectados:</strong> Estes problemas podem causar lentidão significativa quando muitos registros são processados.
                </div>
                <ul class="list-group">
                    @foreach($nPlusOneIssues as $issue)
                    <li class="list-group-item">
                        <strong>{{ $issue['location'] }}</strong><br>
                        <code>{{ $issue['query'] }}</code><br>
                        <small class="text-muted">Solução sugerida: {{ $issue['solution'] }}</small>
                    </li>
                    @endforeach
                </ul>
                @else
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> Nenhum problema N+1 detectado no momento.
                </div>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5>Dicas para Evitar N+1</h5>
            </div>
            <div class="card-body">
                <ul>
                    <li>Use <code>with()</code> para eager loading: <code>$users = User::with('posts')->get();</code></li>
                    <li>Use <code>load()</code> para lazy eager loading: <code>$users->load('posts');</code></li>
                    <li>Considere usar <code>select()</code> para campos específicos quando necessário</li>
                    <li>Monitore queries com Laravel Debugbar em desenvolvimento</li>
                </ul>
            </div>
        </div>
    </div>
</div>