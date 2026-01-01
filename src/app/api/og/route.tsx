import { ImageResponse } from 'next/og';
import { NextRequest } from 'next/server';

export const runtime = 'edge';

export async function GET(request: NextRequest) {
  const { searchParams } = new URL(request.url);
  
  // Get parameters from URL
  const title = searchParams.get('title') || 'Pro Gineous';
  const description = searchParams.get('description') || 'Professional Web Hosting Solutions';
  const locale = searchParams.get('locale') || 'en';
  const page = searchParams.get('page') || 'home';
  
  const isRTL = locale === 'ar';
  
  // Page-specific colors and icons
  const pageConfig: Record<string, { gradient: string; icon: string; badge: string }> = {
    home: { gradient: 'linear-gradient(135deg, #1d71b8 0%, #0d4a7a 100%)', icon: '🏠', badge: '' },
    domains: { gradient: 'linear-gradient(135deg, #8B5CF6 0%, #6D28D9 100%)', icon: '🌐', badge: 'Domains' },
    'hosting-shared': { gradient: 'linear-gradient(135deg, #10B981 0%, #059669 100%)', icon: '💻', badge: 'Shared Hosting' },
    'hosting-cloud': { gradient: 'linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%)', icon: '☁️', badge: 'Cloud Hosting' },
    'hosting-vps': { gradient: 'linear-gradient(135deg, #F59E0B 0%, #D97706 100%)', icon: '🖥️', badge: 'VPS Servers' },
    'hosting-dedicated': { gradient: 'linear-gradient(135deg, #EF4444 0%, #DC2626 100%)', icon: '🏢', badge: 'Dedicated Servers' },
    'hosting-email': { gradient: 'linear-gradient(135deg, #EC4899 0%, #DB2777 100%)', icon: '📧', badge: 'Email Hosting' },
    'hosting-reseller': { gradient: 'linear-gradient(135deg, #14B8A6 0%, #0D9488 100%)', icon: '🤝', badge: 'Reseller Hosting' },
    ssl: { gradient: 'linear-gradient(135deg, #22C55E 0%, #16A34A 100%)', icon: '🔒', badge: 'SSL Certificates' },
    about: { gradient: 'linear-gradient(135deg, #6366F1 0%, #4F46E5 100%)', icon: '🏢', badge: 'About Us' },
    contact: { gradient: 'linear-gradient(135deg, #06B6D4 0%, #0891B2 100%)', icon: '📞', badge: 'Contact' },
    affiliate: { gradient: 'linear-gradient(135deg, #F97316 0%, #EA580C 100%)', icon: '💰', badge: 'Affiliate' },
    default: { gradient: 'linear-gradient(135deg, #1d71b8 0%, #0d4a7a 100%)', icon: '⚡', badge: '' },
  };

  const config = pageConfig[page] || pageConfig.default;

  return new ImageResponse(
    (
      <div
        style={{
          height: '100%',
          width: '100%',
          display: 'flex',
          flexDirection: 'column',
          alignItems: 'center',
          justifyContent: 'center',
          background: config.gradient,
          fontFamily: isRTL ? 'Arial' : 'Inter, Arial',
          direction: isRTL ? 'rtl' : 'ltr',
        }}
      >
        {/* Background Pattern */}
        <div
          style={{
            position: 'absolute',
            top: 0,
            left: 0,
            right: 0,
            bottom: 0,
            display: 'flex',
            opacity: 0.1,
          }}
        >
          <svg width="1200" height="630" viewBox="0 0 1200 630">
            <circle cx="100" cy="100" r="300" fill="none" stroke="white" strokeWidth="1"/>
            <circle cx="100" cy="100" r="400" fill="none" stroke="white" strokeWidth="1"/>
            <circle cx="1100" cy="530" r="200" fill="none" stroke="white" strokeWidth="1"/>
            <circle cx="1100" cy="530" r="300" fill="none" stroke="white" strokeWidth="1"/>
          </svg>
        </div>

        {/* Badge */}
        {config.badge && (
          <div
            style={{
              display: 'flex',
              alignItems: 'center',
              justifyContent: 'center',
              background: 'rgba(255, 255, 255, 0.2)',
              borderRadius: '50px',
              padding: '12px 32px',
              marginBottom: '24px',
            }}
          >
            <span style={{ fontSize: '32px', marginRight: isRTL ? '0' : '12px', marginLeft: isRTL ? '12px' : '0' }}>
              {config.icon}
            </span>
            <span style={{ color: 'white', fontSize: '24px', fontWeight: 600 }}>
              {config.badge}
            </span>
          </div>
        )}

        {/* Logo */}
        <div
          style={{
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center',
            marginBottom: '20px',
          }}
        >
          <div
            style={{
              display: 'flex',
              alignItems: 'center',
              justifyContent: 'center',
              background: 'white',
              borderRadius: '20px',
              padding: '16px 32px',
            }}
          >
            <span style={{ fontSize: '48px', fontWeight: 800, color: '#1d71b8' }}>
              Pro Gineous
            </span>
          </div>
        </div>

        {/* Title */}
        <div
          style={{
            display: 'flex',
            fontSize: title.length > 40 ? '48px' : '56px',
            fontWeight: 700,
            color: 'white',
            textAlign: 'center',
            maxWidth: '1000px',
            lineHeight: 1.3,
            marginBottom: '20px',
            textShadow: '0 4px 8px rgba(0,0,0,0.2)',
          }}
        >
          {title}
        </div>

        {/* Description */}
        <div
          style={{
            display: 'flex',
            fontSize: '28px',
            color: 'rgba(255, 255, 255, 0.9)',
            textAlign: 'center',
            maxWidth: '900px',
            lineHeight: 1.5,
          }}
        >
          {description.length > 100 ? description.substring(0, 100) + '...' : description}
        </div>

        {/* Bottom Bar */}
        <div
          style={{
            position: 'absolute',
            bottom: '40px',
            display: 'flex',
            alignItems: 'center',
            gap: '16px',
          }}
        >
          <div
            style={{
              display: 'flex',
              alignItems: 'center',
              background: 'rgba(255, 255, 255, 0.15)',
              borderRadius: '30px',
              padding: '10px 24px',
            }}
          >
            <span style={{ color: 'white', fontSize: '20px' }}>🌐 progineous.com</span>
          </div>
          <div
            style={{
              display: 'flex',
              alignItems: 'center',
              background: 'rgba(0, 212, 170, 0.3)',
              borderRadius: '30px',
              padding: '10px 24px',
            }}
          >
            <span style={{ color: 'white', fontSize: '20px' }}>
              {isRTL ? '🇸🇦 عربي' : '🇺🇸 English'}
            </span>
          </div>
        </div>
      </div>
    ),
    {
      width: 1200,
      height: 630,
    }
  );
}
