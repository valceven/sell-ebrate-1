import React from "react";
import axios from "axios";
import { serverDomain } from "@/util/server";

export default async function Home() {
  const { data } = await axios.get(serverDomain + "products.php");

  return (
    <main>
      {data.data.products.map((product: any) => {
        return <div key={product.id}>{product.product_name}</div>;
      })}
    </main>
  );
}
