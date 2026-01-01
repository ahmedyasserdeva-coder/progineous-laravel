'use client';

import { useState, useEffect } from 'react';

interface Product {
  pid: number;
  gid: number;
  name: string;
  description: string;
  pricing: {
    [key: string]: {
      monthly?: string;
      quarterly?: string;
      semiannually?: string;
      annually?: string;
      biennially?: string;
      triennially?: string;
    };
  };
}

interface ProductGroup {
  id: number;
  name: string;
  headline?: string;
}

export function useProducts() {
  const [products, setProducts] = useState<Product[]>([]);
  const [groups, setGroups] = useState<ProductGroup[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const fetchProducts = async () => {
      try {
        const response = await fetch('/api/whmcs/products');
        const data = await response.json();

        if (!response.ok) {
          throw new Error(data.error || 'Failed to fetch products');
        }

        setProducts(data.products);
        setGroups(data.groups);
      } catch (err) {
        const message = err instanceof Error ? err.message : 'An error occurred';
        setError(message);
      } finally {
        setLoading(false);
      }
    };

    fetchProducts();
  }, []);

  return { products, groups, loading, error };
}
