'use client';

import Image, { ImageProps } from 'next/image';
import { useState } from 'react';
import { cn } from '@/lib/utils';

interface OptimizedImageProps extends Omit<ImageProps, 'onLoadingComplete'> {
  /**
   * Alt text is required for SEO and accessibility
   * Should be descriptive and include relevant keywords naturally
   */
  alt: string;
  /**
   * Add blur placeholder for better perceived performance
   */
  withBlur?: boolean;
  /**
   * Custom blur data URL
   */
  blurDataURL?: string;
  /**
   * Aspect ratio for the container (e.g., "16/9", "4/3", "1/1")
   */
  aspectRatio?: string;
  /**
   * Show loading skeleton
   */
  showSkeleton?: boolean;
}

/**
 * OptimizedImage Component
 * 
 * SEO and Performance optimized image component following Google's guidelines:
 * - Lazy loading by default (loading="lazy")
 * - Proper alt text for accessibility and SEO
 * - Blur placeholder for better LCP (Largest Contentful Paint)
 * - Responsive sizing with srcSet
 * - WebP/AVIF automatic conversion via Next.js Image
 * 
 * @see https://developers.google.com/search/docs/appearance/google-images
 * @see https://web.dev/lcp/
 */
export function OptimizedImage({
  alt,
  withBlur = true,
  blurDataURL,
  aspectRatio,
  showSkeleton = true,
  className,
  priority = false,
  ...props
}: OptimizedImageProps) {
  const [isLoaded, setIsLoaded] = useState(false);
  const [hasError, setHasError] = useState(false);

  // Default blur placeholder (small gray image)
  const defaultBlurDataURL = 
    'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZTVlN2ViIi8+PC9zdmc+';

  if (hasError) {
    return (
      <div
        className={cn(
          'flex items-center justify-center bg-gray-100 text-gray-400',
          aspectRatio && `aspect-[${aspectRatio}]`,
          className
        )}
        role="img"
        aria-label={alt}
      >
        <svg
          className="w-12 h-12"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            strokeLinecap="round"
            strokeLinejoin="round"
            strokeWidth={1.5}
            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
          />
        </svg>
      </div>
    );
  }

  return (
    <div
      className={cn(
        'relative overflow-hidden',
        aspectRatio && `aspect-[${aspectRatio}]`,
        !isLoaded && showSkeleton && 'animate-pulse bg-gray-200'
      )}
    >
      <Image
        {...props}
        alt={alt}
        className={cn(
          'transition-opacity duration-300',
          !isLoaded && 'opacity-0',
          isLoaded && 'opacity-100',
          className
        )}
        loading={priority ? 'eager' : 'lazy'}
        priority={priority}
        placeholder={withBlur ? 'blur' : 'empty'}
        blurDataURL={withBlur ? (blurDataURL || defaultBlurDataURL) : undefined}
        onLoad={() => setIsLoaded(true)}
        onError={() => setHasError(true)}
        // Enable modern formats
        unoptimized={false}
      />
    </div>
  );
}

/**
 * Generates optimized alt text suggestions based on context
 * Following Google's image SEO best practices
 */
export function generateAltText(options: {
  subject: string;
  context?: string;
  brand?: string;
  action?: string;
}): string {
  const { subject, context, brand, action } = options;
  
  let altText = subject;
  
  if (action) {
    altText = `${action} ${altText}`;
  }
  
  if (context) {
    altText = `${altText} - ${context}`;
  }
  
  if (brand) {
    altText = `${altText} | ${brand}`;
  }
  
  return altText;
}

/**
 * Image SEO Guidelines from Google:
 * 
 * 1. Use descriptive alt text (required)
 *    - Bad: "image1.jpg" or "photo"
 *    - Good: "Golden retriever puppy playing in the park"
 * 
 * 2. Use descriptive filenames
 *    - Bad: "IMG_12345.jpg"
 *    - Good: "shared-hosting-dashboard-progineous.jpg"
 * 
 * 3. Use responsive images
 *    - Next.js Image component handles this automatically
 * 
 * 4. Use modern formats (WebP, AVIF)
 *    - Next.js Image component handles this automatically
 * 
 * 5. Implement lazy loading
 *    - Default behavior in this component
 * 
 * 6. Optimize for Core Web Vitals (LCP)
 *    - Use priority for above-the-fold images
 *    - Use blur placeholder for perceived performance
 */
