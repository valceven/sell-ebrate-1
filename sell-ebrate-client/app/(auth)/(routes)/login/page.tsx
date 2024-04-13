"use client";

import React from "react";
import { Button, buttonVariants } from "@/components/ui/button";
import {
  Form,
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";

import { z } from "zod";
import { zodResolver } from "@hookform/resolvers/zod";
import { useForm } from "react-hook-form";
import { Separator } from "@/components/ui/separator";
import { cn } from "@/lib/utils";
import Link from "next/link";
import axios from "axios";
import { serverDomain, urlParamsSerializer } from "@/util/server";
import { useUserStore } from "@/store/user";
import { useToast } from "@/components/ui/use-toast";

const loginFormSchema = z.object({
  email: z.string().email(),
  password: z.string(),
});

export default function Login() {
  const form = useForm<z.infer<typeof loginFormSchema>>({
    resolver: zodResolver(loginFormSchema),
    defaultValues: {
      email: "123@gmail.com",
      password: "123123",
    },
  });

  const { setToken } = useUserStore();
  const { toast } = useToast();

  async function onSubmit(values: z.infer<typeof loginFormSchema>) {
    const { data } = await axios.post(serverDomain + "login.php", {
      ...values,
    });

    console.log(data);

    if (data.error) {
      // TODO: error toast here
      toast({ title: "Login Error", description: data.error.message });
    } else {
      // TODO: good toast here
      toast({ title: "Login Success", description: data.data.message });
      setToken(data.data.token);
    }
  }

  return (
    <div>
      <Card className="w-full h-full">
        <CardHeader>
          <CardTitle>Login</CardTitle>
          <CardDescription>Enter your credentials</CardDescription>
        </CardHeader>
        <CardContent>
          <Form {...form}>
            <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-8">
              <FormField
                control={form.control}
                name="email"
                render={({ field }) => (
                  <FormItem>
                    <FormLabel>Email</FormLabel>
                    <FormControl>
                      <Input
                        type="email"
                        placeholder="jakebajo@gmail.com"
                        {...field}
                      />
                    </FormControl>
                    <FormMessage />
                  </FormItem>
                )}
              />
              <FormField
                control={form.control}
                name="password"
                render={({ field }) => (
                  <FormItem>
                    <FormLabel>Password</FormLabel>
                    <FormControl>
                      <Input
                        type="password"
                        placeholder="********"
                        {...field}
                      />
                    </FormControl>
                    <FormMessage />
                  </FormItem>
                )}
              />
              <Button type="submit">Login</Button>

              <Separator />

              {/* TODO: add a google button here */}
              <Button type="button">Google button here</Button>
            </form>
          </Form>
        </CardContent>

        <CardFooter>
          <p>
            Don&apos;t have an account yet?
            <Link
              href={"/register"}
              className={cn(buttonVariants({ variant: "link" }), "px-2")}
            >
              Register now
            </Link>
          </p>
        </CardFooter>
      </Card>
    </div>
  );
}
