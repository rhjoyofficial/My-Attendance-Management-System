<?php

namespace App\Providers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Attendance;
use App\Observers\AuditLogObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Attendance::observe(AuditLogObserver::class);
        Student::observe(AuditLogObserver::class);
        Teacher::observe(AuditLogObserver::class);
    }
}
