'use client';

import { useState, useEffect, useRef, useCallback } from 'react';
import { useTranslations, useLocale } from 'next-intl';
import { Link } from '@/i18n/routing';
import { gsap, ScrollTrigger } from '@/lib/gsap';
import { DotLottieReact } from '@lottiefiles/dotlottie-react';
import { ArrowRight, Star, Server, Sparkles, Cpu, Globe, Search, Shield, Zap, Clock, Loader2, CheckCircle, XCircle, ShoppingCart, X } from 'lucide-react';

interface TLD {
  extension: string;
  price: string;
  isFree?: boolean;
}

interface DomainResult {
  domain: string;
  available: boolean;
  status: string;
  price?: string;
}

export function HeroSection() {
  const t = useTranslations('hero');
  const locale = useLocale();
  const [searchQuery, setSearchQuery] = useState('');
  const [modalSearchQuery, setModalSearchQuery] = useState('');
  const [tlds, setTlds] = useState<TLD[]>([]);
  const [tldsLoading, setTldsLoading] = useState(true);
  const [searchLoading, setSearchLoading] = useState(false);
  const [searchResults, setSearchResults] = useState<DomainResult[]>([]);
  const [showResult, setShowResult] = useState(false);
  const [searchedDomain, setSearchedDomain] = useState('');
  const [typingPlaceholder, setTypingPlaceholder] = useState('');
  const [isTyping, setIsTyping] = useState(true);
  const [isDragging, setIsDragging] = useState(false);
  const [dragStartY, setDragStartY] = useState(0);
  const [dragOffset, setDragOffset] = useState(0);
  const modalRef = useRef<HTMLDivElement>(null);

  // GSAP Refs
  const heroRef = useRef<HTMLElement>(null);
  const headlineRef = useRef<HTMLHeadingElement>(null);
  const subtitleRef = useRef<HTMLParagraphElement>(null);
  const badgeRef = useRef<HTMLDivElement>(null);
  const featuresRef = useRef<HTMLDivElement>(null);
  const ctaRef = useRef<HTMLDivElement>(null);
  const servicesRef = useRef<HTMLDivElement>(null);
  const trustedRef = useRef<HTMLDivElement>(null);
  const lottieContainerRef = useRef<HTMLDivElement>(null);
  const [searchLottieLoaded, setSearchLottieLoaded] = useState(false);

  // Preload search Lottie animation
  useEffect(() => {
    const preloadLottie = async () => {
      try {
        const response = await fetch('/images/logos/Free Searching Animation.lottie');
        if (response.ok) {
          setSearchLottieLoaded(true);
        }
      } catch (e) {
        // Ignore preload errors
      }
    };
    preloadLottie();
  }, []);

  // Handle drag to close
  const handleDragStart = useCallback((e: React.MouseEvent | React.TouchEvent) => {
    setIsDragging(true);
    const clientY = 'touches' in e ? e.touches[0].clientY : e.clientY;
    setDragStartY(clientY);
  }, []);

  const handleDragMove = useCallback((e: React.MouseEvent | React.TouchEvent) => {
    if (!isDragging) return;
    const clientY = 'touches' in e ? e.touches[0].clientY : e.clientY;
    const offset = Math.max(0, clientY - dragStartY);
    setDragOffset(offset);
  }, [isDragging, dragStartY]);

  const handleDragEnd = useCallback(() => {
    if (dragOffset > 150) {
      setShowResult(false);
    }
    setIsDragging(false);
    setDragOffset(0);
  }, [dragOffset]);

  // GSAP Animations
  useEffect(() => {
    if (typeof window === 'undefined') return;

    const ctx = gsap.context(() => {
      // Timeline for hero content
      const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });

      // Badge animation
      if (badgeRef.current) {
        tl.fromTo(badgeRef.current, 
          { opacity: 0, y: -20, scale: 0.9 },
          { opacity: 1, y: 0, scale: 1, duration: 0.6 }
        );
      }

      // Headline animation with split text effect
      if (headlineRef.current) {
        const words = headlineRef.current.innerText.split(' ');
        headlineRef.current.innerHTML = words
          .map(word => `<span class="gsap-word" style="display:inline-block;opacity:0;transform:translateY(40px)">${word}</span>`)
          .join(' ');
        
        tl.to('.gsap-word', {
          opacity: 1,
          y: 0,
          duration: 0.6,
          stagger: 0.08,
          ease: 'back.out(1.2)',
        }, '-=0.3');
      }

      // Subtitle animation
      if (subtitleRef.current) {
        tl.fromTo(subtitleRef.current,
          { opacity: 0, y: 30 },
          { opacity: 1, y: 0, duration: 0.6 },
          '-=0.4'
        );
      }

      // Features animation
      if (featuresRef.current) {
        const features = featuresRef.current.querySelectorAll('.feature-item');
        tl.fromTo(features,
          { opacity: 0, y: 20, scale: 0.9 },
          { opacity: 1, y: 0, scale: 1, duration: 0.4, stagger: 0.1 },
          '-=0.3'
        );
      }

      // CTA buttons animation
      if (ctaRef.current) {
        const buttons = ctaRef.current.querySelectorAll('a, button');
        tl.fromTo(buttons,
          { opacity: 0, y: 20 },
          { opacity: 1, y: 0, duration: 0.5, stagger: 0.1 },
          '-=0.2'
        );
      }

      // Lottie container entrance animation
      if (lottieContainerRef.current) {
        tl.fromTo(lottieContainerRef.current,
          { opacity: 0, scale: 0.8, x: 50 },
          { opacity: 1, scale: 1, x: 0, duration: 1, ease: 'power3.out' },
          '-=0.5'
        );
      }

      // Services cards scroll animation
      if (servicesRef.current) {
        const serviceCards = servicesRef.current.querySelectorAll('.service-card');
        gsap.fromTo(serviceCards,
          { opacity: 0, y: 60, scale: 0.9 },
          {
            opacity: 1,
            y: 0,
            scale: 1,
            duration: 0.6,
            stagger: 0.1,
            ease: 'power3.out',
            scrollTrigger: {
              trigger: servicesRef.current,
              start: 'top 80%',
              toggleActions: 'play none none none',
            },
          }
        );
      }

      // Trusted section animation
      if (trustedRef.current) {
        const logos = trustedRef.current.querySelectorAll('.trust-logo');
        gsap.fromTo(logos,
          { opacity: 0, y: 30 },
          {
            opacity: 0.6,
            y: 0,
            duration: 0.5,
            stagger: 0.1,
            scrollTrigger: {
              trigger: trustedRef.current,
              start: 'top 85%',
              toggleActions: 'play none none none',
            },
          }
        );
      }

    }, heroRef);

    return () => ctx.revert();
  }, []);

  // Domain search function - checks multiple TLDs
  const handleDomainSearch = async (queryOverride?: string) => {
    const query = queryOverride || searchQuery;
    if (!query.trim()) return;
    
    setSearchLoading(true);
    setShowResult(true);
    setSearchResults([]);
    setModalSearchQuery(query);
    setSearchQuery(query);
    
    try {
      // Get base domain name (without extension)
      let baseDomain = query.trim().toLowerCase();
      if (baseDomain.includes('.')) {
        baseDomain = baseDomain.split('.')[0];
      }
      setSearchedDomain(baseDomain);
      
      // Extensions to check
      const extensions = ['.com', '.net', '.org', '.io', '.co', '.online', '.info', '.biz', '.store', '.tech'];
      
      // Check all extensions in parallel
      const results = await Promise.all(
        extensions.map(async (ext) => {
          try {
            const domain = `${baseDomain}${ext}`;
            const response = await fetch(`/api/whmcs/domains/check?domain=${encodeURIComponent(domain)}`);
            const data = await response.json();
            
            // Get price from TLDs list or from API response
            const tldPrice = tlds.find(t => t.extension === ext)?.price;
            
            return {
              domain,
              available: data.available,
              status: data.status,
              price: data.price || tldPrice || '$9.99'
            };
          } catch {
            return {
              domain: `${baseDomain}${ext}`,
              available: false,
              status: 'error',
              price: '$9.99'
            };
          }
        })
      );
      
      setSearchResults(results as DomainResult[]);
    } catch (error) {
      console.error('Error checking domains:', error);
      setSearchResults([]);
    } finally {
      setSearchLoading(false);
    }
  };

  // Handle Enter key press
  const handleKeyPress = (e: React.KeyboardEvent) => {
    if (e.key === 'Enter') {
      handleDomainSearch();
    }
  };

  // Typing animation effect
  useEffect(() => {
    if (searchQuery) {
      setIsTyping(false);
      return;
    }
    
    setIsTyping(true);
    const examples = locale === 'ar' 
      ? ['mybusiness.com', 'mystore.net', 'mycompany.org', 'mywebsite.com']
      : ['mybusiness.com', 'mystore.net', 'mycompany.org', 'mywebsite.com'];
    
    let exampleIndex = 0;
    let charIndex = 0;
    let isDeleting = false;
    let isPaused = false;
    
    const typeInterval = setInterval(() => {
      if (isPaused) return;
      
      const currentExample = examples[exampleIndex];
      
      if (!isDeleting) {
        const currentText = currentExample.substring(0, charIndex + 1);
        setTypingPlaceholder(currentText);
        charIndex++;
        
        if (charIndex === currentExample.length) {
          isPaused = true;
          setTimeout(() => {
            isPaused = false;
            isDeleting = true;
          }, 2000); // Wait 2 seconds before deleting
        }
      } else {
        charIndex--;
        const currentText = currentExample.substring(0, charIndex);
        setTypingPlaceholder(currentText);
        
        if (charIndex === 0) {
          isDeleting = false;
          exampleIndex = (exampleIndex + 1) % examples.length;
          // Wait 3 seconds before typing new word
          isPaused = true;
          setTimeout(() => {
            isPaused = false;
          }, 3000);
        }
      }
    }, isDeleting ? 100 : 120); // 120ms per char typing, 100ms for deleting
    
    return () => clearInterval(typeInterval);
  }, [searchQuery, locale]);

  // Fetch TLDs from WHMCS API
  useEffect(() => {
    const fetchTLDs = async () => {
      try {
        const response = await fetch('/api/whmcs/domains/tlds');
        const data = await response.json();
        
        if (data.tlds && data.tlds.length > 0) {
          setTlds(data.tlds.slice(0, 5)); // Show max 5 TLDs
        } else {
          // Fallback TLDs if API fails
          setTlds([
            { extension: '.com', price: '$9.99', isFree: false },
            { extension: '.net', price: '$12.99', isFree: false },
            { extension: '.ae', price: '$29.99', isFree: false },
          ]);
        }
      } catch (error) {
        console.error('Error fetching TLDs:', error);
        // Fallback TLDs on error
        setTlds([
          { extension: '.com', price: '$9.99', isFree: false },
          { extension: '.net', price: '$12.99', isFree: false },
          { extension: '.ae', price: '$29.99', isFree: false },
        ]);
      } finally {
        setTldsLoading(false);
      }
    };

    fetchTLDs();
  }, []);

  const features = [
    { icon: Zap, text: locale === 'ar' ? 'سرعة فائقة' : 'Ultra Fast' },
    { icon: Shield, text: locale === 'ar' ? 'حماية كاملة' : 'Full Security' },
    { icon: Clock, text: locale === 'ar' ? 'دعم 24/7' : '24/7 Support' },
  ];

  return (
    <section ref={heroRef} className="relative overflow-hidden">
      {/* Domain Search Bar */}
      <div className="bg-white py-3 shadow-sm sm:py-4">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="flex flex-col items-center gap-3 sm:gap-4 lg:flex-row lg:justify-between">
            {/* Search Input - Left */}
            <div className="relative w-full lg:w-auto lg:flex-1 lg:max-w-lg">
              <Search className="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400 sm:left-4 sm:h-5 sm:w-5" />
              <input
                type="text"
                value={searchQuery}
                onChange={(e) => {
                  setSearchQuery(e.target.value);
                  setShowResult(false);
                }}
                onKeyPress={handleKeyPress}
                placeholder={isTyping && typingPlaceholder ? typingPlaceholder : (locale === 'ar' ? 'ابحث عن اسم نطاقك المثالي...' : 'Find your perfect domain name...')}
                className="w-full rounded-full border border-gray-200 bg-gray-50 py-2.5 pl-10 pr-24 text-sm text-left transition-all focus:border-[#1d71b8] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1d71b8]/20 sm:py-3 sm:pl-12 sm:pr-32"
                dir="ltr"
              />
              <button 
                onClick={() => handleDomainSearch()}
                disabled={searchLoading || !searchQuery.trim()}
                className="absolute right-1 top-1/2 -translate-y-1/2 rounded-full bg-[#1d71b8] px-4 py-1.5 text-xs font-semibold text-white transition-all hover:bg-[#155a94] disabled:cursor-not-allowed disabled:opacity-50 sm:right-1.5 sm:px-6 sm:py-2 sm:text-sm"
              >
                {searchLoading ? (
                  <Loader2 className="h-4 w-4 animate-spin" />
                ) : (
                  locale === 'ar' ? 'بحث' : 'Search'
                )}
              </button>
            </div>
            
            {/* Domain Extensions - Dynamic from API */}
            <div className="flex flex-wrap items-center justify-center gap-1.5 sm:gap-2">
              {tldsLoading ? (
                <div className="flex items-center gap-2 text-gray-500">
                  <Loader2 className="h-4 w-4 animate-spin" />
                  <span className="text-xs sm:text-sm">{locale === 'ar' ? 'جاري التحميل...' : 'Loading...'}</span>
                </div>
              ) : (
                tlds.map((tld, index) => (
                  <div 
                    key={tld.extension}
                    className={`flex items-center gap-1 rounded-full px-2.5 py-1.5 sm:gap-2 sm:px-4 sm:py-2 ${
                      index < 2 ? 'bg-blue-50' : 'bg-gray-100'
                    }`}
                  >
                    <span className={`text-xs font-bold sm:text-sm ${index < 2 ? 'text-[#1d71b8]' : 'text-gray-700'}`}>
                      {tld.extension}
                    </span>
                    {tld.isFree ? (
                      <span className="rounded-full bg-[#1d71b8] px-1.5 py-0.5 text-[8px] font-medium text-white sm:px-2 sm:text-[10px]">
                        {locale === 'ar' ? 'مجاني' : 'FREE'}
                      </span>
                    ) : (
                      <span className="text-xs font-semibold text-[#1d71b8] sm:text-sm">{tld.price}</span>
                    )}
                  </div>
                ))
              )}
            </div>
          </div>
        </div>
      </div>

      {/* Domain Search Results - Full Screen Slide Up (below navbar) */}
      {showResult && (
        <div 
          ref={modalRef}
          className="fixed inset-x-0 bottom-0 top-[72px] z-40 bg-white transform transition-transform duration-300 ease-out overflow-hidden rounded-t-3xl shadow-2xl"
          style={{ transform: `translateY(${dragOffset}px)` }}
          onMouseMove={handleDragMove}
          onMouseUp={handleDragEnd}
          onMouseLeave={handleDragEnd}
          onTouchMove={handleDragMove}
          onTouchEnd={handleDragEnd}
        >
          {/* Drag Handle */}
          <div 
            className="flex justify-center py-3 cursor-grab active:cursor-grabbing select-none"
            onMouseDown={handleDragStart}
            onTouchStart={handleDragStart}
          >
            <div className="w-12 h-1.5 bg-gray-300 rounded-full hover:bg-gray-400 transition-colors" />
          </div>

          {/* Close Button */}
          <button 
            onClick={() => setShowResult(false)}
            className="absolute top-3 right-4 p-2 rounded-full hover:bg-gray-100 transition-colors z-10"
            title={locale === 'ar' ? 'إغلاق' : 'Close'}
          >
            <X className="h-6 w-6 text-gray-500" />
          </button>

          {/* Title */}
          <div className="text-center pb-4 border-b border-gray-100">
            <h2 className="text-xl font-bold text-gray-900">
              {locale === 'ar' ? 'بحث عن اسم النطاق' : 'Domain Name Search'}
            </h2>
          </div>

          {/* Search Input in Modal */}
          <div className="px-4 py-4 border-b border-gray-100">
            <div className="mx-auto max-w-xl relative">
              <Search className="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400" />
              <input
                type="text"
                value={modalSearchQuery}
                onChange={(e) => setModalSearchQuery(e.target.value)}
                onKeyPress={(e) => {
                  if (e.key === 'Enter' && modalSearchQuery.trim()) {
                    handleDomainSearch(modalSearchQuery);
                  }
                }}
                placeholder={searchedDomain || (locale === 'ar' ? 'ابحث عن نطاق...' : 'Search for a domain...')}
                className="w-full rounded-full border border-gray-200 bg-gray-50 py-3 pl-12 pr-24 text-base focus:border-[#1d71b8] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1d71b8]/20"
                dir="ltr"
              />
              <button 
                onClick={() => {
                  if (modalSearchQuery.trim()) {
                    handleDomainSearch(modalSearchQuery);
                  }
                }}
                className="absolute right-2 top-1/2 -translate-y-1/2 rounded-full bg-gray-900 px-6 py-2 text-sm font-semibold text-white hover:bg-gray-800 transition-colors"
              >
                {locale === 'ar' ? 'بحث' : 'Search'}
              </button>
            </div>
          </div>

          {/* Results List */}
          <div className="overflow-y-auto" style={{ height: 'calc(100vh - 180px)' }}>
            <div className="mx-auto max-w-2xl px-4 py-4">
              {/* Modern Search Loader */}
              <div className={`flex flex-col items-center justify-center py-16 ${searchLoading ? '' : 'hidden'}`}>
                {/* Animated Search Icon with Ripple Effect */}
                <div className="relative">
                  {/* Ripple circles */}
                  <div className="absolute inset-0 flex items-center justify-center">
                    <div className="absolute h-24 w-24 animate-ping rounded-full bg-[#1d71b8]/20" style={{ animationDuration: '1.5s' }} />
                    <div className="absolute h-32 w-32 animate-ping rounded-full bg-[#1d71b8]/10" style={{ animationDuration: '2s', animationDelay: '0.5s' }} />
                  </div>
                  
                  {/* Main loader circle */}
                  <div className="relative flex h-20 w-20 items-center justify-center">
                    {/* Spinning gradient ring */}
                    <div className="absolute inset-0 animate-spin rounded-full border-4 border-transparent border-t-[#1d71b8] border-r-[#1d71b8]/50" style={{ animationDuration: '1s' }} />
                    
                    {/* Inner pulsing circle */}
                    <div className="absolute inset-2 animate-pulse rounded-full bg-gradient-to-br from-[#1d71b8]/20 to-[#1d71b8]/5" />
                    
                    {/* Search icon */}
                    <Search className="h-8 w-8 text-[#1d71b8] animate-pulse" />
                  </div>
                </div>
                
                {/* Animated text */}
                <div className="mt-6 flex flex-col items-center gap-2">
                  <p className="text-lg font-medium text-gray-700">
                    {locale === 'ar' ? 'جاري البحث عن نطاقك...' : 'Searching for your domain...'}
                  </p>
                  <div className="flex gap-1">
                    <span className="h-2 w-2 animate-bounce rounded-full bg-[#1d71b8]" style={{ animationDelay: '0ms' }} />
                    <span className="h-2 w-2 animate-bounce rounded-full bg-[#1d71b8]" style={{ animationDelay: '150ms' }} />
                    <span className="h-2 w-2 animate-bounce rounded-full bg-[#1d71b8]" style={{ animationDelay: '300ms' }} />
                  </div>
                </div>
              </div>
              
              {!searchLoading && (
                <div className="flex flex-col divide-y divide-gray-100">
                  {searchResults.map((result) => (
                    <div 
                      key={result.domain}
                      className="flex items-center justify-between py-4 hover:bg-gray-50 px-2 -mx-2 rounded-lg transition-colors"
                    >
                      {/* Left Side - Domain Info */}
                      <div className="flex items-center gap-3">
                        <CheckCircle className={`h-5 w-5 ${result.available ? 'text-green-500' : 'text-gray-300'}`} />
                        <div>
                          <div className="flex items-center gap-2">
                            <span className="text-xs font-semibold uppercase tracking-wide text-green-600">
                              {result.available 
                                ? (locale === 'ar' ? 'متاح' : 'AVAILABLE')
                                : (locale === 'ar' ? 'محجوز' : 'TAKEN')
                              }
                            </span>
                          </div>
                          <p className="text-base font-semibold text-gray-900" dir="ltr">
                            {result.domain.split('.')[0]}.<span className="font-bold">{result.domain.split('.').slice(1).join('.')}</span>
                          </p>
                        </div>
                      </div>

                      {/* Right Side - Price & Action */}
                      {result.available && (
                        <div className="flex items-center gap-3">
                          <span className="text-lg font-bold text-gray-900">
                            {result.price}<span className="text-sm font-normal text-gray-500">/{locale === 'ar' ? 'سنة' : 'yr'}</span>
                          </span>
                          <a 
                            href={`https://app.progineous.com/cart.php?a=add&domain=register&domains[]=${result.domain}`}
                            target="_blank"
                            rel="noopener noreferrer"
                            className="flex items-center justify-center h-10 w-10 rounded-lg border-2 border-gray-200 bg-white text-gray-600 hover:border-[#1d71b8] hover:text-[#1d71b8] transition-all"
                          >
                            <ShoppingCart className="h-5 w-5" />
                          </a>
                        </div>
                      )}
                    </div>
                  ))}

                  {/* No Results */}
                  {searchResults.length === 0 && !searchLoading && (
                    <div className="text-center py-12">
                      <Search className="h-12 w-12 text-gray-300 mx-auto mb-4" />
                      <p className="text-gray-500">
                        {locale === 'ar' ? 'ابدأ البحث للعثور على نطاقك المثالي' : 'Start searching to find your perfect domain'}
                      </p>
                    </div>
                  )}
                </div>
              )}
            </div>
          </div>
        </div>
      )}

      {/* Main Hero Section */}
      <div className="relative min-h-[600px] bg-gradient-to-br from-[#0f2d3d] via-[#1a4a5e] to-[#1d71b8]/80 sm:min-h-[680px] lg:min-h-[750px]">
        {/* Background Pattern */}
        <div className="absolute inset-0 opacity-10">
          <div className="absolute inset-0" style={{ backgroundImage: 'radial-gradient(circle at 2px 2px, white 1px, transparent 0)', backgroundSize: '40px 40px' }}></div>
        </div>

        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid min-h-[600px] items-center gap-6 py-16 sm:min-h-[680px] sm:gap-8 sm:py-20 lg:min-h-[750px] lg:grid-cols-2 lg:gap-8 lg:py-0 xl:gap-12">
            
            {/* Left Content */}
            <div className="relative z-10 text-center lg:text-start">
              {/* Trust Badges */}
              <div ref={badgeRef} className="mb-4 flex flex-wrap items-center justify-center gap-2 sm:mb-6 sm:gap-4 lg:justify-start">
                <div className="flex items-center gap-1.5 rounded-full bg-white/10 px-2.5 py-1 backdrop-blur-sm sm:gap-2 sm:px-3 sm:py-1.5">
                  <div className="flex">
                    {[1,2,3,4,5].map(i => (
                      <Star key={i} className="h-3 w-3 fill-amber-400 text-amber-400 sm:h-3.5 sm:w-3.5" />
                    ))}
                  </div>
                  <span className="text-[10px] font-medium text-white sm:text-xs">4.9/5 Trustpilot</span>
                </div>
                <div className="flex items-center gap-2 rounded-full bg-white/10 px-2.5 py-1 backdrop-blur-sm sm:px-3 sm:py-1.5">
                  <span className="text-[10px] font-medium text-white sm:text-xs">+50,000 {locale === 'ar' ? 'عميل سعيد' : 'Happy Clients'}</span>
                </div>
              </div>

              {/* Headline */}
              <h1 ref={headlineRef} className="text-2xl font-extrabold leading-tight text-white sm:text-3xl md:text-4xl lg:text-5xl">
                {locale === 'ar' 
                  ? 'السرعة والأمان استضافة احترافية للنمو الحقيقي'
                  : 'Speed Security Professional Hosting for Serious Growth'
                }
              </h1>

              {/* Subtitle */}
              <p ref={subtitleRef} className="mx-auto mt-4 max-w-md text-sm leading-relaxed text-white/70 sm:mt-6 sm:text-base lg:mx-0 lg:text-lg">
                {locale === 'ar'
                  ? 'نتولى التحديثات والتخزين المؤقت والنسخ الاحتياطي والأمان - أنت ركز على نجاح عملك.'
                  : "We handle updates, caching, backups & security – you focus on growing your business."}
              </p>

              {/* Features */}
              <div ref={featuresRef} className="mt-4 flex flex-wrap items-center justify-center gap-3 sm:mt-6 sm:gap-4 lg:justify-start">
                {features.map((feature, idx) => (
                  <div key={idx} className="feature-item flex items-center gap-1.5 text-white/80 sm:gap-2">
                    <feature.icon className="h-3.5 w-3.5 text-[#60a5fa] sm:h-4 sm:w-4" />
                    <span className="text-xs sm:text-sm">{feature.text}</span>
                  </div>
                ))}
              </div>

              {/* CTA */}
              <div ref={ctaRef} className="mt-6 flex flex-col items-center gap-3 sm:mt-8 sm:flex-row sm:gap-4 lg:justify-start">
                <Link
                  href="/hosting/shared"
                  className="group inline-flex items-center justify-center gap-2 rounded-full bg-[#1d71b8] px-8 py-3.5 text-base font-semibold text-white shadow-lg shadow-[#1d71b8]/30 transition-all hover:bg-[#155a94] hover:shadow-xl"
                >
                  {locale === 'ar' ? 'ابدأ الآن بـ $2' : 'Start Now for $2'}
                  <ArrowRight className="h-4 w-4 transition-transform group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1" />
                </Link>
                <a
                  href="#hosting-plans"
                  className="inline-flex items-center justify-center gap-2 rounded-full border-2 border-white px-8 py-3.5 text-base font-semibold text-white transition-all hover:bg-white hover:text-[#1d71b8]"
                >
                  {locale === 'ar' ? 'شاهد الخطط' : 'View Plans'}
                </a>
              </div>
            </div>

            {/* Right Side - Lottie Animation */}
            <div 
              ref={lottieContainerRef}
              className="relative hidden lg:flex items-center justify-center [&_svg_path]:!fill-white [&_svg_*]:!stroke-white"
              style={{ filter: 'brightness(0) invert(1)' }}
            >
              <DotLottieReact
                src="/images/logos/Graphic - Hosting.lottie"
                loop
                autoplay
                className="h-[350px] w-[350px] lg:h-[400px] lg:w-[400px] xl:h-[450px] xl:w-[450px] 2xl:h-[500px] 2xl:w-[500px]"
              />
            </div>
          </div>
        </div>

        {/* Wave Divider */}
        <div className="absolute bottom-0 left-0 right-0">
          <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" className="w-full">
            <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white"/>
          </svg>
        </div>
      </div>
    </section>
  );
}
