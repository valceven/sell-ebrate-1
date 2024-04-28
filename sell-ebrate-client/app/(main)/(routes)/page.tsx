import React from "react";
import axios from "axios";
import { serverDomain } from "@/util/server";
import ProductCard from "@/components/product-card";

export async function getServerComponentProps() {
  const { data } = await axios.get(serverDomain + "product");

  return { data };
}

export default function Home({ data }) {

  if (!data || !data.products) {
    return <div>No products available</div>;
  }

  return (
    <main>
      <div className="flex flex-wrap">
        {data.products.map((product) => (
          <ProductCard key={product.id} product={product} />
        ))}
      </div>
    </main>
  );
}
