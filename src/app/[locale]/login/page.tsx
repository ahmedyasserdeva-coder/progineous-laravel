'use client';

import { useState, useEffect, useRef } from 'react';
import { useLocale } from 'next-intl';
import { gsap } from 'gsap';
import Link from 'next/link';
import {
  Mail,
  Lock,
  Eye,
  EyeOff,
  LogIn,
  AlertCircle,
  CheckCircle,
  Loader2,
  ArrowRight,
  Shield,
  Headphones,
  Zap,
} from 'lucide-react';
import { cn } from '@/lib/utils';

export default function LoginPage() {
  const locale = useLocale();
  const isRTL = locale === 'ar';
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [showPassword, setShowPassword] = useState(false);
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState('');
  const [success, setSuccess] = useState(false);
  
  const canvasRef = useRef<HTMLCanvasElement>(null);
  const mouseRef = useRef({ x: 0, y: 0 });

  // Radio wave animation effect
  useEffect(() => {
    const canvas = canvasRef.current;
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    if (!ctx) return;

    let animationId: number;
    let time = 0;

    const resize = () => {
      const parent = canvas.parentElement;
      if (parent) {
        canvas.width = parent.offsetWidth;
        canvas.height = parent.offsetHeight;
      }
    };

    resize();
    window.addEventListener('resize', resize);

    const handleMouseMove = (e: MouseEvent) => {
      const rect = canvas.getBoundingClientRect();
      mouseRef.current = {
        x: e.clientX - rect.left,
        y: e.clientY - rect.top,
      };
    };

    canvas.addEventListener('mousemove', handleMouseMove);

    const drawRadioWaves = () => {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      
      const centerX = canvas.width / 2;
      const centerY = canvas.height / 2;
      const maxRadius = Math.max(canvas.width, canvas.height);
      
      // Calculate mouse distance from center for interaction
      const mouseDistX = mouseRef.current.x - centerX;
      const mouseDistY = mouseRef.current.y - centerY;
      const mouseDistance = Math.sqrt(mouseDistX * mouseDistX + mouseDistY * mouseDistY);
      const mouseAngle = Math.atan2(mouseDistY, mouseDistX);

      // Draw main radio waves from center - slower speed
      const waveCount = 10;
      for (let i = 0; i < waveCount; i++) {
        const baseRadius = ((time * 0.5 + i * (maxRadius / waveCount)) % maxRadius);
        const opacity = Math.max(0, 0.12 * (1 - baseRadius / maxRadius));
        
        // Distort waves based on mouse position - waves bend towards mouse
        ctx.beginPath();
        for (let angle = 0; angle <= Math.PI * 2; angle += 0.02) {
          const angleDiff = Math.abs(angle - mouseAngle);
          const normalizedDiff = Math.min(angleDiff, Math.PI * 2 - angleDiff) / Math.PI;
          const distortion = (1 - normalizedDiff) * Math.min(mouseDistance * 0.15, 50) * (baseRadius / maxRadius);
          
          const r = baseRadius + distortion;
          const x = centerX + Math.cos(angle) * r;
          const y = centerY + Math.sin(angle) * r;
          
          if (angle === 0) {
            ctx.moveTo(x, y);
          } else {
            ctx.lineTo(x, y);
          }
        }
        ctx.closePath();
        
        ctx.strokeStyle = `rgba(255, 255, 255, ${opacity})`;
        ctx.lineWidth = 1.5;
        ctx.stroke();
      }

      // Draw secondary waves from corners - slower
      const corners = [
        { x: 0, y: 0 },
        { x: canvas.width, y: 0 },
        { x: 0, y: canvas.height },
        { x: canvas.width, y: canvas.height },
      ];

      corners.forEach((corner, cornerIndex) => {
        for (let i = 0; i < 5; i++) {
          const baseRadius = ((time * 0.4 + i * 120 + cornerIndex * 60) % (maxRadius * 0.9));
          const opacity = Math.max(0, 0.06 * (1 - baseRadius / (maxRadius * 0.9)));
          
          // Calculate distortion towards mouse
          const cornerMouseDistX = mouseRef.current.x - corner.x;
          const cornerMouseDistY = mouseRef.current.y - corner.y;
          const cornerMouseAngle = Math.atan2(cornerMouseDistY, cornerMouseDistX);
          const cornerMouseDist = Math.sqrt(cornerMouseDistX * cornerMouseDistX + cornerMouseDistY * cornerMouseDistY);
          
          ctx.beginPath();
          for (let angle = 0; angle <= Math.PI * 2; angle += 0.03) {
            const angleDiff = Math.abs(angle - cornerMouseAngle);
            const normalizedDiff = Math.min(angleDiff, Math.PI * 2 - angleDiff) / Math.PI;
            const distortion = (1 - normalizedDiff) * Math.min(cornerMouseDist * 0.08, 30) * (baseRadius / (maxRadius * 0.9));
            
            const r = baseRadius + distortion;
            const x = corner.x + Math.cos(angle) * r;
            const y = corner.y + Math.sin(angle) * r;
            
            if (angle === 0) {
              ctx.moveTo(x, y);
            } else {
              ctx.lineTo(x, y);
            }
          }
          ctx.closePath();
          
          ctx.strokeStyle = `rgba(0, 212, 170, ${opacity})`;
          ctx.lineWidth = 1;
          ctx.stroke();
        }
      });

      time += 1;
      animationId = requestAnimationFrame(drawRadioWaves);
    };

    drawRadioWaves();

    return () => {
      window.removeEventListener('resize', resize);
      canvas.removeEventListener('mousemove', handleMouseMove);
      cancelAnimationFrame(animationId);
    };
  }, []);

  useEffect(() => {
    // Animate elements when component mounts
    const ctx = gsap.context(() => {
      gsap.fromTo('.login-card', 
        { y: 20, opacity: 0.5 },
        { y: 0, opacity: 1, duration: 0.5, ease: 'power2.out' }
      );
      gsap.fromTo('.feature-item',
        { y: 15, opacity: 0.5 },
        { y: 0, opacity: 1, duration: 0.4, stagger: 0.1, delay: 0.2, ease: 'power2.out' }
      );
    });

    return () => ctx.revert();
  }, []);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setIsLoading(true);
    setError('');
    setSuccess(false);

    try {
      const response = await fetch('/api/auth/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email, password }),
      });

      const data = await response.json();

      if (response.ok && data.success) {
        setSuccess(true);
        // Redirect to WHMCS via SSO
        setTimeout(() => {
          if (data.redirectUrl) {
            window.location.href = data.redirectUrl;
          }
        }, 1000);
      } else {
        setError(data.error || (isRTL ? 'فشل تسجيل الدخول' : 'Login failed'));
      }
    } catch (err) {
      console.error('Login error:', err);
      setError(isRTL ? 'حدث خطأ. يرجى المحاولة مرة أخرى.' : 'An error occurred. Please try again.');
    } finally {
      setIsLoading(false);
    }
  };

  const features = [
    {
      icon: Shield,
      title: { en: 'Secure Login', ar: 'تسجيل دخول آمن' },
      description: { en: 'SSL encrypted connection', ar: 'اتصال مشفر بـ SSL' },
    },
    {
      icon: Headphones,
      title: { en: '24/7 Support', ar: 'دعم على مدار الساعة' },
      description: { en: 'We\'re here to help', ar: 'نحن هنا للمساعدة' },
    },
    {
      icon: Zap,
      title: { en: 'Fast Access', ar: 'وصول سريع' },
      description: { en: 'Instant dashboard access', ar: 'وصول فوري للوحة التحكم' },
    },
  ];

  const jsonLd = {
    '@context': 'https://schema.org',
    '@graph': [
      {
        '@type': 'WebPage',
        '@id': `https://progineous.com/${locale}/login`,
        name: isRTL ? 'تسجيل الدخول | بروجينيوس' : 'Login | Pro Gineous',
        description: isRTL
          ? 'سجل دخولك إلى حسابك في بروجينيوس للوصول إلى لوحة التحكم'
          : 'Sign in to your Pro Gineous account to access your dashboard',
        url: `https://progineous.com/${locale}/login`,
        inLanguage: isRTL ? 'ar' : 'en',
        isPartOf: {
          '@type': 'WebSite',
          name: 'Pro Gineous',
          url: 'https://progineous.com',
        },
      },
      {
        '@type': 'BreadcrumbList',
        itemListElement: [
          {
            '@type': 'ListItem',
            position: 1,
            name: isRTL ? 'الرئيسية' : 'Home',
            item: `https://progineous.com/${locale}`,
          },
          {
            '@type': 'ListItem',
            position: 2,
            name: isRTL ? 'تسجيل الدخول' : 'Login',
            item: `https://progineous.com/${locale}/login`,
          },
        ],
      },
      {
        '@type': 'Organization',
        '@id': 'https://progineous.com/#organization',
        name: 'Pro Gineous',
        url: 'https://progineous.com',
        logo: 'https://progineous.com/pro%20Gineous_logo.svg',
        contactPoint: {
          '@type': 'ContactPoint',
          contactType: 'customer service',
          availableLanguage: ['English', 'Arabic'],
        },
      },
    ],
  };

  return (
    <div className={cn('min-h-screen bg-linear-to-br from-gray-50 to-gray-100', isRTL && 'rtl')}>
      {/* JSON-LD Structured Data */}
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(jsonLd) }}
      />
      {/* Background Pattern */}
      <div className="absolute inset-0 overflow-hidden pointer-events-none">
        <div className="absolute top-0 left-0 w-full h-full opacity-5">
          <div className="absolute top-20 left-10 w-72 h-72 bg-[#1d71b8] rounded-full blur-3xl" />
          <div className="absolute bottom-20 right-10 w-96 h-96 bg-[#00D4AA] rounded-full blur-3xl" />
        </div>
      </div>

      <div className="relative min-h-screen flex">
        {/* Left Side - Features */}
        <div className="hidden lg:flex lg:w-1/2 bg-linear-to-br from-[#1d71b8] via-[#1a5f9a] to-[#0f4c75] p-12 flex-col justify-center relative overflow-hidden">
          
          {/* Water Wave Canvas Animation */}
          <canvas
            ref={canvasRef}
            className="absolute inset-0 w-full h-full pointer-events-auto"
          />

          <div className="max-w-md mx-auto relative z-10">
            <Link href={`/${locale}`} className="inline-block mb-12">
              <img 
                src="/images/logos/pro Gineous_white logo.svg" 
                alt="Pro Gineous" 
                className="h-12 w-auto"
              />
            </Link>
            
            <h1 className="text-4xl font-bold text-white mb-6">
              {isRTL ? 'مرحباً بعودتك!' : 'Welcome Back!'}
            </h1>
            <p className="text-xl text-white/80 mb-12">
              {isRTL
                ? 'سجل دخولك للوصول إلى لوحة تحكم حسابك وإدارة خدماتك'
                : 'Sign in to access your dashboard and manage your services'}
            </p>

            <div className="space-y-6">
              {features.map((feature, index) => {
                const Icon = feature.icon;
                return (
                  <div key={index} className="feature-item flex items-start gap-4 opacity-100">
                    <div className="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center shrink-0">
                      <Icon className="w-6 h-6 text-[#00D4AA]" />
                    </div>
                    <div>
                      <h3 className="text-white font-semibold">
                        {isRTL ? feature.title.ar : feature.title.en}
                      </h3>
                      <p className="text-white/60 text-sm">
                        {isRTL ? feature.description.ar : feature.description.en}
                      </p>
                    </div>
                  </div>
                );
              })}
            </div>

          </div>
        </div>

        {/* Right Side - Login Form */}
        <div className="flex-1 flex items-center justify-center p-6 md:p-8">
          <div className="login-card w-full max-w-md">
            {/* Mobile Logo */}
            <div className="lg:hidden text-center mb-8">
              <Link href={`/${locale}`}>
                <img 
                  src="/pro Gineous_logo.svg" 
                  alt="Pro Gineous" 
                  className="h-10 w-auto mx-auto"
                />
              </Link>
            </div>

            <div className="bg-white rounded-2xl shadow-xl p-8 md:p-10">
              {/* Header - Clean & Professional */}
              <div className="text-center mb-8">
                <div className="inline-flex items-center justify-center w-14 h-14 bg-[#1d71b8]/10 rounded-full mb-4">
                  <Shield className="w-7 h-7 text-[#1d71b8]" />
                </div>
                <h2 className="text-2xl font-bold text-gray-900">
                  {isRTL ? 'تسجيل الدخول الآمن' : 'Secure Login'}
                </h2>
                <p className="text-gray-500 mt-2 text-sm">
                  {isRTL ? 'حسابك محمي بتشفير 256-bit SSL' : 'Your account is protected with 256-bit SSL encryption'}
                </p>
              </div>

              {/* Error Message */}
              {error && (
                <div className="mb-6 p-3 bg-red-50 border border-red-200 rounded-lg flex items-center gap-3">
                  <AlertCircle className="w-5 h-5 text-red-500 shrink-0" />
                  <p className="text-red-600 text-sm">{error}</p>
                </div>
              )}

              {/* Success Message */}
              {success && (
                <div className="mb-6 p-3 bg-green-50 border border-green-200 rounded-lg flex items-center gap-3">
                  <CheckCircle className="w-5 h-5 text-green-500 shrink-0" />
                  <p className="text-green-600 text-sm">
                    {isRTL ? 'تم تسجيل الدخول بنجاح! جاري التوجيه...' : 'Login successful! Redirecting...'}
                  </p>
                </div>
              )}

              <form onSubmit={handleSubmit} className="space-y-5">
                {/* Email Field */}
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1.5">
                    {isRTL ? 'البريد الإلكتروني' : 'Email'}
                  </label>
                  <div className="relative">
                    <div className={cn(
                      'absolute top-1/2 -translate-y-1/2 text-gray-400',
                      isRTL ? 'right-3' : 'left-3'
                    )}>
                      <Mail className="w-5 h-5" />
                    </div>
                    <input
                      type="email"
                      value={email}
                      onChange={(e) => setEmail(e.target.value)}
                      required
                      disabled={isLoading || success}
                      className={cn(
                        'w-full py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1d71b8] focus:border-[#1d71b8] outline-none transition-all disabled:bg-gray-50 disabled:text-gray-500',
                        isRTL ? 'pr-10 pl-4' : 'pl-10 pr-4'
                      )}
                      placeholder={isRTL ? 'example@domain.com' : 'example@domain.com'}
                    />
                  </div>
                </div>

                {/* Password Field */}
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1.5">
                    {isRTL ? 'كلمة المرور' : 'Password'}
                  </label>
                  <div className="relative">
                    <div className={cn(
                      'absolute top-1/2 -translate-y-1/2 text-gray-400',
                      isRTL ? 'right-3' : 'left-3'
                    )}>
                      <Lock className="w-5 h-5" />
                    </div>
                    <input
                      type={showPassword ? 'text' : 'password'}
                      value={password}
                      onChange={(e) => setPassword(e.target.value)}
                      required
                      disabled={isLoading || success}
                      className={cn(
                        'w-full py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1d71b8] focus:border-[#1d71b8] outline-none transition-all disabled:bg-gray-50 disabled:text-gray-500',
                        isRTL ? 'pr-10 pl-10' : 'pl-10 pr-10'
                      )}
                      placeholder="••••••••"
                    />
                    <button
                      type="button"
                      onClick={() => setShowPassword(!showPassword)}
                      disabled={isLoading || success}
                      className={cn(
                        'absolute top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors disabled:opacity-50',
                        isRTL ? 'left-3' : 'right-3'
                      )}
                    >
                      {showPassword ? <EyeOff className="w-5 h-5" /> : <Eye className="w-5 h-5" />}
                    </button>
                  </div>
                </div>

                {/* Remember Me & Forgot Password */}
                <div className="flex items-center justify-between">
                  <label className="flex items-center gap-2 cursor-pointer">
                    <input
                      type="checkbox"
                      className="w-4 h-4 rounded border-gray-300 text-[#1d71b8] focus:ring-[#1d71b8]"
                    />
                    <span className="text-sm text-gray-600">
                      {isRTL ? 'تذكرني' : 'Remember me'}
                    </span>
                  </label>
                  <a
                    href="https://app.progineous.com/pwreset.php"
                    className="text-sm text-[#1d71b8] hover:underline"
                  >
                    {isRTL ? 'نسيت كلمة المرور؟' : 'Forgot password?'}
                  </a>
                </div>

                {/* Submit Button */}
                <button
                  type="submit"
                  disabled={isLoading || success}
                  className="w-full bg-[#1d71b8] text-white py-3 rounded-lg font-medium hover:bg-[#165d99] transition-colors disabled:opacity-60 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                >
                  {isLoading ? (
                    <>
                      <Loader2 className="w-5 h-5 animate-spin" />
                      {isRTL ? 'جاري التحقق...' : 'Verifying...'}
                    </>
                  ) : success ? (
                    <>
                      <CheckCircle className="w-5 h-5" />
                      {isRTL ? 'تم!' : 'Done!'}
                    </>
                  ) : (
                    isRTL ? 'تسجيل الدخول' : 'Sign In'
                  )}
                </button>
              </form>

              {/* Divider */}
              <div className="flex items-center gap-3 my-6">
                <div className="flex-1 h-px bg-gray-200" />
                <span className="text-gray-400 text-xs">{isRTL ? 'أو' : 'or'}</span>
                <div className="flex-1 h-px bg-gray-200" />
              </div>

              {/* Direct Link to WHMCS */}
              <a
                href="https://app.progineous.com/clientarea.php"
                className="w-full flex items-center justify-center gap-2 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors"
              >
                {isRTL ? 'الذهاب لتسجيل الدخول القديم' : 'Go to old login'}
                <ArrowRight className={cn('w-4 h-4', isRTL && 'rotate-180')} />
              </a>

              {/* Security Badge */}
              <div className="mt-6 pt-6 border-t border-gray-100 flex items-center justify-center gap-2 text-gray-400 text-xs">
                <Lock className="w-3.5 h-3.5" />
                <span>{isRTL ? 'اتصال آمن ومشفر' : 'Secure & Encrypted Connection'}</span>
              </div>

            </div>

            {/* Footer */}
            <p className="text-center text-gray-400 text-xs mt-6">
              © {new Date().getFullYear()} Pro Gineous. {isRTL ? 'جميع الحقوق محفوظة.' : 'All rights reserved.'}
            </p>
          </div>
        </div>
      </div>
    </div>
  );
}
