<?php

namespace App\Console\Commands;

use App\Models\Notification;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CleanupOldNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:cleanup {--days=7 : Number of days to keep notifications}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete notifications older than specified days (default: 7 days)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');

        // To this (just for testing):
        //$cutoffDate = Carbon::now()->subMinutes($days);
        $cutoffDate = Carbon::now()->subDays($days);

        $deletedCount = Notification::where('created_at', '<', $cutoffDate)->delete();

        $this->info("Successfully deleted {$deletedCount} notification(s) older than {$days} days.");

        return Command::SUCCESS;
    }
}
