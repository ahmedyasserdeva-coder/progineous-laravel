'use client';

import { useEffect } from 'react';

export default function GlobalError({
  error,
  reset,
}: {
  error: Error & { digest?: string };
  reset: () => void;
}) {
  useEffect(() => {
    console.error(error);
  }, [error]);

  return (
    <html lang="en">
      <body>
        <div style={{
          minHeight: '100vh',
          background: 'linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%)',
          display: 'flex',
          alignItems: 'center',
          justifyContent: 'center',
          padding: '20px',
          fontFamily: 'Inter, Arial, sans-serif',
        }}>
          <div style={{
            textAlign: 'center',
            maxWidth: '500px',
          }}>
            {/* Error Icon */}
            <div style={{
              width: '120px',
              height: '120px',
              margin: '0 auto 32px',
              background: 'linear-gradient(135deg, #dc2626 0%, #ea580c 100%)',
              borderRadius: '50%',
              display: 'flex',
              alignItems: 'center',
              justifyContent: 'center',
              fontSize: '60px',
              boxShadow: '0 25px 50px -12px rgba(220, 38, 38, 0.3)',
            }}>
              
            </div>

            {/* Error Code */}
            <div style={{
              fontSize: '80px',
              fontWeight: 'bold',
              background: 'linear-gradient(90deg, #f87171 0%, #fb923c 100%)',
              WebkitBackgroundClip: 'text',
              WebkitTextFillColor: 'transparent',
              backgroundClip: 'text',
              marginBottom: '16px',
            }}>
              500
            </div>

            {/* Title */}
            <h1 style={{
              fontSize: '32px',
              fontWeight: 'bold',
              color: '#ffffff',
              marginBottom: '16px',
            }}>
              Critical Error
            </h1>

            {/* Description */}
            <p style={{
              fontSize: '18px',
              color: '#9ca3af',
              marginBottom: '32px',
              lineHeight: '1.6',
            }}>
              A critical error occurred. Please try refreshing the page or contact our support team.
            </p>

            {/* Buttons */}
            <div style={{
              display: 'flex',
              flexWrap: 'wrap',
              justifyContent: 'center',
              gap: '16px',
            }}>
              <button
                onClick={reset}
                style={{
                  padding: '16px 32px',
                  background: 'linear-gradient(135deg, #dc2626 0%, #ea580c 100%)',
                  color: '#ffffff',
                  fontWeight: '600',
                  fontSize: '16px',
                  border: 'none',
                  borderRadius: '12px',
                  cursor: 'pointer',
                  transition: 'transform 0.2s, box-shadow 0.2s',
                  boxShadow: '0 10px 40px -10px rgba(220, 38, 38, 0.4)',
                }}
                onMouseOver={(e) => {
                  e.currentTarget.style.transform = 'scale(1.05)';
                }}
                onMouseOut={(e) => {
                  e.currentTarget.style.transform = 'scale(1)';
                }}
              >
                 Try Again
              </button>

              <a
                href="/"
                style={{
                  padding: '16px 32px',
                  background: 'rgba(255, 255, 255, 0.1)',
                  color: '#ffffff',
                  fontWeight: '600',
                  fontSize: '16px',
                  border: 'none',
                  borderRadius: '12px',
                  cursor: 'pointer',
                  textDecoration: 'none',
                  display: 'inline-block',
                }}
              >
                 Go Home
              </a>
            </div>

            {/* Error Details */}
            {process.env.NODE_ENV === 'development' && error.message && (
              <div style={{
                marginTop: '32px',
                padding: '16px',
                background: 'rgba(220, 38, 38, 0.1)',
                border: '1px solid rgba(220, 38, 38, 0.2)',
                borderRadius: '12px',
                textAlign: 'left',
              }}>
                <p style={{
                  color: '#f87171',
                  fontSize: '14px',
                  fontFamily: 'monospace',
                  wordBreak: 'break-all',
                }}>
                  {error.message}
                </p>
              </div>
            )}
          </div>
        </div>
      </body>
    </html>
  );
}


