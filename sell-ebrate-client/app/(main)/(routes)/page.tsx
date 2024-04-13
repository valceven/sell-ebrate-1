import React from "react";
import axios from "axios";
import { serverDomain } from "@/util/server";

export default async function Home() {
  const products = (await axios.get(serverDomain + "products.php")) as any;

  return (
    <main>
      {products.map((product: any) => {
        return <div key={product.id}>{product.name}</div>;
      })}
    </main>
  );
}
