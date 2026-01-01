'use client';

import { useParams } from 'next/navigation';
import { 
  CheckCircle, 
  AlertTriangle, 
  XCircle, 
  Clock,
  Server,
  Mail,
  Globe,
  Database,
  Shield,
  Cloud,
  Wifi,
  HardDrive,
  RefreshCw,
  Calendar,
  MapPin,
  CreditCard,
  MessageSquare,
  Link as LinkIcon,
  ChevronDown,
  ChevronUp
} from 'lucide-react';
import { useState } from 'react';

type ServiceStatus = 'operational' | 'degraded' | 'outage' | 'maintenance';

interface Service {
  id: string;
  name: string;
  nameAr: string;
  status: ServiceStatus;
  uptime: number;
  icon: React.ElementType;
}

interface Incident {
  id: string;
  title: string;
  titleAr: string;
  description: string;
  descriptionAr: string;
  status: 'resolved' | 'monitoring' | 'investigating' | 'identified';
  date: Date;
  service: string;
}

interface ScheduledMaintenance {
  id: string;
  title: string;
  titleAr: string;
  description: string;
  descriptionAr: string;
  scheduledDate: Date;
  duration: string;
  durationAr: string;
  affectedServices: string[];
}

interface Region {
  id: string;
  name: string;
  nameAr: string;
  country: string;
  countryAr: string;
  status: ServiceStatus;
  latency: number;
  flag: string;
}

interface ThirdPartyService {
  id: string;
  name: string;
  nameAr: string;
  status: ServiceStatus;
  url: string;
  icon: React.ElementType;
}

interface MonthlyUptime {
  month: string;
  monthAr: string;
  year: number;
  uptime: number;
  incidents: number;
}

// Services Data
const services: Service[] = [
  { id: 'web-hosting', name: 'Web Hosting', nameAr: 'استضافة المواقع', status: 'operational', uptime: 99.99, icon: Server },
  { id: 'email', name: 'Email Services', nameAr: 'خدمات البريد الإلكتروني', status: 'operational', uptime: 99.98, icon: Mail },
  { id: 'dns', name: 'DNS Services', nameAr: 'خدمات DNS', status: 'operational', uptime: 100, icon: Globe },
  { id: 'database', name: 'Database Servers', nameAr: 'خوادم قواعد البيانات', status: 'operational', uptime: 99.97, icon: Database },
  { id: 'ssl', name: 'SSL Certificates', nameAr: 'شهادات SSL', status: 'operational', uptime: 100, icon: Shield },
  { id: 'cloud', name: 'Cloud Infrastructure', nameAr: 'البنية السحابية', status: 'operational', uptime: 99.99, icon: Cloud },
  { id: 'network', name: 'Network', nameAr: 'الشبكة', status: 'operational', uptime: 99.99, icon: Wifi },
  { id: 'backup', name: 'Backup Systems', nameAr: 'أنظمة النسخ الاحتياطي', status: 'operational', uptime: 99.95, icon: HardDrive },
];

// Scheduled Maintenance Data
const scheduledMaintenances: ScheduledMaintenance[] = [
  {
    id: '1',
    title: 'Database Server Optimization',
    titleAr: 'تحسين خادم قواعد البيانات',
    description: 'We will be performing optimization on our database servers to improve performance.',
    descriptionAr: 'سنقوم بإجراء تحسينات على خوادم قواعد البيانات لتحسين الأداء.',
    scheduledDate: new Date(Date.now() + 3 * 24 * 60 * 60 * 1000),
    duration: '2 hours',
    durationAr: 'ساعتان',
    affectedServices: ['Database Servers', 'Web Hosting']
  },
  {
    id: '2',
    title: 'Network Infrastructure Upgrade',
    titleAr: 'ترقية البنية التحتية للشبكة',
    description: 'Scheduled upgrade to network equipment for improved capacity and redundancy.',
    descriptionAr: 'ترقية مجدولة لمعدات الشبكة لتحسين السعة والتكرار.',
    scheduledDate: new Date(Date.now() + 7 * 24 * 60 * 60 * 1000),
    duration: '4 hours',
    durationAr: '4 ساعات',
    affectedServices: ['Network', 'Cloud Infrastructure']
  },
  {
    id: '3',
    title: 'SSL Certificate System Update',
    titleAr: 'تحديث نظام شهادات SSL',
    description: 'Updating SSL certificate management system to support new security protocols.',
    descriptionAr: 'تحديث نظام إدارة شهادات SSL لدعم بروتوكولات الأمان الجديدة.',
    scheduledDate: new Date(Date.now() + 14 * 24 * 60 * 60 * 1000),
    duration: '1 hour',
    durationAr: 'ساعة واحدة',
    affectedServices: ['SSL Certificates']
  }
];

// 40 Regions Data
const regions: Region[] = [
  // Middle East & North Africa (15)
  { id: 'eg-cairo', name: 'Cairo', nameAr: 'القاهرة', country: 'Egypt', countryAr: 'مصر', status: 'operational', latency: 5, flag: '🇪🇬' },
  { id: 'eg-alex', name: 'Alexandria', nameAr: 'الإسكندرية', country: 'Egypt', countryAr: 'مصر', status: 'operational', latency: 8, flag: '🇪🇬' },
  { id: 'ae-dubai', name: 'Dubai', nameAr: 'دبي', country: 'UAE', countryAr: 'الإمارات', status: 'operational', latency: 25, flag: '🇦🇪' },
  { id: 'ae-abudhabi', name: 'Abu Dhabi', nameAr: 'أبوظبي', country: 'UAE', countryAr: 'الإمارات', status: 'operational', latency: 28, flag: '🇦🇪' },
  { id: 'sa-riyadh', name: 'Riyadh', nameAr: 'الرياض', country: 'Saudi Arabia', countryAr: 'السعودية', status: 'operational', latency: 30, flag: '🇸🇦' },
  { id: 'sa-jeddah', name: 'Jeddah', nameAr: 'جدة', country: 'Saudi Arabia', countryAr: 'السعودية', status: 'operational', latency: 32, flag: '🇸🇦' },
  { id: 'qa-doha', name: 'Doha', nameAr: 'الدوحة', country: 'Qatar', countryAr: 'قطر', status: 'operational', latency: 27, flag: '🇶🇦' },
  { id: 'kw-kuwait', name: 'Kuwait City', nameAr: 'مدينة الكويت', country: 'Kuwait', countryAr: 'الكويت', status: 'operational', latency: 35, flag: '🇰🇼' },
  { id: 'bh-manama', name: 'Manama', nameAr: 'المنامة', country: 'Bahrain', countryAr: 'البحرين', status: 'operational', latency: 29, flag: '🇧🇭' },
  { id: 'om-muscat', name: 'Muscat', nameAr: 'مسقط', country: 'Oman', countryAr: 'عُمان', status: 'operational', latency: 33, flag: '🇴🇲' },
  { id: 'jo-amman', name: 'Amman', nameAr: 'عمّان', country: 'Jordan', countryAr: 'الأردن', status: 'operational', latency: 40, flag: '🇯🇴' },
  { id: 'lb-beirut', name: 'Beirut', nameAr: 'بيروت', country: 'Lebanon', countryAr: 'لبنان', status: 'operational', latency: 45, flag: '🇱🇧' },
  { id: 'ma-casablanca', name: 'Casablanca', nameAr: 'الدار البيضاء', country: 'Morocco', countryAr: 'المغرب', status: 'operational', latency: 65, flag: '🇲🇦' },
  { id: 'tn-tunis', name: 'Tunis', nameAr: 'تونس', country: 'Tunisia', countryAr: 'تونس', status: 'operational', latency: 55, flag: '🇹🇳' },
  { id: 'dz-algiers', name: 'Algiers', nameAr: 'الجزائر', country: 'Algeria', countryAr: 'الجزائر', status: 'operational', latency: 60, flag: '🇩🇿' },
  // Europe (10)
  { id: 'de-frankfurt', name: 'Frankfurt', nameAr: 'فرانكفورت', country: 'Germany', countryAr: 'ألمانيا', status: 'operational', latency: 12, flag: '🇩🇪' },
  { id: 'de-munich', name: 'Munich', nameAr: 'ميونخ', country: 'Germany', countryAr: 'ألمانيا', status: 'operational', latency: 14, flag: '🇩🇪' },
  { id: 'uk-london', name: 'London', nameAr: 'لندن', country: 'UK', countryAr: 'بريطانيا', status: 'operational', latency: 15, flag: '🇬🇧' },
  { id: 'uk-manchester', name: 'Manchester', nameAr: 'مانشستر', country: 'UK', countryAr: 'بريطانيا', status: 'operational', latency: 18, flag: '🇬🇧' },
  { id: 'fr-paris', name: 'Paris', nameAr: 'باريس', country: 'France', countryAr: 'فرنسا', status: 'operational', latency: 13, flag: '🇫🇷' },
  { id: 'nl-amsterdam', name: 'Amsterdam', nameAr: 'أمستردام', country: 'Netherlands', countryAr: 'هولندا', status: 'operational', latency: 11, flag: '🇳🇱' },
  { id: 'es-madrid', name: 'Madrid', nameAr: 'مدريد', country: 'Spain', countryAr: 'إسبانيا', status: 'operational', latency: 20, flag: '🇪🇸' },
  { id: 'it-milan', name: 'Milan', nameAr: 'ميلان', country: 'Italy', countryAr: 'إيطاليا', status: 'operational', latency: 16, flag: '🇮🇹' },
  { id: 'se-stockholm', name: 'Stockholm', nameAr: 'ستوكهولم', country: 'Sweden', countryAr: 'السويد', status: 'operational', latency: 22, flag: '🇸🇪' },
  { id: 'pl-warsaw', name: 'Warsaw', nameAr: 'وارسو', country: 'Poland', countryAr: 'بولندا', status: 'operational', latency: 19, flag: '🇵🇱' },
  // North America (8)
  { id: 'us-newyork', name: 'New York', nameAr: 'نيويورك', country: 'USA', countryAr: 'أمريكا', status: 'operational', latency: 18, flag: '🇺🇸' },
  { id: 'us-losangeles', name: 'Los Angeles', nameAr: 'لوس أنجلوس', country: 'USA', countryAr: 'أمريكا', status: 'operational', latency: 25, flag: '🇺🇸' },
  { id: 'us-chicago', name: 'Chicago', nameAr: 'شيكاغو', country: 'USA', countryAr: 'أمريكا', status: 'operational', latency: 20, flag: '🇺🇸' },
  { id: 'us-miami', name: 'Miami', nameAr: 'ميامي', country: 'USA', countryAr: 'أمريكا', status: 'operational', latency: 22, flag: '🇺🇸' },
  { id: 'us-dallas', name: 'Dallas', nameAr: 'دالاس', country: 'USA', countryAr: 'أمريكا', status: 'operational', latency: 21, flag: '🇺🇸' },
  { id: 'us-seattle', name: 'Seattle', nameAr: 'سياتل', country: 'USA', countryAr: 'أمريكا', status: 'operational', latency: 28, flag: '🇺🇸' },
  { id: 'ca-toronto', name: 'Toronto', nameAr: 'تورنتو', country: 'Canada', countryAr: 'كندا', status: 'operational', latency: 19, flag: '🇨🇦' },
  { id: 'ca-vancouver', name: 'Vancouver', nameAr: 'فانكوفر', country: 'Canada', countryAr: 'كندا', status: 'operational', latency: 26, flag: '🇨🇦' },
  // Asia Pacific (7)
  { id: 'sg-singapore', name: 'Singapore', nameAr: 'سنغافورة', country: 'Singapore', countryAr: 'سنغافورة', status: 'operational', latency: 85, flag: '🇸🇬' },
  { id: 'jp-tokyo', name: 'Tokyo', nameAr: 'طوكيو', country: 'Japan', countryAr: 'اليابان', status: 'operational', latency: 110, flag: '🇯🇵' },
  { id: 'jp-osaka', name: 'Osaka', nameAr: 'أوساكا', country: 'Japan', countryAr: 'اليابان', status: 'operational', latency: 115, flag: '🇯🇵' },
  { id: 'au-sydney', name: 'Sydney', nameAr: 'سيدني', country: 'Australia', countryAr: 'أستراليا', status: 'operational', latency: 180, flag: '🇦🇺' },
  { id: 'au-melbourne', name: 'Melbourne', nameAr: 'ملبورن', country: 'Australia', countryAr: 'أستراليا', status: 'operational', latency: 185, flag: '🇦🇺' },
  { id: 'in-mumbai', name: 'Mumbai', nameAr: 'مومباي', country: 'India', countryAr: 'الهند', status: 'operational', latency: 70, flag: '🇮🇳' },
  { id: 'in-bangalore', name: 'Bangalore', nameAr: 'بنغالور', country: 'India', countryAr: 'الهند', status: 'operational', latency: 75, flag: '🇮🇳' },
  { id: 'kr-seoul', name: 'Seoul', nameAr: 'سيول', country: 'South Korea', countryAr: 'كوريا الجنوبية', status: 'operational', latency: 105, flag: '🇰🇷' },
  { id: 'hk-hongkong', name: 'Hong Kong', nameAr: 'هونغ كونغ', country: 'Hong Kong', countryAr: 'هونغ كونغ', status: 'operational', latency: 90, flag: '🇭🇰' },
  { id: 'br-saopaulo', name: 'São Paulo', nameAr: 'ساو باولو', country: 'Brazil', countryAr: 'البرازيل', status: 'operational', latency: 35, flag: '🇧🇷' },
];

// Third Party Services
const thirdPartyServices: ThirdPartyService[] = [
  { id: 'cloudflare', name: 'Cloudflare CDN', nameAr: 'شبكة Cloudflare', status: 'operational', url: 'https://www.cloudflarestatus.com', icon: Cloud },
  { id: 'stripe', name: 'Stripe Payments', nameAr: 'مدفوعات Stripe', status: 'operational', url: 'https://status.stripe.com', icon: CreditCard },
  { id: 'paypal', name: 'PayPal', nameAr: 'باي بال', status: 'operational', url: 'https://www.paypal-status.com', icon: CreditCard },
  { id: 'letsencrypt', name: "Let's Encrypt", nameAr: "Let's Encrypt", status: 'operational', url: 'https://letsencrypt.status.io', icon: Shield },
];

// Monthly Uptime History
const monthlyUptimeHistory: MonthlyUptime[] = [
  { month: 'December', monthAr: 'ديسمبر', year: 2025, uptime: 99.99, incidents: 0 },
  { month: 'November', monthAr: 'نوفمبر', year: 2025, uptime: 99.98, incidents: 1 },
  { month: 'October', monthAr: 'أكتوبر', year: 2025, uptime: 99.97, incidents: 2 },
  { month: 'September', monthAr: 'سبتمبر', year: 2025, uptime: 100, incidents: 0 },
  { month: 'August', monthAr: 'أغسطس', year: 2025, uptime: 99.99, incidents: 1 },
  { month: 'July', monthAr: 'يوليو', year: 2025, uptime: 99.95, incidents: 3 },
  { month: 'June', monthAr: 'يونيو', year: 2025, uptime: 99.98, incidents: 1 },
  { month: 'May', monthAr: 'مايو', year: 2025, uptime: 99.99, incidents: 0 },
  { month: 'April', monthAr: 'أبريل', year: 2025, uptime: 100, incidents: 0 },
  { month: 'March', monthAr: 'مارس', year: 2025, uptime: 99.96, incidents: 2 },
  { month: 'February', monthAr: 'فبراير', year: 2025, uptime: 99.99, incidents: 1 },
  { month: 'January', monthAr: 'يناير', year: 2025, uptime: 99.97, incidents: 2 },
];

// Recent Incidents
const recentIncidents: Incident[] = [
  { id: '1', title: 'Scheduled Maintenance Completed', titleAr: 'تم الانتهاء من الصيانة المجدولة', description: 'Scheduled maintenance for database servers has been completed successfully.', descriptionAr: 'تم الانتهاء من الصيانة المجدولة لخوادم قواعد البيانات بنجاح.', status: 'resolved', date: new Date(Date.now() - 2 * 24 * 60 * 60 * 1000), service: 'Database Servers' },
  { id: '2', title: 'Network Optimization', titleAr: 'تحسين الشبكة', description: 'Network infrastructure has been optimized for better performance.', descriptionAr: 'تم تحسين البنية التحتية للشبكة لأداء أفضل.', status: 'resolved', date: new Date(Date.now() - 5 * 24 * 60 * 60 * 1000), service: 'Network' },
  { id: '3', title: 'SSL Certificate Renewal', titleAr: 'تجديد شهادات SSL', description: 'All SSL certificates have been renewed automatically.', descriptionAr: 'تم تجديد جميع شهادات SSL تلقائياً.', status: 'resolved', date: new Date(Date.now() - 7 * 24 * 60 * 60 * 1000), service: 'SSL Certificates' },
  { id: '4', title: 'Email Server Performance Boost', titleAr: 'تحسين أداء خادم البريد', description: 'Email delivery speeds have been improved by 40%.', descriptionAr: 'تم تحسين سرعة تسليم البريد الإلكتروني بنسبة 40%.', status: 'resolved', date: new Date(Date.now() - 10 * 24 * 60 * 60 * 1000), service: 'Email Services' },
  { id: '5', title: 'Backup System Upgrade', titleAr: 'ترقية نظام النسخ الاحتياطي', description: 'Backup systems upgraded for faster recovery times.', descriptionAr: 'تمت ترقية أنظمة النسخ الاحتياطي لأوقات استرداد أسرع.', status: 'resolved', date: new Date(Date.now() - 12 * 24 * 60 * 60 * 1000), service: 'Backup Systems' },
];

export default function StatusPage() {
  const params = useParams();
  const locale = (params?.locale as string) || 'en';
  const isRTL = locale === 'ar';
  const [lastUpdated, setLastUpdated] = useState<Date>(new Date());
  const [isRefreshing, setIsRefreshing] = useState(false);
  const [showAllRegions, setShowAllRegions] = useState(false);
  const [activeTab, setActiveTab] = useState<'all' | 'mena' | 'europe' | 'americas' | 'apac'>('all');

  const c = isRTL ? {
    title: 'حالة النظام',
    subtitle: 'حالة جميع خدمات برو جينيوس في الوقت الفعلي',
    allOperational: 'جميع الأنظمة تعمل بشكل طبيعي',
    someIssues: 'بعض الأنظمة تواجه مشاكل',
    majorOutage: 'انقطاع كبير',
    services: 'الخدمات',
    uptime: 'وقت التشغيل',
    status: { operational: 'تعمل', degraded: 'أداء منخفض', outage: 'انقطاع', maintenance: 'تحت الصيانة' },
    incidents: 'الحوادث الأخيرة',
    noIncidents: 'لا توجد حوادث مبلغ عنها',
    incidentStatus: { resolved: 'تم الحل', monitoring: 'قيد المراقبة', investigating: 'قيد التحقيق', identified: 'تم التحديد' },
    lastUpdated: 'آخر تحديث',
    refresh: 'تحديث',
    last90Days: 'وقت التشغيل خلال آخر 90 يوم',
    overallUptime: 'إجمالي وقت التشغيل',
    scheduledMaintenance: 'الصيانة المجدولة',
    noMaintenance: 'لا توجد صيانة مجدولة حالياً',
    duration: 'المدة',
    scheduledFor: 'مجدولة في',
    regionalStatus: 'حالة المناطق',
    latency: 'زمن الاستجابة',
    ms: 'مللي ثانية',
    showAll: 'عرض جميع المناطق',
    showLess: 'عرض أقل',
    thirdParty: 'الخدمات الخارجية',
    viewStatus: 'عرض الحالة',
    monthlyUptime: 'سجل وقت التشغيل الشهري',
    month: 'الشهر',
    incidentsCount: 'الحوادث',
    regionTabs: { all: 'جميع المناطق', mena: 'الشرق الأوسط وأفريقيا', europe: 'أوروبا', americas: 'الأمريكتين', apac: 'آسيا والمحيط الهادئ' },
    regions: 'منطقة'
  } : {
    title: 'System Status',
    subtitle: 'Real-time status of all Pro Gineous services',
    allOperational: 'All Systems Operational',
    someIssues: 'Some Systems Experiencing Issues',
    majorOutage: 'Major Outage',
    services: 'Services',
    uptime: 'Uptime',
    status: { operational: 'Operational', degraded: 'Degraded', outage: 'Outage', maintenance: 'Maintenance' },
    incidents: 'Recent Incidents',
    noIncidents: 'No incidents reported',
    incidentStatus: { resolved: 'Resolved', monitoring: 'Monitoring', investigating: 'Investigating', identified: 'Identified' },
    lastUpdated: 'Last updated',
    refresh: 'Refresh',
    last90Days: 'Last 90 days uptime',
    overallUptime: 'Overall Uptime',
    scheduledMaintenance: 'Scheduled Maintenance',
    noMaintenance: 'No scheduled maintenance',
    duration: 'Duration',
    scheduledFor: 'Scheduled for',
    regionalStatus: 'Regional Status',
    latency: 'Latency',
    ms: 'ms',
    showAll: 'Show All Regions',
    showLess: 'Show Less',
    thirdParty: 'Third-party Services',
    viewStatus: 'View Status',
    monthlyUptime: 'Monthly Uptime History',
    month: 'Month',
    incidentsCount: 'Incidents',
    regionTabs: { all: 'All Regions', mena: 'Middle East & Africa', europe: 'Europe', americas: 'Americas', apac: 'Asia Pacific' },
    regions: 'regions'
  };

  const getOverallStatus = (): ServiceStatus => {
    const hasOutage = services.some(s => s.status === 'outage');
    const hasDegraded = services.some(s => s.status === 'degraded' || s.status === 'maintenance');
    if (hasOutage) return 'outage';
    if (hasDegraded) return 'degraded';
    return 'operational';
  };

  const getStatusIcon = (status: ServiceStatus) => {
    switch (status) {
      case 'operational': return <CheckCircle className="w-5 h-5 text-green-500" />;
      case 'degraded': return <AlertTriangle className="w-5 h-5 text-yellow-500" />;
      case 'outage': return <XCircle className="w-5 h-5 text-red-500" />;
      case 'maintenance': return <Clock className="w-5 h-5 text-blue-500" />;
    }
  };

  const getStatusColor = (status: ServiceStatus) => {
    switch (status) {
      case 'operational': return 'bg-green-500';
      case 'degraded': return 'bg-yellow-500';
      case 'outage': return 'bg-red-500';
      case 'maintenance': return 'bg-blue-500';
    }
  };

  const getStatusBgColor = (status: ServiceStatus) => {
    switch (status) {
      case 'operational': return 'bg-green-50 border-green-200';
      case 'degraded': return 'bg-yellow-50 border-yellow-200';
      case 'outage': return 'bg-red-50 border-red-200';
      case 'maintenance': return 'bg-blue-50 border-blue-200';
    }
  };

  const getIncidentStatusColor = (status: Incident['status']) => {
    switch (status) {
      case 'resolved': return 'bg-green-100 text-green-800';
      case 'monitoring': return 'bg-blue-100 text-blue-800';
      case 'investigating': return 'bg-yellow-100 text-yellow-800';
      case 'identified': return 'bg-orange-100 text-orange-800';
    }
  };

  const getLatencyColor = (latency: number) => {
    if (latency < 50) return 'text-green-600';
    if (latency < 100) return 'text-yellow-600';
    return 'text-orange-600';
  };

  const handleRefresh = () => {
    setIsRefreshing(true);
    setTimeout(() => { setLastUpdated(new Date()); setIsRefreshing(false); }, 1000);
  };

  const formatDate = (date: Date) => date.toLocaleDateString(isRTL ? 'ar-EG' : 'en-US', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
  
  const formatScheduledDate = (date: Date) => date.toLocaleDateString(isRTL ? 'ar-EG' : 'en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' });

  const getFilteredRegions = () => {
    let filtered = regions;
    switch (activeTab) {
      case 'mena': filtered = regions.filter(r => ['🇪🇬', '🇦🇪', '🇸🇦', '🇶🇦', '🇰🇼', '🇧🇭', '🇴🇲', '🇯🇴', '🇱🇧', '🇲🇦', '🇹🇳', '🇩🇿'].includes(r.flag)); break;
      case 'europe': filtered = regions.filter(r => ['🇩🇪', '🇬🇧', '🇫🇷', '🇳🇱', '🇪🇸', '🇮🇹', '🇸🇪', '🇵🇱'].includes(r.flag)); break;
      case 'americas': filtered = regions.filter(r => ['🇺🇸', '🇨🇦', '🇧🇷'].includes(r.flag)); break;
      case 'apac': filtered = regions.filter(r => ['🇸🇬', '🇯🇵', '🇦🇺', '🇮🇳', '🇰🇷', '🇭🇰'].includes(r.flag)); break;
    }
    return showAllRegions ? filtered : filtered.slice(0, 12);
  };

  const overallStatus = getOverallStatus();
  const overallUptime = (services.reduce((acc, s) => acc + s.uptime, 0) / services.length).toFixed(2);
  const uptimeBars = Array.from({ length: 90 }, () => { const r = Math.random(); if (r > 0.98) return 'degraded'; if (r > 0.995) return 'outage'; return 'operational'; });

  return (
    <div className={`min-h-screen bg-gray-50`} dir={isRTL ? 'rtl' : 'ltr'}>
      {/* Header */}
      <div className="bg-white border-b border-gray-200">
        <div className="max-w-6xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
          <div className="text-center">
            <h1 className="text-3xl font-bold text-gray-900 sm:text-4xl">{c.title}</h1>
            <p className="mt-3 text-lg text-gray-600">{c.subtitle}</p>
          </div>
          <div className={`mt-8 p-6 rounded-xl border-2 ${getStatusBgColor(overallStatus)}`}>
            <div className="flex items-center justify-center gap-3">
              {overallStatus === 'operational' && <CheckCircle className="w-8 h-8 text-green-500" />}
              {overallStatus === 'degraded' && <AlertTriangle className="w-8 h-8 text-yellow-500" />}
              {overallStatus === 'outage' && <XCircle className="w-8 h-8 text-red-500" />}
              <span className="text-xl font-semibold text-gray-900">
                {overallStatus === 'operational' && c.allOperational}
                {overallStatus === 'degraded' && c.someIssues}
                {overallStatus === 'outage' && c.majorOutage}
              </span>
            </div>
            <div className="mt-4 flex items-center justify-center gap-2 text-sm text-gray-600">
              <span>{c.lastUpdated}: {formatDate(lastUpdated)}</span>
              <button onClick={handleRefresh} disabled={isRefreshing} className="inline-flex items-center gap-1 text-[#1d71b8] hover:text-[#155a94]">
                <RefreshCw className={`w-4 h-4 ${isRefreshing ? 'animate-spin' : ''}`} />{c.refresh}
              </button>
            </div>
          </div>
        </div>
      </div>

      <div className="max-w-6xl mx-auto px-4 py-12 sm:px-6 lg:px-8 space-y-8">
        {/* Overall Uptime */}
        <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <div className="flex items-center justify-between mb-4">
            <h2 className="text-lg font-semibold text-gray-900">{c.overallUptime}</h2>
            <span className="text-2xl font-bold text-green-600" dir="ltr">{overallUptime}%</span>
          </div>
          <div className="mb-2"><span className="text-sm text-gray-500">{c.last90Days}</span></div>
          <div className="flex gap-0.5">
            {uptimeBars.map((status, i) => (<div key={i} className={`h-8 flex-1 rounded-sm ${getStatusColor(status as ServiceStatus)} opacity-80 hover:opacity-100`} />))}
          </div>
          <div className="flex justify-between mt-2 text-xs text-gray-500">
            <span>{isRTL ? 'منذ 90 يوم' : '90 days ago'}</span>
            <span>{isRTL ? 'اليوم' : 'Today'}</span>
          </div>
        </div>

        {/* Scheduled Maintenance */}
        <div className="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
          <div className="px-6 py-4 border-b border-gray-200 bg-blue-50">
            <div className="flex items-center gap-2">
              <Calendar className="w-5 h-5 text-blue-600" />
              <h2 className="text-lg font-semibold text-gray-900">{c.scheduledMaintenance}</h2>
            </div>
          </div>
          <div className="divide-y divide-gray-100">
            {scheduledMaintenances.map((m) => (
              <div key={m.id} className="px-6 py-4">
                <div className="flex items-start gap-4">
                  <div className="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                    <Clock className="w-5 h-5 text-blue-600" />
                  </div>
                  <div className="flex-1">
                    <h3 className="font-medium text-gray-900">{isRTL ? m.titleAr : m.title}</h3>
                    <p className="text-sm text-gray-600 mt-1">{isRTL ? m.descriptionAr : m.description}</p>
                    <div className="mt-3 flex flex-wrap gap-4 text-sm">
                      <div className="flex items-center gap-1 text-gray-500"><Calendar className="w-4 h-4" /><span>{c.scheduledFor}: {formatScheduledDate(m.scheduledDate)}</span></div>
                      <div className="flex items-center gap-1 text-gray-500"><Clock className="w-4 h-4" /><span>{c.duration}: {isRTL ? m.durationAr : m.duration}</span></div>
                    </div>
                    <div className="mt-2 flex flex-wrap gap-2">
                      {m.affectedServices.map((s) => (<span key={s} className="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">{s}</span>))}
                    </div>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>

        {/* Services */}
        <div className="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
          <div className="px-6 py-4 border-b border-gray-200"><h2 className="text-lg font-semibold text-gray-900">{c.services}</h2></div>
          <div className="divide-y divide-gray-100">
            {services.map((service) => {
              const Icon = service.icon;
              return (
                <div key={service.id} className="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                  <div className="flex items-center gap-4">
                    <div className="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center"><Icon className="w-5 h-5 text-gray-600" /></div>
                    <div>
                      <h3 className="font-medium text-gray-900">{isRTL ? service.nameAr : service.name}</h3>
                      <p className="text-sm text-gray-500">{c.uptime}: <span dir="ltr">{service.uptime}%</span></p>
                    </div>
                  </div>
                  <div className="flex items-center gap-2">
                    {getStatusIcon(service.status)}
                    <span className={`text-sm font-medium ${service.status === 'operational' ? 'text-green-600' : service.status === 'degraded' ? 'text-yellow-600' : service.status === 'outage' ? 'text-red-600' : 'text-blue-600'}`}>{c.status[service.status]}</span>
                  </div>
                </div>
              );
            })}
          </div>
        </div>

        {/* Regional Status */}
        <div className="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
          <div className="px-6 py-4 border-b border-gray-200">
            <div className="flex items-center gap-2">
              <MapPin className="w-5 h-5 text-gray-600" />
              <h2 className="text-lg font-semibold text-gray-900">{c.regionalStatus}</h2>
              <span className="text-sm text-gray-500">({regions.length} {c.regions})</span>
            </div>
          </div>
          <div className="px-6 py-3 border-b border-gray-100 bg-gray-50 overflow-x-auto">
            <div className="flex gap-2 min-w-max">
              {(['all', 'mena', 'europe', 'americas', 'apac'] as const).map((tab) => (
                <button key={tab} onClick={() => setActiveTab(tab)} className={`px-4 py-2 rounded-lg text-sm font-medium transition-colors ${activeTab === tab ? 'bg-[#1d71b8] text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'}`}>{c.regionTabs[tab]}</button>
              ))}
            </div>
          </div>
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-px bg-gray-100">
            {getFilteredRegions().map((region) => (
              <div key={region.id} className="bg-white px-4 py-3 flex items-center justify-between">
                <div className="flex items-center gap-3">
                  <span className="text-xl">{region.flag}</span>
                  <div>
                    <h4 className="font-medium text-gray-900 text-sm">{isRTL ? region.nameAr : region.name}</h4>
                    <p className="text-xs text-gray-500">{isRTL ? region.countryAr : region.country}</p>
                  </div>
                </div>
                <div className="flex items-center gap-2">
                  <span className={`text-xs font-medium ${getLatencyColor(region.latency)}`} dir="ltr">{region.latency} {c.ms}</span>
                  <div className={`w-2 h-2 rounded-full ${getStatusColor(region.status)}`} />
                </div>
              </div>
            ))}
          </div>
          {getFilteredRegions().length < (activeTab === 'all' ? regions : regions.filter(r => {
            if (activeTab === 'mena') return ['🇪🇬', '🇦🇪', '🇸🇦', '🇶🇦', '🇰🇼', '🇧🇭', '🇴🇲', '🇯🇴', '🇱🇧', '🇲🇦', '🇹🇳', '🇩🇿'].includes(r.flag);
            if (activeTab === 'europe') return ['🇩🇪', '🇬🇧', '🇫🇷', '🇳🇱', '🇪🇸', '🇮🇹', '🇸🇪', '🇵🇱'].includes(r.flag);
            if (activeTab === 'americas') return ['🇺🇸', '🇨🇦', '🇧🇷'].includes(r.flag);
            if (activeTab === 'apac') return ['🇸🇬', '🇯🇵', '🇦🇺', '🇮🇳', '🇰🇷', '🇭🇰'].includes(r.flag);
            return true;
          })).length && (
            <div className="px-6 py-3 border-t border-gray-200 text-center">
              <button onClick={() => setShowAllRegions(!showAllRegions)} className="inline-flex items-center gap-1 text-[#1d71b8] hover:text-[#155a94] text-sm font-medium">
                {showAllRegions ? <><ChevronUp className="w-4 h-4" />{c.showLess}</> : <><ChevronDown className="w-4 h-4" />{c.showAll}</>}
              </button>
            </div>
          )}
        </div>

        {/* Monthly Uptime */}
        <div className="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
          <div className="px-6 py-4 border-b border-gray-200"><h2 className="text-lg font-semibold text-gray-900">{c.monthlyUptime}</h2></div>
          <div className="overflow-x-auto">
            <table className="w-full">
              <thead className="bg-gray-50">
                <tr>
                  <th className="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">{c.month}</th>
                  <th className="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">{c.uptime}</th>
                  <th className="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">{c.incidentsCount}</th>
                  <th className="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">{c.status.operational}</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-gray-100">
                {monthlyUptimeHistory.map((m, i) => (
                  <tr key={i} className="hover:bg-gray-50">
                    <td className="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{isRTL ? m.monthAr : m.month} <span dir="ltr">{m.year}</span></td>
                    <td className="px-6 py-4 whitespace-nowrap"><span className={`font-semibold ${m.uptime >= 99.9 ? 'text-green-600' : m.uptime >= 99 ? 'text-yellow-600' : 'text-red-600'}`} dir="ltr">{m.uptime}%</span></td>
                    <td className="px-6 py-4 whitespace-nowrap"><span className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${m.incidents === 0 ? 'bg-green-100 text-green-800' : m.incidents <= 2 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'}`}>{m.incidents}</span></td>
                    <td className="px-6 py-4 whitespace-nowrap"><div className="w-32 bg-gray-200 rounded-full h-2"><div className={`h-2 rounded-full ${m.uptime >= 99.9 ? 'bg-green-500' : m.uptime >= 99 ? 'bg-yellow-500' : 'bg-red-500'}`} style={{ width: `${m.uptime}%` }} /></div></td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>

        {/* Third-party Services */}
        <div className="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
          <div className="px-6 py-4 border-b border-gray-200">
            <div className="flex items-center gap-2"><LinkIcon className="w-5 h-5 text-gray-600" /><h2 className="text-lg font-semibold text-gray-900">{c.thirdParty}</h2></div>
          </div>
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-px bg-gray-100">
            {thirdPartyServices.map((service) => {
              const Icon = service.icon;
              return (
                <div key={service.id} className="bg-white px-4 py-4">
                  <div className="flex items-center justify-between mb-2">
                    <div className="flex items-center gap-2"><Icon className="w-4 h-4 text-gray-500" /><span className="font-medium text-gray-900 text-sm">{isRTL ? service.nameAr : service.name}</span></div>
                    <div className={`w-2 h-2 rounded-full ${getStatusColor(service.status)}`} />
                  </div>
                  <div className="flex items-center justify-between">
                    <span className={`text-xs ${service.status === 'operational' ? 'text-green-600' : 'text-red-600'}`}>{c.status[service.status]}</span>
                    <a href={service.url} target="_blank" rel="noopener noreferrer" className="text-xs text-[#1d71b8] hover:underline">{c.viewStatus} →</a>
                  </div>
                </div>
              );
            })}
          </div>
        </div>

        {/* Recent Incidents */}
        <div className="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
          <div className="px-6 py-4 border-b border-gray-200"><h2 className="text-lg font-semibold text-gray-900">{c.incidents}</h2></div>
          <div className="divide-y divide-gray-100">
            {recentIncidents.map((incident) => (
              <div key={incident.id} className="px-6 py-4">
                <div className="flex items-center gap-2 mb-1">
                  <h3 className="font-medium text-gray-900">{isRTL ? incident.titleAr : incident.title}</h3>
                  <span className={`px-2 py-0.5 text-xs font-medium rounded-full ${getIncidentStatusColor(incident.status)}`}>{c.incidentStatus[incident.status]}</span>
                </div>
                <p className="text-sm text-gray-600 mb-2">{isRTL ? incident.descriptionAr : incident.description}</p>
                <p className="text-xs text-gray-400">{formatDate(incident.date)} • {incident.service}</p>
              </div>
            ))}
          </div>
        </div>

        {/* Legend */}
        <div className="flex flex-wrap items-center justify-center gap-6 text-sm">
          <div className="flex items-center gap-2"><div className="w-3 h-3 rounded-full bg-green-500" /><span className="text-gray-600">{c.status.operational}</span></div>
          <div className="flex items-center gap-2"><div className="w-3 h-3 rounded-full bg-yellow-500" /><span className="text-gray-600">{c.status.degraded}</span></div>
          <div className="flex items-center gap-2"><div className="w-3 h-3 rounded-full bg-red-500" /><span className="text-gray-600">{c.status.outage}</span></div>
          <div className="flex items-center gap-2"><div className="w-3 h-3 rounded-full bg-blue-500" /><span className="text-gray-600">{c.status.maintenance}</span></div>
        </div>
      </div>
    </div>
  );
}
