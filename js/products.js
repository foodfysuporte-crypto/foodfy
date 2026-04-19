const productsHandler = {
    async list() {
        const session = await window.auth.session();
        if (!session) return [];
        const orgId = session.profile.org_id;

        const { data, error } = await window.supabaseClient.from('products')
            .select('*, categories(name)')
            .eq('org_id', orgId)
            .is('deleted_at', null)
            .order('created_at', { ascending: false });
        
        if (error) throw error;
        return data || [];
    },

    async listCategories() {
        const session = await window.auth.session();
        if (!session) return [];
        
        const { data, error } = await window.supabaseClient.from('categories')
            .select('*')
            .eq('org_id', session.profile.org_id)
            .is('deleted_at', null)
            .order('name');
        
        if (error) throw error;
        return data || [];
    },

    async uploadImage(fileBinary) {
        if (!fileBinary) return null;
        
        const fileExt = fileBinary.name.split('.').pop();
        const fileName = `${Math.random().toString(36).substring(2)}_${Date.now()}.${fileExt}`;
        
        const { data, error } = await window.supabaseClient.storage
            .from('product_images')
            .upload(fileName, fileBinary, { cacheControl: '3600', upsert: false });
            
        if (error) throw error;

        const { data: publicUrlData } = window.supabaseClient.storage
            .from('product_images')
            .getPublicUrl(fileName);
            
        return publicUrlData.publicUrl;
    },

    async save(product, imageFile = null) {
        const session = await window.auth.session();
        const orgId = session.profile.org_id;
        
        let imageUrl = product.image_url;
        
        if (imageFile) {
            imageUrl = await this.uploadImage(imageFile);
        }

        const productData = { 
            name: product.name,
            price: parseFloat(product.price),
            category_id: product.category_id || null,
            image_url: imageUrl,
            org_id: orgId 
        };

        if (product.id) {
            const { error } = await window.supabaseClient.from('products').update(productData).eq('id', product.id);
            if (error) throw error;
        } else {
            const { error } = await window.supabaseClient.from('products').insert([productData]);
            if (error) throw error;
        }
        return true;
    },

    async delete(id) {
        // Soft delete para não quebrar orders atreladas
        const { error } = await window.supabaseClient.from('products')
            .update({ deleted_at: new Date().toISOString() })
            .eq('id', id);
        if (error) throw error;
        return true;
    }
};

window.products = productsHandler;
