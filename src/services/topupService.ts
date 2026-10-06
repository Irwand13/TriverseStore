import { supabase } from '../lib/supabase';
import type { Database } from '../types/database';

type TopupOrderInsert = Database['public']['Tables']['topup_orders']['Insert'];

export const topupService = {
  async getTopupProducts(category?: string) {
    let query = supabase.from('topup_products').select('*').eq('active', true);
    if (category) {
      query = query.eq('category', category);
    }
    const { data, error } = await query;
    return { data, error };
  },

  async getTopupProductById(id: string) {
    const { data, error } = await supabase
      .from('topup_products')
      .select('*')
      .eq('id', id)
      .single();
    return { data, error };
  },

  async getUserTopupOrders(userId: string) {
    const { data, error } = await supabase
      .from('topup_orders')
      .select('*, topup_products(name, category)')
      .eq('user_id', userId)
      .order('created_at', { ascending: false });
    return { data, error };
  },

  async getTopupOrder(id: string) {
    const { data, error } = await supabase
      .from('topup_orders')
      .select('*, topup_products(name, category)')
      .eq('id', id)
      .single();
    return { data, error };
  },

  async createTopupOrder(order: TopupOrderInsert) {
    // Note: The actual call to Digiflazz should happen in a Supabase Edge Function
    // We insert the pending record here, and a database trigger/webhook can call the edge function,
    // or we can call the edge function directly from the frontend which handles both DB insert and API call.
    // Assuming we just insert here and a backend process takes over:
    const { data, error } = await supabase
      .from('topup_orders')
      .insert(order)
      .select()
      .single();
      
    return { data, error };
  }
};
