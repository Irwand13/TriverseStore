import { supabase } from '../lib/supabase';
import type { Database } from '../types/database';

type OrderInsert = Database['public']['Tables']['orders']['Insert'];
type OrderUpdate = Database['public']['Tables']['orders']['Update'];

export const orderService = {
  async createOrder(order: OrderInsert) {
    const { data, error } = await supabase
      .from('orders')
      .insert(order)
      .select()
      .single();
      
    return { data, error };
  },

  async getOrderById(id: string) {
    const { data, error } = await supabase
      .from('orders')
      .select('*, listings(title, image_url), profiles!orders_seller_id_fkey(username)')
      .eq('id', id)
      .single();
      
    return { data, error };
  },

  async getUserOrders(userId: string, role: 'buyer' | 'seller' = 'buyer') {
    const column = role === 'buyer' ? 'buyer_id' : 'seller_id';
    
    const { data, error } = await supabase
      .from('orders')
      .select('*, listings(title, image_url), profiles!orders_seller_id_fkey(username), profiles!orders_buyer_id_fkey(username)')
      .eq(column, userId)
      .order('created_at', { ascending: false });
      
    return { data, error };
  },

  async updateOrderStatus(id: string, status: OrderUpdate['status']) {
    const { data, error } = await supabase
      .from('orders')
      .update({ status })
      .eq('id', id)
      .select()
      .single();
      
    return { data, error };
  }
};
