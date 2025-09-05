<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('QR Codes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
                        <form method="get" class="flex w-full sm:w-auto items-center gap-2">
                            <x-text-input
                                name="search"
                                :value="request('search')"
                                class="w-full sm:w-64"
                                placeholder="Search slug or URL"
                            />
                            <x-primary-button type="submit">Search</x-primary-button>
                            @if(request('search'))
                                <a href="{{ route('qrs.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                                    Clear
                                </a>
                            @endif
                        </form>

                        <a href="{{ route('qrs.create') }}">
                            <x-primary-button>New QR</x-primary-button>
                        </a>
                    </div>

                    @if($qrs->count() === 0)
                        <div class="border border-dashed rounded-lg p-10 text-center text-gray-600">
                            <p class="mb-2 font-semibold">No QR codes yet</p>
                            <p class="mb-4 text-sm">Create your first trackable QR to start counting scans.</p>
                            <a href="{{ route('qrs.create') }}"><x-primary-button>Create QR</x-primary-button></a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Link</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Scans</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last scan</th>
                                        <th class="px-4 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($qrs as $qr)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 font-mono text-sm text-gray-900">
                                                {{ $qr->slug }}
                                            </td>
                                            <td class="px-4 py-3 text-sm max-w-xl">
                                                <a class="text-blue-600 hover:underline line-clamp-1"
                                                   href="{{ $qr->target_url }}" target="_blank" title="{{ $qr->target_url }}">
                                                    {{ $qr->target_url }}
                                                </a>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-900">
                                                {{ $qr->total_scans }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-500">
                                                {{ optional($qr->last_scanned_at)->diffForHumans() ?? '—' }}
                                            </td>
                                            <td class="px-4 py-3 text-right text-sm">
                                                <div class="flex justify-end gap-2">
                                                    <a href="{{ route('qrs.show', $qr) }}"
                                                    class="inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                                        View
                                                    </a>
                                                    <form method="post" action="{{ route('qrs.destroy', $qr) }}"
                                                        onsubmit="return confirm('Delete this QR?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $qrs->onEachSide(1)->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
