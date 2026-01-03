<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hosting Products
        $hostingProducts = [
            [
                'name' => 'Shared Hosting - Basic',
                'type' => 'hosting',
                'category' => 'shared_hosting',
                'description' => 'Perfect for small websites and blogs',
                'price' => 29.99,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    '1 Website',
                    '10 GB SSD Storage',
                    'Unlimited Bandwidth',
                    'Free SSL Certificate',
                    '24/7 Support',
                    'cPanel Control Panel'
                ]),
                'api_product_id' => 'shared_basic'
            ],
            [
                'name' => 'Shared Hosting - Professional',
                'type' => 'hosting',
                'category' => 'shared_hosting',
                'description' => 'Great for growing businesses',
                'price' => 59.99,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    'Unlimited Websites',
                    '50 GB SSD Storage',
                    'Unlimited Bandwidth',
                    'Free SSL Certificate',
                    '24/7 Support',
                    'cPanel Control Panel',
                    'Free Domain'
                ]),
                'api_product_id' => 'shared_pro'
            ],
            [
                'name' => 'Cloud Hosting - Starter',
                'type' => 'hosting',
                'category' => 'cloud_hosting',
                'description' => 'Scalable cloud hosting solution',
                'price' => 99.99,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    '2 CPU Cores',
                    '4 GB RAM',
                    '100 GB SSD Storage',
                    'Unlimited Bandwidth',
                    'Auto-scaling',
                    'Free SSL Certificate',
                    '24/7 Support'
                ]),
                'api_product_id' => 'cloud_starter'
            ],
            [
                'name' => 'VPS Hosting - Basic',
                'type' => 'hosting',
                'category' => 'vps_hosting',
                'description' => 'Virtual Private Server for more control',
                'price' => 199.99,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    '2 CPU Cores',
                    '8 GB RAM',
                    '200 GB SSD Storage',
                    'Root Access',
                    'Choice of OS',
                    'Dedicated IP',
                    '24/7 Support'
                ]),
                'api_product_id' => 'vps_basic'
            ],
            [
                'name' => 'Dedicated Server - Professional',
                'type' => 'hosting',
                'category' => 'dedicated_server',
                'description' => 'Dedicated server for maximum performance',
                'price' => 999.99,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    'Intel Xeon Processor',
                    '32 GB RAM',
                    '1 TB SSD Storage',
                    'Full Root Access',
                    'Dedicated IP',
                    'Hardware RAID',
                    '24/7 Support',
                    'Free Setup'
                ]),
                'api_product_id' => 'dedicated_pro'
            ],
            [
                'name' => 'Reseller Hosting',
                'type' => 'hosting',
                'category' => 'reseller_hosting',
                'description' => 'Start your own hosting business',
                'price' => 149.99,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    '100 GB SSD Storage',
                    'Unlimited Bandwidth',
                    'WHM Control Panel',
                    'Free SSL Certificates',
                    'White Label Options',
                    'Billing Software',
                    '24/7 Support'
                ]),
                'api_product_id' => 'reseller_basic'
            ]
        ];

        // Email Products
        $emailProducts = [
            [
                'name' => 'Professional Email - Basic',
                'type' => 'email',
                'category' => 'professional_email',
                'description' => 'Professional email for your business',
                'price' => 19.99,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    '5 Email Accounts',
                    '50 GB Storage per account',
                    'IMAP/POP3 Support',
                    'Webmail Access',
                    'Mobile Sync',
                    'Spam Protection'
                ])
            ],
            [
                'name' => 'Email Security Suite',
                'type' => 'email',
                'category' => 'email_security',
                'description' => 'Advanced email security and backup',
                'price' => 39.99,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    'Advanced Spam Protection',
                    'Virus Scanning',
                    'Email Archiving',
                    'Data Loss Prevention',
                    'Encryption',
                    'Compliance Tools'
                ])
            ],
            [
                'name' => 'Email Migration Service',
                'type' => 'email',
                'category' => 'migrate_email',
                'description' => 'Professional email migration service',
                'price' => 99.99,
                'billing_cycle' => 'one_time',
                'features' => json_encode([
                    'Complete Email Migration',
                    'Zero Downtime',
                    'All Email Data',
                    'Contacts & Calendars',
                    'Expert Support',
                    '30-day Support'
                ])
            ]
        ];

        // Domain Products
        $domainProducts = [
            [
                'name' => '.com Domain',
                'type' => 'domain',
                'category' => 'domain_registration',
                'description' => 'Most popular domain extension',
                'price' => 12.99,
                'billing_cycle' => 'yearly',
                'features' => json_encode([
                    'Free DNS Management',
                    'Domain Forwarding',
                    'Email Forwarding',
                    'Privacy Protection Available',
                    'Easy Management'
                ]),
                'api_product_id' => 'com'
            ],
            [
                'name' => '.net Domain',
                'type' => 'domain',
                'category' => 'domain_registration',
                'description' => 'Professional domain for networks',
                'price' => 14.99,
                'billing_cycle' => 'yearly',
                'features' => json_encode([
                    'Free DNS Management',
                    'Domain Forwarding',
                    'Email Forwarding',
                    'Privacy Protection Available',
                    'Easy Management'
                ]),
                'api_product_id' => 'net'
            ],
            [
                'name' => '.org Domain',
                'type' => 'domain',
                'category' => 'domain_registration',
                'description' => 'Perfect for organizations',
                'price' => 13.99,
                'billing_cycle' => 'yearly',
                'features' => json_encode([
                    'Free DNS Management',
                    'Domain Forwarding',
                    'Email Forwarding',
                    'Privacy Protection Available',
                    'Easy Management'
                ]),
                'api_product_id' => 'org'
            ],
            [
                'name' => 'Domain Transfer',
                'type' => 'domain',
                'category' => 'transfer_domain',
                'description' => 'Transfer your domain to us',
                'price' => 12.99,
                'billing_cycle' => 'yearly',
                'features' => json_encode([
                    'Free Transfer',
                    '1 Year Extension',
                    'Free DNS Management',
                    'No Downtime',
                    'Expert Support'
                ])
            ]
        ];

        // Insert all products
        foreach (array_merge($hostingProducts, $emailProducts, $domainProducts) as $product) {
            Product::create($product);
        }
    }
}
