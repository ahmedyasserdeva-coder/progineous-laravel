'use client';

import { useRef, useEffect, useCallback } from 'react';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { TextPlugin } from 'gsap/TextPlugin';
import { MotionPathPlugin } from 'gsap/MotionPathPlugin';

// Register GSAP plugins
if (typeof window !== 'undefined') {
  gsap.registerPlugin(ScrollTrigger, TextPlugin, MotionPathPlugin);
}

/**
 * Custom hook for GSAP animations
 */
export function useGSAP() {
  const tl = useRef<gsap.core.Timeline | null>(null);

  // Cleanup on unmount
  useEffect(() => {
    return () => {
      tl.current?.kill();
      ScrollTrigger.getAll().forEach(st => st.kill());
    };
  }, []);

  return {
    gsap,
    timeline: tl,
    ScrollTrigger,
  };
}

/**
 * Fade In animation
 */
export function useFadeIn(
  ref: React.RefObject<HTMLElement>,
  options: {
    duration?: number;
    delay?: number;
    y?: number;
    x?: number;
    scale?: number;
    ease?: string;
    scrollTrigger?: boolean;
  } = {}
) {
  useEffect(() => {
    if (!ref.current) return;

    const {
      duration = 1,
      delay = 0,
      y = 50,
      x = 0,
      scale = 1,
      ease = 'power3.out',
      scrollTrigger = true,
    } = options;

    const animation = gsap.fromTo(
      ref.current,
      {
        opacity: 0,
        y,
        x,
        scale: scale === 1 ? 1 : 0.9,
      },
      {
        opacity: 1,
        y: 0,
        x: 0,
        scale: 1,
        duration,
        delay,
        ease,
        scrollTrigger: scrollTrigger
          ? {
              trigger: ref.current,
              start: 'top 80%',
              toggleActions: 'play none none none',
            }
          : undefined,
      }
    );

    return () => {
      animation.kill();
    };
  }, [ref, options]);
}

/**
 * Stagger children animation
 */
export function useStaggerChildren(
  containerRef: React.RefObject<HTMLElement>,
  childSelector: string,
  options: {
    duration?: number;
    stagger?: number;
    y?: number;
    ease?: string;
    scrollTrigger?: boolean;
  } = {}
) {
  useEffect(() => {
    if (!containerRef.current) return;

    const {
      duration = 0.8,
      stagger = 0.1,
      y = 30,
      ease = 'power3.out',
      scrollTrigger = true,
    } = options;

    const children = containerRef.current.querySelectorAll(childSelector);

    const animation = gsap.fromTo(
      children,
      {
        opacity: 0,
        y,
      },
      {
        opacity: 1,
        y: 0,
        duration,
        stagger,
        ease,
        scrollTrigger: scrollTrigger
          ? {
              trigger: containerRef.current,
              start: 'top 80%',
              toggleActions: 'play none none none',
            }
          : undefined,
      }
    );

    return () => {
      animation.kill();
    };
  }, [containerRef, childSelector, options]);
}

/**
 * Text reveal animation (character by character)
 */
export function useTextReveal(
  ref: React.RefObject<HTMLElement>,
  options: {
    duration?: number;
    stagger?: number;
    ease?: string;
    delay?: number;
  } = {}
) {
  useEffect(() => {
    if (!ref.current) return;

    const element = ref.current;
    const text = element.textContent || '';
    
    // Split text into spans
    element.innerHTML = text
      .split('')
      .map(char => `<span class="gsap-char" style="display:inline-block">${char === ' ' ? '&nbsp;' : char}</span>`)
      .join('');

    const {
      duration = 0.05,
      stagger = 0.03,
      ease = 'power2.out',
      delay = 0,
    } = options;

    const animation = gsap.fromTo(
      element.querySelectorAll('.gsap-char'),
      {
        opacity: 0,
        y: 20,
      },
      {
        opacity: 1,
        y: 0,
        duration,
        stagger,
        ease,
        delay,
      }
    );

    return () => {
      animation.kill();
      element.textContent = text;
    };
  }, [ref, options]);
}

/**
 * Parallax effect on scroll
 */
export function useParallax(
  ref: React.RefObject<HTMLElement>,
  speed: number = 0.5
) {
  useEffect(() => {
    if (!ref.current) return;

    const animation = gsap.to(ref.current, {
      yPercent: -100 * speed,
      ease: 'none',
      scrollTrigger: {
        trigger: ref.current,
        start: 'top bottom',
        end: 'bottom top',
        scrub: true,
      },
    });

    return () => {
      animation.kill();
    };
  }, [ref, speed]);
}

/**
 * Magnetic hover effect
 */
export function useMagnetic(ref: React.RefObject<HTMLElement>, strength: number = 0.3) {
  useEffect(() => {
    if (!ref.current) return;

    const element = ref.current;

    const handleMouseMove = (e: MouseEvent) => {
      const rect = element.getBoundingClientRect();
      const x = e.clientX - rect.left - rect.width / 2;
      const y = e.clientY - rect.top - rect.height / 2;

      gsap.to(element, {
        x: x * strength,
        y: y * strength,
        duration: 0.3,
        ease: 'power2.out',
      });
    };

    const handleMouseLeave = () => {
      gsap.to(element, {
        x: 0,
        y: 0,
        duration: 0.5,
        ease: 'elastic.out(1, 0.3)',
      });
    };

    element.addEventListener('mousemove', handleMouseMove);
    element.addEventListener('mouseleave', handleMouseLeave);

    return () => {
      element.removeEventListener('mousemove', handleMouseMove);
      element.removeEventListener('mouseleave', handleMouseLeave);
    };
  }, [ref, strength]);
}

/**
 * Counter animation
 */
export function useCounter(
  ref: React.RefObject<HTMLElement>,
  endValue: number,
  options: {
    duration?: number;
    delay?: number;
    prefix?: string;
    suffix?: string;
    decimals?: number;
  } = {}
) {
  useEffect(() => {
    if (!ref.current) return;

    const {
      duration = 2,
      delay = 0,
      prefix = '',
      suffix = '',
      decimals = 0,
    } = options;

    const obj = { value: 0 };

    const animation = gsap.to(obj, {
      value: endValue,
      duration,
      delay,
      ease: 'power2.out',
      scrollTrigger: {
        trigger: ref.current,
        start: 'top 80%',
        toggleActions: 'play none none none',
      },
      onUpdate: () => {
        if (ref.current) {
          ref.current.textContent = `${prefix}${obj.value.toFixed(decimals)}${suffix}`;
        }
      },
    });

    return () => {
      animation.kill();
    };
  }, [ref, endValue, options]);
}

/**
 * Floating animation (continuous)
 */
export function useFloat(
  ref: React.RefObject<HTMLElement>,
  options: {
    y?: number;
    duration?: number;
    ease?: string;
  } = {}
) {
  useEffect(() => {
    if (!ref.current) return;

    const { y = 10, duration = 2, ease = 'sine.inOut' } = options;

    const animation = gsap.to(ref.current, {
      y: `-=${y}`,
      duration,
      ease,
      repeat: -1,
      yoyo: true,
    });

    return () => {
      animation.kill();
    };
  }, [ref, options]);
}

/**
 * Motion Path animation - Animate element along a path
 */
export function useMotionPath(
  elementRef: React.RefObject<HTMLElement | SVGElement>,
  pathRef: React.RefObject<SVGPathElement> | string,
  options: {
    duration?: number;
    delay?: number;
    ease?: string;
    repeat?: number;
    autoRotate?: boolean | number;
    alignOrigin?: [number, number];
    start?: number;
    end?: number;
  } = {}
) {
  useEffect(() => {
    if (!elementRef.current) return;

    const {
      duration = 5,
      delay = 0,
      ease = 'none',
      repeat = -1,
      autoRotate = false,
      alignOrigin = [0.5, 0.5],
      start = 0,
      end = 1,
    } = options;

    const pathElement = typeof pathRef === 'string' 
      ? pathRef 
      : pathRef.current;

    if (!pathElement) return;

    const animation = gsap.to(elementRef.current, {
      motionPath: {
        path: pathElement,
        align: pathElement,
        alignOrigin,
        autoRotate,
        start,
        end,
      },
      duration,
      delay,
      ease,
      repeat,
    });

    return () => {
      animation.kill();
    };
  }, [elementRef, pathRef, options]);
}

/**
 * Draw SVG Path animation
 */
export function useDrawSVG(
  pathRef: React.RefObject<SVGPathElement>,
  options: {
    duration?: number;
    delay?: number;
    ease?: string;
    scrollTrigger?: boolean;
    reverse?: boolean;
  } = {}
) {
  useEffect(() => {
    if (!pathRef.current) return;

    const {
      duration = 2,
      delay = 0,
      ease = 'power2.inOut',
      scrollTrigger = false,
      reverse = false,
    } = options;

    const path = pathRef.current;
    const length = path.getTotalLength();

    // Set initial state
    gsap.set(path, {
      strokeDasharray: length,
      strokeDashoffset: reverse ? -length : length,
    });

    const animation = gsap.to(path, {
      strokeDashoffset: 0,
      duration,
      delay,
      ease,
      scrollTrigger: scrollTrigger
        ? {
            trigger: path,
            start: 'top 80%',
            toggleActions: 'play none none none',
          }
        : undefined,
    });

    return () => {
      animation.kill();
    };
  }, [pathRef, options]);
}

export { gsap, ScrollTrigger, TextPlugin, MotionPathPlugin };
