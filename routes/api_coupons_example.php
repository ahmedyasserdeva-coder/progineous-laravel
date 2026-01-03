<?php

/**
 * مثال على استخدام كوبونات Dynadot في API Routes
 * 
 * أضف هذا الكود في routes/api.php
 */

use Illuminate\Support\Facades\Route;
use App\Services\DynadotService;
use App\Models\DomainRegistrar;
use Illuminate\Http\Request;

/**
 * 1. جلب قائمة الكوبونات المتاحة
 * 
 * GET /api/dynadot/coupons/{type}
 * type: registration | renewal | transfer
 */
Route::get('/dynadot/coupons/{type}', function($type) {
    try {
        // التحقق من صحة النوع
        if (!in_array($type, ['registration', 'renewal', 'transfer'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon type. Must be: registration, renewal, or transfer'
            ], 400);
        }

        // الحصول على إعدادات Dynadot
        $registrar = DomainRegistrar::where('type', 'dynadot')
            ->where('status', 1)
            ->firstOrFail();

        $service = new DynadotService($registrar);
        
        // جلب الكوبونات
        $coupons = $service->listCoupons($type);
        
        return response()->json([
            'success' => true,
            'type' => $type,
            'count' => count($coupons),
            'coupons' => $coupons
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to fetch coupons: ' . $e->getMessage()
        ], 500);
    }
});

/**
 * 2. التحقق من صلاحية كوبون معين
 * 
 * POST /api/dynadot/coupons/verify
 * Body: { "code": "OCTCOM25", "type": "registration", "tld": "com", "currency": "USD" }
 */
Route::post('/dynadot/coupons/verify', function(Request $request) {
    try {
        $request->validate([
            'code' => 'required|string',
            'type' => 'required|in:registration,renewal,transfer',
            'tld' => 'nullable|string',
            'currency' => 'nullable|string|in:USD,EUR,GBP,CAD'
        ]);

        $registrar = DomainRegistrar::where('type', 'dynadot')
            ->where('status', 1)
            ->firstOrFail();

        $service = new DynadotService($registrar);
        
        // جلب الكوبونات من النوع المحدد
        $coupons = $service->listCoupons($request->input('type'));
        
        // البحث عن الكوبون
        $coupon = collect($coupons)->firstWhere('Code', $request->input('code'));
        
        if (!$coupon) {
            return response()->json([
                'success' => false,
                'valid' => false,
                'message' => 'Coupon code not found or expired'
            ], 404);
        }

        // التحقق من القيود إذا كان TLD محدد
        $restrictions = [];
        if ($request->filled('tld')) {
            $tld = '.' . ltrim($request->input('tld'), '.');
            $allowedTlds = $coupon['Restriction']['Tlds'] ?? [];
            
            if (!empty($allowedTlds) && !in_array($tld, $allowedTlds)) {
                $restrictions[] = "This coupon is only valid for: " . implode(', ', $allowedTlds);
            }
        }

        // التحقق من العملة
        if ($request->filled('currency')) {
            $currency = $request->input('currency');
            $allowedCurrencies = $coupon['Restriction']['Currencies'] ?? [];
            
            if (!empty($allowedCurrencies)) {
                $currencyValid = false;
                foreach ($allowedCurrencies as $curr) {
                    if (str_contains($curr, $currency)) {
                        $currencyValid = true;
                        break;
                    }
                }
                
                if (!$currencyValid) {
                    $restrictions[] = "This coupon is not valid for currency: {$currency}";
                }
            }
        }

        return response()->json([
            'success' => true,
            'valid' => empty($restrictions),
            'coupon' => [
                'code' => $coupon['Code'],
                'description' => $coupon['Description'],
                'discount_type' => $coupon['DiscountType'],
                'discount_info' => $coupon['DiscountInfo'],
                'restrictions' => $coupon['Restriction'],
                'start_date' => $coupon['StartDate'] ?? null,
                'end_date' => $coupon['EndDate'] ?? null
            ],
            'restrictions' => $restrictions,
            'message' => empty($restrictions) 
                ? 'Coupon is valid and can be used' 
                : 'Coupon has restrictions'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to verify coupon: ' . $e->getMessage()
        ], 500);
    }
});

/**
 * 3. تسجيل نطاق مع كوبون
 * 
 * POST /api/dynadot/domains/register
 * Body: { "domain": "example.com", "duration": 1, "currency": "USD", "coupon": "OCTCOM25" }
 */
Route::post('/dynadot/domains/register', function(Request $request) {
    try {
        $request->validate([
            'domain' => 'required|string',
            'duration' => 'required|integer|min:1|max:10',
            'currency' => 'nullable|string|in:USD,EUR,GBP,CAD',
            'coupon' => 'nullable|string'
        ]);

        $registrar = DomainRegistrar::where('type', 'dynadot')
            ->where('status', 1)
            ->firstOrFail();

        $service = new DynadotService($registrar);
        
        // إعداد الخيارات
        $options = [
            'currency' => $request->input('currency', 'USD')
        ];

        // إضافة الكوبون إذا كان موجوداً
        if ($request->filled('coupon')) {
            $options['coupon'] = $request->input('coupon');
        }

        // تسجيل النطاق
        $result = $service->registerDomain(
            $request->input('domain'),
            $request->input('duration'),
            $options
        );

        return response()->json([
            'success' => true,
            'message' => 'Domain registered successfully',
            'domain' => $request->input('domain'),
            'coupon_applied' => $request->filled('coupon'),
            'coupon_code' => $request->input('coupon'),
            'result' => $result
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Registration failed: ' . $e->getMessage()
        ], 400);
    }
});

/**
 * 4. تجديد نطاق مع كوبون
 * 
 * POST /api/dynadot/domains/renew
 * Body: { "domain": "example.com", "duration": 1, "currency": "USD", "coupon": "RENEW2024" }
 */
Route::post('/dynadot/domains/renew', function(Request $request) {
    try {
        $request->validate([
            'domain' => 'required|string',
            'duration' => 'required|integer|min:1|max:10',
            'currency' => 'nullable|string|in:USD,EUR,GBP,CAD',
            'coupon' => 'nullable|string'
        ]);

        $registrar = DomainRegistrar::where('type', 'dynadot')
            ->where('status', 1)
            ->firstOrFail();

        $service = new DynadotService($registrar);
        
        $options = [
            'currency' => $request->input('currency', 'USD')
        ];

        if ($request->filled('coupon')) {
            $options['coupon'] = $request->input('coupon');
        }

        $result = $service->renewDomain(
            $request->input('domain'),
            $request->input('duration'),
            $options
        );

        return response()->json([
            'success' => true,
            'message' => 'Domain renewed successfully',
            'domain' => $request->input('domain'),
            'coupon_applied' => $request->filled('coupon'),
            'coupon_code' => $request->input('coupon'),
            'result' => $result
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Renewal failed: ' . $e->getMessage()
        ], 400);
    }
});

/**
 * 5. نقل نطاق مع كوبون
 * 
 * POST /api/dynadot/domains/transfer
 * Body: { "domain": "example.com", "auth_code": "ABC123", "currency": "USD", "coupon": "TRANSFER10" }
 */
Route::post('/dynadot/domains/transfer', function(Request $request) {
    try {
        $request->validate([
            'domain' => 'required|string',
            'auth_code' => 'required|string',
            'currency' => 'nullable|string|in:USD,EUR,GBP,CAD',
            'coupon' => 'nullable|string'
        ]);

        $registrar = DomainRegistrar::where('type', 'dynadot')
            ->where('status', 1)
            ->firstOrFail();

        $service = new DynadotService($registrar);
        
        $options = [
            'currency' => $request->input('currency', 'USD')
        ];

        if ($request->filled('coupon')) {
            $options['coupon'] = $request->input('coupon');
        }

        $result = $service->transferDomain(
            $request->input('domain'),
            $request->input('auth_code'),
            $options
        );

        return response()->json([
            'success' => true,
            'message' => 'Domain transfer initiated successfully',
            'domain' => $request->input('domain'),
            'coupon_applied' => $request->filled('coupon'),
            'coupon_code' => $request->input('coupon'),
            'result' => $result
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Transfer failed: ' . $e->getMessage()
        ], 400);
    }
});
