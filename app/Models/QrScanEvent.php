<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrScanEvent extends Model
{
    protected $fillable = ['qr_link_id','ip','user_agent','referer','device_hint'];
    protected $casts = [
        'created_at' => 'datetime',
    ];
    public function link() { return $this->belongsTo(QrLink::class, 'qr_link_id'); }
}
