@php
    $logoPath = \App\Models\SiteSetting::where('key', 'logo')->value('value');
    $logoUrl = $logoPath && file_exists(public_path('storage/'.$logoPath))
        ? asset('storage/'.$logoPath)
        : (file_exists(public_path('assets/logo.png')) ? asset('assets/logo.png') : null);
    $siteName = \App\Models\SiteSetting::where('key', 'site_name')->value('value') ?: 'FibermediaPlay';
@endphp

@if($logoUrl)
    <img src="{{ $logoUrl }}" alt="{{ $siteName }}" {{ $attributes->merge(['class' => 'h-10 w-auto object-contain']) }}>
@else
    <span {{ $attributes->merge(['class' => 'text-2xl font-black tracking-tight text-[#1E5FA8]']) }}>
        {{ $siteName }}<span class="text-[#38bdf8]">.</span>
    </span>
@endif
