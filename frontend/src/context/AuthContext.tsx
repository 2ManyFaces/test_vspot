"use client";

import React, { createContext, useContext, useState, useEffect, useCallback } from "react";
import Cookies from "js-cookie";

interface User {
  id: number;
  display_name: string;
  email: string;
  profile_photo_url?: string;
  [key: string]: any;
}

interface AuthContextType {
  user: User | null;
  role: "user" | "admin" | null;
  isLoading: boolean;
  login: (token: string, userData: User, userRole: "user" | "admin") => void;
  logout: () => void;
}

const AuthContext = createContext<AuthContextType>({
  user: null,
  role: null,
  isLoading: true,
  login: () => {},
  logout: () => {},
});

export const AuthProvider = ({ children }: { children: React.ReactNode }) => {
  const [user, setUser] = useState<User | null>(null);
  const [role, setRole] = useState<"user" | "admin" | null>(null);
  const [isLoading, setIsLoading] = useState(true);

  useEffect(() => {
    const fetchUser = async () => {
      const token = Cookies.get("auth_token");

      if (!token) {
        setIsLoading(false);
        return;
      }

      try {
        const res = await fetch("http://localhost:8000/api/auth/me", {
          headers: {
            Authorization: `Bearer ${token}`,
            Accept: "application/json",
          },
        });

        if (res.ok) {
          const data = await res.json();
          setUser(data.data.user);
          setRole(data.data.role);
        } else {
          Cookies.remove("auth_token");
        }
      } catch (error) {
        console.error("Failed to fetch user session", error);
      } finally {
        setIsLoading(false);
      }
    };

    fetchUser();
  }, []);

  const login = useCallback((token: string, userData: User, userRole: "user" | "admin") => {
    Cookies.set("auth_token", token, { expires: 7 }); // 7 days expiration
    setUser(userData);
    setRole(userRole);
  }, []);

  const logout = useCallback(() => {
    const token = Cookies.get("auth_token");
    Cookies.remove("auth_token");
    setUser(null);
    setRole(null);
    
    // Optional: Call strictly backend logout to invalidate token
    if (token) {
      fetch("http://localhost:8000/api/auth/logout", {
        method: "POST",
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: "application/json",
        },
      }).catch(() => {});
    }
  }, []);

  return (
    <AuthContext.Provider value={{ user, role, isLoading, login, logout }}>
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = () => useContext(AuthContext);
