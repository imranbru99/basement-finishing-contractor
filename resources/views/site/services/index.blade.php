@extends('layouts.site')
@section('title', 'Basement Finishing Services')
@section('content')
<div class="page-hero"><div class="wrap"><h1>Services</h1><p>End-to-end basement finishing for Twin Cities homes.</p></div></div>
<section><div class="wrap">
    @foreach ($services as $service)
        <a class="service-link" href="{{ route('services.show', $service) }}">
            <strong>{{ $service->title }}</strong>
            <span>{{ $service->summary }}</span>
            @if($service->starting_price)
                <div style="margin-top:.4rem;color:var(--cv-cedar);font-weight:700;">From ${{ number_format($service->starting_price, 0) }}</div>
            @endif
        </a>
    @endforeach
</div></section>
@endsection
