import React from "react";
import axios from "axios";
import { serverDomain } from "@/util/server";
import ProductCard from "@/components/product-card";

export default async function Home() {
  const { data } = await axios.get(serverDomain + "products.php");

  return (
    <main>
      {data.data.products.map((product: any) => {
        return <ProductCard key={product.id} product={product} />;
      })}
    </main>
  );
}
