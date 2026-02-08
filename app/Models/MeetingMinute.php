<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeetingMinute extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'department_id',
        'meeting_date',
        'meeting_location',
        'participants',
        'is_active',
        'content',
        'decisions',
        'action_items',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'meeting_date' => 'datetime',
        'participants' => 'array',
        'is_active' => 'boolean',
        'approved_at' => 'datetime',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeApproved($query)
    {
        return $query->whereNotNull('approved_at');
    }

    public function scopePendingApproval($query)
    {
        return $query->whereNull('approved_at');
    }

    public function scopeByDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('meeting_date', [$startDate, $endDate]);
    }

    public function getFormattedMeetingDateAttribute(): string
    {
        return $this->meeting_date->format('d/m/Y H:i');
    }

    public function getFormattedMeetingDateOnlyAttribute(): string
    {
        return $this->meeting_date->format('d/m/Y');
    }

    public function getFormattedMeetingTimeAttribute(): string
    {
        return $this->meeting_date->format('H:i');
    }

    public function getParticipantsListAttribute(): string
    {
        if (empty($this->participants)) {
            return '--';
        }

        $participantNames = [];
        foreach ($this->participants as $participantId) {
            $user = User::find($participantId);
            if ($user) {
                $participantNames[] = $user->name;
            }
        }

        return implode(', ', $participantNames);
    }

    public function getParticipantsCountAttribute(): int
    {
        return count($this->participants ?? []);
    }

    public function getStatusBadgeAttribute(): string
    {
        if ($this->approved_at) {
            return '<span class="badge badge-success">Aprovado</span>';
        }
        
        return '<span class="badge badge-warning">Pendente Aprovação</span>';
    }

    public function isApproved(): bool
    {
        return !is_null($this->approved_at);
    }

    public function canBeApproved(): bool
    {
        return !$this->isApproved();
    }

    public function canBeEditedByUser(User $user): bool
    {
        return $user->hasRole('admin') || 
               $this->created_by === $user->id || 
               ($this->department_id && $user->department_id === $this->department_id);
    }

    public function canBeApprovedByUser(User $user): bool
    {
        return $user->hasRole('admin') || 
               ($this->department_id && $user->department_id === $this->department_id);
    }

    public function hasContent(): bool
    {
        return !empty($this->content);
    }

    public function hasDecisions(): bool
    {
        return !empty($this->decisions);
    }

    public function hasActionItems(): bool
    {
        return !empty($this->action_items);
    }

    public function getSummaryAttribute(): string
    {
        $summary = [];
        
        if ($this->hasContent()) {
            $summary[] = 'Conteúdo disponível';
        }
        
        if ($this->hasDecisions()) {
            $summary[] = 'Decisões registradas';
        }
        
        if ($this->hasActionItems()) {
            $summary[] = 'Itens de ação definidos';
        }
        
        return empty($summary) ? 'Sem detalhes' : implode(' | ', $summary);
    }
}
