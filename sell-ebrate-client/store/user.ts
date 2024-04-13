import { create } from "zustand";

interface UserStateType {
  getToken: () => string | null;
  setToken: (token: string) => void;
  removeToken: () => void;
}

export const useUserStore = create<UserStateType>((set) => ({
  getToken: () => {
    return localStorage.getItem("token");
  },
  setToken: (token: string) => {
    localStorage.setItem("token", token);
  },
  removeToken: () => {
    localStorage.removeItem("token");
  },
}));
