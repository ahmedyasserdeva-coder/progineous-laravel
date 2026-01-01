import type { Metadata } from 'next';

type Props = {
  params: Promise<{ locale: string }>;
  children: React.ReactNode;
};

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { locale } = await params;
  const isArabic = locale === 'ar';

  const title = isArabic 
    ? 'شاركنا رأيك واحصل على خصم 15% | Pro Gineous'
    : 'Share Your Feedback & Get 15% Off | Pro Gineous';

  const description = isArabic
    ? 'قيّم تجربتك مع Pro Gineous واحصل على كود خصم 15% حصري. رأيك يهمنا لتحسين خدماتنا.'
    : 'Rate your experience with Pro Gineous and get an exclusive 15% discount code. Your feedback helps us improve our services.';

  return {
    title,
    description,
    robots: {
      index: false, // لا نريد أرشفة هذه الصفحة
      follow: false,
    },
    openGraph: {
      type: 'website',
      locale: isArabic ? 'ar_SA' : 'en_US',
      url: `https://progineous.com/${locale}/feedback`,
      title,
      description,
      siteName: 'Pro Gineous',
      images: [
        {
          url: `/api/og?title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&locale=${locale}&page=feedback`,
          width: 1200,
          height: 630,
          alt: title
        }
      ]
    },
  };
}

export default function FeedbackLayout({ children }: { children: React.ReactNode }) {
  return children;
}
