CREATE TABLE public.topup_products (
    id UUID DEFAULT uuid_generate_v4() PRIMARY KEY,
    provider_code TEXT NOT NULL UNIQUE, -- E.g., Digiflazz code
    name TEXT NOT NULL,
    category TEXT NOT NULL, -- E.g., Mobile Legends, Free Fire
    price DECIMAL(10, 2) NOT NULL,
    active BOOLEAN DEFAULT true,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT timezone('utc'::text, now()) NOT NULL,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT timezone('utc'::text, now()) NOT NULL
);

CREATE TABLE public.topup_orders (
    id UUID DEFAULT uuid_generate_v4() PRIMARY KEY,
    user_id UUID REFERENCES public.profiles(id) ON DELETE CASCADE NOT NULL,
    product_id UUID REFERENCES public.topup_products(id) ON DELETE SET NULL,
    target_id TEXT NOT NULL, -- E.g., Player ID
    server_id TEXT, -- E.g., Zone ID
    amount DECIMAL(10, 2) NOT NULL,
    status TEXT NOT NULL DEFAULT 'pending' CHECK (status IN ('pending', 'processing', 'success', 'failed')),
    provider_trx_id TEXT, -- E.g., Digiflazz ref_id
    created_at TIMESTAMP WITH TIME ZONE DEFAULT timezone('utc'::text, now()) NOT NULL,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT timezone('utc'::text, now()) NOT NULL
);
