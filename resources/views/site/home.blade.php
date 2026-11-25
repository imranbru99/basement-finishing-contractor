@extends('layouts.site')

@section('title', 'CedarVault Basement Studio')
@section('meta_description', 'Turn unused lower levels into warm, code-ready living space. Waterproofing-first basement finishing across Minneapolis–St. Paul.')

@section('content')
<section class="hero">
    <div class="hero-media" aria-hidden="true"></div>
    <div class="wrap hero-copy">
        <div class="eyebrow">Twin Cities basement finishing</div>
        <h1>CedarVault Basement Studio</h1>
        <p>We transform damp, unfinished lower levels into bright family rooms, suites, and workspaces — moisture-managed, permit-ready, and finished like the rest of your home.</p>
        <div class="cta-row">
            <a class="btn btn-primary" href="{{ route('contact') }}">Book a free consult</a>
            <a class="btn btn-ghost" href="{{ route('services.index') }}" style="color:#fff;border-color:rgba(255,255,255,.4);">Explore services</a>
        </div>
    </div>
</section>

<section>
    <div class="wrap">
        <div class="section-head">
            <h2>Finish what your foundation started</h2>
            <p>From vapor barriers to egress and final trim, CedarVault coordinates every trade so your basement becomes usable square footage — not a storage afterthought.</p>
        </div>
        <div>
            @foreach ($services as $service)
                <a class="service-link" href="{{ route('services.show', $service) }}">
                    <strong>{{ $service->title }}</strong>
                    <span>{{ $service->summary }}</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section style="padding-top:0;">
    <div class="wrap about-split">
        <img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=1400&q=80" alt="Finished lower-level living room with warm lighting">
        <div>
            <div class="eyebrow" style="color:var(--cv-cedar);">About CedarVault</div>
            <h2 style="color:var(--cv-spruce);">Built for Minnesota foundations</h2>
            <p>Our crews specialize in below-grade living: frost-line realities, clay soils, and the moisture that sneaks into Twin Cities basements every spring thaw. Design starts with dry — then layout, light, and craftsmanship.</p>
            <p>Homeowners hire us for full finishes, bathroom adds, theater rooms, and ADU-style suites with separate entries when zoning allows.</p>
            <a class="btn btn-primary" href="{{ route('knowledge.index') }}">Read the knowledge base</a>
        </div>
    </div>
</section>

<section>
    <div class="wrap">
        <div class="section-head">
            <h2>Operations dashboard preview</h2>
            <p>The same ERP your project manager uses — jobs, inventory, invoices, and scheduling in one spruce-green Filament workspace.</p>
        </div>
        <div class="visual-board">
            <div class="dash-preview">
                <img src="https://images.unsplash.com/photo-1556912173-3bb406ef7e77?auto=format&fit=crop&w=1400&q=80" alt="Basement remodel planning materials and finishes">
            </div>
            <div style="display:grid;gap:.8rem;">
                <div class="metric"><b>{{ $stats['jobs'] }}</b> tracked jobs in demo ERP</div>
                <div class="metric"><b>{{ $stats['completed'] }}</b> completed finishes</div>
                <div class="metric"><b>{{ number_format($stats['sqft']) }}</b> sq ft in pipeline data</div>
                <a class="btn btn-ghost" style="color:#fff;border-color:rgba(255,255,255,.35);" href="/admin">Open admin demo</a>
            </div>
        </div>
    </div>
</section>

<section style="padding-top:0;">
    <div class="wrap">
        <div class="section-head">
            <h2>From the field journal</h2>
            <p>Practical notes on egress, waterproofing, and finishing sequences.</p>
        </div>
        <div class="post-list">
            @foreach ($posts as $post)
                <article>
                    <a href="{{ route('blog.show', $post) }}">
                        <strong style="font-size:1.2rem;">{{ $post->title }}</strong>
                        <p style="margin:.35rem 0 0;color:#405248;">{{ $post->excerpt }}</p>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section>
    <div class="wrap grid-2">
        <div>
            <h2 style="color:var(--cv-spruce);">Ready to reclaim your lower level?</h2>
            <p>Tell us your city, unfinished sq ft, and whether you need a bath or bedroom. We’ll schedule a moisture-aware design walkthrough.</p>
        </div>
        <div class="cta-row" style="align-items:center;">
            <a class="btn btn-primary" href="{{ route('contact') }}">Contact CedarVault</a>
            <a class="btn btn-ghost" href="https://wa.me/{{ config('services.whatsapp.number') }}" target="_blank" rel="noopener">WhatsApp</a>
        </div>
    </div>
</section>
@endsection
