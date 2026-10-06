import { createClient } from '@supabase/supabase-js';

const supabaseUrl = import.meta.env?.VITE_SUPABASE_URL || '';
const supabaseAnonKey = import.meta.env?.VITE_SUPABASE_ANON_KEY || '';

// We explicitly check if variables are available to avoid throwing errors instantly 
// in environments where dotenv might not be properly loaded yet (e.g., standard HTML context without Vite).
if (!supabaseUrl || !supabaseAnonKey) {
  console.warn('Supabase environment variables (VITE_SUPABASE_URL, VITE_SUPABASE_ANON_KEY) are missing. Check your .env file.');
}

export const supabase = createClient(supabaseUrl, supabaseAnonKey);
