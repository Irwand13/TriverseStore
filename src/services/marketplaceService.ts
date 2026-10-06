import { supabase } from '../lib/supabase';
import type { Database } from '../types/database';

type Listing = Database['public']['Tables']['listings']['Row'];
type ListingInsert = Database['public']['Tables']['listings']['Insert'];
type ListingUpdate = Database['public']['Tables']['listings']['Update'];

export const marketplaceService = {
  async getListings(filters?: { category_id?: string, status?: string }) {
    let query = supabase.from('listings').select('*, profiles(username, avatar_url), game_categories(name)');
    
    if (filters?.category_id) {
      query = query.eq('category_id', filters.category_id);
    }
    if (filters?.status) {
      query = query.eq('status', filters.status);
    } else {
      query = query.eq('status', 'active');
    }
    
    const { data, error } = await query;
    return { data, error };
  },

  async getListingById(id: string) {
    const { data, error } = await supabase
      .from('listings')
      .select('*, profiles(username, avatar_url), game_categories(name)')
      .eq('id', id)
      .single();
      
    return { data, error };
  },

  async searchListings(searchTerm: string) {
    const { data, error } = await supabase
      .from('listings')
      .select('*, profiles(username, avatar_url)')
      .ilike('title', `%${searchTerm}%`)
      .eq('status', 'active');
      
    return { data, error };
  },

  async createListing(listing: ListingInsert) {
    const { data, error } = await supabase
      .from('listings')
      .insert(listing)
      .select()
      .single();
      
    return { data, error };
  },

  async updateListing(id: string, updates: ListingUpdate) {
    const { data, error } = await supabase
      .from('listings')
      .update(updates)
      .eq('id', id)
      .select()
      .single();
      
    return { data, error };
  },

  async deleteListing(id: string) {
    const { error } = await supabase
      .from('listings')
      .update({ status: 'deleted' })
      .eq('id', id);
      
    return { error };
  },

  async getCategories() {
    const { data, error } = await supabase
      .from('game_categories')
      .select('*');
    return { data, error };
  }
};
