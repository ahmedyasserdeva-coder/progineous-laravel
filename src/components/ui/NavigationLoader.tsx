'use client';

import { useEffect, useState } from 'react';
import { usePathname } from 'next/navigation';

export function NavigationLoader() {
  const [isLoading, setIsLoading] = useState(true); // Start with loading true for initial page load
  const [minTimeElapsed, setMinTimeElapsed] = useState(false);
  const pathname = usePathname();

  // Initial page load - show loader for 3 seconds
  useEffect(() => {
    const timer = setTimeout(() => {
      setMinTimeElapsed(true);
    }, 3000);

    return () => clearTimeout(timer);
  }, []);

  // Hide loader when minimum time has elapsed
  useEffect(() => {
    if (minTimeElapsed) {
      setIsLoading(false);
    }
  }, [minTimeElapsed]);

  // Listen for clicks on links for navigation
  useEffect(() => {
    const handleClick = (e: MouseEvent) => {
      const target = e.target as HTMLElement;
      const link = target.closest('a');
      
      if (link && link.href && !link.target && !link.download) {
        const url = new URL(link.href);
        const currentUrl = new URL(window.location.href);
        
        // Check if it's an internal navigation (same origin, different path)
        if (url.origin === currentUrl.origin && url.pathname !== currentUrl.pathname) {
          setIsLoading(true);
          setMinTimeElapsed(false);
          
          // Set minimum display time to 3 seconds
          setTimeout(() => {
            setMinTimeElapsed(true);
          }, 3000);
        }
      }
    };

    document.addEventListener('click', handleClick);
    return () => document.removeEventListener('click', handleClick);
  }, []);

  if (!isLoading) return null;

  return (
    <div className="fixed inset-0 z-[9999] flex items-center justify-center bg-white/95 backdrop-blur-sm">
      <div className="flex flex-col items-center gap-6">
        {/* Logo Container with Effects */}
        <div className="relative">
          {/* Outer Rotating Ring */}
          <div className="absolute -inset-6">
            <svg className="h-full w-full loader-spin-slow" viewBox="0 0 100 100">
              <circle
                cx="50"
                cy="50"
                r="45"
                fill="none"
                stroke="#1d71b8"
                strokeWidth="2"
                strokeDasharray="70 200"
                strokeLinecap="round"
              />
            </svg>
          </div>

          {/* Inner Rotating Ring (opposite direction) */}
          <div className="absolute -inset-3">
            <svg className="h-full w-full loader-spin-reverse" viewBox="0 0 100 100">
              <circle
                cx="50"
                cy="50"
                r="45"
                fill="none"
                stroke="#1d71b8"
                strokeWidth="1.5"
                strokeDasharray="40 150"
                strokeLinecap="round"
                opacity="0.5"
              />
            </svg>
          </div>
          
          {/* Pulsing Glow */}
          <div className="absolute -inset-1 animate-pulse rounded-full bg-gradient-to-r from-[#1d71b8]/20 to-[#60a5fa]/20 blur-md" />
          
          {/* Logo */}
          <div className="relative flex h-24 w-24 items-center justify-center rounded-full bg-white shadow-lg">
            <img 
              src="/pro Gineous_favico.svg" 
              alt="Pro Gineous" 
              className="h-14 w-14 loader-pulse-img"
            />
          </div>
        </div>

        {/* Brand Name */}
        <div className="flex flex-col items-center gap-3">
          <div className="bg-gradient-to-r from-[#1d71b8] to-[#0f4c75] bg-clip-text text-xl font-bold text-transparent">
            Pro Gineous
          </div>
          
          {/* Loading Dots */}
          <div className="flex items-center gap-1.5">
            <span className="h-2 w-2 rounded-full bg-[#1d71b8] loader-bounce-1" />
            <span className="h-2 w-2 rounded-full bg-[#1d71b8] loader-bounce-2" />
            <span className="h-2 w-2 rounded-full bg-[#1d71b8] loader-bounce-3" />
          </div>
        </div>
      </div>
    </div>
  );
}
