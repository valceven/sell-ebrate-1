import { z } from "zod";
import { Gender } from "./types";

export const registerFormSchema = z.object({
  firstname: z.string().min(2).max(20),
  lastname: z.string().min(2).max(20),
  email: z.string().email(),
  password: z.string(),

  gender: z.nativeEnum(Gender),
  birthdate: z.string().datetime(),

  address: z.object({
    street: z.string(),
    barangay: z.string(),
    municipality: z.string(),
    province: z.string(),
    country: z.string(),
    zipcode: z.number().int(),
  }),
});
