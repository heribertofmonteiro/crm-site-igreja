<?php

namespace App\Console\Commands;

use App\Models\FinancialAudit;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CreateQuarterlyAudit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audit:create-quarterly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria uma auditoria financeira trimestral automaticamente';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        // Determine the previous quarter
        $quarter = ceil($now->month / 3);
        $year = $now->year;

        if ($quarter == 1) {
            $periodStart = Carbon::create($year - 1, 10, 1);
            $periodEnd = Carbon::create($year - 1, 12, 31);
        } else {
            $monthStart = (($quarter - 1) * 3) - 2;
            $periodStart = Carbon::create($year, $monthStart, 1);
            $periodEnd = Carbon::create($year, $monthStart + 2, 1)->endOfMonth();
        }

        // Check if audit already exists for this period
        $existingAudit = FinancialAudit::where('period_start', $periodStart->toDateString())
            ->where('period_end', $periodEnd->toDateString())
            ->first();

        if ($existingAudit) {
            $this->info('Auditoria para o trimestre já existe.');
            return;
        }

        FinancialAudit::create([
            'audit_date' => $now->toDateString(),
            'period_start' => $periodStart->toDateString(),
            'period_end' => $periodEnd->toDateString(),
            'status' => 'pending',
        ]);

        $this->info('Auditoria trimestral criada com sucesso para o período: ' . $periodStart->format('d/m/Y') . ' - ' . $periodEnd->format('d/m/Y'));
    }
}
