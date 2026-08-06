<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Maintenance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'fleet_id',
        'type',
        'date',
        'cost',
        'description',
        'workshop',
        'mileage',
        'next_maintenance_at',
        'valid_until',
        'status',
        'evidence_image',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'date' => 'date',
        'next_maintenance_at' => 'date',
        'valid_until' => 'date',
        'cost' => 'decimal:2',
    ];

    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    public static function types(): array
    {
        return [
            'servis' => 'Servis Berkala',
            'ganti_oli' => 'Ganti Oli',
            'perbaikan' => 'Perbaikan',
            'pajak' => 'Pajak Kendaraan',
            'asuransi' => 'Asuransi',
            'lainnya' => 'Lainnya',
        ];
    }
}