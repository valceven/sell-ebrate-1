"use client";

import React from "react";
import Link from "next/link";

import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group";
import { Button, buttonVariants } from "@/components/ui/button";
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from "@/components/ui/popover";
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
import { Calendar } from "@/components/ui/calendar";

import { Gender } from "@/util/types";
import { CalendarIcon } from "lucide-react";

import axios from "axios";
import { format } from "date-fns";
import { z } from "zod";
import { zodResolver } from "@hookform/resolvers/zod";
import { useForm } from "react-hook-form";
import { registerFormSchema } from "@/util/form-schema";
import { cn } from "@/lib/utils";
import { serverDomain } from "@/util/server";
import { useUserStore } from "@/store/user";
import { useToast } from "@/components/ui/use-toast";

export default function RegisterBank() {
  const form = useForm<z.infer<typeof registerFormSchema>>({
    resolver: zodResolver(registerFormSchema),
    defaultValues: {
      firstName: "firstname",
      lastName: "lastname",
      email: "",
      password: "123123",

      gender: Gender.MALE,
      birthdate: new Date(),

      address: {
        street: "street",
        barangay: "brangay",
        municipality: "muni",
        province: "province",
        country: "ph",
      //  zipcode: 6046,
      },
    },
  });

  const { setToken } = useUserStore();
  const { toast } = useToast();

  async function onSubmit(values: z.infer<typeof registerFormSchema>) {
    console.log(values); // Log values here
    const { data } = await axios.post(serverDomain + "auth/register", {
      ...values,
    });

    if (data.error) {
      // TODO: error toast here
      toast({ title: "Register Error", description: data.error.message });
    } else {
      // TODO: good toast here
      toast({ title: "Register Success", description: data.data.message });
      localStorage.setItem("token", data.data.token);
      setToken(data.data.token);
    }
  }


  return (
    <Card className="flex-1">
      <CardHeader>
        <CardTitle>Register</CardTitle>
        <CardDescription>insert cool desc</CardDescription>
      </CardHeader>
      <CardContent>
        <Form {...form}>
          <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-2">
            <div className="flex gap-2">
              <FormField
                control={form.control}
                name="firstName"
                render={({ field }) => (
                  <FormItem className="flex-1">
                    <FormLabel>Firstname</FormLabel>
                    <FormControl>
                      <Input placeholder="Jake" {...field} />
                    </FormControl>
                    <FormMessage />
                  </FormItem>
                )}
              />

              <FormField
                control={form.control}
                name="lastName"
                render={({ field }) => (
                  <FormItem className="flex-1">
                    <FormLabel>Lastname</FormLabel>
                    <FormControl>
                      <Input placeholder="Bajo" {...field} />
                    </FormControl>
                    <FormMessage />
                  </FormItem>
                )}
              />
            </div>

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
                    <Input type="password" placeholder="******" {...field} />
                  </FormControl>
                  <FormMessage />
                </FormItem>
              )}
            />

            <FormField
              control={form.control}
              name="birthdate"
              render={({ field }) => (
                <FormItem className="flex flex-col">
                  <FormLabel>Birthdate</FormLabel>
                  <Popover>
                    <PopoverTrigger asChild>
                      <FormControl>
                        <Button
                          variant={"outline"}
                          className={cn(
                            "w-[240px] pl-3 text-left font-normal",
                            !field.value && "text-muted-foreground",
                          )}
                        >
                          {field.value ? (
                            format(field.value, "PPP")
                          ) : (
                            <span>Pick a date</span>
                          )}
                          <CalendarIcon className="ml-auto h-4 w-4 opacity-50" />
                        </Button>
                      </FormControl>
                    </PopoverTrigger>
                    <PopoverContent className="w-auto p-0" align="start">
                      <Calendar
                        mode="single"
                        selected={field.value}
                        onSelect={field.onChange}
                        disabled={(date) =>
                          date > new Date() || date < new Date("1900-01-01")
                        }
                        initialFocus
                      />
                    </PopoverContent>
                  </Popover>
                  <FormMessage />
                </FormItem>
              )}
            />

            <FormField
              control={form.control}
              name="gender"
              render={({ field }) => (
                <FormItem>
                  <FormLabel>Gender</FormLabel>
                  <FormControl>
                    <RadioGroup
                      onValueChange={field.onChange}
                      className="flex justify-evenly w-full"
                      defaultValue={Gender.MALE}
                      {...field}
                    >
                      <FormItem className="flex items-center space-x-3 space-y-0">
                        <FormControl>
                          <RadioGroupItem value={Gender.MALE} />
                        </FormControl>
                        <FormLabel className="font-normal">Male</FormLabel>
                      </FormItem>
                      <FormItem className="flex items-center space-x-3 space-y-0">
                        <FormControl>
                          <RadioGroupItem value={Gender.FEMALE} />
                        </FormControl>
                        <FormLabel className="font-normal">Female</FormLabel>
                      </FormItem>
                    </RadioGroup>
                  </FormControl>
                  <FormMessage />
                </FormItem>
              )}
            />

            {/* -- address -- */}

            <FormField
              control={form.control}
              name="address.street"
              render={({ field }) => (
                <FormItem>
                  <FormLabel>Street</FormLabel>
                  <FormControl>
                    <Input placeholder="bao unsa ni" {...field} />
                  </FormControl>
                  <FormMessage />
                </FormItem>
              )}
            />

            <FormField
              control={form.control}
              name="address.barangay"
              render={({ field }) => (
                <FormItem>
                  <FormLabel>Barangay</FormLabel>
                  <FormControl>
                    <Input placeholder="bao unsa ni" {...field} />
                  </FormControl>
                  <FormMessage />
                </FormItem>
              )}
            />

            <FormField
              control={form.control}
              name="address.municipality"
              render={({ field }) => (
                <FormItem>
                  <FormLabel>Municipality</FormLabel>
                  <FormControl>
                    <Input placeholder="bao unsa ni" {...field} />
                  </FormControl>
                  <FormMessage />
                </FormItem>
              )}
            />

            <FormField
              control={form.control}
              name="address.province"
              render={({ field }) => (
                <FormItem>
                  <FormLabel>Province</FormLabel>
                  <FormControl>
                    <Input placeholder="bao unsa ni" {...field} />
                  </FormControl>
                  <FormMessage />
                </FormItem>
              )}
            />

            <FormField
              control={form.control}
              name="address.country"
              render={({ field }) => (
                <FormItem>
                  <FormLabel>Country</FormLabel>
                  <FormControl>
                    <Input placeholder="bao unsa ni" {...field} />
                  </FormControl>
                  <FormMessage />
                </FormItem>
              )}
            />

            {/* <FormField
              control={form.control}
              name="address.zipcode"
              render={({ field }) => (
                <FormItem>
                  <FormLabel>Zipcode</FormLabel>
                  <FormControl>
                    <Input placeholder="bao unsa ni" {...field} />
                  </FormControl>
                  <FormMessage />
                </FormItem>
              )}
            /> */}

            <Button type="submit">Sign Up</Button>
          </form>
        </Form>
      </CardContent>

      <CardFooter>
        <p>
          Already have an account?
          <Link
            href={"/login"}
            className={cn(buttonVariants({ variant: "link" }), "px-2")}
          >
            Login now
          </Link>
        </p>
      </CardFooter>
    </Card>
  );
}
