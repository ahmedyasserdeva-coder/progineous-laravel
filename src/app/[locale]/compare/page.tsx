'use client';

import { useLocale } from 'next-intl';
import { Link } from '@/i18n/routing';
import Image from 'next/image';
import { 
  ArrowRight, 
  CheckCircle, 
  XCircle, 
  Star,
  Shield,
  Headphones,
  Zap,
  Globe,
  Server
} from 'lucide-react';
import { cn } from '@/lib/utils';

const competitors = [
  {
    id: 'hostinger',
    name: 'Hostinger',
    logo: '/images/competitors/Hostinger_logo_purple.svg.png',
    slug: 'hostinger'
  },
  {
    id: 'godaddy',
    name: 'GoDaddy',
    logo: '/images/competitors/GD_LOCKUP_RGB_BLACK.png',
    slug: 'godaddy'
  },
  {
    id: 'namecheap',
    name: 'Namecheap',
    logo: '/images/competitors/Namecheap_Logo.svg.png',
    slug: 'namecheap'
  },
  {
    id: 'hostgator',
    name: 'HostGator',
    logo: '/images/competitors/Hostgator-logo.png',
    slug: 'hostgator'
  },
  {
    id: 'bluehost',
    name: 'Bluehost',
    logo: '/images/competitors/Bluehost_logo.svg.png',
    slug: 'bluehost'
  },
  {
    id: 'siteground',
    name: 'SiteGround',
    logo: '/images/competitors/SiteGround.Com_Inc._Logo.png',
    slug: 'siteground'
  }
];

export default function ComparePage() {
  const locale = useLocale();
  const isArabic = locale === 'ar';

  const content = {
    title: isArabic ? 'قارن Pro Gineous مع المنافسين' : 'Compare Pro Gineous with Competitors',
    subtitle: isArabic 
      ? 'اكتشف لماذا يختار آلاف العملاء Pro Gineous على أكبر شركات الاستضافة العالمية'
      : 'Discover why thousands of customers choose Pro Gineous over the biggest global hosting companies',
    selectCompetitor: isArabic ? 'اختر شركة للمقارنة' : 'Select a company to compare',
    viewComparison: isArabic ? 'عرض المقارنة' : 'View Comparison',
    whyChooseUs: isArabic ? 'لماذا تختار Pro Gineous؟' : 'Why Choose Pro Gineous?',
    features: [
      {
        icon: Zap,
        title: isArabic ? 'أسرع 3 مرات' : '3x Faster',
        description: isArabic ? 'سيرفرات LiteSpeed مع NVMe SSD' : 'LiteSpeed servers with NVMe SSD'
      },
      {
        icon: Headphones,
        title: isArabic ? 'دعم عربي 24/7' : '24/7 Arabic Support',
        description: isArabic ? 'فريق دعم يتحدث لغتك' : 'Support team that speaks your language'
      },
      {
        icon: Shield,
        title: isArabic ? 'SSL مجاني مدى الحياة' : 'Lifetime Free SSL',
        description: isArabic ? 'حماية كاملة لموقعك وزوارك' : 'Complete protection for your site and visitors'
      },
      {
        icon: Globe,
        title: isArabic ? 'سيرفرات في الشرق الأوسط' : 'Middle East Servers',
        description: isArabic ? 'سرعة أفضل لزوار المنطقة' : 'Better speed for regional visitors'
      }
    ]
  };

  return (
    <div className="min-h-screen bg-gradient-to-b from-gray-50 to-white">
      {/* Hero Section */}
      <section className="pt-32 pb-16 px-4">
        <div className="max-w-6xl mx-auto text-center">
          <h1 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
            {content.title}
          </h1>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto mb-12">
            {content.subtitle}
          </p>

          {/* Competitors Grid */}
          <div className="mb-16">
            <h2 className="text-2xl font-semibold text-gray-800 mb-8">
              {content.selectCompetitor}
            </h2>
            <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
              {competitors.map((competitor) => (
                <Link
                  key={competitor.id}
                  href={`/compare/${competitor.slug}`}
                  className="group p-6 bg-white rounded-xl border border-gray-200 hover:border-blue-500 hover:shadow-lg transition-all duration-300"
                >
                  <div className="h-12 mb-3 flex items-center justify-center">
                    <img 
                      src={competitor.logo}
                      alt={competitor.name}
                      className="h-8 max-w-full object-contain"
                    />
                  </div>
                  <h3 className="font-semibold text-gray-900 group-hover:text-blue-600 text-center">
                    {competitor.name}
                  </h3>
                  <div className="mt-2 text-sm text-blue-600 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-1">
                    {content.viewComparison}
                    <ArrowRight className="w-4 h-4" />
                  </div>
                </Link>
              ))}
            </div>
          </div>

          {/* Why Choose Us */}
          <div className="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-8 md:p-12 text-white">
            <h2 className="text-3xl font-bold mb-8">{content.whyChooseUs}</h2>
            <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
              {content.features.map((feature, index) => (
                <div key={index} className="text-center p-4">
                  <feature.icon className="w-12 h-12 mx-auto mb-4 text-blue-200" />
                  <h3 className="font-semibold text-lg mb-2">{feature.title}</h3>
                  <p className="text-blue-100 text-sm">{feature.description}</p>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* SEO Content Section */}
      <section className="py-16 px-4 bg-white">
        <div className="max-w-4xl mx-auto prose prose-lg">
          {isArabic ? (
            <>
              <h2>لماذا Pro Gineous أفضل من شركات الاستضافة الأخرى؟</h2>
              <p>
                عند البحث عن <strong>أفضل استضافة مواقع في مصر والسعودية والإمارات</strong>، 
                ستجد العديد من الخيارات مثل Hostinger و GoDaddy و Namecheap. لكن Pro Gineous 
                تقدم مميزات فريدة تجعلها الخيار الأمثل للمواقع العربية.
              </p>
              <h3>مميزات Pro Gineous مقارنة بالمنافسين:</h3>
              <ul>
                <li><strong>أسعار أقل بنسبة 40%</strong> من Hostinger و GoDaddy</li>
                <li><strong>دعم فني عربي</strong> متاح على مدار الساعة</li>
                <li><strong>سيرفرات في الشرق الأوسط</strong> لسرعة أفضل</li>
                <li><strong>نقل مجاني</strong> من أي شركة استضافة أخرى</li>
                <li><strong>ضمان استرداد 30 يوم</strong> بدون أسئلة</li>
              </ul>
              <h3>هل Hostinger أفضل من Pro Gineous؟</h3>
              <p>
                بينما Hostinger شركة كبيرة، إلا أن Pro Gineous تتفوق في خدمة العملاء العرب 
                بفضل الدعم الفني باللغة العربية والأسعار المناسبة للسوق المحلي.
              </p>
              <h3>هل GoDaddy أرخص من Pro Gineous؟</h3>
              <p>
                GoDaddy تعتبر من أغلى شركات الاستضافة، بينما Pro Gineous تقدم نفس الجودة 
                بأسعار أقل بكثير، مع دعم فني أفضل للعملاء العرب.
              </p>
              <h3>مقارنة Pro Gineous vs Bluehost</h3>
              <p>
                Bluehost معروفة عالمياً لكنها لا توفر دعم عربي. Pro Gineous تقدم <strong>مساحة 70GB</strong> مقارنة بـ 10GB في Bluehost، 
                مع <strong>150 موقع</strong> بدلاً من 10 مواقع فقط.
              </p>
              <h3>مقارنة Pro Gineous vs SiteGround</h3>
              <p>
                SiteGround ممتازة لكن <strong>أسعار التجديد مرتفعة جداً ($17.99/شهر)</strong>. 
                Pro Gineous تقدم تجديد بسعر $10/شهر فقط - أرخص بنسبة 44%!
              </p>
              <h3>عيوب المنافسين الشائعة:</h3>
              <ul>
                <li><strong>عيوب Hostinger:</strong> لا يوجد دعم عربي، سيرفرات بعيدة عن الشرق الأوسط</li>
                <li><strong>عيوب GoDaddy:</strong> أسعار مرتفعة، SSL غير مجاني، تجربة مستخدم معقدة</li>
                <li><strong>عيوب Bluehost:</strong> مساحة محدودة، أداء متوسط، لا دعم عربي</li>
                <li><strong>عيوب SiteGround:</strong> أسعار تجديد باهظة، مواقع محدودة</li>
                <li><strong>عيوب Namecheap:</strong> دعم فني بطيء، لا سيرفرات في الشرق الأوسط</li>
              </ul>
            </>
          ) : (
            <>
              <h2>Why Pro Gineous is Better Than Other Hosting Companies?</h2>
              <p>
                When searching for the <strong>best web hosting in Egypt, Saudi Arabia, and UAE</strong>, 
                you'll find many options like Hostinger, GoDaddy, and Namecheap. But Pro Gineous 
                offers unique features that make it the best choice for Arabic websites.
              </p>
              <h3>Pro Gineous Advantages Over Competitors:</h3>
              <ul>
                <li><strong>40% lower prices</strong> than Hostinger and GoDaddy</li>
                <li><strong>Arabic technical support</strong> available 24/7</li>
                <li><strong>Middle East servers</strong> for better speed</li>
                <li><strong>Free migration</strong> from any other hosting company</li>
                <li><strong>30-day money-back guarantee</strong> no questions asked</li>
              </ul>
              <h3>Is Hostinger Better Than Pro Gineous?</h3>
              <p>
                While Hostinger is a large company, Pro Gineous excels in serving Arab customers 
                with Arabic technical support and prices suitable for the local market.
              </p>
              <h3>Is GoDaddy Cheaper Than Pro Gineous?</h3>
              <p>
                GoDaddy is considered one of the most expensive hosting companies, while Pro Gineous 
                offers the same quality at much lower prices, with better support for Arab customers.
              </p>
              <h3>Pro Gineous vs Bluehost Comparison</h3>
              <p>
                Bluehost is globally known but doesn't offer Arabic support. Pro Gineous offers <strong>70GB storage</strong> compared to 10GB on Bluehost, 
                with <strong>150 websites</strong> instead of just 10 websites.
              </p>
              <h3>Pro Gineous vs SiteGround Comparison</h3>
              <p>
                SiteGround is excellent but <strong>renewal prices are very high ($17.99/month)</strong>. 
                Pro Gineous offers renewal at only $10/month - 44% cheaper!
              </p>
              <h3>Common Competitor Disadvantages:</h3>
              <ul>
                <li><strong>Hostinger problems:</strong> No Arabic support, servers far from Middle East</li>
                <li><strong>GoDaddy problems:</strong> High prices, SSL not free, complex user experience</li>
                <li><strong>Bluehost problems:</strong> Limited storage, average performance, no Arabic support</li>
                <li><strong>SiteGround problems:</strong> Expensive renewal prices, limited websites</li>
                <li><strong>Namecheap problems:</strong> Slow support, no Middle East servers</li>
              </ul>
            </>
          )}
        </div>
      </section>

      {/* FAQ Section */}
      <section className="py-16 px-4 bg-gray-50">
        <div className="max-w-4xl mx-auto">
          <h2 className="text-3xl font-bold text-center mb-12">
            {isArabic ? 'الأسئلة الشائعة عن استضافة المواقع' : 'Frequently Asked Questions About Web Hosting'}
          </h2>
          <div className="space-y-6">
            {(isArabic ? [
              {
                q: 'ما هي أفضل شركة استضافة في 2026؟',
                a: 'Pro Gineous تعتبر أفضل خيار للعملاء العرب بفضل الدعم الفني العربي على مدار الساعة، الأسعار التنافسية، والسيرفرات القريبة من الشرق الأوسط.'
              },
              {
                q: 'هل Hostinger أفضل من Pro Gineous؟',
                a: 'Hostinger شركة جيدة لكن Pro Gineous تتفوق بـ: دعم عربي 24/7، مساحة 70GB (مقابل 20GB)، 150 موقع (مقابل 3 مواقع)، وسيرفرات أقرب للشرق الأوسط.'
              },
              {
                q: 'ما هو بديل GoDaddy الأرخص؟',
                a: 'Pro Gineous هي أفضل بديل لـ GoDaddy بسعر $2/شهر فقط مقارنة بـ $5.99/شهر في GoDaddy، مع SSL مجاني ودعم عربي.'
              },
              {
                q: 'أيهما أفضل Bluehost أو Pro Gineous؟',
                a: 'Pro Gineous أفضل للمواقع العربية: مساحة 7 أضعاف، 15 ضعف عدد المواقع، دعم عربي، وأسعار تجديد أقل.'
              },
              {
                q: 'هل SiteGround تستحق السعر المرتفع؟',
                a: 'SiteGround ممتازة لكن أسعار التجديد ($17.99/شهر) مرتفعة جداً. Pro Gineous تقدم نفس الجودة بسعر تجديد $10/شهر فقط.'
              },
              {
                q: 'ما هي عيوب Hostinger؟',
                a: 'أبرز عيوب Hostinger: لا يوجد دعم عربي، مساحة محدودة (20GB)، 3 مواقع فقط في الخطة الأساسية، سيرفرات بعيدة عن الشرق الأوسط.'
              }
            ] : [
              {
                q: 'What is the best hosting company in 2026?',
                a: 'Pro Gineous is the best choice for Arab customers with 24/7 Arabic support, competitive prices, and servers close to the Middle East.'
              },
              {
                q: 'Is Hostinger better than Pro Gineous?',
                a: 'Hostinger is a good company but Pro Gineous excels with: 24/7 Arabic support, 70GB storage (vs 20GB), 150 websites (vs 3), and servers closer to the Middle East.'
              },
              {
                q: 'What is the cheapest GoDaddy alternative?',
                a: 'Pro Gineous is the best GoDaddy alternative at only $2/month compared to $5.99/month on GoDaddy, with free SSL and Arabic support.'
              },
              {
                q: 'Which is better Bluehost or Pro Gineous?',
                a: 'Pro Gineous is better for Arabic websites: 7x storage, 15x websites, Arabic support, and lower renewal prices.'
              },
              {
                q: 'Is SiteGround worth the high price?',
                a: 'SiteGround is excellent but renewal prices ($17.99/month) are very high. Pro Gineous offers the same quality at only $10/month renewal.'
              },
              {
                q: 'What are Hostinger disadvantages?',
                a: 'Main Hostinger problems: No Arabic support, limited storage (20GB), only 3 websites on basic plan, servers far from Middle East.'
              }
            ]).map((faq, index) => (
              <div key={index} className="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h3 className="font-semibold text-lg text-gray-900 mb-3">{faq.q}</h3>
                <p className="text-gray-600">{faq.a}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* JSON-LD Structured Data */}
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{
          __html: JSON.stringify({
            '@context': 'https://schema.org',
            '@type': 'ItemList',
            name: isArabic ? 'مقارنة شركات الاستضافة' : 'Web Hosting Comparison',
            description: isArabic 
              ? 'مقارنة بين Pro Gineous وأفضل شركات الاستضافة'
              : 'Comparison between Pro Gineous and top hosting companies',
            itemListElement: competitors.map((c, i) => ({
              '@type': 'ListItem',
              position: i + 1,
              name: `Pro Gineous vs ${c.name}`,
              url: `https://progineous.com/${locale}/compare/${c.slug}`
            }))
          })
        }}
      />
    </div>
  );
}
