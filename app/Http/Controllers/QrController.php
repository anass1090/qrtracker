<?php

namespace App\Http\Controllers;

use App\Models\QrLink;
use App\Models\QrScanEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class QrController extends Controller
{
    public function scan(Request $request, string $slug)
    {
        $link = QrLink::where('slug', $slug)->firstOrFail();

        // (Optional) dedupe quick re-scans for a few minutes (IP+UA+slug)
        $fingerprint = sha1($slug.'|'.$request->ip().'|'.$request->userAgent());
        $shouldCount = Cache::add("qr:hit:$fingerprint", 1, now()->addMinutes(5));

        // Log event (can be queued later for performance)
        QrScanEvent::create([
            'qr_link_id' => $link->id,
            'ip'         => $request->ip(),
            'user_agent' => substr($request->userAgent() ?? '', 0, 1024),
            'referer'    => substr($request->headers->get('referer') ?? '', 0, 1024),
            'device_hint'=> $this->deviceHint($request->userAgent() ?? ''),
        ]);

        if ($shouldCount) {
            QrLink::where('id', $link->id)->update([
                'total_scans'    => $link->total_scans + 1,
                'last_scanned_at'=> now(),
            ]);
        }

        return redirect()->away($link->target_url, 302);
    }

    public function stats(\Illuminate\Http\Request $request, string $slug)
    {
        $link = \App\Models\QrLink::where('slug', $slug)->firstOrFail();

        // last 30 days
        $start = now()->subDays(29)->startOfDay();
        $rows = $link->scans()
            ->where('created_at', '>=', $start)
            ->orderBy('created_at')
            ->get(['created_at']);

        // bucket by Y-m-d
        $buckets = collect();
        for ($d = 0; $d < 30; $d++) {
            $day = $start->copy()->addDays($d)->format('Y-m-d');
            $buckets[$day] = 0;
        }
        foreach ($rows as $r) {
            $day = $r->created_at->format('Y-m-d');
            if (isset($buckets[$day])) $buckets[$day]++;
        }

        return response()->json([
            'slug'   => $link->slug,
            'total'  => $link->total_scans,
            'daily'  => [
                'labels' => $buckets->keys()->values(),
                'counts' => $buckets->values()->values(),
            ],
        ]);
    }


    private function deviceHint(string $ua): string
    {
        $ua = strtolower($ua);
        return str_contains($ua,'android') ? 'android'
            : (str_contains($ua,'iphone') || str_contains($ua,'ios') ? 'ios'
            : (str_contains($ua,'ipad') ? 'ipad'
            : (str_contains($ua,'windows') ? 'windows'
            : (str_contains($ua,'mac os') ? 'mac'
            : 'other'))));
    }
}

