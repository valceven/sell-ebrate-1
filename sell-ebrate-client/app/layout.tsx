import type { Metadata } from "next";
import { Inter } from "next/font/google";

import "./globals.css";
import Provider from "@/components/provider/provider";
import { ModeToggle } from "@/components/theme-toggle";

const inter = Inter({ subsets: ["latin"] });

export const metadata: Metadata = {
  title: "Sell-Ebrate",
  description: "An Ecommerce Platform for Sellers",
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en">
      <body className={inter.className}>
        <Provider>{children}</Provider>
      </body>
    </html>
  );
}
