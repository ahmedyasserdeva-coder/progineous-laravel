'use client';

import { useEffect, useRef } from 'react';
import { gsap } from '@/lib/gsap';

interface MorphSVGProps {
  className?: string;
}

export function MorphSVG({ className = '' }: MorphSVGProps) {
  const svgRef = useRef<SVGSVGElement>(null);
  const pathRef = useRef<SVGPathElement>(null);

  // Different shapes to morph between
  const shapes = {
    // Server/Data Center
    server: "M100,180 L100,120 L120,100 L180,100 L200,120 L200,180 L180,200 L120,200 Z",
    // Cloud
    cloud: "M80,160 Q60,160 60,140 Q60,120 80,120 Q80,100 110,100 Q140,80 170,100 Q200,100 200,130 Q220,130 220,150 Q220,170 200,170 L80,170 Z",
    // Shield (Security)
    shield: "M150,80 L200,100 L200,150 Q200,200 150,220 Q100,200 100,150 L100,100 Z",
    // Globe
    globe: "M150,80 Q200,80 200,150 Q200,220 150,220 Q100,220 100,150 Q100,80 150,80 Z",
    // Rocket (Speed)
    rocket: "M150,80 L170,120 L170,180 L160,200 L140,200 L130,180 L130,120 Z",
    // Database
    database: "M100,100 Q100,80 150,80 Q200,80 200,100 L200,180 Q200,200 150,200 Q100,200 100,180 Z",
  };

  useEffect(() => {
    if (!svgRef.current || !pathRef.current) return;

    const path = pathRef.current;
    const shapeKeys = Object.keys(shapes) as (keyof typeof shapes)[];
    let currentIndex = 0;

    // Create timeline for morphing
    const tl = gsap.timeline({ repeat: -1, repeatDelay: 0.5 });

    // Morph through all shapes
    shapeKeys.forEach((_, index) => {
      const nextIndex = (index + 1) % shapeKeys.length;
      const nextShape = shapes[shapeKeys[nextIndex]];

      tl.to(path, {
        attr: { d: nextShape },
        duration: 1.5,
        ease: 'power2.inOut',
      });
    });

    return () => {
      tl.kill();
    };
  }, []);

  return (
    <svg
      ref={svgRef}
      viewBox="0 0 300 300"
      className={`${className}`}
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
    >
      <defs>
        <linearGradient id="morphGradient" x1="0%" y1="0%" x2="100%" y2="100%">
          <stop offset="0%" stopColor="#1d71b8" />
          <stop offset="100%" stopColor="#60a5fa" />
        </linearGradient>
        <filter id="morphGlow">
          <feGaussianBlur stdDeviation="4" result="coloredBlur"/>
          <feMerge>
            <feMergeNode in="coloredBlur"/>
            <feMergeNode in="SourceGraphic"/>
          </feMerge>
        </filter>
      </defs>
      
      {/* Morphing Shape */}
      <path
        ref={pathRef}
        d={shapes.server}
        fill="url(#morphGradient)"
        filter="url(#morphGlow)"
        opacity="0.9"
      />
      
      {/* Inner details that also animate */}
      <circle cx="150" cy="150" r="3" fill="white" opacity="0.8">
        <animate attributeName="r" values="3;5;3" dur="2s" repeatCount="indefinite"/>
      </circle>
    </svg>
  );
}

// Hero Section specific morph animation
export function HeroMorphAnimation({ className = '' }: MorphSVGProps) {
  const containerRef = useRef<HTMLDivElement>(null);
  const iconRefs = useRef<(SVGSVGElement | null)[]>([]);

  const icons = [
    {
      name: 'server',
      paths: {
        initial: "M20,35 L20,15 L25,10 L75,10 L80,15 L80,35 L75,40 L25,40 Z M25,20 L75,20 M25,30 L75,30",
        morph: "M20,25 Q50,5 80,25 Q80,45 50,50 Q20,45 20,25"
      },
      color: '#1d71b8'
    },
    {
      name: 'cloud',
      paths: {
        initial: "M25,35 Q15,35 15,25 Q15,15 30,15 Q35,5 50,10 Q70,5 75,20 Q90,20 90,30 Q90,40 75,40 L25,40 Z",
        morph: "M20,40 L20,10 L80,10 L80,40 Z M30,20 L70,20 M30,30 L70,30"
      },
      color: '#22c55e'
    },
    {
      name: 'shield',
      paths: {
        initial: "M50,10 L80,20 L80,35 Q80,50 50,55 Q20,50 20,35 L20,20 Z",
        morph: "M30,10 L70,10 L70,55 L30,55 Z M40,25 L60,25 M40,40 L60,40"
      },
      color: '#8b5cf6'
    },
    {
      name: 'speed',
      paths: {
        initial: "M50,10 L60,25 L55,25 L65,45 L45,30 L50,30 L35,45 L50,10 Z",
        morph: "M25,25 Q50,10 75,25 Q75,40 50,45 Q25,40 25,25"
      },
      color: '#f59e0b'
    }
  ];

  useEffect(() => {
    if (!containerRef.current) return;

    const ctx = gsap.context(() => {
      iconRefs.current.forEach((svg, i) => {
        if (!svg) return;
        
        const path = svg.querySelector('.morph-path');
        if (!path) return;

        // Create morph animation
        gsap.to(path, {
          attr: { d: icons[i].paths.morph },
          duration: 2,
          ease: 'power2.inOut',
          repeat: -1,
          yoyo: true,
          delay: i * 0.3,
        });

        // Add floating effect
        gsap.to(svg, {
          y: -10,
          duration: 2 + i * 0.2,
          ease: 'sine.inOut',
          repeat: -1,
          yoyo: true,
          delay: i * 0.2,
        });

        // Add subtle rotation
        gsap.to(svg, {
          rotation: 5,
          duration: 3 + i * 0.3,
          ease: 'sine.inOut',
          repeat: -1,
          yoyo: true,
          delay: i * 0.1,
          transformOrigin: 'center center',
        });
      });
    }, containerRef);

    return () => ctx.revert();
  }, []);

  return (
    <div ref={containerRef} className={`relative ${className}`}>
      {/* Background circles */}
      <div className="absolute inset-0 flex items-center justify-center">
        <div className="h-64 w-64 animate-pulse rounded-full bg-[#1d71b8]/10"></div>
      </div>
      <div className="absolute inset-0 flex items-center justify-center">
        <div className="h-48 w-48 animate-pulse rounded-full bg-[#1d71b8]/20" style={{ animationDelay: '0.5s' }}></div>
      </div>
      
      {/* Morphing Icons Grid */}
      <div className="relative grid grid-cols-2 gap-8 p-8">
        {icons.map((icon, index) => (
          <div
            key={icon.name}
            className="flex items-center justify-center rounded-2xl bg-white/10 p-6 backdrop-blur-sm"
          >
            <svg
              ref={(el) => { iconRefs.current[index] = el; }}
              viewBox="0 0 100 60"
              className="h-16 w-24"
              fill="none"
            >
              <defs>
                <linearGradient id={`grad-${icon.name}`} x1="0%" y1="0%" x2="100%" y2="100%">
                  <stop offset="0%" stopColor={icon.color} />
                  <stop offset="100%" stopColor={icon.color} stopOpacity="0.6" />
                </linearGradient>
                <filter id={`glow-${icon.name}`}>
                  <feGaussianBlur stdDeviation="2" result="coloredBlur"/>
                  <feMerge>
                    <feMergeNode in="coloredBlur"/>
                    <feMergeNode in="SourceGraphic"/>
                  </feMerge>
                </filter>
              </defs>
              <path
                className="morph-path"
                d={icon.paths.initial}
                fill={`url(#grad-${icon.name})`}
                stroke={icon.color}
                strokeWidth="2"
                filter={`url(#glow-${icon.name})`}
              />
            </svg>
          </div>
        ))}
      </div>

      {/* Center Icon - Main Morph */}
      <div className="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
        <MorphSVG className="h-24 w-24" />
      </div>
    </div>
  );
}

export default MorphSVG;
