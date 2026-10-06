import { supabase } from '../lib/supabase';

export const chatService = {
  async getUserChats(userId: string) {
    const { data, error } = await supabase
      .from('chat_participants')
      .select('chat_id, chats(updated_at)')
      .eq('user_id', userId)
      .order('chats(updated_at)', { ascending: false });
      
    return { data, error };
  },

  async getChatMessages(chatId: string) {
    const { data, error } = await supabase
      .from('chat_messages')
      .select('*, profiles(username, avatar_url)')
      .eq('chat_id', chatId)
      .order('created_at', { ascending: true });
      
    return { data, error };
  },

  async sendMessage(chatId: string, senderId: string, content: string) {
    const { data, error } = await supabase
      .from('chat_messages')
      .insert({
        chat_id: chatId,
        sender_id: senderId,
        content
      })
      .select()
      .single();
      
    if (!error) {
      // Update chat updated_at
      await supabase
        .from('chats')
        .update({ updated_at: new Date().toISOString() })
        .eq('id', chatId);
    }
      
    return { data, error };
  },

  async createChat(userIds: string[]) {
    // 1. Create chat
    const { data: chat, error: chatError } = await supabase
      .from('chats')
      .insert({})
      .select()
      .single();
      
    if (chatError || !chat) return { data: null, error: chatError };

    // 2. Add participants
    const participants = userIds.map(id => ({ chat_id: chat.id, user_id: id }));
    const { error: partError } = await supabase
      .from('chat_participants')
      .insert(participants);
      
    if (partError) return { data: null, error: partError };
    
    return { data: chat, error: null };
  }
};
