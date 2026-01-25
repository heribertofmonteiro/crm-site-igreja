<div class="row">
    <div class="col-md-12">
        <h4>Mapa de Relacionamentos (ER Diagram)</h4>

        <div class="card">
            <div class="card-header">
                <h5>Diagrama Entidade-Relacionamento</h5>
            </div>
            <div class="card-body">
                <div id="erd-diagram" style="height: 600px; border: 1px solid #ddd;">
                    <!-- Diagrama será renderizado aqui via JavaScript -->
                    <div class="text-center mt-5">
                        <i class="fas fa-project-diagram fa-3x text-muted"></i>
                        <p class="mt-3">Diagrama ER será renderizado aqui</p>
                        <small class="text-muted">Implementação simplificada - em produção usaria bibliotecas como D3.js ou vis.js</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5>Lista de Relacionamentos</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tabela Origem</th>
                            <th>Coluna</th>
                            <th>Tabela Destino</th>
                            <th>Coluna Referenciada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($relationships as $table => $fks)
                        @foreach($fks as $fk)
                        <tr>
                            <td>{{ $table }}</td>
                            <td>{{ $fk->COLUMN_NAME }}</td>
                            <td>{{ $fk->REFERENCED_TABLE_NAME }}</td>
                            <td>{{ $fk->REFERENCED_COLUMN_NAME }}</td>
                        </tr>
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>