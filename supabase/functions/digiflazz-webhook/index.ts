import { serve } from "https://deno.land/std@0.168.0/http/server.ts"

serve(async (req) => {
  try {
    // 1. Verify webhook signature (Idempotency and Security)
    const payload = await req.json()
    
    // 2. Parse payload to get provider_trx_id and status
    const { ref_id, status } = payload.data
    
    // 3. Update topup_orders table using Supabase service role key
    // Ensure we don't duplicate operations if webhook received twice (Idempotency)
    
    // Example logic:
    // UPDATE topup_orders SET status = 'success' WHERE provider_trx_id = ref_id AND status = 'pending'

    return new Response(
      JSON.stringify({ success: true }),
      { headers: { "Content-Type": "application/json" } },
    )
  } catch (error: any) {
    return new Response(JSON.stringify({ error: error.message }), {
      status: 400,
      headers: { "Content-Type": "application/json" },
    })
  }
})
