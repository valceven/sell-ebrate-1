export enum Gender {
  MALE = "male",
  FEMALE = "female",
}

export interface Product {
  productId: string;
  sellerId: string;

  productName: string;
  description: string;
  quantity: number;
  price: number;
}

export interface Profile {
  account_id: string;

  firstname: string;
  lastname: string;
  email: string;
  password: string;
  gender: Gender;
  birthdate: Date;
}
