<?php

namespace App\Console\Commands;

use App\Models\Webinar;
use App\Mail\WebinarReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendWebinarReminders extends Command
{
    protected $signature = 'webinars:send-reminders';
    protected $description = 'Send reminder emails for upcoming webinars';

    public function handle()
    {
        $this->info('Checking for webinars to send reminders...');

        // Send 1-day reminders (webinars happening in ~24 hours)
        $this->sendReminders('1_day', 23, 25);

        // Send 1-hour reminders (webinars happening in ~1 hour)
        $this->sendReminders('1_hour', 0.9, 1.1);

        $this->info('Reminder check completed.');
        return Command::SUCCESS;
    }

    private function sendReminders(string $type, float $minHours, float $maxHours)
    {
        $now = Carbon::now();
        $minTime = $now->copy()->addHours($minHours);
        $maxTime = $now->copy()->addHours($maxHours);

        $webinars = Webinar::where('status', 'published')
            ->whereBetween('scheduled_at', [$minTime, $maxTime])
            ->with(['registrations' => function ($query) {
                $query->where('status', 'registered');
            }])
            ->get();

        foreach ($webinars as $webinar) {
            $this->info("Sending {$type} reminders for: {$webinar->title}");
            
            foreach ($webinar->registrations as $registration) {
                try {
                    Mail::to($registration->email)->send(
                        new WebinarReminder($webinar, $registration, $type)
                    );
                    $this->line("  - Sent to: {$registration->email}");
                } catch (\Exception $e) {
                    Log::error("Failed to send webinar reminder to {$registration->email}: " . $e->getMessage());
                    $this->error("  - Failed: {$registration->email}");
                }
            }
        }
    }
}

