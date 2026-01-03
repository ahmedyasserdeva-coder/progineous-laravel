<?php

use Illuminate\Support\Facades\Route;
use App\Models\DomainRegistrar;
use App\Services\DynadotService;

// Test route to check saved coupons
Route::get('/test/dynadot-coupons', function () {
    $registrar = DomainRegistrar::where('type', 'dynadot')->first();
    
    if (!$registrar) {
        return response()->json([
            'status' => 'error',
            'message' => 'No Dynadot registrar found!'
        ], 404);
    }
    
    $preferredCoupons = $registrar->preferred_coupons ?? [];
    
    return response()->json([
        'status' => 'success',
        'registrar' => [
            'id' => $registrar->id,
            'name' => $registrar->name,
            'status' => $registrar->status ? 'Active' : 'Inactive',
        ],
        'preferred_coupons' => $preferredCoupons,
        'count' => count($preferredCoupons)
    ]);
})->name('test.dynadot.coupons');

// Test route to simulate domain registration with coupon
Route::get('/test/dynadot-register-with-coupon', function () {
    $registrar = DomainRegistrar::where('type', 'dynadot')
        ->where('status', 1)
        ->first();
    
    if (!$registrar) {
        return response()->json([
            'status' => 'error',
            'message' => 'No active Dynadot registrar found!'
        ], 404);
    }
    
    $preferredCoupons = $registrar->preferred_coupons ?? [];
    
    // Get registration coupon
    $registrationCoupon = collect($preferredCoupons)
        ->where('type', 'registration')
        ->first();
    
    if (!$registrationCoupon) {
        return response()->json([
            'status' => 'info',
            'message' => 'No registration coupon found in preferred coupons',
            'all_coupons' => $preferredCoupons
        ]);
    }
    
    $service = new DynadotService($registrar);
    
    // Test domain (won't actually register, just to see API response)
    $testDomain = 'test-example-' . time() . '.com';
    
    try {
        // Build the request parameters
        $params = [
            'currency' => 'USD',
            'coupon' => $registrationCoupon['code']
        ];
        
        return response()->json([
            'status' => 'ready',
            'message' => 'Coupon is ready to use',
            'test_domain' => $testDomain,
            'coupon_to_use' => $registrationCoupon,
            'api_params' => $params,
            'note' => 'This is a dry run. To actually register, call $service->registerDomain("' . $testDomain . '", 1, $params)'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Error preparing registration: ' . $e->getMessage(),
            'coupon' => $registrationCoupon
        ], 500);
    }
})->name('test.dynadot.register');

// Test route to verify coupon with Dynadot API
Route::get('/test/dynadot-verify-coupon/{type}', function ($type) {
    $registrar = DomainRegistrar::where('type', 'dynadot')
        ->where('status', 1)
        ->first();
    
    if (!$registrar) {
        return response()->json([
            'status' => 'error',
            'message' => 'No active Dynadot registrar found!'
        ], 404);
    }
    
    $preferredCoupons = $registrar->preferred_coupons ?? [];
    
    // Get coupon by type
    $coupon = collect($preferredCoupons)
        ->where('type', $type)
        ->first();
    
    if (!$coupon) {
        return response()->json([
            'status' => 'error',
            'message' => "No {$type} coupon found in preferred coupons",
            'all_coupons' => $preferredCoupons
        ], 404);
    }
    
    $service = new DynadotService($registrar);
    
    try {
        // Fetch all coupons of this type from Dynadot
        $availableCoupons = $service->listCoupons($type);
        
        // Check if our saved coupon exists in the available list
        $foundInAPI = collect($availableCoupons)
            ->where('Code', $coupon['code'])
            ->first();
        
        if ($foundInAPI) {
            return response()->json([
                'status' => 'valid',
                'message' => 'Coupon is valid and active in Dynadot API!',
                'coupon' => $coupon,
                'api_details' => $foundInAPI
            ]);
        } else {
            return response()->json([
                'status' => 'warning',
                'message' => 'Coupon not found in current Dynadot API response',
                'coupon' => $coupon,
                'note' => 'This could mean: 1) Coupon expired, 2) Coupon code is incorrect, 3) No active coupons in your account',
                'available_coupons_count' => count($availableCoupons)
            ]);
        }
        
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Error verifying coupon: ' . $e->getMessage(),
            'coupon' => $coupon
        ], 500);
    }
})->name('test.dynadot.verify')->where('type', 'registration|renewal|transfer');
