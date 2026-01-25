<?php

namespace App\Console\Commands;

use App\Jobs\SendBirthdayEmail;
use App\Models\Member;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SendBirthdayEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-birthday-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar emails de aniversário para membros que fazem aniversário hoje';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        $currentYear = $today->year;

        $members = Member::whereMonth('birth_date', $today->month)
            ->whereDay('birth_date', $today->day)
            ->where(function ($query) use ($currentYear) {
                $query->whereNull('last_birthday_email_sent')
                      ->orWhereYear('last_birthday_email_sent', '<', $currentYear);
            })
            ->get();

        $this->info("Encontrados {$members->count()} membros para enviar email de aniversário.");

        foreach ($members as $member) {
            SendBirthdayEmail::dispatch($member);
            $this->line("Enviando email para {$member->name}");
        }

        $this->info('Emails de aniversário enfileirados com sucesso.');
    }
}
