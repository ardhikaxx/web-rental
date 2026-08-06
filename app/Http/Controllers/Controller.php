<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

abstract class Controller
{
    protected function log(string $action, string $module, ?string $description = null, $model = null, ?array $data = null): void
    {
        try {
            ActivityLog::record($action, $module, $description, $model, $data);
        } catch (\Throwable $e) {
            // never let auditing break the request
        }
    }

    protected function flashSuccess(string $message): void
    {
        session()->flash('success', $message);
    }

    protected function flashError(string $message): void
    {
        session()->flash('error', $message);
    }
}