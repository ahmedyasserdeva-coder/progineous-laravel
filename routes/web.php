<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\HostingController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\AccessRequestController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use App\Models\DomainPricing;

// Frontend Routes
Route::get('/', function () {
    $featuredDomains = DomainPricing::where('is_featured', 1)
        ->orderBy('progineous_register', 'asc')
        ->get(['tld', 'progineous_register']);

    return view('frontend.home', compact('featuredDomains'));
})->name('home');

// Legal Pages
Route::get('/terms', function () {
    return view('frontend.legal.terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('frontend.legal.privacy');
})->name('privacy');

// Public Document Verification Routes (No Authentication Required)
Route::get('/verify/{documentId}', [\App\Http\Controllers\DocumentVerificationController::class, 'show'])->name('verify.document');
Route::post('/verify/{documentId}/file', [\App\Http\Controllers\DocumentVerificationController::class, 'verifyByFile'])->name('verify.file');

// Client Authentication Routes (Frontend)
Route::get('/login', [\App\Http\Controllers\Auth\ClientAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\ClientAuthController::class, 'login'])->name('login.post');
Route::get('/2fa/verify', [\App\Http\Controllers\Auth\ClientAuthController::class, 'show2FAForm'])->name('2fa.verify.show');
Route::post('/2fa/verify', [\App\Http\Controllers\Auth\ClientAuthController::class, 'verify2FA'])->name('2fa.verify.post');
Route::post('/logout', [\App\Http\Controllers\Auth\ClientAuthController::class, 'logout'])->name('logout');

// Google OAuth Routes
Route::get('/auth/google', [\App\Http\Controllers\Auth\SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [\App\Http\Controllers\Auth\SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// GitHub OAuth Routes
Route::get('/auth/github', [\App\Http\Controllers\Auth\SocialAuthController::class, 'redirectToGithub'])->name('auth.github');
Route::get('/auth/github/callback', [\App\Http\Controllers\Auth\SocialAuthController::class, 'handleGithubCallback'])->name('auth.github.callback');

// LinkedIn OAuth Routes
Route::get('/auth/linkedin', [\App\Http\Controllers\Auth\SocialAuthController::class, 'redirectToLinkedin'])->name('auth.linkedin');
Route::get('/auth/linkedin/callback', [\App\Http\Controllers\Auth\SocialAuthController::class, 'handleLinkedinCallback'])->name('auth.linkedin.callback');

Route::get('/register', [\App\Http\Controllers\Auth\ClientRegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [\App\Http\Controllers\Auth\ClientRegisterController::class, 'register'])->name('register.post');

// Client Dashboard (Protected)
Route::middleware(['client.auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('frontend.client.dashboard');
    })->name('client.dashboard');

    // Support PIN API
    Route::get('/api/support-pin', function () {
        $client = Auth::guard('client')->user();
        return response()->json([
            'pin' => $client->support_pin,
            'expires_at' => $client->support_pin_expires_at,
            'server_time' => time(),
        ]);
    })->name('api.support-pin');

    // ProGenius AI Routes
    Route::prefix('ai')->group(function () {
        Route::get('/assistant', function() {
            return view('frontend.client.ai-assistant.index');
        })->name('ai.assistant');
        Route::post('/generate', [\App\Http\Controllers\GeminiController::class, 'generate'])->name('ai.generate');
        Route::post('/translate', [\App\Http\Controllers\GeminiController::class, 'translate'])->name('ai.translate');
        Route::post('/summarize', [\App\Http\Controllers\GeminiController::class, 'summarize'])->name('ai.summarize');
        Route::post('/faq', [\App\Http\Controllers\GeminiController::class, 'generateFAQ'])->name('ai.faq');
        Route::post('/grammar', [\App\Http\Controllers\GeminiController::class, 'checkGrammar'])->name('ai.grammar');
        Route::post('/chat', [\App\Http\Controllers\GeminiController::class, 'chat'])->name('ai.chat');
    });

    // Profile & Settings Routes
    Route::get('/profile', [\App\Http\Controllers\Client\ProfileController::class, 'index'])->name('client.profile');
    Route::put('/profile', [\App\Http\Controllers\Client\ProfileController::class, 'update'])->name('client.profile.update');
    Route::post('/profile/check-username', [\App\Http\Controllers\Client\ProfileController::class, 'checkUsername'])->name('client.profile.check-username');
    Route::post('/profile/check-email', [\App\Http\Controllers\Client\ProfileController::class, 'checkEmail'])->name('profile.check-email');
    Route::post('/profile/generate-username', [\App\Http\Controllers\Client\ProfileController::class, 'generateUsername'])->name('client.profile.generate-username');
    Route::post('/profile/send-current-email-code', [\App\Http\Controllers\Client\ProfileController::class, 'sendCurrentEmailCode'])->name('profile.send-current-email-code');
    Route::post('/profile/verify-current-email', [\App\Http\Controllers\Client\ProfileController::class, 'verifyCurrentEmail'])->name('profile.verify-current-email');
    Route::post('/profile/send-new-email-code', [\App\Http\Controllers\Client\ProfileController::class, 'sendNewEmailCode'])->name('profile.send-new-email-code');
    Route::post('/profile/verify-new-email', [\App\Http\Controllers\Client\ProfileController::class, 'verifyNewEmail'])->name('profile.verify-new-email');

    // Client Domains Routes
    Route::get('/my-domains', [\App\Http\Controllers\Client\DomainController::class, 'index'])->name('client.domains.index');
    Route::get('/my-domains/{domain}', [\App\Http\Controllers\Client\DomainController::class, 'show'])->name('client.domains.show');
    Route::get('/my-domains/{domain}/contacts', [\App\Http\Controllers\Client\DomainController::class, 'contacts'])->name('client.domains.contacts');
    Route::post('/my-domains/{domain}/contacts', [\App\Http\Controllers\Client\DomainController::class, 'updateContacts'])->name('client.domains.contacts.update');
    Route::get('/my-domains/{domain}/ownership', [\App\Http\Controllers\Client\DomainController::class, 'ownership'])->name('client.domains.ownership');
    Route::post('/my-domains/{domain}/ownership', [\App\Http\Controllers\Client\DomainController::class, 'transferOwnership'])->name('client.domains.ownership.transfer');
    Route::post('/my-domains/{domain}/ownership/lookup', [\App\Http\Controllers\Client\DomainController::class, 'lookupOwner'])->name('client.domains.ownership.lookup');
    Route::post('/my-domains/{domain}/ownership/send-otp', [\App\Http\Controllers\Client\DomainController::class, 'sendOwnershipOtp'])->name('client.domains.ownership.send-otp');
    Route::post('/my-domains/{domain}/toggle-auto-renew', [\App\Http\Controllers\Client\DomainController::class, 'toggleAutoRenew'])->name('client.domains.toggle-auto-renew');
    Route::post('/my-domains/{domain}/update-nameservers', [\App\Http\Controllers\Client\DomainController::class, 'updateNameservers'])->name('client.domains.update-nameservers');
    Route::get('/my-domains/{domain}/check-nameservers', [\App\Http\Controllers\Client\DomainController::class, 'checkNameservers'])->name('client.domains.check-nameservers');
    Route::get('/my-domains/{domain}/check-ssl', [\App\Http\Controllers\Client\DomainController::class, 'checkSSL'])->name('client.domains.check-ssl');
    Route::post('/my-domains/{domain}/toggle-transfer-lock', [\App\Http\Controllers\Client\DomainController::class, 'toggleTransferLock'])->name('client.domains.toggle-transfer-lock');
    Route::post('/my-domains/{domain}/toggle-whois-privacy', [\App\Http\Controllers\Client\DomainController::class, 'toggleWhoisPrivacy'])->name('client.domains.toggle-whois-privacy');
    Route::get('/my-domains/{domain}/get-auth-code', [\App\Http\Controllers\Client\DomainController::class, 'getAuthCode'])->name('client.domains.get-auth-code');
    Route::post('/my-domains/{domain}/setup-cloudflare', [\App\Http\Controllers\Client\DomainController::class, 'setupCloudflare'])->name('client.domains.setup-cloudflare');
    Route::get('/my-domains/{domain}/dns-records', [\App\Http\Controllers\Client\DomainController::class, 'getDnsRecords'])->name('client.domains.dns-records');
    Route::post('/my-domains/{domain}/dns-records', [\App\Http\Controllers\Client\DomainController::class, 'addDnsRecord'])->name('client.domains.dns-records.add');
    Route::put('/my-domains/{domain}/dns-records/{recordId}', [\App\Http\Controllers\Client\DomainController::class, 'updateDnsRecord'])->name('client.domains.dns-records.update');
    Route::delete('/my-domains/{domain}/dns-records/{recordId}', [\App\Http\Controllers\Client\DomainController::class, 'deleteDnsRecord'])->name('client.domains.dns-records.delete');
    Route::get('/my-domains/{domain}/health-check', [\App\Http\Controllers\Client\DomainController::class, 'healthCheck'])->name('client.domains.health-check');
    Route::get('/my-domains/{domain}/activity-log', [\App\Http\Controllers\Client\DomainController::class, 'activityLog'])->name('client.domains.activity-log');

    Route::get('/settings', [\App\Http\Controllers\Client\SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [\App\Http\Controllers\Client\SettingsController::class, 'update'])->name('client.settings.update');
    Route::post('/settings/verify-current-password', [\App\Http\Controllers\Client\SettingsController::class, 'verifyCurrentPassword'])->name('settings.verify-current-password');

    // Two-Factor Authentication Routes
    Route::post('/settings/2fa/send-enable-code', [\App\Http\Controllers\Client\SettingsController::class, 'sendEnableCode'])->name('settings.2fa.send-enable-code');
    Route::post('/settings/2fa/enable', [\App\Http\Controllers\Client\SettingsController::class, 'enable2FA'])->name('settings.2fa.enable');
    Route::post('/settings/2fa/verify', [\App\Http\Controllers\Client\SettingsController::class, 'verify2FA'])->name('settings.2fa.verify');
    Route::post('/settings/2fa/send-disable-code', [\App\Http\Controllers\Client\SettingsController::class, 'sendDisableCode'])->name('settings.2fa.send-disable-code');
    Route::post('/settings/2fa/disable', [\App\Http\Controllers\Client\SettingsController::class, 'disable2FA'])->name('settings.2fa.disable');
    Route::post('/settings/2fa/send-regenerate-code', [\App\Http\Controllers\Client\SettingsController::class, 'sendRegenerateCode'])->name('settings.2fa.send-regenerate-code');
    Route::post('/settings/2fa/regenerate-codes', [\App\Http\Controllers\Client\SettingsController::class, 'regenerateBackupCodes'])->name('settings.2fa.regenerate');

    // Active Sessions Routes
    Route::delete('/settings/sessions/{sessionId}', [\App\Http\Controllers\Client\SettingsController::class, 'deleteSession'])->name('settings.sessions.delete');

    // Language Preference Route
    Route::post('/settings/language', [\App\Http\Controllers\Client\SettingsController::class, 'updateLanguage'])->name('settings.language.update');

    // Social Accounts Disconnect Routes
    Route::delete('/settings/disconnect/google', [\App\Http\Controllers\Client\SettingsController::class, 'disconnectGoogle'])->name('settings.disconnect.google');
    Route::delete('/settings/disconnect/github', [\App\Http\Controllers\Client\SettingsController::class, 'disconnectGithub'])->name('settings.disconnect.github');
    Route::delete('/settings/disconnect/linkedin', [\App\Http\Controllers\Client\SettingsController::class, 'disconnectLinkedin'])->name('settings.disconnect.linkedin');

    // Hosting Services Routes
    Route::get('/services/hosting', [\App\Http\Controllers\Client\HostingController::class, 'index'])->name('client.hosting.index');
    
    // Reseller Hosting - Separate Controller (manual setup by admin)
    Route::get('/services/reseller', [\App\Http\Controllers\Client\ResellerHostingController::class, 'index'])->name('client.hosting.reseller');
    Route::get('/services/reseller/{id}', [\App\Http\Controllers\Client\ResellerHostingController::class, 'show'])->name('client.hosting.reseller.show');
    Route::get('/services/reseller/{id}/whm-login', [\App\Http\Controllers\Client\ResellerHostingController::class, 'loginWhm'])->name('client.hosting.reseller.whm');
    
    Route::get('/services/cloud-hosting', [\App\Http\Controllers\Client\HostingController::class, 'cloudHosting'])->name('client.hosting.cloud');
    Route::get('/services/vps', [\App\Http\Controllers\Client\HostingController::class, 'vpsHosting'])->name('client.hosting.vps');
    Route::get('/services/dedicated', [\App\Http\Controllers\Client\HostingController::class, 'dedicatedServers'])->name('client.hosting.dedicated');
    Route::get('/services/dedicated/{id}', [\App\Http\Controllers\Client\HostingController::class, 'showDedicated'])->name('client.hosting.dedicated.show');
    Route::post('/services/dedicated/{id}/action', [\App\Http\Controllers\Client\HostingController::class, 'dedicatedAction'])->name('client.hosting.dedicated.action');
    Route::get('/services/dedicated/{id}/status', [\App\Http\Controllers\Client\HostingController::class, 'dedicatedStatus'])->name('client.hosting.dedicated.status');
    Route::get('/services/dedicated/{id}/activities', [\App\Http\Controllers\Client\HostingController::class, 'dedicatedActivities'])->name('client.hosting.dedicated.activities');
    Route::get('/services/dedicated/{id}/metrics', [\App\Http\Controllers\Client\HostingController::class, 'dedicatedMetrics'])->name('client.hosting.dedicated.metrics');
    Route::get('/services/dedicated/{id}/backups', [\App\Http\Controllers\Client\HostingController::class, 'dedicatedBackups'])->name('client.hosting.dedicated.backups');
    Route::get('/services/dedicated/{id}/backups/cost', [\App\Http\Controllers\Client\HostingController::class, 'dedicatedBackupCost'])->name('client.hosting.dedicated.backups.cost');
    Route::post('/services/dedicated/{id}/backups/enable', [\App\Http\Controllers\Client\HostingController::class, 'dedicatedEnableBackups'])->name('client.hosting.dedicated.backups.enable');

    // Dedicated Snapshots Routes
    Route::get('/services/dedicated/{id}/snapshots', [\App\Http\Controllers\Client\HostingController::class, 'dedicatedSnapshots'])->name('client.hosting.dedicated.snapshots');
    Route::get('/services/dedicated/{id}/snapshots/cost', [\App\Http\Controllers\Client\HostingController::class, 'dedicatedSnapshotCost'])->name('client.hosting.dedicated.snapshots.cost');
    Route::post('/services/dedicated/{id}/snapshots/create', [\App\Http\Controllers\Client\HostingController::class, 'dedicatedCreateSnapshot'])->name('client.hosting.dedicated.snapshots.create');
    Route::delete('/services/dedicated/{id}/snapshots/{snapshotId}', [\App\Http\Controllers\Client\HostingController::class, 'dedicatedDeleteSnapshot'])->name('client.hosting.dedicated.snapshots.delete');

    // Dedicated Network Routes
    Route::get('/services/dedicated/{id}/network', [\App\Http\Controllers\Client\HostingController::class, 'dedicatedNetwork'])->name('client.hosting.dedicated.network');
    Route::post('/services/dedicated/{id}/network/reverse-dns', [\App\Http\Controllers\Client\HostingController::class, 'dedicatedUpdateReverseDns'])->name('client.hosting.dedicated.network.reverse-dns');
    Route::post('/services/dedicated/{id}/network/floating-ip', [\App\Http\Controllers\Client\HostingController::class, 'dedicatedCreateFloatingIP'])->name('client.hosting.dedicated.network.floating-ip.create');
    Route::delete('/services/dedicated/{id}/network/floating-ip/{floatingIpId}', [\App\Http\Controllers\Client\HostingController::class, 'dedicatedDeleteFloatingIP'])->name('client.hosting.dedicated.network.floating-ip.delete');

    // Dedicated ISO Images Routes
    Route::get('/services/dedicated/{id}/iso-images', [\App\Http\Controllers\Client\HostingController::class, 'dedicatedIsoImages'])->name('client.hosting.dedicated.iso-images');
    Route::post('/services/dedicated/{id}/iso-images/mount', [\App\Http\Controllers\Client\HostingController::class, 'dedicatedMountIso'])->name('client.hosting.dedicated.iso-images.mount');
    Route::post('/services/dedicated/{id}/iso-images/unmount', [\App\Http\Controllers\Client\HostingController::class, 'dedicatedUnmountIso'])->name('client.hosting.dedicated.iso-images.unmount');

    // Dedicated Console Route
    Route::get('/services/dedicated/{id}/console', [\App\Http\Controllers\Client\HostingController::class, 'dedicatedConsole'])->name('client.hosting.dedicated.console');

    Route::get('/services/vps/{id}', [\App\Http\Controllers\Client\HostingController::class, 'showVps'])->name('client.hosting.vps.show');
    Route::post('/services/vps/{id}/action', [\App\Http\Controllers\Client\HostingController::class, 'vpsAction'])->name('client.hosting.vps.action');
    Route::get('/services/vps/{id}/status', [\App\Http\Controllers\Client\HostingController::class, 'vpsStatus'])->name('client.hosting.vps.status');
    Route::post('/services/vps/{id}/snapshot', [\App\Http\Controllers\Client\HostingController::class, 'vpsCreateSnapshot'])->name('client.hosting.vps.snapshot');
    Route::get('/services/vps/{id}/resources', [\App\Http\Controllers\Client\HostingController::class, 'vpsResources'])->name('client.hosting.vps.resources');
    Route::get('/services/vps/{id}/activities', [\App\Http\Controllers\Client\HostingController::class, 'vpsActivities'])->name('client.hosting.vps.activities');
    Route::get('/services/vps/{id}/graphs', [\App\Http\Controllers\Client\HostingController::class, 'vpsGraphs'])->name('client.hosting.vps.graphs');
    Route::get('/services/vps/{id}/backup-status', [\App\Http\Controllers\Client\HostingController::class, 'backupStatus'])->name('client.hosting.vps.backup.status');
    Route::post('/services/vps/{id}/enable-backups', [\App\Http\Controllers\Client\HostingController::class, 'enableBackups'])->name('client.hosting.vps.backup.enable');
    Route::post('/services/vps/{id}/create-backup', [\App\Http\Controllers\Client\HostingController::class, 'createBackup'])->name('client.hosting.vps.backup.create');
    Route::post('/services/vps/{id}/restore-backup/{backupId}', [\App\Http\Controllers\Client\HostingController::class, 'restoreBackup'])->name('client.hosting.vps.backup.restore');
    Route::delete('/services/vps/{id}/delete-backup/{backupId}', [\App\Http\Controllers\Client\HostingController::class, 'deleteBackup'])->name('client.hosting.vps.backup.delete');
    Route::get('/services/vps/{id}/snapshots', [\App\Http\Controllers\Client\HostingController::class, 'getSnapshots'])->name('client.hosting.vps.snapshots.list');
    Route::post('/services/vps/{id}/create-snapshot', [\App\Http\Controllers\Client\HostingController::class, 'createSnapshot'])->name('client.hosting.vps.snapshots.create');
    Route::delete('/services/vps/{id}/delete-snapshot/{snapshotId}', [\App\Http\Controllers\Client\HostingController::class, 'deleteSnapshot'])->name('client.hosting.vps.snapshots.delete');
    Route::get('/services/vps/{id}/network', [\App\Http\Controllers\Client\HostingController::class, 'getNetwork'])->name('client.hosting.vps.network');
    Route::post('/services/vps/{id}/network/reverse-dns', [\App\Http\Controllers\Client\HostingController::class, 'updateReverseDns'])->name('client.hosting.vps.network.reverse-dns');
    Route::get('/services/vps/{id}/hetzner-locations', [\App\Http\Controllers\Client\HostingController::class, 'getHetznerLocations'])->name('client.hosting.vps.hetzner-locations');
    Route::post('/services/vps/{id}/floating-ip', [\App\Http\Controllers\Client\HostingController::class, 'createFloatingIP'])->name('client.hosting.vps.floating-ip.create');
    Route::delete('/services/vps/{id}/floating-ip/{floatingIpId}', [\App\Http\Controllers\Client\HostingController::class, 'deleteFloatingIP'])->name('client.hosting.vps.floating-ip.delete');
    Route::get('/services/vps/{id}/floating-ip/success', [\App\Http\Controllers\Client\HostingController::class, 'floatingIPSuccess'])->name('client.hosting.vps.floating-ip.success');
    Route::get('/services/vps/{id}/floating-ip/failed', [\App\Http\Controllers\Client\HostingController::class, 'floatingIPFailed'])->name('client.hosting.vps.floating-ip.failed');
    Route::get('/services/vps/{id}/floating-ip/pending', [\App\Http\Controllers\Client\HostingController::class, 'floatingIPPending'])->name('client.hosting.vps.floating-ip.pending');
    Route::get('/services/vps/{id}/iso-images', [\App\Http\Controllers\Client\HostingController::class, 'getISOImages'])->name('client.hosting.vps.iso-images');
    Route::post('/services/vps/{id}/iso/mount', [\App\Http\Controllers\Client\HostingController::class, 'mountISO'])->name('client.hosting.vps.iso.mount');
    Route::post('/services/vps/{id}/iso/unmount', [\App\Http\Controllers\Client\HostingController::class, 'unmountISO'])->name('client.hosting.vps.iso.unmount');
    Route::get('/services/vps/{id}/console', [\App\Http\Controllers\Client\HostingController::class, 'getConsole'])->name('client.hosting.vps.console');
    Route::get('/services/hosting/{id}', [\App\Http\Controllers\Client\HostingController::class, 'show'])->name('client.hosting.show');
    Route::get('/services/cloud-hosting/{id}', [\App\Http\Controllers\Client\HostingController::class, 'showCloud'])->name('client.hosting.cloud.show');
    Route::get('/services/hosting/{id}/cpanel', [\App\Http\Controllers\Client\HostingController::class, 'loginCpanel'])->name('client.hosting.cpanel');
    Route::get('/services/hosting/{id}/cpanel/ssl', [\App\Http\Controllers\Client\HostingController::class, 'loginCpanelSSL'])->name('client.hosting.cpanel.ssl');
    Route::get('/services/hosting/{id}/cpanel/ftp', [\App\Http\Controllers\Client\HostingController::class, 'loginCpanelFTP'])->name('client.hosting.cpanel.ftp');
    Route::get('/services/hosting/{id}/cpanel/database', [\App\Http\Controllers\Client\HostingController::class, 'loginCpanelDatabase'])->name('client.hosting.cpanel.database');
    Route::get('/services/hosting/{id}/cpanel/domains', [\App\Http\Controllers\Client\HostingController::class, 'loginCpanelDomains'])->name('client.hosting.cpanel.domains');
    Route::get('/services/hosting/{id}/cpanel/email-accounts', [\App\Http\Controllers\Client\HostingController::class, 'loginCpanelEmailAccounts'])->name('client.hosting.cpanel.email.accounts');
    Route::get('/services/hosting/{id}/stats', [\App\Http\Controllers\Client\HostingController::class, 'getStats'])->name('client.hosting.stats');
    Route::post('/services/hosting/{id}/send-cancellation-code', [\App\Http\Controllers\Client\HostingController::class, 'sendCancellationCode'])->name('client.hosting.send-cancellation-code');
    Route::post('/services/hosting/{id}/verify-cancellation', [\App\Http\Controllers\Client\HostingController::class, 'verifyCancellation'])->name('client.hosting.verify-cancellation');

    // Quick Access Routes
    Route::get('/services/hosting/{id}/file-manager', [\App\Http\Controllers\Client\HostingController::class, 'loginFileManager'])->name('client.hosting.file.manager');
    Route::get('/services/hosting/{id}/databases', [\App\Http\Controllers\Client\HostingController::class, 'loginDatabases'])->name('client.hosting.databases');
    Route::get('/services/hosting/{id}/php-selector', [\App\Http\Controllers\Client\HostingController::class, 'loginPHPSelector'])->name('client.hosting.php.selector');
    Route::get('/services/hosting/{id}/webmail', [\App\Http\Controllers\Client\HostingController::class, 'loginWebmail'])->name('client.hosting.webmail');
    Route::get('/services/hosting/{id}/wordpress', [\App\Http\Controllers\Client\HostingController::class, 'loginWordPress'])->name('client.hosting.wordpress');
    Route::get('/services/hosting/{id}/modsecurity', [\App\Http\Controllers\Client\HostingController::class, 'loginModSecurity'])->name('client.hosting.modsecurity');
    Route::get('/services/hosting/{id}/sitejet', [\App\Http\Controllers\Client\HostingController::class, 'loginSitejet'])->name('client.hosting.sitejet');
    Route::get('/services/hosting/{id}/sitepad', [\App\Http\Controllers\Client\HostingController::class, 'loginSitepad'])->name('client.hosting.sitepad');
    Route::get('/services/hosting/{id}/social', [\App\Http\Controllers\Client\HostingController::class, 'loginSocialBee'])->name('client.hosting.social');

    // cPanel Password Management
    Route::post('/services/hosting/{id}/change-password', [\App\Http\Controllers\Client\HostingController::class, 'changePassword'])->name('client.hosting.change-password');

    // Email Management Routes
    Route::get('/services/hosting/{id}/emails', [\App\Http\Controllers\Client\HostingController::class, 'listEmails'])->name('client.hosting.emails.list');
    Route::get('/services/hosting/{id}/domains', [\App\Http\Controllers\Client\HostingController::class, 'getDomains'])->name('client.hosting.domains.list');
    Route::post('/services/hosting/{id}/emails', [\App\Http\Controllers\Client\HostingController::class, 'createEmail'])->name('client.hosting.emails.create');
    Route::post('/services/hosting/{id}/emails/delete', [\App\Http\Controllers\Client\HostingController::class, 'deleteEmail'])->name('client.hosting.emails.delete');

    // FTP Management Routes
    Route::get('/services/hosting/{id}/ftp', [\App\Http\Controllers\Client\HostingController::class, 'listFtp'])->name('client.hosting.ftp.list');
    Route::post('/services/hosting/{id}/ftp', [\App\Http\Controllers\Client\HostingController::class, 'createFtp'])->name('client.hosting.ftp.create');
    Route::delete('/services/hosting/{id}/ftp', [\App\Http\Controllers\Client\HostingController::class, 'deleteFtp'])->name('client.hosting.ftp.delete');

    // Domains Management Routes - Addon Domains
    Route::get('/services/hosting/{id}/domains/addon', [\App\Http\Controllers\Client\HostingController::class, 'listAddonDomains'])->name('client.hosting.domains.addon.list');
    Route::post('/services/hosting/{id}/domains/addon', [\App\Http\Controllers\Client\HostingController::class, 'addAddonDomain'])->name('client.hosting.domains.addon.add');
    Route::delete('/services/hosting/{id}/domains/addon', [\App\Http\Controllers\Client\HostingController::class, 'deleteAddonDomain'])->name('client.hosting.domains.addon.delete');

    // Domains Management Routes - Subdomains
    Route::get('/services/hosting/{id}/domains/subdomains', [\App\Http\Controllers\Client\HostingController::class, 'listSubdomains'])->name('client.hosting.domains.subdomain.list');
    Route::post('/services/hosting/{id}/domains/subdomains', [\App\Http\Controllers\Client\HostingController::class, 'addSubdomain'])->name('client.hosting.domains.subdomain.add');
    Route::delete('/services/hosting/{id}/domains/subdomains', [\App\Http\Controllers\Client\HostingController::class, 'deleteSubdomain'])->name('client.hosting.domains.subdomain.delete');

    // Zone Editor (DNS) Routes
    Route::get('/services/hosting/{id}/dns/zones', [\App\Http\Controllers\Client\HostingController::class, 'listZones'])->name('client.hosting.dns.zones.list');
    Route::post('/services/hosting/{id}/dns/records', [\App\Http\Controllers\Client\HostingController::class, 'getZoneRecords'])->name('client.hosting.dns.records.get');
    Route::post('/services/hosting/{id}/dns/records/add', [\App\Http\Controllers\Client\HostingController::class, 'addZoneRecord'])->name('client.hosting.dns.records.add');

    // SSL/TLS Routes
    Route::get('/services/hosting/{id}/ssl/certificates', [\App\Http\Controllers\Client\HostingController::class, 'listSSLCertificates'])->name('client.hosting.ssl.certificates.list');
    Route::get('/services/hosting/{id}/ssl/status', [\App\Http\Controllers\Client\HostingController::class, 'getSSLStatus'])->name('client.hosting.ssl.status');
    Route::post('/services/hosting/{id}/ssl/autossl', [\App\Http\Controllers\Client\HostingController::class, 'installAutoSSL'])->name('client.hosting.ssl.autossl');

    // PHP Selector Routes
    Route::get('/services/hosting/{id}/php/selector', [\App\Http\Controllers\Client\HostingController::class, 'loginPHPSelector'])->name('client.hosting.php.selector');
    Route::get('/services/hosting/{id}/php/versions', [\App\Http\Controllers\Client\HostingController::class, 'getAvailablePHPVersions'])->name('client.hosting.php.versions');
    Route::get('/services/hosting/{id}/php/current', [\App\Http\Controllers\Client\HostingController::class, 'getCurrentPHPVersion'])->name('client.hosting.php.current');
    Route::post('/services/hosting/{id}/php/set', [\App\Http\Controllers\Client\HostingController::class, 'setPHPVersion'])->name('client.hosting.php.set');

    // Database Wizard Routes
    Route::post('/services/hosting/{id}/database/create', [\App\Http\Controllers\Client\HostingController::class, 'createDatabase'])->name('client.hosting.create-database');
    Route::post('/services/hosting/{id}/database/user/create', [\App\Http\Controllers\Client\HostingController::class, 'createDatabaseUser'])->name('client.hosting.create-database-user');
    Route::post('/services/hosting/{id}/database/privileges/assign', [\App\Http\Controllers\Client\HostingController::class, 'assignDatabasePrivileges'])->name('client.hosting.assign-database-privileges');

    // Invoice Routes
    Route::get('/invoices', [\App\Http\Controllers\Client\InvoiceController::class, 'index'])->name('client.invoices');
    Route::get('/invoices/{id}', [\App\Http\Controllers\Client\InvoiceController::class, 'show'])->name('client.invoices.show');
    Route::get('/invoices/{id}/download', [\App\Http\Controllers\Client\InvoiceController::class, 'download'])->name('client.invoices.download');

    // Wallet Routes
    Route::get('/wallet', [\App\Http\Controllers\Client\WalletController::class, 'index'])->name('client.wallet');
    Route::get('/wallet/add-funds', [\App\Http\Controllers\Client\WalletController::class, 'addFunds'])->name('client.wallet.add-funds');
    Route::post('/wallet/add-funds', [\App\Http\Controllers\Client\WalletController::class, 'storeFunds'])->name('client.wallet.store-funds');

    // Card Verification Routes
    Route::post('/wallet/send-card-otp', [\App\Http\Controllers\Client\WalletController::class, 'sendCardOtp'])->name('client.wallet.send-card-otp');
    Route::post('/wallet/verify-card-otp', [\App\Http\Controllers\Client\WalletController::class, 'verifyCardOtp'])->name('client.wallet.verify-card-otp');

    // Wallet Transfer Routes
    Route::get('/wallet/transfer', [\App\Http\Controllers\Client\WalletController::class, 'showTransferForm'])->name('client.wallet.transfer-form');
    Route::post('/wallet/verify-receiver', [\App\Http\Controllers\Client\WalletController::class, 'verifyReceiver'])->name('client.wallet.verify-receiver');
    Route::post('/wallet/send-transfer-otp', [\App\Http\Controllers\Client\WalletController::class, 'sendTransferOtp'])->name('client.wallet.send-transfer-otp');
    Route::post('/wallet/transfer', [\App\Http\Controllers\Client\WalletController::class, 'processTransfer'])->name('client.wallet.transfer');

    // Payment Callback Routes
    Route::get('/wallet/payment/success', [\App\Http\Controllers\Client\WalletController::class, 'paymentSuccess'])->name('client.wallet.payment.success');
    Route::get('/wallet/payment/failed', [\App\Http\Controllers\Client\WalletController::class, 'paymentFailed'])->name('client.wallet.payment.failed');
    Route::get('/wallet/payment/pending', [\App\Http\Controllers\Client\WalletController::class, 'paymentPending'])->name('client.wallet.payment.pending');
    Route::get('/wallet/payment/cancelled', [\App\Http\Controllers\Client\WalletController::class, 'paymentCancelled'])->name('client.wallet.payment.cancelled');

    // Account Statement Routes
    Route::get('/account-statement', [\App\Http\Controllers\Client\AccountStatementController::class, 'index'])->name('client.account-statement');
    Route::get('/account-statement/pdf', [\App\Http\Controllers\Client\AccountStatementController::class, 'downloadPdf'])->name('client.account-statement.pdf');

    // Affiliate Routes
    Route::get('/affiliate', [\App\Http\Controllers\Client\AffiliateController::class, 'index'])->name('client.affiliate');
    Route::post('/affiliate/activate', [\App\Http\Controllers\Client\AffiliateController::class, 'activate'])->name('client.affiliate.activate');
    Route::get('/affiliate/stats', [\App\Http\Controllers\Client\AffiliateController::class, 'stats'])->name('client.affiliate.stats');
    Route::get('/affiliate/live-visitors', [\App\Http\Controllers\Client\AffiliateController::class, 'liveVisitors'])->name('client.affiliate.live-visitors');
    Route::get('/affiliate/faqs', [\App\Http\Controllers\Client\AffiliateController::class, 'faqs'])->name('client.affiliate.faqs');
    Route::post('/affiliate/request-payout', [\App\Http\Controllers\Client\AffiliateController::class, 'requestPayout'])->name('client.affiliate.request-payout');
    Route::post('/affiliate/payment-settings', [\App\Http\Controllers\Client\AffiliateController::class, 'updatePaymentSettings'])->name('client.affiliate.payment-settings');

    // Affiliate Campaign Routes
    Route::get('/affiliate/campaigns', [\App\Http\Controllers\Client\AffiliateController::class, 'campaigns'])->name('client.affiliate.campaigns');
    Route::post('/affiliate/campaigns', [\App\Http\Controllers\Client\AffiliateController::class, 'storeCampaign'])->name('client.affiliate.campaigns.store');
    Route::put('/affiliate/campaigns/{id}/status', [\App\Http\Controllers\Client\AffiliateController::class, 'updateCampaignStatus'])->name('client.affiliate.campaigns.status');
    Route::delete('/affiliate/campaigns/{id}', [\App\Http\Controllers\Client\AffiliateController::class, 'deleteCampaign'])->name('client.affiliate.campaigns.delete');
    Route::get('/affiliate/campaigns/{id}/stats', [\App\Http\Controllers\Client\AffiliateController::class, 'campaignStats'])->name('client.affiliate.campaigns.stats');

    // Notification Routes
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\Client\NotificationController::class, 'markAsRead'])->name('client.notifications.mark-read');
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\Client\NotificationController::class, 'markAllAsRead'])->name('client.notifications.mark-all-read');

    // Support Tickets Routes
    Route::prefix('tickets')->name('client.tickets.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Client\TicketController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Client\TicketController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Client\TicketController::class, 'store'])->name('store');
        Route::get('/{ticket}', [\App\Http\Controllers\Client\TicketController::class, 'show'])->name('show');
        Route::post('/{ticket}/reply', [\App\Http\Controllers\Client\TicketController::class, 'reply'])->name('reply');
        Route::post('/{ticket}/close', [\App\Http\Controllers\Client\TicketController::class, 'close'])->name('close');
        Route::post('/{ticket}/reopen', [\App\Http\Controllers\Client\TicketController::class, 'reopen'])->name('reopen');
        Route::post('/reply/{reply}/rate', [\App\Http\Controllers\Client\TicketController::class, 'rateReply'])->name('reply.rate');
        Route::get('/attachment/{attachment}/download', [\App\Http\Controllers\Client\TicketController::class, 'downloadAttachment'])->name('attachment.download');
        Route::post('/upload-image', [\App\Http\Controllers\Client\TicketController::class, 'uploadImage'])->name('upload.image');
    });
});

// VPS Hosting Page
Route::get('/vps-hosting', [\App\Http\Controllers\Frontend\VpsHostingController::class, 'index'])->name('vps.hosting');
Route::get('/vps-hosting/configure/{vpsPlan}', [\App\Http\Controllers\Frontend\VpsHostingController::class, 'configure'])->name('vps.configure');

// Dedicated Servers Page
Route::get('/dedicated-servers', [\App\Http\Controllers\Frontend\DedicatedServerController::class, 'index'])->name('dedicated.servers');
Route::get('/dedicated-servers/configure/{dedicatedPlan}', [\App\Http\Controllers\Frontend\DedicatedServerController::class, 'configure'])->name('dedicated.configure');

// Careers Page
Route::get('/careers', [\App\Http\Controllers\Frontend\CareersController::class, 'index'])->name('careers');

// About Us Page
Route::get('/about', [\App\Http\Controllers\Frontend\AboutController::class, 'index'])->name('about');

// Include test routes for coupons
if (file_exists(__DIR__ . '/test_coupons.php')) {
    require __DIR__ . '/test_coupons.php';
}

// Temporary debug route for Dynadot pricing
Route::get('/dynadot-pricing-debug', function() {
    $registrar = \App\Models\DomainRegistrar::where('type', 'dynadot')->where('status', 1)->first();
    if (!$registrar) {
        return response()->json(['error' => 'Dynadot not configured']);
    }
    $service = new \App\Services\DynadotService($registrar);
    try {
        $reflection = new ReflectionClass($service);
        $method = $reflection->getMethod('makeV3Request');
        $method->setAccessible(true);
        $result = $method->invoke($service, 'tld_price', ['currency' => 'USD']);
        return response()->json($result, 200, [], JSON_PRETTY_PRINT);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
    }
});

// Language switching route
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, config('app.supported_locales'))) {
        Session::put('locale', $locale);
        App::setLocale($locale);

        // Update client's preferred language if authenticated
        if (Auth::guard('client')->check()) {
            $client = Auth::guard('client')->user();
            $client->preferred_language = $locale;
            $client->save();
        }
        // Update admin's preferred language if authenticated
        elseif (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();
            $admin->preferred_language = $locale;
            $admin->save();
        }
        // Update web user's preferred language if authenticated
        elseif (auth()->check()) {
            $user = auth()->user();
            $user->preferred_language = $locale;
            $user->save();
        }
    }
    return redirect()->back();
})->name('language.switch');

// Currency switching route
Route::get('/currency/{currency}', function ($currency) {
    if (in_array($currency, config('app.supported_currencies'))) {
        Session::put('currency', $currency);
    }
    return redirect()->back();
})->name('currency.switch');

// Dynadot Debug Route (temporary)
Route::get('/dynadot-debug', function () {
    $registrar = \App\Models\DomainRegistrar::where('type', 'dynadot')->first();

    if (!$registrar) {
        return response()->json(['error' => 'No Dynadot configuration found']);
    }

    $url = $registrar->test_mode
        ? 'https://api-sandbox.dynadot.com/api3.json'
        : 'https://api.dynadot.com/api3.json';

    $params = [
        'key' => $registrar->api_key,
        'command' => 'account_info'
    ];

    try {
        $response = Http::timeout(30)->get($url, $params);
        $data = $response->json();

        return response()->json([
            'status' => 'success',
            'server_ip' => request()->ip(),
            'public_ip' => @file_get_contents('https://ifconfig.me'),
            'test_mode' => $registrar->test_mode,
            'api_url' => $url,
            'response' => $data,
            'http_status' => $response->status(),
        ], 200, [], JSON_PRETTY_PRINT);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'server_ip' => request()->ip(),
            'public_ip' => @file_get_contents('https://ifconfig.me'),
            'test_mode' => $registrar->test_mode,
            'api_url' => $url,
            'error' => $e->getMessage(),
        ], 200, [], JSON_PRETTY_PRINT);
    }
})->name('dynadot.debug');

// Admin Routes
Route::prefix('unleasha')->name('admin.')->group(function () {
    // Admin Auth Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Password Reset Routes
    Route::get('/forgot-password', [LoginController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [LoginController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [LoginController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [LoginController::class, 'resetPassword'])->name('password.update');

    // Location logging route
    Route::post('/log-location', [LoginController::class, 'logLocation'])->name('log.location');

    // Protected Admin Routes
    Route::middleware('admin.auth')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        // Client Management Routes
        Route::post('clients/check-username', [\App\Http\Controllers\Admin\ClientController::class, 'checkUsername'])->name('clients.check-username');
        Route::post('clients/check-email', [\App\Http\Controllers\Admin\ClientController::class, 'checkEmail'])->name('clients.check-email');
        Route::post('clients/check-password', [\App\Http\Controllers\Admin\ClientController::class, 'checkPasswordCompromised'])->name('clients.check-password');
        Route::post('clients/validate-phone', [\App\Http\Controllers\Admin\ClientController::class, 'validatePhone'])->name('clients.validate-phone');
        Route::post('clients/send-otp', [\App\Http\Controllers\Admin\ClientController::class, 'sendOTP'])->name('clients.send-otp');
        Route::post('clients/verify-otp', [\App\Http\Controllers\Admin\ClientController::class, 'verifyOTP'])->name('clients.verify-otp');
        Route::get('clients/{client}/support-pin', [\App\Http\Controllers\Admin\ClientController::class, 'getSupportPin'])->name('clients.support-pin');
        Route::get('clients/{client}/online-status', [\App\Http\Controllers\Admin\ClientController::class, 'getOnlineStatus'])->name('clients.online-status');
        Route::get('clients/{client}/login-activities', [\App\Http\Controllers\Admin\ClientController::class, 'getLoginActivities'])->name('clients.login-activities');
        Route::get('clients/{client}/statement', [\App\Http\Controllers\Admin\ClientController::class, 'statement'])->name('clients.statement');
        Route::get('clients/{client}/statement/pdf', [\App\Http\Controllers\Admin\ClientController::class, 'statementPdf'])->name('clients.statement.pdf');
        Route::get('clients/{client}/wallet', [\App\Http\Controllers\Admin\ClientController::class, 'wallet'])->name('clients.wallet');
        Route::get('clients/{client}/wallet/transaction/{transaction}', [\App\Http\Controllers\Admin\ClientController::class, 'walletTransaction'])->name('clients.wallet.transaction');
        Route::post('clients/{client}/wallet/add-credit', [\App\Http\Controllers\Admin\ClientController::class, 'addWalletCredit'])->name('clients.wallet.add-credit');
        Route::post('clients/{client}/wallet/deduct-credit', [\App\Http\Controllers\Admin\ClientController::class, 'deductWalletCredit'])->name('clients.wallet.deduct-credit');
        Route::get('invoices/{invoice}', [\App\Http\Controllers\Admin\ClientController::class, 'showInvoice'])->name('invoices.show');
        Route::post('clients/{client}/verify-document', [\App\Http\Controllers\Admin\ClientController::class, 'verifyDocument'])->name('clients.verify-document');
        Route::post('clients/{client}/verify-document-id', [\App\Http\Controllers\Admin\ClientController::class, 'verifyDocumentById'])->name('clients.verify-document-id');
        Route::post('clients/{client}/activate-affiliate', [\App\Http\Controllers\Admin\ClientController::class, 'activateAffiliate'])->name('clients.activate-affiliate');
        Route::get('clients/{client}/affiliate', [\App\Http\Controllers\Admin\ClientController::class, 'affiliateDetails'])->name('clients.affiliate');
        Route::patch('clients/{client}/affiliate/tier', [\App\Http\Controllers\Admin\ClientController::class, 'updateAffiliateTier'])->name('clients.updateAffiliateTier');
        Route::post('clients/{client}/affiliate/add-balance', [\App\Http\Controllers\Admin\ClientController::class, 'addAffiliateBalance'])->name('clients.addAffiliateBalance');
        Route::post('clients/{client}/affiliate/deduct-balance', [\App\Http\Controllers\Admin\ClientController::class, 'deductAffiliateBalance'])->name('clients.deductAffiliateBalance');
        Route::post('clients/{client}/close-account', [\App\Http\Controllers\Admin\ClientController::class, 'closeAccount'])->name('clients.close-account');
        Route::post('clients/{client}/update-email', [\App\Http\Controllers\Admin\ClientController::class, 'updateEmail'])->name('clients.update-email');
        Route::resource('clients', \App\Http\Controllers\Admin\ClientController::class);

        // Support Tickets Routes
        Route::prefix('tickets')->name('tickets.')->group(function () {
            Route::get('/overview', [\App\Http\Controllers\Admin\TicketController::class, 'overview'])->name('overview');
            Route::get('/', [\App\Http\Controllers\Admin\TicketController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\TicketController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\TicketController::class, 'store'])->name('store');
            Route::get('/departments', [\App\Http\Controllers\Admin\TicketController::class, 'departments'])->name('departments');
            Route::post('/departments', [\App\Http\Controllers\Admin\TicketController::class, 'storeDepartment'])->name('departments.store');
            Route::put('/departments/{department}', [\App\Http\Controllers\Admin\TicketController::class, 'updateDepartment'])->name('departments.update');
            Route::delete('/departments/{department}', [\App\Http\Controllers\Admin\TicketController::class, 'destroyDepartment'])->name('departments.destroy');
            Route::get('/{ticket}', [\App\Http\Controllers\Admin\TicketController::class, 'show'])->name('show');
            Route::post('/{ticket}/reply', [\App\Http\Controllers\Admin\TicketController::class, 'reply'])->name('reply');
            Route::post('/{ticket}/toggle-flag', [\App\Http\Controllers\Admin\TicketController::class, 'toggleFlag'])->name('toggle-flag');
            Route::put('/{ticket}', [\App\Http\Controllers\Admin\TicketController::class, 'update'])->name('update');
            Route::delete('/{ticket}', [\App\Http\Controllers\Admin\TicketController::class, 'destroy'])->name('destroy');
            Route::get('/attachment/{attachment}/download', [\App\Http\Controllers\Admin\TicketController::class, 'downloadAttachment'])->name('attachment.download');
        });

        // Predefined Replies Routes
        Route::resource('predefined-replies', \App\Http\Controllers\Admin\PredefinedReplyController::class)->except(['show']);
        Route::get('predefined-replies/get-for-department', [\App\Http\Controllers\Admin\PredefinedReplyController::class, 'getForDepartment'])->name('predefined-replies.for-department');

        // Domain Management Routes
        Route::resource('domains', \App\Http\Controllers\Admin\DomainController::class)->except(['create', 'store']);
        Route::post('domains/{domain}/sync', [\App\Http\Controllers\Admin\DomainController::class, 'sync'])->name('domains.sync');

        // Service Management Routes
        Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class)->except(['create', 'store']);
        Route::get('services/reseller/{service}', [\App\Http\Controllers\Admin\ServiceController::class, 'showReseller'])->name('services.reseller.show');
        Route::put('services/{service}/update-whm-credentials', [\App\Http\Controllers\Admin\ServiceController::class, 'updateWhmCredentials'])->name('services.update-whm-credentials');
        Route::put('services/{service}/update-cpanel-accounts', [\App\Http\Controllers\Admin\ServiceController::class, 'updateCpanelAccounts'])->name('services.update-cpanel-accounts');
        Route::post('services/{service}/update-status', [\App\Http\Controllers\Admin\ServiceController::class, 'updateStatus'])->name('services.update-status');
        Route::post('services/{service}/suspend', [\App\Http\Controllers\Admin\ServiceController::class, 'suspend'])->name('services.suspend');
        Route::post('services/{service}/unsuspend', [\App\Http\Controllers\Admin\ServiceController::class, 'unsuspend'])->name('services.unsuspend');
        Route::post('services/{service}/terminate', [\App\Http\Controllers\Admin\ServiceController::class, 'terminate'])->name('services.terminate');
        Route::post('services/{service}/change-password', [\App\Http\Controllers\Admin\ServiceController::class, 'changePassword'])->name('services.change-password');
        Route::post('services/{service}/change-username', [\App\Http\Controllers\Admin\ServiceController::class, 'changeUsername'])->name('services.change-username');
        Route::post('services/{service}/change-package', [\App\Http\Controllers\Admin\ServiceController::class, 'changePackage'])->name('services.change-package');
        Route::post('services/{service}/change-domain', [\App\Http\Controllers\Admin\ServiceController::class, 'changeDomain'])->name('services.change-domain');
        Route::post('services/{service}/change-server', [\App\Http\Controllers\Admin\ServiceController::class, 'changeServer'])->name('services.change-server');
        Route::post('services/{service}/change-datacenter', [\App\Http\Controllers\Admin\ServiceController::class, 'changeDatacenter'])->name('services.change-datacenter');
        Route::post('services/{service}/change-recurring-amount', [\App\Http\Controllers\Admin\ServiceController::class, 'changeRecurringAmount'])->name('services.change-recurring-amount');
        Route::post('services/{service}/change-billing-cycle', [\App\Http\Controllers\Admin\ServiceController::class, 'changeBillingCycle'])->name('services.change-billing-cycle');
        Route::post('services/{service}/change-next-due-date', [\App\Http\Controllers\Admin\ServiceController::class, 'changeNextDueDate'])->name('services.change-next-due-date');
        Route::post('domains/{domain}/renew', [\App\Http\Controllers\Admin\DomainController::class, 'renew'])->name('domains.renew');
        Route::post('domains/{domain}/update-status', [\App\Http\Controllers\Admin\DomainController::class, 'updateStatus'])->name('domains.update-status');
        Route::post('domains/{domain}/update-nameservers', [\App\Http\Controllers\Admin\DomainController::class, 'updateNameservers'])->name('domains.update-nameservers');
        Route::post('domains/{domain}/update-first-payment', [\App\Http\Controllers\Admin\DomainController::class, 'updateFirstPayment'])->name('domains.update-first-payment');
        Route::post('domains/{domain}/update-recurring-amount', [\App\Http\Controllers\Admin\DomainController::class, 'updateRecurringAmount'])->name('domains.update-recurring-amount');
        Route::post('domains/{domain}/update-registration-period', [\App\Http\Controllers\Admin\DomainController::class, 'updateRegistrationPeriod'])->name('domains.update-registration-period');
        Route::post('domains/{domain}/update-expiry-date', [\App\Http\Controllers\Admin\DomainController::class, 'updateExpiryDate'])->name('domains.update-expiry-date');
        Route::post('domains/{domain}/update-next-due-date', [\App\Http\Controllers\Admin\DomainController::class, 'updateNextDueDate'])->name('domains.update-next-due-date');
        Route::post('domains/{domain}/update-domain-name', [\App\Http\Controllers\Admin\DomainController::class, 'updateDomainName'])->name('domains.update-domain-name');
        Route::post('domains/{domain}/update-auth-code', [\App\Http\Controllers\Admin\DomainController::class, 'updateAuthCode'])->name('domains.update-auth-code');
        Route::post('domains/{domain}/reset-nameservers', [\App\Http\Controllers\Admin\DomainController::class, 'resetNameservers'])->name('domains.reset-nameservers');
        Route::post('domains/{domain}/toggle-registrar-lock', [\App\Http\Controllers\Admin\DomainController::class, 'toggleRegistrarLock'])->name('domains.toggle-registrar-lock');
        Route::post('domains/{domain}/toggle-tool', [\App\Http\Controllers\Admin\DomainController::class, 'toggleTool'])->name('domains.toggle-tool');
        Route::post('domains/{domain}/fetch-dates-from-dynadot', [\App\Http\Controllers\Admin\DomainController::class, 'fetchDatesFromDynadot'])->name('domains.fetch-dates-from-dynadot');
        Route::post('domains/{domain}/fetch-nameservers-from-dynadot', [\App\Http\Controllers\Admin\DomainController::class, 'fetchNameserversFromDynadot'])->name('domains.fetch-nameservers-from-dynadot');
        Route::post('domains/{domain}/register', [\App\Http\Controllers\Admin\DomainController::class, 'register'])->name('domains.register');
        Route::post('domains/{domain}/transfer', [\App\Http\Controllers\Admin\DomainController::class, 'transfer'])->name('domains.transfer');
        Route::post('domains/{domain}/modify-contact', [\App\Http\Controllers\Admin\DomainController::class, 'modifyContactDetails'])->name('domains.modify-contact');
        Route::post('domains/{domain}/get-epp-code', [\App\Http\Controllers\Admin\DomainController::class, 'getEppCode'])->name('domains.get-epp-code');
        Route::post('domains/{domain}/request-delete', [\App\Http\Controllers\Admin\DomainController::class, 'requestDelete'])->name('domains.request-delete');
        Route::post('domains/{domain}/enable-id-protection', [\App\Http\Controllers\Admin\DomainController::class, 'enableIdProtection'])->name('domains.enable-id-protection');
        Route::post('domains/{domain}/disable-id-protection', [\App\Http\Controllers\Admin\DomainController::class, 'disableIdProtection'])->name('domains.disable-id-protection');
        Route::post('domains/{domain}/mark-contact-verified', [\App\Http\Controllers\Admin\DomainController::class, 'markContactVerified'])->name('domains.mark-contact-verified');

        // System Settings Routes
        Route::prefix('system-settings')->name('system-settings.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'index'])->name('index');
            Route::get('/general', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'general'])->name('general');
            Route::post('/general', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'saveGeneral'])->name('general.save');
            Route::post('/localisation', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'saveLocalisation'])->name('localisation.save');
            Route::get('/automation', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'automation'])->name('automation');
            Route::get('/products', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'products'])->name('products');

            // Shared Hosting Plans Routes
            Route::get('/products/shared-hosting/create', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'createSharedHosting'])->name('products.shared-hosting.create');
            Route::post('/products/shared-hosting', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'storeSharedHosting'])->name('products.shared-hosting.store');
            Route::get('/products/shared-hosting/{product}', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'showSharedHosting'])->name('products.shared-hosting.show');
            Route::get('/products/shared-hosting/{product}/edit', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'editSharedHosting'])->name('products.shared-hosting.edit');
            Route::put('/products/shared-hosting/{product}', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'updateSharedHosting'])->name('products.shared-hosting.update');
            Route::delete('/products/shared-hosting/{product}', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'destroySharedHosting'])->name('products.shared-hosting.destroy');

            // Cloud Hosting Plans Routes
            Route::get('/products/cloud-hosting/create', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'createCloudHosting'])->name('products.cloud-hosting.create');
            Route::post('/products/cloud-hosting', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'storeCloudHosting'])->name('products.cloud-hosting.store');
            Route::get('/products/cloud-hosting/{product}', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'showCloudHosting'])->name('products.cloud-hosting.show');
            Route::get('/products/cloud-hosting/{product}/edit', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'editCloudHosting'])->name('products.cloud-hosting.edit');
            Route::put('/products/cloud-hosting/{product}', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'updateCloudHosting'])->name('products.cloud-hosting.update');
            Route::delete('/products/cloud-hosting/{product}', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'destroyCloudHosting'])->name('products.cloud-hosting.destroy');

            // Reseller Hosting Plans Routes
            Route::get('/products/reseller-hosting/create', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'createResellerHosting'])->name('products.reseller-hosting.create');
            Route::post('/products/reseller-hosting', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'storeResellerHosting'])->name('products.reseller-hosting.store');
            Route::get('/products/reseller-hosting/{product}', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'showResellerHosting'])->name('products.reseller-hosting.show');
            Route::get('/products/reseller-hosting/{product}/edit', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'editResellerHosting'])->name('products.reseller-hosting.edit');
            Route::put('/products/reseller-hosting/{product}', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'updateResellerHosting'])->name('products.reseller-hosting.update');
            Route::delete('/products/reseller-hosting/{product}', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'destroyResellerHosting'])->name('products.reseller-hosting.destroy');

            // VPS Plans Routes
            Route::get('/products/vps-plans', [\App\Http\Controllers\Admin\VpsController::class, 'index'])->name('products.vps-plans.index');
            Route::get('/products/vps-plans/create', [\App\Http\Controllers\Admin\VpsController::class, 'create'])->name('products.vps-plans.create');
            Route::post('/products/vps-plans', [\App\Http\Controllers\Admin\VpsController::class, 'store'])->name('products.vps-plans.store');
            Route::get('/products/vps-plans/{vpsPlan}/edit', [\App\Http\Controllers\Admin\VpsController::class, 'edit'])->name('products.vps-plans.edit');
            Route::put('/products/vps-plans/{vpsPlan}', [\App\Http\Controllers\Admin\VpsController::class, 'update'])->name('products.vps-plans.update');
            Route::delete('/products/vps-plans/{vpsPlan}', [\App\Http\Controllers\Admin\VpsController::class, 'destroy'])->name('products.vps-plans.destroy');
            Route::post('/products/vps-plans/sync', [\App\Http\Controllers\Admin\VpsController::class, 'syncPlans'])->name('products.vps-plans.sync');
            Route::post('/products/vps-plans/test-connection', [\App\Http\Controllers\Admin\VpsController::class, 'testConnection'])->name('products.vps-plans.test-connection');

            // VPS Instances Routes
            Route::get('/products/vps-instances', [\App\Http\Controllers\Admin\VpsController::class, 'instances'])->name('products.vps-instances.index');
            Route::get('/products/vps-instances/{instance}', [\App\Http\Controllers\Admin\VpsController::class, 'showInstance'])->name('products.vps-instances.show');
            Route::post('/products/vps-instances/provision', [\App\Http\Controllers\Admin\VpsController::class, 'provisionInstance'])->name('products.vps-instances.provision');

            // Dedicated Server Plans Routes
            Route::get('/products/dedicated-plans', [\App\Http\Controllers\Admin\DedicatedController::class, 'index'])->name('products.dedicated-plans.index');
            Route::get('/products/dedicated-plans/create', [\App\Http\Controllers\Admin\DedicatedController::class, 'create'])->name('products.dedicated-plans.create');
            Route::post('/products/dedicated-plans', [\App\Http\Controllers\Admin\DedicatedController::class, 'store'])->name('products.dedicated-plans.store');
            Route::get('/products/dedicated-plans/{dedicatedPlan}/edit', [\App\Http\Controllers\Admin\DedicatedController::class, 'edit'])->name('products.dedicated-plans.edit');
            Route::put('/products/dedicated-plans/{dedicatedPlan}', [\App\Http\Controllers\Admin\DedicatedController::class, 'update'])->name('products.dedicated-plans.update');
            Route::delete('/products/dedicated-plans/{dedicatedPlan}', [\App\Http\Controllers\Admin\DedicatedController::class, 'destroy'])->name('products.dedicated-plans.destroy');
            Route::post('/products/dedicated-plans/sync', [\App\Http\Controllers\Admin\DedicatedController::class, 'syncPlans'])->name('products.dedicated-plans.sync');

            // Dedicated Server Instances Routes
            Route::get('/products/dedicated-instances', [\App\Http\Controllers\Admin\DedicatedController::class, 'instances'])->name('products.dedicated-instances.index');
            Route::get('/products/dedicated-instances/{instance}', [\App\Http\Controllers\Admin\DedicatedController::class, 'showInstance'])->name('products.dedicated-instances.show');
            Route::post('/products/dedicated-instances/provision', [\App\Http\Controllers\Admin\DedicatedController::class, 'provisionInstance'])->name('products.dedicated-instances.provision');
            Route::post('/products/dedicated-instances/{instance}/approve', [\App\Http\Controllers\Admin\DedicatedController::class, 'approveInstance'])->name('products.dedicated-instances.approve');
            Route::post('/products/dedicated-instances/{instance}/reject', [\App\Http\Controllers\Admin\DedicatedController::class, 'rejectInstance'])->name('products.dedicated-instances.reject');

            Route::get('/addons', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'addons'])->name('addons');
            Route::get('/promotions', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'promotions'])->name('promotions');

            // Coupons routes
            Route::get('/promotions/coupons/create', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'createCoupon'])->name('promotions.coupons.create');
            Route::post('/promotions/coupons', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'storeCoupon'])->name('promotions.coupons.store');
            Route::get('/promotions/coupons/{id}/edit', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'editCoupon'])->name('promotions.coupons.edit');
            Route::post('/promotions/coupons/{id}/update', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'updateCoupon'])->name('promotions.coupons.update');
            Route::post('/promotions/coupons/{id}/delete', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'deleteCoupon'])->name('promotions.coupons.delete');
            Route::post('/promotions/coupons/{id}/toggle', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'toggleCoupon'])->name('promotions.coupons.toggle');

            // Campaigns routes
            Route::get('/promotions/campaigns/create', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'createCampaign'])->name('promotions.campaigns.create');
            Route::post('/promotions/campaigns', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'storeCampaign'])->name('promotions.campaigns.store');
            Route::get('/promotions/campaigns/{id}/edit', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'editCampaign'])->name('promotions.campaigns.edit');
            Route::post('/promotions/campaigns/{id}/update', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'updateCampaign'])->name('promotions.campaigns.update');
            Route::post('/promotions/campaigns/{id}/delete', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'deleteCampaign'])->name('promotions.campaigns.delete');
            Route::post('/promotions/campaigns/{id}/toggle', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'toggleCampaign'])->name('promotions.campaigns.toggle');

            Route::get('/domains', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'domains'])->name('domains');
            Route::get('/domains/pricing/list', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'listDomainPricing'])->name('domains.pricing.list');
            Route::post('/domains/pricing/toggle-featured', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'toggleFeaturedDomain'])->name('domains.pricing.toggle-featured');

            // WHM Packages API - Must be before /servers routes
            Route::get('/servers/{server}/whm-packages', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'getWHMPackages'])->name('servers.whm-packages');

            Route::get('/servers', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'servers'])->name('servers');
            Route::get('/servers/create', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'createServer'])->name('servers.create');
            Route::post('/servers', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'storeServer'])->name('servers.store');
            Route::get('/servers/{server}/edit', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'editServer'])->name('servers.edit');
            Route::put('/servers/{server}', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'updateServer'])->name('servers.update');
            Route::delete('/servers/{server}', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'deleteServer'])->name('servers.delete');
            Route::post('/servers/test-connection', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'testConnection'])->name('servers.test-connection');
            Route::get('/departments', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'departments'])->name('departments');
            Route::get('/emails', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'emails'])->name('emails');
            Route::get('/client-groups', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'clientGroups'])->name('client-groups');
            Route::get('/order-statuses', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'orderStatuses'])->name('order-statuses');
            Route::get('/banned-ips', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'bannedIps'])->name('banned-ips');
            Route::get('/sign-in-integrations', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'signInIntegrations'])->name('sign-in-integrations');
            Route::get('/payment-gateways', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'paymentGateways'])->name('payment-gateways');
            Route::get('/domain-registrars', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'domainRegistrars'])->name('domain-registrars');
            Route::get('/domain-registrars/dynadot', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'configureDynadot'])->name('domain-registrars.dynadot');
            Route::post('/domain-registrars/dynadot', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'storeDynadot'])->name('domain-registrars.dynadot.store');
            Route::post('/domain-registrars/dynadot/test', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'testDynadotConnection'])->name('domain-registrars.dynadot.test');
            Route::post('/domain-registrars/dynadot/coupons', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'fetchDynadotCoupons'])->name('domain-registrars.dynadot.coupons');
            Route::get('/domains/pricing/dynadot', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'dynadotPricing'])->name('domains.pricing.dynadot');
            Route::post('/domains/pricing/dynadot/fetch', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'fetchDynadotPricing'])->name('domains.pricing.dynadot.fetch');
            Route::post('/domains/pricing/dynadot/save', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'saveDynadotPricing'])->name('domains.pricing.dynadot.save');
            Route::get('/currencies', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'currencies'])->name('currencies');
            Route::get('/tax-configuration', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'taxConfiguration'])->name('tax-configuration');
            Route::get('/administrator-users', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'administratorUsers'])->name('administrator-users');
            Route::get('/administrator-roles', [\App\Http\Controllers\Admin\SystemSettingsController::class, 'administratorRoles'])->name('administrator-roles');
        });
    });
});

// Client/Customer Routes (Frontend Shopping)
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/hosting', [ProductController::class, 'hosting'])->name('hosting');
        Route::get('/domains', [ProductController::class, 'domains'])->name('domains');
        Route::get('/email', [ProductController::class, 'email'])->name('email');
        Route::get('/{product}', [ProductController::class, 'show'])->name('show');
    });

    // Cart Routes
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [\App\Http\Controllers\CartController::class, 'index'])->name('index');
        Route::post('/add-domain', [\App\Http\Controllers\CartController::class, 'addDomain'])->name('add-domain');
        Route::post('/add-hosting', [\App\Http\Controllers\CartController::class, 'addHosting'])->name('add-hosting');
        Route::post('/add-vps', [\App\Http\Controllers\CartController::class, 'addVps'])->name('add-vps');
        Route::post('/add-dedicated', [\App\Http\Controllers\CartController::class, 'addDedicated'])->name('add-dedicated');
        Route::post('/remove', [\App\Http\Controllers\CartController::class, 'remove'])->name('remove');
        Route::post('/clear', [\App\Http\Controllers\CartController::class, 'clear'])->name('clear');
        Route::get('/count', [\App\Http\Controllers\CartController::class, 'count'])->name('count');
        Route::get('/checkout', [\App\Http\Controllers\CartController::class, 'checkout'])->name('checkout');
        Route::post('/checkout/process', function(\Illuminate\Http\Request $request) {
            \Illuminate\Support\Facades\Log::info('=== ROUTE HIT ===', [
                'method' => $request->method(),
                'all_data' => $request->all(),
                'headers' => $request->headers->all()
            ]);
            return app(\App\Http\Controllers\OrderController::class)->processCheckout($request);
        })->name('checkout.process');
        Route::post('/update-years', [\App\Http\Controllers\CartController::class, 'updateYears'])->name('update-years');
        Route::post('/toggle-privacy', [\App\Http\Controllers\CartController::class, 'togglePrivacy'])->name('toggle-privacy');
        Route::post('/update-dns-type', [\App\Http\Controllers\CartController::class, 'updateDnsType'])->name('update-dns-type');
        Route::post('/update-dns', [\App\Http\Controllers\CartController::class, 'updateDns'])->name('update-dns');
        Route::post('/apply-coupon', [\App\Http\Controllers\CartController::class, 'applyCoupon'])->name('apply-coupon');
        Route::post('/remove-coupon', [\App\Http\Controllers\CartController::class, 'removeCoupon'])->name('remove-coupon');
    });

    // Order Routes (داخل لوحة تحكم العميل)
    Route::prefix('order')->name('order.')->middleware(['client.auth'])->group(function () {
        Route::get('/success/{order}', [\App\Http\Controllers\OrderController::class, 'success'])->name('success');
        Route::get('/failed/{order}', [\App\Http\Controllers\OrderController::class, 'failed'])->name('failed');
        Route::post('/retry-payment/{order}', [\App\Http\Controllers\OrderController::class, 'retryPayment'])->name('retry-payment');
        Route::post('/{order}/rating', [\App\Http\Controllers\Client\OrderRatingController::class, 'store'])->name('rating.store');
        Route::get('/{order}/rating', [\App\Http\Controllers\Client\OrderRatingController::class, 'show'])->name('rating.show');
    });

    // Payment Callback Routes
    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('/success/{order}', [\App\Http\Controllers\PaymentController::class, 'orderSuccess'])->name('success');
        Route::get('/failed/{order}', [\App\Http\Controllers\PaymentController::class, 'orderFailed'])->name('failed');
        Route::get('/pending/{order}', [\App\Http\Controllers\PaymentController::class, 'orderPending'])->name('pending');
        Route::get('/check-status/{order}', [\App\Http\Controllers\PaymentController::class, 'checkPaymentStatus'])->name('check-status');
        Route::post('/webhook/fawaterak', [\App\Http\Controllers\PaymentController::class, 'fawaterakWebhook'])->name('webhook.fawaterak')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
    });

    // API Routes for AJAX calls
    Route::post('/api/check-username', [\App\Http\Controllers\CartController::class, 'checkUsername'])->name('api.check-username');
    Route::post('/api/check-email', [\App\Http\Controllers\CartController::class, 'checkEmail'])->name('api.check-email');
    Route::post('/api/check-phone', [\App\Http\Controllers\CartController::class, 'checkPhone'])->name('api.check-phone');
    Route::post('/api/check-tax-number', [\App\Http\Controllers\CartController::class, 'checkTaxNumber'])->name('api.check-tax-number');
    Route::get('/test-email-check', function() { return view('test-email-check'); });

    // Email Preview Route (للتطوير فقط)
    Route::get('/mail-preview/order-confirmation/{order}', function(\App\Models\Order $order, \Illuminate\Http\Request $request) {
        $order->load(['items', 'services', 'client', 'invoice']);
        
        // Allow testing with ?lang=ar or ?lang=en
        if ($request->has('lang')) {
            $order->client->preferred_language = $request->get('lang');
        }
        
        return new \App\Mail\OrderConfirmationMail($order, $order->client, $order->invoice);
    })->name('mail.preview.order-confirmation');

    // Service Suspended Email Preview (للتطوير فقط)
    Route::get('/mail-preview/service-suspended/{service}', function(\App\Models\Service $service, \Illuminate\Http\Request $request) {
        $service->load('client');
        
        // Allow testing with ?lang=ar or ?lang=en
        $lang = $request->get('lang', $service->client->preferred_language ?? 'en');
        $service->client->preferred_language = $lang;
        
        // Set session for RTL support in layout
        session(['mail_locale' => $lang]);
        app()->setLocale($lang);
        
        // Allow testing different reasons with ?reason=
        $reason = $request->get('reason', 'Non-payment');
        
        return new \App\Mail\ServiceSuspendedMail($service, $service->client, $reason);
    })->name('mail.preview.service-suspended');

    // Service Unsuspended Email Preview (للتطوير فقط)
    Route::get('/mail-preview/service-unsuspended/{service}', function(\App\Models\Service $service, \Illuminate\Http\Request $request) {
        $service->load('client');
        
        // Allow testing with ?lang=ar or ?lang=en
        $lang = $request->get('lang', $service->client->preferred_language ?? 'en');
        $service->client->preferred_language = $lang;
        
        // Set session for RTL support in layout
        session(['mail_locale' => $lang]);
        app()->setLocale($lang);
        
        return new \App\Mail\ServiceUnsuspendedMail($service, $service->client);
    })->name('mail.preview.service-unsuspended');

    // Service Terminated Email Preview (للتطوير فقط)
    Route::get('/mail-preview/service-terminated/{service}', function(\App\Models\Service $service, \Illuminate\Http\Request $request) {
        $service->load('client');
        
        // Allow testing with ?lang=ar or ?lang=en
        $lang = $request->get('lang', $service->client->preferred_language ?? 'en');
        $service->client->preferred_language = $lang;
        
        // Set session for RTL support in layout
        session(['mail_locale' => $lang]);
        app()->setLocale($lang);
        
        return new \App\Mail\ServiceTerminatedMail($service, $service->client);
    })->name('mail.preview.service-terminated');

    // Domain Routes
    Route::prefix('domains')->name('domains.')->group(function () {
        Route::get('/search', [DomainController::class, 'search'])->name('search');
        Route::get('/bulk-search', [DomainController::class, 'bulkSearch'])->name('bulk-search');
        Route::post('/bulk-check', [DomainController::class, 'bulkCheckAvailability'])->name('bulk-check');
        Route::post('/check', [DomainController::class, 'checkAvailability'])->name('check');
        Route::post('/check-existing', [DomainController::class, 'checkExistingDomain'])->name('check-existing');
        Route::post('/transfer/validate', [DomainController::class, 'validateTransfer'])->name('transfer.validate');
        Route::get('/transfer', [DomainController::class, 'transfer'])->name('transfer');
        Route::get('/new-tlds', [DomainController::class, 'newTlds'])->name('new-tlds');
        Route::get('/tld-list', [DomainController::class, 'tldList'])->name('tld-list');
        Route::post('/register', [DomainController::class, 'register'])->name('register');
        Route::get('/whois', [DomainController::class, 'whois'])->name('whois');
        Route::post('/whois/lookup', [DomainController::class, 'whoisLookup'])->name('whois.lookup');
        Route::get('/freedns', [DomainController::class, 'freeDns'])->name('freedns');
        Route::post('/freedns/check', [DomainController::class, 'checkDns'])->name('freedns.check');
    });

    // Hosting Routes
    Route::prefix('hosting')->name('hosting.')->group(function () {
        Route::get('/', [HostingController::class, 'index'])->name('index');
        Route::get('/shared', [HostingController::class, 'shared'])->name('shared');
        Route::get('/cloud', [HostingController::class, 'cloud'])->name('cloud');
        Route::get('/vps', [HostingController::class, 'vps'])->name('vps');
        Route::get('/dedicated', [HostingController::class, 'dedicated'])->name('dedicated');
        Route::get('/reseller', [HostingController::class, 'reseller'])->name('reseller');
    });

    // Email Routes
    Route::prefix('email')->name('email.')->group(function () {
        Route::get('/', [ProductController::class, 'email'])->name('index');
        Route::get('/professional', [ProductController::class, 'professionalEmail'])->name('professional');
        Route::get('/security', [ProductController::class, 'emailSecurity'])->name('security');
        Route::get('/migration', [ProductController::class, 'emailMigration'])->name('migration');
        Route::get('/webmail', function() {
            return redirect()->away('https://webmail.progineous.com');
        })->name('webmail');
    });

// Payment Routes
Route::prefix('payment')->name('payment.')->group(function () {
    // Payment gateway selection and processing
    Route::get('/', [\App\Http\Controllers\PaymentController::class, 'index'])->name('index');
    Route::post('/process', [\App\Http\Controllers\PaymentController::class, 'process'])->name('process');

    // Payment callbacks
    Route::get('/success', [\App\Http\Controllers\PaymentController::class, 'success'])->name('success');
    Route::get('/fail', [\App\Http\Controllers\PaymentController::class, 'fail'])->name('fail');
    Route::get('/pending', [\App\Http\Controllers\PaymentController::class, 'pending'])->name('pending');
});

// Webhook Routes (no CSRF protection needed)
Route::prefix('webhooks')->name('webhooks.')->group(function () {
    // Fawaterak Unified Webhook
    Route::post('/fawaterak', [\App\Http\Controllers\WebhookController::class, 'fawaterak'])
        ->name('fawaterak')
        ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

    // Legacy Fawaterak Webhooks (for backward compatibility)
    Route::post('/fawaterak/paid', [\App\Http\Controllers\WebhookController::class, 'fawaterak'])
        ->name('fawaterak.paid')
        ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

    Route::post('/fawaterak/cancelled', [\App\Http\Controllers\WebhookController::class, 'fawaterak'])
        ->name('fawaterak.cancelled')
        ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

    Route::post('/fawaterak/failed', [\App\Http\Controllers\WebhookController::class, 'fawaterak'])
        ->name('fawaterak.failed')
        ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

    Route::post('/fawaterak/refund', [\App\Http\Controllers\WebhookController::class, 'fawaterak'])
        ->name('fawaterak.refund')
        ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

    // Stripe Webhook (for future implementation)
    Route::post('/stripe', function() {
        // TODO: Implement Stripe webhook handler
        return response()->json(['status' => 'success']);
    })->name('stripe')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);

    // PayPal Webhook (for future implementation)
    Route::post('/paypal', function() {
        // TODO: Implement PayPal webhook handler
        return response()->json(['status' => 'success']);
    })->name('paypal')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);
});
