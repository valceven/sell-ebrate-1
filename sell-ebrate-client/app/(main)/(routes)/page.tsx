import React from "react";
import axios from "axios";
import { serverDomain } from "@/util/server";
import ProductCard from "@/components/product-card";

export default async function Home() {
  const { data } = await axios.get(serverDomain + "products");

  return (
    <main>
      <div className="flex flex-wrap">
        {data.data.products.map((product: any) => {
          return <ProductCard key={product.id} product={product} />;
        })}
      </div>
    </main>
  );
}
