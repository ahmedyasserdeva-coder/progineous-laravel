'use client';

/**
 * Icon Libraries Usage Examples
 * 
 * This file demonstrates how to use different icon libraries
 * installed in the project.
 */

// ============================================
// 1. LUCIDE REACT (Already installed)
// ============================================
// Clean, consistent icons - Best for UI
import { 
  Home, 
  Settings, 
  User, 
  Mail,
  Search,
  Menu,
  X,
  ChevronDown,
  ArrowRight,
  Check,
  Shield,
  Server,
  Globe,
  Zap
} from 'lucide-react';

// Usage: <Home className="h-6 w-6 text-blue-500" />

// ============================================
// 2. REACT ICONS (40,000+ icons!)
// ============================================
// Includes: Font Awesome, Material, Bootstrap, Feather, etc.

// Font Awesome
import { FaServer, FaShieldAlt, FaRocket, FaWordpress } from 'react-icons/fa';
// Material Design
import { MdDashboard, MdSecurity, MdSpeed, MdCloud } from 'react-icons/md';
// Bootstrap Icons
import { BsServer, BsShieldCheck, BsGlobe, BsLightning } from 'react-icons/bs';
// Heroicons
import { HiServer, HiShieldCheck, HiGlobeAlt, HiLightningBolt } from 'react-icons/hi';
// Simple Icons (Brand logos)
import { SiCpanel, SiWordpress, SiCloudflare, SiLetsencrypt } from 'react-icons/si';

// Usage: <FaServer className="h-6 w-6 text-blue-500" />

// ============================================
// 3. PHOSPHOR ICONS (7,000+ icons)
// ============================================
// Multiple weights: thin, light, regular, bold, fill, duotone
import { 
  HardDrive as PhServer,
  ShieldCheck as PhShield,
  GlobeSimple as PhGlobe,
  Lightning as PhLightning,
  CloudArrowUp,
  Database,
  Lock,
  Envelope,
  Phone,
  ChatCircle
} from '@phosphor-icons/react';

// Usage with weights:
// <PhServer size={24} weight="duotone" className="text-blue-500" />
// <PhShield size={24} weight="fill" className="text-green-500" />

// ============================================
// EXAMPLE COMPONENT
// ============================================

export function IconShowcase() {
  return (
    <div className="grid grid-cols-4 gap-4 p-8">
      {/* Lucide */}
      <div className="flex flex-col items-center gap-2 p-4 rounded-lg bg-gray-100">
        <Server className="h-8 w-8 text-[#1d71b8]" />
        <span className="text-xs">Lucide</span>
      </div>
      
      {/* React Icons - Font Awesome */}
      <div className="flex flex-col items-center gap-2 p-4 rounded-lg bg-gray-100">
        <FaServer className="h-8 w-8 text-[#1d71b8]" />
        <span className="text-xs">Font Awesome</span>
      </div>
      
      {/* React Icons - Material */}
      <div className="flex flex-col items-center gap-2 p-4 rounded-lg bg-gray-100">
        <MdCloud className="h-8 w-8 text-[#1d71b8]" />
        <span className="text-xs">Material</span>
      </div>
      
      {/* Phosphor - Duotone */}
      <div className="flex flex-col items-center gap-2 p-4 rounded-lg bg-gray-100">
        <PhServer size={32} weight="duotone" className="text-[#1d71b8]" />
        <span className="text-xs">Phosphor Duotone</span>
      </div>
      
      {/* Brand Icons */}
      <div className="flex flex-col items-center gap-2 p-4 rounded-lg bg-gray-100">
        <SiCpanel className="h-8 w-8 text-[#FF6C2C]" />
        <span className="text-xs">cPanel</span>
      </div>
      
      <div className="flex flex-col items-center gap-2 p-4 rounded-lg bg-gray-100">
        <SiWordpress className="h-8 w-8 text-[#21759B]" />
        <span className="text-xs">WordPress</span>
      </div>
      
      <div className="flex flex-col items-center gap-2 p-4 rounded-lg bg-gray-100">
        <SiCloudflare className="h-8 w-8 text-[#F38020]" />
        <span className="text-xs">Cloudflare</span>
      </div>
      
      <div className="flex flex-col items-center gap-2 p-4 rounded-lg bg-gray-100">
        <SiLetsencrypt className="h-8 w-8 text-[#003A70]" />
        <span className="text-xs">Let's Encrypt</span>
      </div>
    </div>
  );
}

// ============================================
// HOSTING-SPECIFIC ICONS RECOMMENDATIONS
// ============================================

export const HostingIcons = {
  // Services
  webHosting: Server,
  vps: MdCloud,
  dedicated: FaServer,
  domain: Globe,
  ssl: Lock,
  email: Envelope,
  
  // Features
  speed: Zap,
  security: Shield,
  support: ChatCircle,
  backup: CloudArrowUp,
  database: Database,
  
  // Brands (use React Icons - Simple Icons)
  cpanel: SiCpanel,
  wordpress: SiWordpress,
  cloudflare: SiCloudflare,
  letsencrypt: SiLetsencrypt,
};
