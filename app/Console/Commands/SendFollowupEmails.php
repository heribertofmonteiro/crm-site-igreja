<?php

namespace App\Console\Commands;

use App\Jobs\SendFollowupEmail;
use App\Models\Member;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SendFollowupEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-followup-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar emails de acompanhamento para visitantes recentes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Enviar followup para membros criados há 3 dias e que não receberam followup ainda
        $threeDaysAgo = Carbon::now()->subDays(3);

        $members = Member::where('created_at', '>=', $threeDaysAgo)
            ->whereNull('last_followup_email_sent')
            ->get();

        $this->info("Encontrados {$members->count()} membros para enviar email de acompanhamento.");

        foreach ($members as $member) {
            SendFollowupEmail::dispatch($member);
            $this->line("Enviando email para {$member->name}");
        }

        $this->info('Emails de acompanhamento enfileirados com sucesso.');
    }
}
