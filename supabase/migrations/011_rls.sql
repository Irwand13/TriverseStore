-- Enable RLS on all tables
ALTER TABLE public.profiles ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.game_categories ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.listings ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.orders ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.reviews ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.wallets ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.wallet_transactions ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.topup_products ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.topup_orders ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.notifications ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.chats ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.chat_participants ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.chat_messages ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.payments ENABLE ROW LEVEL SECURITY;

-- Profiles: Anyone can read, users can update their own
CREATE POLICY "Public profiles are viewable by everyone." ON public.profiles FOR SELECT USING (true);
CREATE POLICY "Users can update own profile." ON public.profiles FOR UPDATE USING (auth.uid() = id);

-- Categories: Anyone can read
CREATE POLICY "Game categories viewable by everyone." ON public.game_categories FOR SELECT USING (true);

-- Listings: Anyone can read, users can insert/update/delete their own
CREATE POLICY "Listings viewable by everyone." ON public.listings FOR SELECT USING (true);
CREATE POLICY "Users can insert their own listings." ON public.listings FOR INSERT WITH CHECK (auth.uid() = seller_id);
CREATE POLICY "Users can update their own listings." ON public.listings FOR UPDATE USING (auth.uid() = seller_id);
CREATE POLICY "Users can delete their own listings." ON public.listings FOR DELETE USING (auth.uid() = seller_id);

-- Orders: Users can read their own orders (as buyer or seller)
CREATE POLICY "Users can view their own orders." ON public.orders FOR SELECT USING (auth.uid() = buyer_id OR auth.uid() = seller_id);
CREATE POLICY "Users can insert orders." ON public.orders FOR INSERT WITH CHECK (auth.uid() = buyer_id);
CREATE POLICY "Buyers can update their pending orders." ON public.orders FOR UPDATE USING (auth.uid() = buyer_id AND status = 'pending');

-- Reviews: Anyone can read, buyers can insert for their completed orders
CREATE POLICY "Reviews viewable by everyone." ON public.reviews FOR SELECT USING (true);
CREATE POLICY "Users can insert their own reviews." ON public.reviews FOR INSERT WITH CHECK (auth.uid() = reviewer_id);

-- Wallets: Users can read their own wallet
CREATE POLICY "Users can view their own wallet." ON public.wallets FOR SELECT USING (auth.uid() = user_id);

-- Wallet Transactions: Users can read their own
CREATE POLICY "Users can view their own wallet transactions." ON public.wallet_transactions FOR SELECT USING (
    wallet_id IN (SELECT id FROM public.wallets WHERE user_id = auth.uid())
);

-- Topup Products: Viewable by all
CREATE POLICY "Topup products viewable by everyone." ON public.topup_products FOR SELECT USING (true);

-- Topup Orders: Viewable by owner
CREATE POLICY "Users can view their own topup orders." ON public.topup_orders FOR SELECT USING (auth.uid() = user_id);
CREATE POLICY "Users can insert topup orders." ON public.topup_orders FOR INSERT WITH CHECK (auth.uid() = user_id);

-- Notifications: View and update own
CREATE POLICY "Users can view their own notifications." ON public.notifications FOR SELECT USING (auth.uid() = user_id);
CREATE POLICY "Users can update their own notifications." ON public.notifications FOR UPDATE USING (auth.uid() = user_id);

-- Chats: View if participant
CREATE POLICY "Users can view chats they are in." ON public.chats FOR SELECT USING (
    EXISTS (SELECT 1 FROM public.chat_participants WHERE chat_id = id AND user_id = auth.uid())
);
CREATE POLICY "Users can insert chats." ON public.chats FOR INSERT WITH CHECK (true);

CREATE POLICY "Users can view participants of their chats." ON public.chat_participants FOR SELECT USING (
    chat_id IN (SELECT chat_id FROM public.chat_participants WHERE user_id = auth.uid())
);
CREATE POLICY "Users can insert themselves into chats." ON public.chat_participants FOR INSERT WITH CHECK (auth.uid() = user_id);

CREATE POLICY "Users can view messages in their chats." ON public.chat_messages FOR SELECT USING (
    chat_id IN (SELECT chat_id FROM public.chat_participants WHERE user_id = auth.uid())
);
CREATE POLICY "Users can insert messages to their chats." ON public.chat_messages FOR INSERT WITH CHECK (
    auth.uid() = sender_id AND chat_id IN (SELECT chat_id FROM public.chat_participants WHERE user_id = auth.uid())
);

-- Payments: Viewable by owner
CREATE POLICY "Users can view their own payments." ON public.payments FOR SELECT USING (auth.uid() = user_id);
CREATE POLICY "Users can insert payments." ON public.payments FOR INSERT WITH CHECK (auth.uid() = user_id);
