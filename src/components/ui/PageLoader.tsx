'use client';

import { useEffect, useState, useCallback, useRef } from 'react';
import { usePathname, useSearchParams } from 'next/navigation';

export function PageLoader() {
  const [isLoading, setIsLoading] = useState(true);
  const [isVisible, setIsVisible] = useState(true);
  const pathname = usePathname();
  const searchParams = useSearchParams();
  const isFirstLoad = useRef(true);

  // Hide loader function
  const hideLoader = useCallback(() => {
    setIsLoading(false);
    setTimeout(() => setIsVisible(false), 300);
  }, []);

  // Show loader function
  const showLoader = useCallback(() => {
    setIsVisible(true);
    setIsLoading(true);
  }, []);

  // Initial page load - wait for DOM to be ready
  useEffect(() => {
    if (!isFirstLoad.current) return;
    
    const checkReady = () => {
      if (document.readyState === 'complete') {
        // Add small delay for smooth experience
        setTimeout(hideLoader, 300);
        isFirstLoad.current = false;
      }
    };

    // Check if already loaded
    if (document.readyState === 'complete') {
      setTimeout(hideLoader, 300);
      isFirstLoad.current = false;
    } else {
      // Wait for load event
      window.addEventListener('load', checkReady);
      document.addEventListener('readystatechange', checkReady);
      
      return () => {
        window.removeEventListener('load', checkReady);
        document.removeEventListener('readystatechange', checkReady);
      };
    }
  }, [hideLoader]);

  // Handle route changes - hide when new page is ready
  useEffect(() => {
    if (isFirstLoad.current) return;
    
    // Small delay to ensure content is rendered
    const timer = setTimeout(hideLoader, 200);
    return () => clearTimeout(timer);
  }, [pathname, searchParams, hideLoader]);

  // Listen for link clicks to show loader during navigation
  useEffect(() => {
    const handleClick = (e: MouseEvent) => {
      const target = e.target as HTMLElement;
      const link = target.closest('a');
      
      if (link && link.href && !link.target && !link.download) {
        try {
          const url = new URL(link.href);
          const currentUrl = new URL(window.location.href);
          
          // Only show loader for internal navigation to different pages
          if (url.origin === currentUrl.origin && url.pathname !== currentUrl.pathname) {
            showLoader();
          }
        } catch {
          // Invalid URL, ignore
        }
      }
    };

    document.addEventListener('click', handleClick);
    return () => document.removeEventListener('click', handleClick);
  }, [showLoader]);

  if (!isVisible) return null;

  return (
    <div
      className={`fixed inset-0 z-[9999] flex items-center justify-center bg-white transition-opacity duration-300 ${
        isLoading ? 'opacity-100' : 'opacity-0 pointer-events-none'
      }`}
    >
      <div className="flex flex-col items-center gap-6">
        {/* Logo with Animation */}
        <div className="relative">
          {/* Rotating Ring */}
          <div className="absolute -inset-4">
            <div className="h-full w-full animate-spin rounded-full border-4 border-transparent border-t-[#1d71b8] border-r-[#1d71b8]/30" style={{ animationDuration: '1s' }} />
          </div>
          
          {/* Pulsing Background */}
          <div className="absolute -inset-2 animate-pulse rounded-full bg-[#1d71b8]/10" />
          
          {/* Logo */}
          <div className="relative flex h-20 w-20 items-center justify-center">
            <img 
              src="/pro Gineous_favico.svg" 
              alt="Pro Gineous" 
              className="h-12 w-12 animate-pulse"
            />
          </div>
        </div>

        {/* Loading Text */}
        <div className="flex flex-col items-center gap-2">
          <div className="text-lg font-semibold text-gray-800">Pro Gineous</div>
          
          {/* Animated Dots */}
          <div className="flex items-center gap-1.5">
            <span 
              className="h-2 w-2 animate-bounce rounded-full bg-[#1d71b8]" 
              style={{ animationDelay: '0ms' }} 
            />
            <span 
              className="h-2 w-2 animate-bounce rounded-full bg-[#1d71b8]" 
              style={{ animationDelay: '150ms' }} 
            />
            <span 
              className="h-2 w-2 animate-bounce rounded-full bg-[#1d71b8]" 
              style={{ animationDelay: '300ms' }} 
            />
          </div>
        </div>
      </div>
    </div>
  );
}
