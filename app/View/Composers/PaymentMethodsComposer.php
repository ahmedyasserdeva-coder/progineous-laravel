<?php

namespace App\View\Composers;

use App\Services\FawaterakPaymentService;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class PaymentMethodsComposer
{
    protected $fawaterakService;

    public function __construct(FawaterakPaymentService $fawaterakService)
    {
        $this->fawaterakService = $fawaterakService;
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view)
    {
        // Cache payment methods for 24 hours to avoid excessive API calls
        $paymentMethods = Cache::remember('fawaterak_payment_methods', 86400, function () {
            $result = $this->fawaterakService->getPaymentMethods();
            
            if ($result['success'] && isset($result['methods'])) {
                return $result['methods'];
            }
            
            return [];
        });

        // Get website logo and favicon from settings
        $websiteLogo = Setting::get('website_logo', '');
        $favicon = Setting::get('favicon', '');
        $companyName = Setting::get('company_name', config('app.name', 'Pro Hosting'));

        $view->with([
            'fawaterakPaymentMethods' => $paymentMethods,
            'websiteLogo' => $websiteLogo,
            'favicon' => $favicon,
            'companyName' => $companyName,
        ]);
    }
}
