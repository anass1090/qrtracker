<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New QR') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 max-w-2xl">

                    <form method="POST" action="{{ route('qrs.store') }}" class="space-y-6">
                        @csrf

                        {{-- Slug --}}
                        <div>
                            <x-input-label for="slug" :value="__('Slug')" />
                            <x-text-input id="slug" name="slug" type="text"
                                class="mt-1 block w-full"
                                value="{{ old('slug') }}"
                                placeholder="promo1"
                                required />
                            <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                        </div>

                        {{-- Target URL --}}
                        <div>
                            <x-input-label for="target_url" :value="__('Target URL')" />
                            <x-text-input id="target_url" name="target_url" type="url"
                                class="mt-1 block w-full"
                                value="{{ old('target_url') }}"
                                placeholder="https://example.com/landing"
                                required />
                            <x-input-error :messages="$errors->get('target_url')" class="mt-2" />
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-4">
                            <x-primary-button>
                                {{ __('Create') }}
                            </x-primary-button>
                            <a href="{{ route('qrs.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                                Cancel
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
