<div class="row">
    <div class="col-md-12">
        <h4>Monitoramento das Tabelas e Campos</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Tabela</th>
                        <th>Colunas</th>
                        <th>Chaves Estrangeiras</th>
                        <th>Índices</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tableData as $tableName => $data)
                    <tr>
                        <td><strong>{{ $tableName }}</strong></td>
                        <td>
                            <ul class="list-unstyled">
                                @foreach($data['columns'] as $column)
                                <li>{{ $column }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            @if(count($data['foreign_keys']) > 0)
                            <ul class="list-unstyled">
                                @foreach($data['foreign_keys'] as $fk)
                                <li>{{ $fk->COLUMN_NAME }} → {{ $fk->REFERENCED_TABLE_NAME }}.{{ $fk->REFERENCED_COLUMN_NAME }}</li>
                                @endforeach
                            </ul>
                            @else
                            <span class="text-muted">Nenhuma</span>
                            @endif
                        </td>
                        <td>
                            @if(count($data['indexes']) > 0)
                            <ul class="list-unstyled">
                                @foreach($data['indexes'] as $index)
                                <li>{{ $index->Key_name }} ({{ $index->Column_name }})</li>
                                @endforeach
                            </ul>
                            @else
                            <span class="text-muted">Nenhum</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>