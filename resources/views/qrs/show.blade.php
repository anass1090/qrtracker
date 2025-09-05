<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            QR: {{ $qr->slug }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-8">

                    {{-- Top section: QR image + details --}}
                    <div class="grid md:grid-cols-2 gap-6">
                        {{-- QR Image --}}
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold mb-3">QR Image</h3>
                            <div class="flex items-center justify-center">
                                {!! QrCode::size(240)->margin(1)->generate($scanUrl) !!}
                            </div>
                            <div class="mt-4 flex gap-3">
                                <a class="px-3 py-2 bg-gray-800 text-white rounded hover:bg-gray-900"
                                   href="{{ route('qrs.download',$qr) }}">Download image</a>
                                <a class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                                   target="_blank" href="{{ $scanUrl }}">Open link</a>
                            </div>
                        </div>

                        {{-- Details --}}
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold mb-3">Details</h3>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="font-medium inline">Name:</dt>
                                    <dd class="inline font-mono text-gray-700">{{ $qr->slug }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium inline">Link:</dt>
                                    <dd class="inline">
                                        <a class="text-blue-600 hover:underline" href="{{ $qr->target_url }}" target="_blank">
                                            {{ $qr->target_url }}
                                        </a>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="font-medium inline">Total scans:</dt>
                                    <dd class="inline text-gray-700">{{ $qr->total_scans }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium inline">Last scan:</dt>
                                    <dd class="inline text-gray-500">
                                        {{ $qr->last_scanned_at ? $qr->last_scanned_at->diffForHumans() : '—' }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
