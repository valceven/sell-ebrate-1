"use client";
import React from "react";
import axios from "axios";
import { serverDomain } from "@/util/server";

export default function Home() {
  async function getData() {
    const res = await axios.post(serverDomain + "login");
    console.log(res);
  }

  return (
    <div>
      <button onClick={getData}>cicled</button>
    </div>
  );
}
