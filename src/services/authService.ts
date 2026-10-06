import { supabase } from '../lib/supabase';
import type { Database } from '../types/database';

export const authService = {
  async register(email: string, password: string, username?: string) {
    const { data, error } = await supabase.auth.signUp({
      email,
      password,
      options: {
        data: {
          username: username || '',
        },
      },
    });
    return { data, error };
  },

  async login(email: string, password: string) {
    const { data, error } = await supabase.auth.signInWithPassword({
      email,
      password,
    });
    return { data, error };
  },

  async logout() {
    const { error } = await supabase.auth.signOut();
    return { error };
  },

  async getSession() {
    const { data, error } = await supabase.auth.getSession();
    return { data, error };
  },

  async getCurrentUser() {
    const { data, error } = await supabase.auth.getUser();
    return { data, error };
  }
};
