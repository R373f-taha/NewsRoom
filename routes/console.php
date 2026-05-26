<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');



Schedule::command('articles:report')
->fridays()->at('8:00')->withoutOverlapping(30)
 ->onFailure(function () {

                Log::warn('Weekly Articles Reports about number of  published articles per writer during current month failed');
            })
->description('Weekly Articles Reports about number of  published articles per writer during current month');


Schedule::command('report:weekly')
->saturdays()->at('8:00')->withoutOverlapping(30)
 ->onFailure(function () {

                Log::warn('Weekly Articles Reports about all published articles during the recent week');
            })
->description('Weekly Articles Reports about all published articles during the recent week');


Schedule::command('articles:archive --days=30')->monthly()
->at('2:00')->withoutOverlapping(60)
 ->onFailure(function () {
                Log::warn('Failed to archive old articles (older than 30 days)');
            })
->description('archive old articles (older than 30 days)');

Schedule::command('articles:archive --days=30')->monthly()
->at('5:00')->withoutOverlapping(60)
 ->onFailure(function () {
                Log::warn('Failed to clean api logs (older than 30 days)');
            })
->description('clean api logs (older than 30 days)');
