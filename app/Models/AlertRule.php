<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlertRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'trigger_type',
        'is_active',
        'conditions',
        'actions',
        'notification_channel',
        'notification_config',
        'cooldown_minutes',
        'last_triggered',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'conditions' => 'array',
        'actions' => 'array',
        'notification_config' => 'array',
        'cooldown_minutes' => 'integer',
        'last_triggered' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByTriggerType($query, string $triggerType)
    {
        return $query->where('trigger_type', $triggerType);
    }

    public function scopeNotOnCooldown($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('last_triggered')
              ->orWhere('last_triggered', '<', now()->subMinutes($this->cooldown_minutes));
        });
    }

    public function getTriggerTypeLabelAttribute(): string
    {
        return match($this->trigger_type) {
            'threshold' => 'Limite',
            'deadline' => 'Prazo',
            'event' => 'Evento',
            'custom' => 'Personalizado',
            default => ucfirst($this->trigger_type)
        };
    }

    public function getNotificationChannelLabelAttribute(): string
    {
        return match($this->notification_channel) {
            'system' => 'Sistema',
            'email' => 'E-mail',
            'sms' => 'SMS',
            'webhook' => 'Webhook',
            default => 'Sistema'
        };
    }

    public function getFormattedLastTriggeredAttribute(): ?string
    {
        return $this->last_triggered ? $this->last_triggered->format('d/m/Y H:i') : null;
    }

    public function getFormattedCooldownAttribute(): string
    {
        return $this->cooldown_minutes . ' minutos';
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function isOnCooldown(): bool
    {
        if (!$this->last_triggered) {
            return false;
        }
        
        return $this->last_triggered->diffInMinutes(now()) < $this->cooldown_minutes;
    }

    public function canBeTriggered(): bool
    {
        return $this->isActive() && !$this->isOnCooldown();
    }

    public function getConditionValue(string $key): mixed
    {
        return data_get($this->conditions, $key);
    }

    public function getActionValue(string $key): mixed
    {
        return data_get($this->actions, $key);
    }

    public function getNotificationConfigValue(string $key): mixed
    {
        return data_get($this->notification_config, $key);
    }

    public function evaluateConditions(array $data): bool
    {
        if (empty($this->conditions)) {
            return false;
        }

        foreach ($this->conditions as $condition) {
            $field = $condition['field'];
            $operator = $condition['operator'];
            $value = $condition['value'];
            $dataValue = data_get($data, $field);

            if (!$this->evaluateCondition($dataValue, $operator, $value)) {
                return false;
            }
        }

        return true;
    }

    private function evaluateCondition($dataValue, string $operator, $value): bool
    {
        return match($operator) {
            '==' => $dataValue == $value,
            '!=' => $dataValue != $value,
            '>' => $dataValue > $value,
            '<' => $dataValue < $value,
            '>=' => $dataValue >= $value,
            '<=' => $dataValue <= $value,
            'contains' => str_contains($dataValue, $value),
            'not_contains' => !str_contains($dataValue, $value),
            'in' => in_array($dataValue, $value),
            'not_in' => !in_array($dataValue, $value),
            'is_null' => is_null($dataValue),
            'is_not_null' => !is_null($dataValue),
            default => false
        };
    }

    public function executeActions(array $data): bool
    {
        if (empty($this->actions)) {
            return false;
        }

        $success = true;

        foreach ($this->actions as $action) {
            $type = $action['type'];
            $config = $action['config'] ?? [];

            switch ($type) {
                case 'notification':
                    $success = $this->sendNotification($data, $config);
                    break;
                case 'webhook':
                    $success = $this->callWebhook($data, $config);
                    break;
                case 'email':
                    $success = $this->sendEmail($data, $config);
                    break;
                case 'sms':
                    $success = $this->sendSMS($data, $config);
                    break;
            }

            if (!$success) {
                break;
            }
        }

        return $success;
    }

    private function sendNotification(array $data, array $config): bool
    {
        $title = $config['title'] ?? 'Alerta: ' . $this->name;
        $message = $config['message'] ?? 'Uma regra de alerta foi acionada.';
        $type = $config['type'] ?? 'warning';

        // Create system notification
        Notification::createSystem($title, $message, [
            'alert_rule_id' => $this->id,
            'trigger_data' => $data,
            'type' => $type,
        ]);

        return true;
    }

    private function callWebhook(array $data, array $config): bool
    {
        $url = $config['url'] ?? null;
        $method = $config['method'] ?? 'POST';
        $headers = $config['headers'] ?? [];
        $payload = array_merge($data, [
            'alert_rule' => [
                'id' => $this->id,
                'name' => $this->name,
                'triggered_at' => now()->toISOString(),
            ]
        ]);

        if (!$url) {
            return false;
        }

        try {
            $response = \Http::withHeaders($headers)
                ->{$method}($url, $payload);

            return $response->successful();
        } catch (\Exception $e) {
            \Log::error('Webhook call failed', [
                'alert_rule_id' => $this->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    private function sendEmail(array $data, array $config): bool
    {
        $recipients = $config['recipients'] ?? [];
        $subject = $config['subject'] ?? 'Alerta: ' . $this->name;
        $body = $config['body'] ?? 'Uma regra de alerta foi acionada.';

        if (empty($recipients)) {
            return false;
        }

        // This would integrate with your email system
        // For now, just log the email
        \Log::info('Alert email would be sent', [
            'alert_rule_id' => $this->id,
            'recipients' => $recipients,
            'subject' => $subject,
        ]);

        return true;
    }

    private function sendSMS(array $data, array $config): bool
    {
        $phone = $config['phone'] ?? null;
        $message = $config['message'] ?? 'Alerta: ' . $this->name;

        if (!$phone) {
            return false;
        }

        // This would integrate with your SMS system
        // For now, just log the SMS
        \Log::info('Alert SMS would be sent', [
            'alert_rule_id' => $this->id,
            'phone' => $phone,
            'message' => $message,
        ]);

        return true;
    }

    public function trigger(array $data): bool
    {
        if (!$this->canBeTriggered()) {
            return false;
        }

        if (!$this->evaluateConditions($data)) {
            return false;
        }

        $success = $this->executeActions($data);

        if ($success) {
            $this->last_triggered = now();
            $this->save();
        }

        return $success;
    }

    public function markAsTriggered(): void
    {
        $this->last_triggered = now();
        $this->save();
    }

    public function resetCooldown(): void
    {
        $this->last_triggered = null;
        $this->save();
    }

    public function canBeEditedByUser(User $user): bool
    {
        return $user->hasRole('admin') || $this->created_by === $user->id;
    }

    public function canBeDeletedByUser(User $user): bool
    {
        return $user->hasRole('admin') || $this->created_by === $user->id;
    }

    public function toggleStatus(): void
    {
        $this->is_active = !$this->is_active;
        $this->save();
    }

    public function getTestResults(array $data): array
    {
        $results = [
            'can_be_triggered' => $this->canBeTriggered(),
            'conditions_met' => $this->evaluateConditions($data),
            'conditions' => [],
        ];

        foreach ($this->conditions as $index => $condition) {
            $field = $condition['field'];
            $operator = $condition['operator'];
            $value = $condition['value'];
            $dataValue = data_get($data, $field);

            $results['conditions'][] = [
                'field' => $field,
                'operator' => $operator,
                'value' => $value,
                'data_value' => $dataValue,
                'result' => $this->evaluateCondition($dataValue, $operator, $value),
            ];
        }

        return $results;
    }

    public static function checkAllRules(array $data): array
    {
        $results = [];
        
        self::active()
            ->notOnCooldown()
            ->get()
            ->each(function ($rule) use ($data, &$results) {
                $results[] = [
                    'rule_id' => $rule->id,
                    'rule_name' => $rule->name,
                    'triggered' => $rule->trigger($data),
                ];
            });

        return $results;
    }
}
