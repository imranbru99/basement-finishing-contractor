<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\BlogPost;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\KnowledgeArticle;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['admin', 'manager', 'staff'] as $role) {
            Role::findOrCreate($role);
        }

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'CedarVault Admin',
                'phone' => '(612) 555-0100',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );
        $admin->syncRoles(['admin']);

        $manager = User::query()->updateOrCreate(
            ['email' => 'manager@cedarvault.example'],
            [
                'name' => 'Maya Ortiz',
                'phone' => '(612) 555-0101',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'is_active' => true,
            ]
        );
        $manager->syncRoles(['manager']);

        $staff = User::query()->updateOrCreate(
            ['email' => 'crew@cedarvault.example'],
            [
                'name' => 'Jonah Blake',
                'phone' => '(612) 555-0102',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'is_active' => true,
            ]
        );
        $staff->syncRoles(['staff']);

        $settings = [
            'company_name' => 'CedarVault Basement Studio',
            'tagline' => 'Finished living spaces below grade',
            'company_phone' => '(612) 555-0148',
            'company_email' => 'hello@cedarvault.example',
            'company_address' => '1840 Marshall St NE, Minneapolis, MN 55413',
            'whatsapp_number' => '16125550148',
            'service_area' => 'Twin Cities metro — Minneapolis, St. Paul, and surrounding suburbs',
        ];
        foreach ($settings as $key => $value) {
            Setting::setValue($key, $value, 'company');
        }

        $services = [
            [
                'title' => 'Full Basement Finishing',
                'slug' => 'full-basement-finishing',
                'icon' => 'home',
                'summary' => 'Turnkey framing, MEP, insulation, drywall, flooring, and trim for unused lower levels.',
                'description' => '<p>CedarVault manages design, permits, waterproofing coordination, framing, electrical, HVAC returns, drywall, paint, and flooring so your basement feels like the rest of the house.</p><p>Typical projects include family rooms, offices, and flex spaces with recessed lighting and durable LVP floors.</p>',
                'starting_price' => 28000,
                'image_url' => 'https://images.unsplash.com/photo-1600210492493-0946911123ea?auto=format&fit=crop&w=1400&q=80',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Waterproofing & Moisture Control',
                'slug' => 'waterproofing-moisture-control',
                'icon' => 'droplet',
                'summary' => 'Diagnose seepage, install drain systems, vapor barriers, and dry-out protocols before finish work.',
                'description' => '<p>We never hang drywall over an unresolved wet wall. Our moisture package may include interior drain tile, sump upgrades, crack injection, and closed-cell foam against foundation walls.</p>',
                'starting_price' => 6500,
                'image_url' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=1400&q=80',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Egress Windows & Code Paths',
                'slug' => 'egress-windows-code',
                'icon' => 'window',
                'summary' => 'Cut openings, set wells, and pass inspection for legal basement bedrooms.',
                'description' => '<p>Minnesota code requires egress in sleeping rooms. We excavate, cut, set code-sized windows and wells, and handle inspection scheduling.</p>',
                'starting_price' => 4200,
                'image_url' => 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1400&q=80',
                'is_featured' => false,
                'sort_order' => 3,
            ],
            [
                'title' => 'Basement Bathrooms',
                'slug' => 'basement-bathrooms',
                'icon' => 'bath',
                'summary' => 'Add full or half baths with ejector systems, waterproof floors, and proper venting.',
                'description' => '<p>Below-grade baths often need sewage ejector pumps. We design wet walls, tile surrounds, exhaust, and GFCI protection for long-term reliability.</p>',
                'starting_price' => 14500,
                'image_url' => 'https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?auto=format&fit=crop&w=1400&q=80',
                'is_featured' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Theater & Rec Rooms',
                'slug' => 'theater-rec-rooms',
                'icon' => 'tv',
                'summary' => 'Acoustic detailing, dimmable lighting, and media walls for downstairs entertainment.',
                'description' => '<p>From resilient channel and mineral wool to blackout niches and wet bars, we build rec spaces that stay quiet upstairs.</p>',
                'starting_price' => 22000,
                'image_url' => 'https://images.unsplash.com/photo-1593784991095-a205069470b6?auto=format&fit=crop&w=1400&q=80',
                'is_featured' => false,
                'sort_order' => 5,
            ],
            [
                'title' => 'ADU-Style Lower Suites',
                'slug' => 'adu-lower-suites',
                'icon' => 'key',
                'summary' => 'Kitchenettes, baths, and separate entries for guests or rental-ready suites where zoning allows.',
                'description' => '<p>We help evaluate zoning early, then deliver kitchenettes, laundry, egress, and privacy detailing for multi-generational living.</p>',
                'starting_price' => 48000,
                'image_url' => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1400&q=80',
                'is_featured' => false,
                'sort_order' => 6,
            ],
        ];
        foreach ($services as $service) {
            Service::query()->updateOrCreate(['slug' => $service['slug']], $service);
        }

        $products = [
            ['name' => 'Closed-Cell Spray Foam (board ft)', 'sku' => 'INS-CCSF-BF', 'category' => 'insulation', 'unit_cost' => 0.85, 'unit_price' => 1.45, 'stock_qty' => 12000, 'unit' => 'bf'],
            ['name' => '2x4 Stud 8ft KD', 'sku' => 'FRM-24-8', 'category' => 'framing', 'unit_cost' => 3.40, 'unit_price' => 5.10, 'stock_qty' => 480, 'unit' => 'ea'],
            ['name' => 'Moisture-Resistant Drywall 1/2"', 'sku' => 'DW-MR-12', 'category' => 'drywall', 'unit_cost' => 14.00, 'unit_price' => 22.00, 'stock_qty' => 160, 'unit' => 'sht'],
            ['name' => 'LVP Plank Oak Drift', 'sku' => 'FLR-LVP-OD', 'category' => 'flooring', 'unit_cost' => 2.10, 'unit_price' => 3.95, 'stock_qty' => 3200, 'unit' => 'sf'],
            ['name' => 'Interior Drain Tile Kit', 'sku' => 'WP-IDT-KIT', 'category' => 'waterproofing', 'unit_cost' => 180, 'unit_price' => 320, 'stock_qty' => 24, 'unit' => 'kit'],
            ['name' => 'LED Recessed 6" Canless', 'sku' => 'EL-REC-6', 'category' => 'electrical', 'unit_cost' => 18, 'unit_price' => 34, 'stock_qty' => 210, 'unit' => 'ea'],
            ['name' => 'Sewage Ejector Pump Package', 'sku' => 'PL-EJP-1', 'category' => 'plumbing', 'unit_cost' => 620, 'unit_price' => 980, 'stock_qty' => 8, 'unit' => 'ea'],
            ['name' => 'Paint-Grade Base MDF 5.25"', 'sku' => 'FIN-BASE-525', 'category' => 'finish', 'unit_cost' => 1.15, 'unit_price' => 2.40, 'stock_qty' => 1800, 'unit' => 'lf'],
        ];
        foreach ($products as $product) {
            Product::query()->updateOrCreate(
                ['sku' => $product['sku']],
                array_merge($product, ['description' => 'CedarVault stock for basement finishing crews.', 'is_active' => true])
            );
        }

        $customers = collect([
            ['name' => 'Elena Park', 'email' => 'elena.park@example.com', 'phone' => '(651) 555-2211', 'city' => 'St. Paul', 'address' => '412 Summit Ave', 'zip' => '55102'],
            ['name' => 'Marcus & Dee Holt', 'email' => 'holt.family@example.com', 'phone' => '(612) 555-8830', 'city' => 'Minneapolis', 'address' => '2901 Bryant Ave S', 'zip' => '55408'],
            ['name' => 'Priya Nair', 'email' => 'priya.nair@example.com', 'phone' => '(763) 555-4412', 'city' => 'Plymouth', 'address' => '11840 36th Ave N', 'zip' => '55441'],
            ['name' => 'Tom Brennan', 'email' => 'tbrennan@example.com', 'phone' => '(952) 555-7788', 'city' => 'Edina', 'address' => '5208 Wooddale Ave', 'zip' => '55424'],
            ['name' => 'Aisha Rahman', 'email' => 'aisha.r@example.com', 'phone' => '(651) 555-9090', 'city' => 'Woodbury', 'address' => '8890 Tamarack Rd', 'zip' => '55125'],
        ])->map(function (array $data) {
            return Customer::query()->updateOrCreate(
                ['email' => $data['email']],
                array_merge($data, ['state' => 'MN', 'notes' => 'Demo homeowner lead for CedarVault.'])
            );
        });

        $projectDefs = [
            ['number' => 'CV-2401', 'title' => 'Summit Ave family room finish', 'status' => 'completed', 'sqft' => 780, 'est' => 62000, 'act' => 64500],
            ['number' => 'CV-2408', 'title' => 'Bryant Ave bath + egress suite', 'status' => 'in_progress', 'sqft' => 920, 'est' => 88500, 'act' => 42000],
            ['number' => 'CV-2412', 'title' => 'Plymouth theater & wet bar', 'status' => 'scheduled', 'sqft' => 650, 'est' => 54000, 'act' => 0],
            ['number' => 'CV-2415', 'title' => 'Edina waterproofing + LVP', 'status' => 'quoted', 'sqft' => 1100, 'est' => 39000, 'act' => 0],
            ['number' => 'CV-2419', 'title' => 'Woodbury ADU-style suite', 'status' => 'lead', 'sqft' => 980, 'est' => 112000, 'act' => 0],
        ];

        $projects = collect();
        foreach ($projectDefs as $i => $def) {
            $customer = $customers[$i];
            $projects->push(Project::query()->updateOrCreate(
                ['project_number' => $def['number']],
                [
                    'customer_id' => $customer->id,
                    'assigned_to' => $i % 2 === 0 ? $manager->id : $staff->id,
                    'title' => $def['title'],
                    'description' => 'Demo basement finishing project seeded for CedarVault ERP.',
                    'status' => $def['status'],
                    'priority' => $i === 1 ? 'high' : 'normal',
                    'site_address' => $customer->address.', '.$customer->city.', MN',
                    'sqft' => $def['sqft'],
                    'estimated_value' => $def['est'],
                    'actual_value' => $def['act'],
                    'start_date' => now()->subDays(40 - ($i * 5)),
                    'target_date' => now()->addDays(20 + ($i * 7)),
                    'completed_at' => $def['status'] === 'completed' ? now()->subDays(10) : null,
                ]
            ));
        }

        $invoice1 = Invoice::query()->updateOrCreate(
            ['invoice_number' => 'INV-1001'],
            [
                'customer_id' => $customers[0]->id,
                'project_id' => $projects[0]->id,
                'status' => 'paid',
                'issue_date' => now()->subMonths(2),
                'due_date' => now()->subMonths(1)->subDays(15),
                'subtotal' => 60000,
                'tax' => 4500,
                'total' => 64500,
                'amount_paid' => 64500,
                'notes' => 'Final payment for Summit Ave finish.',
            ]
        );
        Payment::query()->updateOrCreate(
            ['invoice_id' => $invoice1->id, 'reference' => 'CHK-44021'],
            [
                'amount' => 32000,
                'method' => 'check',
                'paid_at' => now()->subMonths(2)->addDays(3),
            ]
        );
        Payment::query()->updateOrCreate(
            ['invoice_id' => $invoice1->id, 'reference' => 'ACH-99102'],
            [
                'amount' => 32500,
                'method' => 'ach',
                'paid_at' => now()->subMonths(1)->subDays(10),
            ]
        );

        $invoice2 = Invoice::query()->updateOrCreate(
            ['invoice_number' => 'INV-1008'],
            [
                'customer_id' => $customers[1]->id,
                'project_id' => $projects[1]->id,
                'status' => 'partial',
                'issue_date' => now()->subDays(18),
                'due_date' => now()->addDays(12),
                'subtotal' => 40000,
                'tax' => 3000,
                'total' => 43000,
                'amount_paid' => 20000,
                'notes' => 'Deposit + progress billing for Bryant Ave suite.',
            ]
        );
        Payment::query()->updateOrCreate(
            ['invoice_id' => $invoice2->id, 'reference' => 'CARD-2281'],
            [
                'amount' => 20000,
                'method' => 'card',
                'paid_at' => now()->subDays(16),
            ]
        );

        Appointment::query()->updateOrCreate(
            ['title' => 'Bryant Ave rough-in walkthrough', 'starts_at' => now()->addDays(2)->setTime(9, 0)],
            [
                'customer_id' => $customers[1]->id,
                'project_id' => $projects[1]->id,
                'assigned_to' => $manager->id,
                'type' => 'site_visit',
                'status' => 'confirmed',
                'ends_at' => now()->addDays(2)->setTime(10, 30),
                'location' => $customers[1]->address,
            ]
        );
        Appointment::query()->updateOrCreate(
            ['title' => 'Edina moisture consult', 'starts_at' => now()->addDays(5)->setTime(14, 0)],
            [
                'customer_id' => $customers[3]->id,
                'project_id' => $projects[3]->id,
                'assigned_to' => $staff->id,
                'type' => 'consultation',
                'status' => 'scheduled',
                'ends_at' => now()->addDays(5)->setTime(15, 0),
                'location' => $customers[3]->address,
            ]
        );

        $posts = [
            [
                'title' => 'Why Twin Cities basements fail before drywall goes up',
                'slug' => 'why-basements-fail-before-drywall',
                'excerpt' => 'Moisture is a sequencing problem. Here is how CedarVault stages waterproofing before finish carpentry.',
                'cover_image' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=1400&q=80',
                'body' => '<p>Every spring we see the same pattern: a beautiful finish installed over a foundation that still weeps. Paint bubbles, trim cups, and carpet smells follow.</p><p>Our rule is simple — prove the wall is dry, manage vapor, then frame. That may mean drain tile, crack injection, or waiting through a rain cycle with moisture meters logged.</p>',
            ],
            [
                'title' => 'Egress windows that pass inspection the first time',
                'slug' => 'egress-windows-first-pass',
                'excerpt' => 'Opening size, well depth, and ladder requirements — a field checklist for legal bedrooms.',
                'cover_image' => 'https://images.unsplash.com/photo-1600047509807-ba8f99d2cd00?auto=format&fit=crop&w=1400&q=80',
                'body' => '<p>Inspectors care about clear opening, sill height, and well geometry. We cut only after confirming structural headers and exterior grade.</p><p>Homeowners get a bedroom that is actually legal — not a gray-area den.</p>',
            ],
            [
                'title' => 'Choosing LVP vs carpet in finished basements',
                'slug' => 'lvp-vs-carpet-basements',
                'excerpt' => 'Comfort underfoot matters, but so does a spill from the ejector alarm weekend.',
                'cover_image' => 'https://images.unsplash.com/photo-1581858726788-75bc0f6a952d?auto=format&fit=crop&w=1400&q=80',
                'body' => '<p>We specify rigid-core LVP with vapor-aware underlayment for most CedarVault projects. Carpet still works in dry, elevated rooms with rugs as accents.</p>',
            ],
        ];
        foreach ($posts as $post) {
            BlogPost::query()->updateOrCreate(
                ['slug' => $post['slug']],
                array_merge($post, [
                    'author_name' => 'CedarVault Studio',
                    'is_published' => true,
                    'published_at' => now()->subDays(rand(3, 40)),
                ])
            );
        }

        $articles = [
            [
                'title' => 'Musty smell after framing',
                'slug' => 'musty-smell-after-framing',
                'category' => 'issues',
                'summary' => 'What to check when organic odors appear mid-project.',
                'body' => '<ol><li>Meter concrete and sill plates.</li><li>Confirm vapor barrier continuity.</li><li>Inspect sump discharge and grading.</li><li>Hold drywall until readings stabilize.</li></ol>',
                'sort_order' => 1,
            ],
            [
                'title' => 'Basement finish sequence checklist',
                'slug' => 'basement-finish-sequence',
                'category' => 'guides',
                'summary' => 'From moisture proofing to punch list — the CedarVault order of operations.',
                'body' => '<p>1) Moisture diagnosis 2) Permits 3) Rough MEP 4) Insulation 5) Drywall 6) Paint 7) Flooring 8) Trim 9) Final inspection.</p>',
                'sort_order' => 1,
            ],
            [
                'title' => 'Admin: creating a job in Filament ERP',
                'slug' => 'admin-creating-a-job',
                'category' => 'admin',
                'summary' => 'How staff open projects, assign crew, and link invoices.',
                'body' => '<p>Navigate to <strong>Jobs / Projects</strong>, create a record with customer and sq ft, then schedule an appointment and draft an invoice from Finance.</p>',
                'sort_order' => 1,
            ],
            [
                'title' => 'Invoice balance not updating after payment',
                'slug' => 'invoice-balance-not-updating',
                'category' => 'troubleshooting',
                'summary' => 'Quick ERP checks when amount_paid looks wrong.',
                'body' => '<p>Confirm the payment is linked to the correct invoice, that status is partial/paid, and that amount_paid equals the sum of payment rows. Re-save the invoice if needed.</p>',
                'sort_order' => 1,
            ],
            [
                'title' => 'Low ceiling height options',
                'slug' => 'low-ceiling-height-options',
                'category' => 'issues',
                'summary' => 'Strategies when joists leave limited headroom.',
                'body' => '<p>Consider shallow LED cans, beam wraps, and relocating duct runs. Code minimums still apply for habitable rooms.</p>',
                'sort_order' => 2,
            ],
            [
                'title' => 'Homeowner prep before demo day',
                'slug' => 'homeowner-prep-demo-day',
                'category' => 'guides',
                'summary' => 'Clear paths, protect upstairs finishes, confirm pets and parking.',
                'body' => '<p>Move stored items, reserve driveway space for dumpsters, and share Wi-Fi only if cameras need access. CedarVault covers dust walls at stair openings.</p>',
                'sort_order' => 2,
            ],
        ];
        foreach ($articles as $article) {
            KnowledgeArticle::query()->updateOrCreate(
                ['slug' => $article['slug']],
                array_merge($article, ['is_published' => true])
            );
        }
    }
}
