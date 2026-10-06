export type Json =
  | string
  | number
  | boolean
  | null
  | { [key: string]: Json | undefined }
  | Json[]

export interface Database {
  public: {
    Tables: {
      profiles: {
        Row: {
          id: string
          username: string | null
          full_name: string | null
          avatar_url: string | null
          created_at: string
          updated_at: string
        }
        Insert: {
          id: string
          username?: string | null
          full_name?: string | null
          avatar_url?: string | null
          created_at?: string
          updated_at?: string
        }
        Update: {
          id?: string
          username?: string | null
          full_name?: string | null
          avatar_url?: string | null
          created_at?: string
          updated_at?: string
        }
      }
      game_categories: {
        Row: {
          id: string
          name: string
          slug: string
          description: string | null
          image_url: string | null
          created_at: string
        }
        Insert: {
          id?: string
          name: string
          slug: string
          description?: string | null
          image_url?: string | null
          created_at?: string
        }
        Update: {
          id?: string
          name?: string
          slug?: string
          description?: string | null
          image_url?: string | null
          created_at?: string
        }
      }
      listings: {
        Row: {
          id: string
          seller_id: string
          category_id: string | null
          title: string
          description: string
          price: number
          image_url: string | null
          status: 'active' | 'inactive' | 'sold' | 'deleted'
          created_at: string
          updated_at: string
        }
        Insert: {
          id?: string
          seller_id: string
          category_id?: string | null
          title: string
          description: string
          price: number
          image_url?: string | null
          status?: 'active' | 'inactive' | 'sold' | 'deleted'
          created_at?: string
          updated_at?: string
        }
        Update: {
          id?: string
          seller_id?: string
          category_id?: string | null
          title?: string
          description?: string
          price?: number
          image_url?: string | null
          status?: 'active' | 'inactive' | 'sold' | 'deleted'
          created_at?: string
          updated_at?: string
        }
      }
      orders: {
        Row: {
          id: string
          buyer_id: string
          seller_id: string
          listing_id: string | null
          amount: number
          status: 'pending' | 'paid' | 'completed' | 'cancelled' | 'refunded'
          created_at: string
          updated_at: string
        }
        Insert: {
          id?: string
          buyer_id: string
          seller_id: string
          listing_id?: string | null
          amount: number
          status?: 'pending' | 'paid' | 'completed' | 'cancelled' | 'refunded'
          created_at?: string
          updated_at?: string
        }
        Update: {
          id?: string
          buyer_id?: string
          seller_id?: string
          listing_id?: string | null
          amount?: number
          status?: 'pending' | 'paid' | 'completed' | 'cancelled' | 'refunded'
          created_at?: string
          updated_at?: string
        }
      }
      reviews: {
        Row: {
          id: string
          order_id: string
          reviewer_id: string
          listing_id: string
          rating: number
          comment: string | null
          created_at: string
        }
        Insert: {
          id?: string
          order_id: string
          reviewer_id: string
          listing_id: string
          rating: number
          comment?: string | null
          created_at?: string
        }
        Update: {
          id?: string
          order_id?: string
          reviewer_id?: string
          listing_id?: string
          rating?: number
          comment?: string | null
          created_at?: string
        }
      }
      wallets: {
        Row: {
          id: string
          user_id: string
          balance: number
          created_at: string
          updated_at: string
        }
        Insert: {
          id?: string
          user_id: string
          balance?: number
          created_at?: string
          updated_at?: string
        }
        Update: {
          id?: string
          user_id?: string
          balance?: number
          created_at?: string
          updated_at?: string
        }
      }
      wallet_transactions: {
        Row: {
          id: string
          wallet_id: string
          amount: number
          type: 'deposit' | 'purchase' | 'topup' | 'withdrawal' | 'refund' | 'adjustment'
          reference_id: string | null
          description: string | null
          created_at: string
        }
        Insert: {
          id?: string
          wallet_id: string
          amount: number
          type: 'deposit' | 'purchase' | 'topup' | 'withdrawal' | 'refund' | 'adjustment'
          reference_id?: string | null
          description?: string | null
          created_at?: string
        }
        Update: {
          id?: string
          wallet_id?: string
          amount?: number
          type?: 'deposit' | 'purchase' | 'topup' | 'withdrawal' | 'refund' | 'adjustment'
          reference_id?: string | null
          description?: string | null
          created_at?: string
        }
      }
      topup_products: {
        Row: {
          id: string
          provider_code: string
          name: string
          category: string
          price: number
          active: boolean
          created_at: string
          updated_at: string
        }
        Insert: {
          id?: string
          provider_code: string
          name: string
          category: string
          price: number
          active?: boolean
          created_at?: string
          updated_at?: string
        }
        Update: {
          id?: string
          provider_code?: string
          name?: string
          category?: string
          price?: number
          active?: boolean
          created_at?: string
          updated_at?: string
        }
      }
      topup_orders: {
        Row: {
          id: string
          user_id: string
          product_id: string | null
          target_id: string
          server_id: string | null
          amount: number
          status: 'pending' | 'processing' | 'success' | 'failed'
          provider_trx_id: string | null
          created_at: string
          updated_at: string
        }
        Insert: {
          id?: string
          user_id: string
          product_id?: string | null
          target_id: string
          server_id?: string | null
          amount: number
          status?: 'pending' | 'processing' | 'success' | 'failed'
          provider_trx_id?: string | null
          created_at?: string
          updated_at?: string
        }
        Update: {
          id?: string
          user_id?: string
          product_id?: string | null
          target_id?: string
          server_id?: string | null
          amount?: number
          status?: 'pending' | 'processing' | 'success' | 'failed'
          provider_trx_id?: string | null
          created_at?: string
          updated_at?: string
        }
      }
      notifications: {
        Row: {
          id: string
          user_id: string
          title: string
          message: string
          is_read: boolean
          type: string | null
          link: string | null
          created_at: string
        }
        Insert: {
          id?: string
          user_id: string
          title: string
          message: string
          is_read?: boolean
          type?: string | null
          link?: string | null
          created_at?: string
        }
        Update: {
          id?: string
          user_id?: string
          title?: string
          message?: string
          is_read?: boolean
          type?: string | null
          link?: string | null
          created_at?: string
        }
      }
      chats: {
        Row: {
          id: string
          created_at: string
          updated_at: string
        }
        Insert: {
          id?: string
          created_at?: string
          updated_at?: string
        }
        Update: {
          id?: string
          created_at?: string
          updated_at?: string
        }
      }
      chat_participants: {
        Row: {
          chat_id: string
          user_id: string
          joined_at: string
        }
        Insert: {
          chat_id: string
          user_id: string
          joined_at?: string
        }
        Update: {
          chat_id?: string
          user_id?: string
          joined_at?: string
        }
      }
      chat_messages: {
        Row: {
          id: string
          chat_id: string
          sender_id: string
          content: string
          is_read: boolean
          created_at: string
        }
        Insert: {
          id?: string
          chat_id: string
          sender_id: string
          content: string
          is_read?: boolean
          created_at?: string
        }
        Update: {
          id?: string
          chat_id?: string
          sender_id?: string
          content?: string
          is_read?: boolean
          created_at?: string
        }
      }
      payments: {
        Row: {
          id: string
          user_id: string
          amount: number
          type: 'wallet_deposit' | 'order' | 'topup'
          reference_id: string
          status: 'pending' | 'settlement' | 'expire' | 'cancel' | 'deny'
          payment_method: string | null
          provider_trx_id: string | null
          created_at: string
          updated_at: string
        }
        Insert: {
          id?: string
          user_id: string
          amount: number
          type: 'wallet_deposit' | 'order' | 'topup'
          reference_id: string
          status?: 'pending' | 'settlement' | 'expire' | 'cancel' | 'deny'
          payment_method?: string | null
          provider_trx_id?: string | null
          created_at?: string
          updated_at?: string
        }
        Update: {
          id?: string
          user_id?: string
          amount?: number
          type?: 'wallet_deposit' | 'order' | 'topup'
          reference_id?: string
          status?: 'pending' | 'settlement' | 'expire' | 'cancel' | 'deny'
          payment_method?: string | null
          provider_trx_id?: string | null
          created_at?: string
          updated_at?: string
        }
      }
    }
    Views: {
      [_ in never]: never
    }
    Functions: {
      [_ in never]: never
    }
    Enums: {
      [_ in never]: never
    }
    CompositeTypes: {
      [_ in never]: never
    }
  }
}
