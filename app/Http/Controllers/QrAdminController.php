<?php

namespace App\Http\Controllers;

use App\Models\QrLink;
use App\Http\Requests\StoreQrLinkRequest;
use App\Http\Requests\UpdateQrLinkRequest;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpFoundation\StreamedResponse;

class QrAdminController extends Controller
{
    public function index(Request $request) {
        $q = QrLink::query()
            ->when($request->get('search'), fn($qb,$s)=>$qb->where('slug','like',"%$s%")->orWhere('target_url','like',"%$s%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('qrs.index', ['qrs' => $q]);
    }

    public function create() {
        return view('qrs.create');
    }

    public function store(StoreQrLinkRequest $request) {
        $qr = QrLink::create($request->validated());
        return redirect()->route('qrs.show', $qr)->with('status', 'QR created');
    }

    public function show(QrLink $qr) {
        $scanUrl = route('qr.scan', ['slug' => $qr->slug]);
        return view('qrs.show', compact('qr','scanUrl'));
    }

    public function edit(QrLink $qr) {
        return view('qrs.edit', compact('qr'));
    }

    public function update(UpdateQrLinkRequest $request, QrLink $qr) {
        $qr->update($request->validated());
        return redirect()->route('qrs.show', $qr)->with('status', 'QR updated');
    }

    public function destroy(QrLink $qr) {
        $qr->delete();
        return redirect()->route('qrs.index')->with('status', 'QR deleted');
    }

    public function download(QrLink $qr): StreamedResponse {
        $scanUrl = route('qr.scan', ['slug' => $qr->slug]);
        $png = QrCode::format('svg')->size(800)->margin(2)->generate($scanUrl);
        return response()->streamDownload(
            function() use ($png) { echo $png; },
            "qr-{$qr->slug}.svg",
            ['Content-Type' => 'image/svg']
        );
    }
}
