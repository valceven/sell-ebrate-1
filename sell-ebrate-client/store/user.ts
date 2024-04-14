import { create } from "zustand";

interface UserStateType {
  token: string;
  setToken: (token: string) => void;
  removeToken: () => void;
}

export const useUserStore = create<UserStateType>((set) => ({
  token: localStorage.getItem("token") || "",
  setToken: (token: string) => set({ token: token }),
  removeToken: () => set({ token: "" }),
}));
