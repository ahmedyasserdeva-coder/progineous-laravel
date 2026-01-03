<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DomainPricing;
use Illuminate\Http\Request;

class DomainSearchController extends Controller
{
    /**
     * Display the domain search page.
     */
    public function index()
    {
        // Get popular extensions with ProGineous pricing
        $popularExtensions = DomainPricing::whereIn('tld', [
            'com', 'net', 'org', 'io', 'co', 'me', 'online', 'app', 
            'dev', 'store', 'tech', 'shop'
        ])
        ->where('currency', 'USD')
        ->orderByRaw("FIELD(tld, 'com', 'net', 'org', 'io', 'co', 'me', 'online', 'app', 'dev', 'store', 'tech', 'shop')")
        ->get()
        ->map(function ($pricing) {
            return [
                'tld' => '.' . $pricing->tld,
                'price' => $pricing->progineous_register ?? $pricing->dynadot_register,
                'currency' => $pricing->currency,
            ];
        });

        return view('frontend.domains.search', compact('popularExtensions'));
    }

    /**
     * Search for available domains.
     */
    public function search(Request $request)
    {
        $request->validate([
            'domain' => 'required|string|max:255',
        ]);

        $domain = $request->input('domain');
        
        // Remove any protocol, www, and whitespace
        $domain = preg_replace('#^https?://#', '', trim($domain));
        $domain = preg_replace('#^www\.#', '', $domain);
        
        // TODO: Implement actual domain availability check
        // For now, return mock data
        
        return response()->json([
            'success' => true,
            'domain' => $domain,
            'results' => $this->getMockResults($domain)
        ]);
    }

    /**
     * Get mock domain availability results
     */
    private function getMockResults($domain)
    {
        $tlds = ['.com', '.net', '.org', '.online', '.shop', '.store', '.tech', '.io'];
        $results = [];
        
        foreach ($tlds as $tld) {
            $results[] = [
                'domain' => $domain . $tld,
                'available' => rand(0, 1) === 1,
                'price' => rand(10, 50),
                'renewal_price' => rand(15, 60),
            ];
        }
        
        return $results;
    }
}
