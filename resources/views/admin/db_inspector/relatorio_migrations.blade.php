<div class="row">
    <div class="col-md-12">
        <h4>Relatório de Migrations</h4>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Migration</th>
                            <th>Batch</th>
                            <th>Executado em</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($migrationStatus as $migration)
                        <tr>
                            <td><code>{{ $migration['migration'] }}</code></td>
                            <td>{{ $migration['batch'] }}</td>
                            <td>{{ $migration['executed_at'] }}</td>
                            <td><span class="badge badge-success">Executada</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>