const posHandler = {
    async loadCategories() {
        const { data: { session } } = await window.supabaseClient.auth.getSession();
        if (!session) return [];
        const orgId = session.user.user_metadata?.org_id || (await window.supabaseClient.from('profiles').select('org_id').eq('id', session.user.id).single()).data?.org_id;

        const { data, error } = await window.supabaseClient.from('categories')
            .select('*').eq('org_id', orgId);
        return error ? [] : data;
    },

    async loadProducts() {
        const { data: { session } } = await window.supabaseClient.auth.getSession();
        if (!session) return [];
        const orgId = session.user.user_metadata?.org_id || (await window.supabaseClient.from('profiles').select('org_id').eq('id', session.user.id).single()).data?.org_id;

        const { data, error } = await window.supabaseClient.from('products')
            .select('*').eq('org_id', orgId).is('deleted_at', null);
        return error ? [] : data;
    },

    async placeOrder(cart, orderType, identifier, address = null, payment = null) {
        if (!cart.length) throw new Error("Carrinho vazio");
        
        const { data: { session } } = await window.supabaseClient.auth.getSession();
        const profileResponse = await window.supabaseClient.from('profiles').select('org_id').eq('id', session.user.id).single();
        const orgId = profileResponse.data.org_id;

        let customerId = null;

        // Gerenciar cliente dinâmico (Mesa ou Balcão genérico)
        if (identifier) {
            let fetchCustomer = await window.supabaseClient.from('customers')
                .select('id').eq('org_id', orgId).eq('name', identifier).eq('type', orderType).single();
            
            if (fetchCustomer.data) {
                customerId = fetchCustomer.data.id;
            } else {
                let createCustomer = await window.supabaseClient.from('customers')
                    .insert({ org_id: orgId, name: identifier, type: orderType, phone: '', email: null })
                    .select('id').single();
                if(createCustomer.error) throw createCustomer.error;
                customerId = createCustomer.data.id;
            }
        }

        const totalAmount = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

        // Criar Pedido Mestre com Endereço e Metodo
        const { data: orderMestre, error: orderError } = await window.supabaseClient.from('orders')
            .insert({
                org_id: orgId,
                customer_id: customerId,
                total_amount: totalAmount,
                status: 'paid', // Em uma v2 teria 'aberto', 'pago'
                delivery_address: address, // Vindo do Caixa no modo Balcão/Delivery
                payment_method: payment || 'pix'
            })
            .select('id').single();
        
        if (orderError) throw orderError;

        // Inserir Itens
        const orderItems = cart.map(item => ({
            order_id: orderMestre.id,
            product_id: item.id,
            quantity: item.quantity,
            unit_price: item.price
        }));

        const { error: itemsError } = await window.supabaseClient.from('order_items').insert(orderItems);
        if (itemsError) throw itemsError;

        return true;
    }
};

window.pos = posHandler;
