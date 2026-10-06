import { supabase } from '../lib/supabase';

export const walletService = {
  async getWallet(userId: string) {
    const { data, error } = await supabase
      .from('wallets')
      .select('*')
      .eq('user_id', userId)
      .single();
      
    return { data, error };
  },

  async getWalletBalance(userId: string) {
    const { data, error } = await this.getWallet(userId);
    if (error || !data) return { balance: 0, error };
    return { balance: data.balance, error: null };
  },

  async getWalletTransactions(walletId: string) {
    const { data, error } = await supabase
      .from('wallet_transactions')
      .select('*')
      .eq('wallet_id', walletId)
      .order('created_at', { ascending: false });
      
    return { data, error };
  }
};
