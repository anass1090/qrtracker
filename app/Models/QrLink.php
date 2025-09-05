<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrLink extends Model
{
    protected $fillable = ['slug', 'target_url', 'total_scans', 'last_scanned_at'];

    protected $casts = [
        'last_scanned_at' => 'datetime',
    ];

    public function scans() {
        return $this->hasMany(QrScanEvent::class);
    }
}

