import { useEffect, useState } from "react";

export default function Get(api: string) {
  const [data, setData] = useState<[]>([]);
  const [isLoading, setIsLoading] = useState<boolean>(false);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const getData = async () => {
      try {
        setIsLoading(true);
        const response = await fetch(api);
        if (!response.ok) {
          setError(`Error found: ${response.status}`);
        }
        const item = await response.json();
        if (item) {
          setData(item.data);
        }
      } catch (error) {
        setError(error as string);
      } finally {
        setIsLoading(false);
      }
    };
    
    getData();

  }, [api]);

  return { data, isLoading, error };
}
