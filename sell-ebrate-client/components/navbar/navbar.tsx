"use client";

import React from "react";
import { ModeToggle } from "@/components/theme-toggle";
import { Button } from "@/components/ui/button";
import Link from "next/link";

export default function Navbar() {
  return (
    <div className="flex">
      <h1>Sell-Ebrate</h1>

      <div>
        <Button variant={"link"} asChild>
          <Link href={"/"}>Something</Link>
        </Button>
      </div>

      <ModeToggle />
    </div>
  );
}
