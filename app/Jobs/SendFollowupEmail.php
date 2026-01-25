<?php

namespace App\Jobs;

use App\Mail\VisitorFollowup;
use App\Models\Member;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendFollowupEmail implements ShouldQueue
{
    use Queueable;

    public Member $member;

    /**
     * Create a new job instance.
     */
    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->member->email)->send(new VisitorFollowup($this->member));

        $this->member->update([
            'last_followup_email_sent' => Carbon::today(),
        ]);
    }
}
