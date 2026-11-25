@extends('layouts.site')
@section('title', 'Contact')
@section('content')
<div class="page-hero"><div class="wrap"><h1>Contact CedarVault</h1><p>Free consults across the Twin Cities metro.</p></div></div>
<section><div class="wrap grid-2">
    <div class="form-card">
        <form method="post" action="{{ route('contact.store') }}">
            @csrf
            <label for="name">Name</label>
            <input id="name" name="name" value="{{ old('name') }}" required>
            @error('name')<div style="color:#b91c1c;margin-top:-.6rem;margin-bottom:.8rem;">{{ $message }}</div>@enderror

            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            @error('email')<div style="color:#b91c1c;margin-top:-.6rem;margin-bottom:.8rem;">{{ $message }}</div>@enderror

            <label for="phone">Phone</label>
            <input id="phone" name="phone" value="{{ old('phone') }}">

            <label for="subject">Subject</label>
            <input id="subject" name="subject" value="{{ old('subject') }}" placeholder="e.g. 900 sq ft finish + bath">

            <label for="message">Project details</label>
            <textarea id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
            @error('message')<div style="color:#b91c1c;margin-top:-.6rem;margin-bottom:.8rem;">{{ $message }}</div>@enderror

            <button class="btn btn-primary" type="submit">Send message</button>
        </form>
    </div>
    <div>
        <h2 style="color:var(--cv-spruce);">Studio</h2>
        <p>1840 Marshall St NE<br>Minneapolis, MN 55413</p>
        <p><a href="tel:+16125550148">(612) 555-0148</a><br>
        <a href="mailto:hello@cedarvault.example">hello@cedarvault.example</a></p>
        <p>Prefer chat? <a href="https://wa.me/{{ config('services.whatsapp.number') }}" target="_blank" rel="noopener"><strong>WhatsApp CedarVault</strong></a></p>
        <img src="https://images.unsplash.com/photo-1581858726788-75bc0f6a952d?auto=format&fit=crop&w=1200&q=80" alt="Basement flooring and framing materials" style="border-radius:20px;margin-top:1rem;width:100%;min-height:240px;object-fit:cover;">
    </div>
</div></section>
@endsection
