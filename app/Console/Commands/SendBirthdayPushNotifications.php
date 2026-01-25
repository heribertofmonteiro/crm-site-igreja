<?php

namespace App\Console\Commands;

use App\Models\Member;
use App\Services\FirebaseService;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SendBirthdayPushNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-birthday-push-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar notificações push de aniversário para membros que fazem aniversário hoje';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $firebaseService = app(FirebaseService::class);

        $today = Carbon::today();
        $currentYear = $today->year;

        $members = Member::whereMonth('birth_date', $today->month)
            ->whereDay('birth_date', $today->day)
            ->where(function ($query) use ($currentYear) {
                $query->whereNull('last_birthday_email_sent')
                      ->orWhereYear('last_birthday_email_sent', '<', $currentYear);
            })
            ->with('deviceTokens')
            ->get();

        $this->info("Encontrados {$members->count()} membros para enviar notificação push de aniversário.");

        foreach ($members as $member) {
            $tokens = $member->deviceTokens->pluck('device_token')->toArray();

            if (!empty($tokens)) {
                $title = 'Feliz Aniversário!';
                $body = "Parabéns, {$member->name}! Que Deus te abençoe neste dia especial.";

                try {
                    $firebaseService->sendMulticast($tokens, $title, $body);
                    $this->line("Notificação enviada para {$member->name}");
                } catch (\Exception $e) {
                    $this->error("Erro ao enviar para {$member->name}: " . $e->getMessage());
                }
            }
        }

        $this->info('Notificações push de aniversário enviadas com sucesso.');
    }
}
