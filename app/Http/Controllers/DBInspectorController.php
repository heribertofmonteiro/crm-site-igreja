<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class DBInspectorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:db_inspector.view');
    }

    /**
     * Dashboard principal do DB Inspector
     */
    public function index()
    {
        $stats = [
            'total_tables' => count(DB::select('SHOW TABLES')),
            'total_migrations' => DB::table('migrations')->count(),
            'cache_status' => Cache::store('redis')->getStore() ? 'Connected' : 'Not Connected',
            'db_connection' => DB::connection()->getPdo() ? 'Connected' : 'Disconnected',
        ];

        return view('admin.db_inspector.index', compact('stats'));
    }

    /**
     * Schema Watcher - Monitoramento das tabelas e campos
     */
    public function schemaWatcher()
    {
        $tables = DB::select('SHOW TABLES');
        $tableData = [];

        foreach ($tables as $table) {
            $tableName = $table->{'Tables_in_' . env('DB_DATABASE')};
            $columns = Schema::getColumnListing($tableName);
            $foreignKeys = $this->getForeignKeys($tableName);

            $tableData[$tableName] = [
                'columns' => $columns,
                'foreign_keys' => $foreignKeys,
                'indexes' => $this->getIndexes($tableName),
            ];
        }

        return view('admin.db_inspector.schema_watcher', compact('tableData'));
    }

    /**
     * Query Analyzer - Análise de performance das consultas
     */
    public function queryAnalyzer()
    {
        // Simulação de análise de queries lentas
        $slowQueries = DB::select("
            SELECT sql_text, exec_count, avg_timer_wait/1000000000 as avg_time_sec
            FROM performance_schema.events_statements_summary_by_digest
            WHERE avg_timer_wait > 1000000000
            ORDER BY avg_timer_wait DESC
            LIMIT 10
        ");

        // Detecção de N+1 (simplificada)
        $nPlusOneQueries = $this->detectNPlusOne();

        return view('admin.db_inspector.query_analyzer', compact('slowQueries', 'nPlusOneQueries'));
    }

    /**
     * Integridade - Verificação de erros de relacionamento e dados inconsistentes
     */
    public function integridade()
    {
        $orphanedRecords = $this->checkOrphanedRecords();
        $foreignKeyViolations = $this->checkForeignKeyViolations();

        return view('admin.db_inspector.integridade', compact('orphanedRecords', 'foreignKeyViolations'));
    }

    /**
     * Cache (Redis) - Monitoramento da camada de performance
     */
    public function cache()
    {
        $cacheInfo = [
            'hits' => Cache::store('redis')->getStore()->getHits(),
            'misses' => Cache::store('redis')->getStore()->getMisses(),
            'keys' => Cache::store('redis')->getStore()->getKeys(),
            'memory_usage' => $this->getRedisMemoryUsage(),
        ];

        return view('admin.db_inspector.cache', compact('cacheInfo'));
    }

    /**
     * Mapa de Relacionamentos - Visualização gráfica das tabelas
     */
    public function mapaRelacionamentos()
    {
        $relationships = $this->getTableRelationships();

        return view('admin.db_inspector.mapa_relacionamentos', compact('relationships'));
    }

    /**
     * Relatório de Migrations - Status de cada tabela criada
     */
    public function relatorioMigrations()
    {
        $migrations = DB::table('migrations')->orderBy('batch', 'desc')->get();
        $migrationStatus = [];

        foreach ($migrations as $migration) {
            $migrationStatus[] = [
                'migration' => $migration->migration,
                'batch' => $migration->batch,
                'executed_at' => $migration->created_at,
            ];
        }

        return view('admin.db_inspector.relatorio_migrations', compact('migrationStatus'));
    }

    /**
     * Detector de "N+1" - Página que alerta quando o código está fazendo consultas excessivas
     */
    public function detectorNPlusOne()
    {
        $nPlusOneIssues = $this->detectNPlusOne();

        return view('admin.db_inspector.detector_n_plus_one', compact('nPlusOneIssues'));
    }

    /**
     * Auditoria de Tipagem - Verifica se campos sensíveis estão usando os tipos corretos
     */
    public function auditoriaTipagem()
    {
        $typeIssues = $this->auditDataTypes();

        return view('admin.db_inspector.auditoria_tipagem', compact('typeIssues'));
    }

    /**
     * Validador de AGENTS.md - Ferramenta que cruza as necessidades dos agentes com as tabelas existentes
     */
    public function validadorAgents()
    {
        $agentsRequirements = $this->parseAgentsMd();
        $validationResults = $this->validateAgainstAgents($agentsRequirements);

        return view('admin.db_inspector.validador_agents', compact('validationResults'));
    }

    /**
     * Slow Query Log Visualizer - Interface para ver quais consultas estão demorando mais de 1 segundo
     */
    public function slowQueryLog()
    {
        $slowQueries = DB::select("
            SELECT sql_text, exec_count, avg_timer_wait/1000000000 as avg_time_sec, max_timer_wait/1000000000 as max_time_sec
            FROM performance_schema.events_statements_summary_by_digest
            WHERE avg_timer_wait > 1000000000
            ORDER BY avg_timer_wait DESC
        ");

        return view('admin.db_inspector.slow_query_log', compact('slowQueries'));
    }

    /**
     * Simulador de Carga - Testa como o banco se comporta com 10.000 membros cadastrados simultaneamente
     */
    public function simuladorCarga()
    {
        // Este método seria chamado via AJAX para simular carga
        return view('admin.db_inspector.simulador_carga');
    }

    public function runLoadSimulation(Request $request)
    {
        $numRecords = $request->input('num_records', 1000);

        // Simulação de inserção em lote
        $startTime = microtime(true);

        for ($i = 0; $i < $numRecords; $i++) {
            DB::table('members')->insert([
                'name' => 'Test Member ' . $i,
                'email' => 'test' . $i . '@example.com',
                'phone' => '123456789',
                'birth_date' => '1990-01-01',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        return response()->json([
            'success' => true,
            'execution_time' => $executionTime,
            'records_inserted' => $numRecords,
        ]);
    }

    /**
     * Auto-Fix de Índices - Sugere e aplica índices em colunas que são muito usadas em filtros
     */
    public function autoFixIndices()
    {
        $indexSuggestions = $this->suggestIndexes();

        return view('admin.db_inspector.auto_fix_indices', compact('indexSuggestions'));
    }

    public function applyIndex(Request $request)
    {
        $table = $request->input('table');
        $column = $request->input('column');

        try {
            DB::statement("ALTER TABLE `$table` ADD INDEX idx_{$table}_{$column} (`$column`)");
            return response()->json(['success' => true, 'message' => 'Index applied successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // Helper methods

    private function getForeignKeys($tableName)
    {
        return DB::select("
            SELECT
                COLUMN_NAME,
                REFERENCED_TABLE_NAME,
                REFERENCED_COLUMN_NAME
            FROM
                INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE
                TABLE_NAME = ? AND
                REFERENCED_TABLE_NAME IS NOT NULL
        ", [$tableName]);
    }

    private function getIndexes($tableName)
    {
        return DB::select("SHOW INDEX FROM `$tableName`");
    }

    private function detectNPlusOne()
    {
        $issues = [];
        $queryCount = 0;
        $queries = [];

        // Listen to queries during a test operation
        DB::listen(function ($query) use (&$queryCount, &$queries) {
            $queryCount++;
            $sql = $query->sql;
            $table = $this->extractTableFromQuery($sql);
            if ($table) {
                if (!isset($queries[$table])) {
                    $queries[$table] = 0;
                }
                $queries[$table]++;
            }
        });

        // Simulate loading members with relationships (potential N+1)
        try {
            $members = DB::table('members')->limit(10)->get();
            foreach ($members as $member) {
                // This could trigger N+1 if not eager loaded
                $transactions = DB::table('transactions')->where('member_id', $member->id)->get();
            }
        } catch (\Exception $e) {
            // Ignore errors for detection
        }

        // Analyze query patterns
        foreach ($queries as $table => $count) {
            if ($count > 10) { // Arbitrary threshold
                $issues[] = [
                    'table' => $table,
                    'query_count' => $count,
                    'issue' => 'Potential N+1 query detected - multiple queries for same table',
                    'suggestion' => 'Use eager loading or optimize queries',
                ];
            }
        }

        return $issues;
    }

    private function extractTableFromQuery($sql)
    {
        // Simple extraction - look for FROM table
        if (preg_match('/FROM\s+`?(\w+)`?/i', $sql, $matches)) {
            return $matches[1];
        }
        return null;
    }

    private function checkOrphanedRecords()
    {
        // Verificar registros órfãos (exemplo simplificado)
        $orphaned = [];

        // Exemplo: transações sem membro
        $orphanedTransactions = DB::table('transactions')
            ->leftJoin('members', 'transactions.member_id', '=', 'members.id')
            ->whereNull('members.id')
            ->count();

        if ($orphanedTransactions > 0) {
            $orphaned[] = [
                'table' => 'transactions',
                'issue' => 'Transactions without valid member',
                'count' => $orphanedTransactions,
            ];
        }

        return $orphaned;
    }

    private function checkForeignKeyViolations()
    {
        $violations = [];

        // Check for orphaned records in common relationships
        $checks = [
            [
                'child_table' => 'transactions',
                'child_column' => 'member_id',
                'parent_table' => 'members',
                'parent_column' => 'id',
                'description' => 'Transactions without valid member',
            ],
            [
                'child_table' => 'event_registrations',
                'child_column' => 'member_id',
                'parent_table' => 'members',
                'parent_column' => 'id',
                'description' => 'Event registrations without valid member',
            ],
            [
                'child_table' => 'students',
                'child_column' => 'class_id',
                'parent_table' => 'classes',
                'parent_column' => 'id',
                'description' => 'Students without valid class',
            ],
        ];

        foreach ($checks as $check) {
            if (Schema::hasTable($check['child_table']) && Schema::hasTable($check['parent_table'])) {
                $count = DB::table($check['child_table'])
                    ->leftJoin($check['parent_table'], $check['child_table'] . '.' . $check['child_column'], '=', $check['parent_table'] . '.' . $check['parent_column'])
                    ->whereNull($check['parent_table'] . '.' . $check['parent_column'])
                    ->count();

                if ($count > 0) {
                    $violations[] = [
                        'child_table' => $check['child_table'],
                        'parent_table' => $check['parent_table'],
                        'description' => $check['description'],
                        'count' => $count,
                        'severity' => 'high',
                    ];
                }
            }
        }

        return $violations;
    }

    private function getRedisMemoryUsage()
    {
        try {
            $redis = Cache::store('redis')->getStore()->getRedis();
            $info = $redis->info('memory');
            return $info['used_memory_human'];
        } catch (\Exception $e) {
            return 'N/A';
        }
    }

    private function getTableRelationships()
    {
        $relationships = [];
        $tables = DB::select('SHOW TABLES');

        foreach ($tables as $table) {
            $tableName = $table->{'Tables_in_' . env('DB_DATABASE')};
            $fks = $this->getForeignKeys($tableName);
            $relationships[$tableName] = $fks;
        }

        return $relationships;
    }

    private function auditDataTypes()
    {
        $issues = [];

        // Verificar campos monetários
        $financialTables = ['transactions', 'budgets', 'financial_accounts'];
        foreach ($financialTables as $table) {
            if (Schema::hasTable($table)) {
                $columns = Schema::getColumnListing($table);
                foreach ($columns as $column) {
                    $type = Schema::getColumnType($table, $column);
                    if (str_contains($column, 'amount') || str_contains($column, 'value')) {
                        if ($type !== 'decimal') {
                            $issues[] = [
                                'table' => $table,
                                'column' => $column,
                                'current_type' => $type,
                                'recommended_type' => 'decimal',
                                'issue' => 'Financial fields should use decimal type',
                            ];
                        }
                    }
                }
            }
        }

        return $issues;
    }

    private function parseAgentsMd()
    {
        // Parse AGENTS.md to extract agent requirements
        $agentsMdPath = base_path('AGENTS.md');
        if (!file_exists($agentsMdPath)) {
            return [];
        }

        $content = file_get_contents($agentsMdPath);
        $requirements = [];

        // Map agents to expected tables based on their responsibilities
        $agentMappings = [
            'secretaria_geral' => ['members', 'documents', 'church_events'],
            'tesouraria' => ['transactions', 'budgets', 'financial_accounts', 'financial_audits', 'fiscal_council_meetings'],
            'coordenacao_voluntariado' => ['volunteer_roles', 'volunteer_schedules', 'users'],
            'gestor_integracao_discipulado' => ['members', 'event_registrations'],
            'coordenador_ministerios' => ['classes', 'students', 'educational_materials', 'social_projects', 'social_volunteers'],
            'hub_comunicacao' => ['social_posts', 'worship_schedules'],
            'assistencia_social' => ['social_assistance', 'social_projects'],
            'expansao_plantacao' => ['church_planting_plans', 'leadership_trainings', 'expansion_projects'],
            'missionarios' => ['missionaries', 'mission_projects', 'mission_support'],
            'zeladoria' => ['assets', 'maintenance_orders', 'space_bookings', 'infrastructure_assets'],
            'assessoria_juridica' => ['legal_documents', 'compliance_obligations', 'lgpd_consents'],
            'gestao_eventos' => ['church_events', 'event_registrations'],
            'suporte_ti' => ['system_access_logs', 'security_incidents'],
        ];

        // Check if agents are mentioned in the file
        foreach ($agentMappings as $agent => $tables) {
            if (stripos($content, $agent) !== false || stripos($content, str_replace('_', ' ', $agent)) !== false) {
                $requirements[$agent] = $tables;
            }
        }

        return $requirements;
    }

    private function validateAgainstAgents($requirements)
    {
        $results = [];

        foreach ($requirements as $agent => $tables) {
            foreach ($tables as $table) {
                $exists = Schema::hasTable($table);
                $results[] = [
                    'agent' => $agent,
                    'table' => $table,
                    'exists' => $exists,
                    'status' => $exists ? 'OK' : 'MISSING',
                ];
            }
        }

        return $results;
    }

    private function suggestIndexes()
    {
        // Simplificado - analisaria queries comuns
        $suggestions = [];

        // Exemplo: índice em member_id de transactions
        if (Schema::hasTable('transactions') && Schema::hasColumn('transactions', 'member_id')) {
            $suggestions[] = [
                'table' => 'transactions',
                'column' => 'member_id',
                'reason' => 'Frequently used in WHERE clauses',
            ];
        }

        return $suggestions;
    }
}