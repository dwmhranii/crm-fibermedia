@php
    $logoPath = \App\Models\SiteSetting::where('key', 'logo')->value('value');
    if ($logoPath) {
        $logoUrl = str_starts_with($logoPath, 'http') ? $logoPath : asset('storage/' . ltrim($logoPath, '/'));
    } else {
        $logoUrl = asset('storage/settings/S23vZEfu6xyfma6fMkYpjTN0W2ss4hOx6GBcdaom.png');
    }
    $siteName = \App\Models\SiteSetting::where('key', 'site_name')->value('value') ?: 'FibermediaPlay';
@endphp

<img
    src="{{ $logoUrl }}"
    alt="{{ $siteName }}"
    {{ $attributes->merge(['class' => 'h-10 w-auto object-contain']) }}
    onerror="this.onerror=null; this.src='https://fibermediaplay.net/storage/settings/S23vZEfu6xyfma6fMkYpjTN0W2ss4hOx6GBcdaom.png';"
>
