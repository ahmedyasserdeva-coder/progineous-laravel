{{-- مثال على كيفية إضافة زر Live Chat في أي صفحة --}}

{{-- مثال 1: زر بسيط --}}
<button onclick="showIntercom()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
    {{ __('frontend.live_chat') }}
</button>

{{-- مثال 2: زر عائم (Floating Button) --}}
<button onclick="showIntercom()" 
        class="fixed bottom-6 right-6 w-14 h-14 bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 hover:shadow-xl transition-all duration-300 flex items-center justify-center z-40">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
    </svg>
</button>

{{-- مثال 3: رابط في Navigation --}}
<a href="#" onclick="event.preventDefault(); showIntercom();" class="nav-link">
    Live Chat
</a>

{{-- مثال 4: استخدام Alpine.js --}}
<div x-data="{ showChat: false }">
    <button @click="showChat = true; showIntercom()" 
            class="btn btn-primary">
        Start Chat
    </button>
</div>

{{-- مثال 5: زر مع أيقونة في صفحة Support --}}
<div class="support-options grid grid-cols-1 md:grid-cols-3 gap-6">
    {{-- Email Support --}}
    <div class="bg-white rounded-lg shadow p-6 text-center">
        <svg class="w-12 h-12 mx-auto text-blue-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
        </svg>
        <h3 class="text-xl font-bold mb-2">Email Support</h3>
        <p class="text-gray-600 mb-4">Get help via email</p>
        <a href="mailto:support@example.com" class="btn btn-outline">Send Email</a>
    </div>

    {{-- Live Chat --}}
    <div class="bg-white rounded-lg shadow p-6 text-center">
        <svg class="w-12 h-12 mx-auto text-green-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
        </svg>
        <h3 class="text-xl font-bold mb-2">Live Chat</h3>
        <p class="text-gray-600 mb-4">Chat with us now</p>
        <button onclick="showIntercom()" class="btn btn-primary">Start Chat</button>
    </div>

    {{-- Phone Support --}}
    <div class="bg-white rounded-lg shadow p-6 text-center">
        <svg class="w-12 h-12 mx-auto text-purple-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
        </svg>
        <h3 class="text-xl font-bold mb-2">Phone Support</h3>
        <p class="text-gray-600 mb-4">Call us directly</p>
        <a href="tel:+201009839264" class="btn btn-outline">Call Now</a>
    </div>
</div>

{{-- مثال 6: إضافة في صفحة Pricing لبدء محادثة عن العروض --}}
<div class="pricing-card">
    <h3>Premium Plan</h3>
    <p class="price">$99/month</p>
    <ul class="features">
        <li>Unlimited Bandwidth</li>
        <li>100GB Storage</li>
        <li>24/7 Support</li>
    </ul>
    <button class="btn btn-primary">Subscribe Now</button>
    <button onclick="showIntercom()" class="btn btn-link mt-2">
        Questions? Chat with us
    </button>
</div>

{{-- مثال 7: إضافة في صفحة Error 404 --}}
<div class="error-page text-center">
    <h1 class="text-6xl font-bold">404</h1>
    <p class="text-xl mb-6">Page not found</p>
    <div class="flex gap-4 justify-center">
        <a href="/" class="btn btn-primary">Go Home</a>
        <button onclick="showIntercom()" class="btn btn-outline">
            Need Help?
        </button>
    </div>
</div>

{{-- مثال 8: استخدام في Form للحصول على مساعدة فورية --}}
<form class="contact-form">
    <div class="form-header flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold">Contact Us</h3>
        <button type="button" onclick="showIntercom()" class="text-blue-600 hover:text-blue-700 text-sm">
            Or chat with us →
        </button>
    </div>
    
    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" class="form-control">
    </div>
    
    <div class="form-group">
        <label>Message</label>
        <textarea name="message" class="form-control"></textarea>
    </div>
    
    <button type="submit" class="btn btn-primary">Send Message</button>
</form>

{{-- مثال 9: JavaScript للتحديث بعد تسجيل الدخول --}}
<script>
// بعد نجاح تسجيل الدخول
fetch('/api/auth/login', {
    method: 'POST',
    // ... login data
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        // تحديث بيانات Intercom
        updateIntercomUser({
            id: data.user.id,
            name: data.user.name,
            email: data.user.email,
            created_at: data.user.created_at
        });
    }
});

// عند تسجيل الخروج
function logout() {
    // إيقاف Intercom
    shutdownIntercom();
    
    // ... logout logic
}
</script>

{{-- مثال 10: إضافة Custom Events --}}
<script>
// عند شراء منتج
function onProductPurchase(product) {
    if (window.Intercom) {
        window.Intercom('trackEvent', 'purchased-product', {
            product_name: product.name,
            product_price: product.price,
            product_id: product.id
        });
    }
}

// عند زيارة صفحة معينة
function trackPageView(pageName) {
    if (window.Intercom) {
        window.Intercom('trackEvent', 'visited-page', {
            page: pageName,
            timestamp: Date.now()
        });
    }
}
</script>
