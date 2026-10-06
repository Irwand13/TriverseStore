import { supabase } from '../lib/supabase';
import type { Database } from '../types/database';

type ReviewInsert = Database['public']['Tables']['reviews']['Insert'];

export const reviewService = {
  async createReview(review: ReviewInsert) {
    const { data, error } = await supabase
      .from('reviews')
      .insert(review)
      .select()
      .single();
      
    return { data, error };
  },

  async getListingReviews(listingId: string) {
    const { data, error } = await supabase
      .from('reviews')
      .select('*, profiles(username, avatar_url)')
      .eq('listing_id', listingId)
      .order('created_at', { ascending: false });
      
    return { data, error };
  },

  async getUserReviews(userId: string) {
    const { data, error } = await supabase
      .from('reviews')
      .select('*, listings(title)')
      .eq('reviewer_id', userId)
      .order('created_at', { ascending: false });
      
    return { data, error };
  }
};
