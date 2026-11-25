<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use OpenAI\Laravel\Facades\OpenAI;
use Throwable;

class AiAssistantService
{
    /** @var array<int, array{q: string, a: string}> */
    protected array $faq = [
        [
            'q' => 'how long does basement finishing take',
            'a' => 'Most CedarVault full basement finishes run 6–12 weeks depending on square footage, bathroom count, egress work, and permit timelines in the Twin Cities metro.',
        ],
        [
            'q' => 'cost price estimate budget',
            'a' => 'Typical Twin Cities basement finishing ranges from about $45–$120 per finished sq ft. Waterproofing, bathrooms, and egress windows push costs higher. We provide a free on-site estimate.',
        ],
        [
            'q' => 'waterproof moisture mold',
            'a' => 'We diagnose moisture first: exterior grading, sump systems, interior drain tile, vapor barriers, and closed-cell foam where needed. Finishing over an unresolved wet basement is never recommended.',
        ],
        [
            'q' => 'egress window code',
            'a' => 'Minnesota code requires egress windows in basement bedrooms. We handle opening cuts, well installation, and inspection coordination so sleeping spaces are legal and safe.',
        ],
        [
            'q' => 'permit inspection',
            'a' => 'CedarVault pulls building, electrical, plumbing, and mechanical permits as needed and schedules rough-in and final inspections with your city or township.',
        ],
        [
            'q' => 'bathroom plumbing',
            'a' => 'Basement baths often need an up-flush or ejector system if the sewer line sits above the fixture elevation. We design the wet wall, waterproof floor, and ventilation for code compliance.',
        ],
        [
            'q' => 'insulation soundproof',
            'a' => 'We use rigid foam against foundation walls, mineral wool or fiberglass in stud cavities, and resilient channel or double drywall where you want theater-level sound control.',
        ],
        [
            'q' => 'schedule appointment consult',
            'a' => 'Book a free design consult via our contact form or WhatsApp. A project manager will measure, discuss layout options, and send a scoped proposal within a few business days.',
        ],
        [
            'q' => 'adu in-law suite rental',
            'a' => 'Many homeowners finish basements as ADU-style suites with kitchenette, bath, and separate entrance. Local zoning and egress rules apply—we guide that early in design.',
        ],
        [
            'q' => 'warranty guarantee',
            'a' => 'Craftsmanship on CedarVault finishes is warrantied for 2 years. Manufacturer warranties on waterproofing systems, flooring, and fixtures are passed through to you.',
        ],
    ];

    public function chat(string $message, string $context = 'public'): string
    {
        $message = trim($message);
        if ($message === '') {
            return 'Ask anything about basement finishing, waterproofing, egress, timelines, or CedarVault project workflow.';
        }

        if ($this->hasOpenAiKey()) {
            try {
                $system = $this->systemPrompt($context);
                $result = OpenAI::chat()->create([
                    'model' => config('services.ai.openai_model', 'gpt-4o-mini'),
                    'messages' => [
                        ['role' => 'system', 'content' => $system],
                        ['role' => 'user', 'content' => $message],
                    ],
                    'temperature' => 0.4,
                ]);

                return trim($result->choices[0]->message->content ?? '') ?: $this->faqReply($message);
            } catch (Throwable) {
                // Fall through to Gemini, then FAQ.
            }
        }

        if ($this->hasGeminiKey()) {
            try {
                $reply = $this->geminiReply($message, $context);
                if ($reply !== null) {
                    return $reply;
                }
            } catch (Throwable) {
                // Fall through to FAQ demo mode.
            }
        }

        return $this->faqReply($message);
    }

    public function generateContent(string $type, string $topic): string
    {
        $prompt = match ($type) {
            'blog' => "Write a practical 400-word blog post outline and intro for CedarVault Basement Studio about: {$topic}",
            'service' => "Write a persuasive service description for a basement finishing offering: {$topic}",
            'email' => "Write a short homeowner follow-up email about: {$topic}",
            default => "Write helpful basement finishing copy about: {$topic}",
        };

        return $this->chat($prompt, 'generator');
    }

    public function automationSuggestions(): string
    {
        return $this->chat(
            'Suggest 5 practical ERP automations for a US basement finishing contractor using jobs, inventory, invoices, and appointments.',
            'automation'
        );
    }

    public function troubleshoot(string $issue): string
    {
        return $this->chat(
            "Troubleshoot this basement finishing / admin workflow issue and give step-by-step checks: {$issue}",
            'troubleshoot'
        );
    }

    protected function faqReply(string $message): string
    {
        $hay = Str::lower($message);
        $best = null;
        $bestScore = 0;

        foreach ($this->faq as $item) {
            $score = 0;
            foreach (explode(' ', $item['q']) as $token) {
                if ($token !== '' && Str::contains($hay, $token)) {
                    $score++;
                }
            }
            if ($score > $bestScore) {
                $bestScore = $score;
                $best = $item['a'];
            }
        }

        if ($best && $bestScore > 0) {
            return $best.' (Demo AI mode — add OPENAI_API_KEY or GEMINI_API_KEY for live model replies.)';
        }

        return 'Thanks for asking CedarVault. We finish basements across the Twin Cities with waterproofing-first design, code-compliant egress, and turnkey carpentry/MEP coordination. Share square footage, whether you need a bathroom, and your city for a tighter estimate—or book a free consult. (Demo AI mode.)';
    }

    protected function systemPrompt(string $context): string
    {
        $base = 'You are the AI assistant for CedarVault Basement Studio, a US basement finishing contractor in the Twin Cities, Minnesota. Be concise, practical, and safety/code-aware. Never invent legal advice; recommend local permits and inspections.';

        return match ($context) {
            'generator' => $base.' Generate clear marketing or operational copy for basement remodeling.',
            'automation' => $base.' Focus on Filament ERP workflows: leads, projects, inventory, invoices, scheduling.',
            'troubleshoot' => $base.' Help staff diagnose moisture, framing, scheduling, invoice, or CRM issues step by step.',
            default => $base.' Answer homeowner FAQs about finishing, waterproofing, cost ranges, and next steps.',
        };
    }

    protected function hasOpenAiKey(): bool
    {
        return filled(config('openai.api_key')) || filled(env('OPENAI_API_KEY'));
    }

    protected function hasGeminiKey(): bool
    {
        return filled(config('services.ai.gemini_key'));
    }

    protected function geminiReply(string $message, string $context): ?string
    {
        $key = config('services.ai.gemini_key');
        $model = config('services.ai.gemini_model', 'gemini-1.5-flash');
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$key}";

        $response = Http::timeout(20)->post($url, [
            'contents' => [[
                'parts' => [[
                    'text' => $this->systemPrompt($context)."\n\nUser: {$message}",
                ]],
            ]],
        ]);

        if (! $response->successful()) {
            return null;
        }

        return data_get($response->json(), 'candidates.0.content.parts.0.text');
    }
}
