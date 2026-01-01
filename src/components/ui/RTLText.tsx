'use client';

import React from 'react';

interface RTLTextProps {
  children: string;
  className?: string;
}

// Function to wrap numbers and special patterns with LTR direction
function processTextForRTL(text: string): React.ReactNode[] {
  // Pattern to match: phone numbers, dates, times, percentages, currency, and general numbers with special chars
  const pattern = /(\+?\d[\d\s\-\.\:\/\,\%\$€£]+\d|\d+)/g;
  
  const parts = text.split(pattern);
  
  return parts.map((part, index) => {
    if (pattern.test(part) || /^\+?\d[\d\s\-\.\:\/\,\%\$€£]*\d?$/.test(part) || /^\d+$/.test(part)) {
      return (
        <span key={index} dir="ltr" style={{ unicodeBidi: 'embed' }}>
          {part}
        </span>
      );
    }
    return part;
  });
}

export function RTLText({ children, className = '' }: RTLTextProps) {
  const processedContent = processTextForRTL(children);
  
  return <span className={className}>{processedContent}</span>;
}

// For processing paragraph content
export function RTLParagraph({ children, className = '' }: RTLTextProps) {
  const processedContent = processTextForRTL(children);
  
  return <p className={className}>{processedContent}</p>;
}
