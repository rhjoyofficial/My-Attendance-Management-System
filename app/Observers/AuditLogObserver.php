<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLogObserver
{
    public function created($model)
    {
        $this->log('created', $model);
    }

    public function updated($model)
    {
        $this->log('updated', $model);
    }

    public function deleted($model)
    {
        $this->log('deleted', $model);
    }

    protected function log(string $action, $model)
    {
        AuditLog::create([
            'user_id'   => Auth::id(),
            'action'    => class_basename($model) . " {$action}",
            'details'   => json_encode($model->getAttributes()),
            'ip_address' => Request::ip(),
        ]);
    }
}
