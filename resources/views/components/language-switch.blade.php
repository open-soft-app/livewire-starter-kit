@php
    $currentLocale = auth()->user()->locale ?? config('app.locale');
    $supportedLocales = ['it' => 'Italiano', 'en' => 'English'];
@endphp

<form method="POST" action="{{ route('language.switch', $currentLocale) }}">
    @csrf
    <div class="flex items-center justify-center gap-x-4">
        @foreach ($supportedLocales as $locale => $label)
            <x-radio :label="$label"
                     name="locale"
                     :value="$locale"
                     :checked="$currentLocale === $locale"
                     x-on:change="$el.form.action = '{{ route('language.switch', $locale) }}'; $el.form.submit()" />
        @endforeach
    </div>
</form>
