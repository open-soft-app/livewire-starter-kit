@php
    $currentLocale = auth()->user()->locale ?? config('app.locale');
    $supportedLocales = ['it' => 'Italiano', 'en' => 'English'];
@endphp

<div class="flex gap-1">
    @foreach ($supportedLocales as $locale => $label)
        @if ($currentLocale === $locale)
            <span class="px-2.5 py-1.5 text-sm font-semibold text-primary-500 rounded">{{ $label }}</span>
        @else
            <form method="POST" action="{{ route('language.switch', $locale) }}" class="inline">
                @csrf
                <button type="submit"
                        class="px-2.5 py-1.5 text-sm font-medium text-gray-600 hover:text-primary-500 dark:text-gray-300 dark:hover:text-primary-400 transition">
                    {{ $label }}
                </button>
            </form>
        @endif
    @endforeach
</div>
