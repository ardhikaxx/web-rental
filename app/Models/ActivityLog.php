<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'user_name', 'role_name', 'action', 'module',
        'description', 'ip_address', 'user_agent', 'loggable_type',
        'loggable_id', 'data',
    ];

    protected $casts = ['data' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function loggable()
    {
        return $this->morphTo();
    }

    public static function record(string $action, ?string $module, ?string $description = null, $model = null, ?array $data = null): self
    {
        return static::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()?->name,
            'role_name' => auth()->user()?->getRoleNameAttribute(),
            'action' => $action,
            'module' => $module,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => substr((string) request()->userAgent(), 0, 250),
            'loggable_type' => $model ? get_class($model) : null,
            'loggable_id' => $model?->getKey(),
            'data' => $data,
        ]);
    }
}