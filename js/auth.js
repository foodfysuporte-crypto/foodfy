const authHandler = { 
    async signIn(email, password) { 
        const { data, error } = await window.supabaseClient.auth.signInWithPassword({ email, password }); 
        if (error) throw error; 
        
        const { data: profile } = await window.supabaseClient.from('profiles').select('role').eq('id', data.user.id).single(); 
        
        const role = profile?.role || 'user';
        if (role === 'super_admin') window.location.href = 'admin/index.html'; 
        else if (role === 'caixa') window.location.href = 'pos.html';
        else if (role === 'garcom') window.location.href = 'waiter.html';
        else if (role === 'motoboy') window.location.href = 'delivery.html';
        else window.location.href = 'dashboard.html'; 
        return { data }; 
    }, 
    
    async signUpStaff(email, password, inviteCode) {
        // Find org by invite code
        const { data: org, error: orgError } = await window.supabaseClient.from('organizations').select('id').eq('invite_code', inviteCode.trim()).single();
        if (orgError || !org) throw new Error('Código de loja inválido!');

        // Sign up the user
        const { data, error } = await window.supabaseClient.auth.signUp({ email, password });
        if (error) throw error;

        // Since trigger might create profile immediately, we wait 1 sec to ensure trigger finished
        await new Promise(r => setTimeout(r, 1000));
        
        // Update user's profile to link to the organization with 'pendente' role
        await window.supabaseClient.from('profiles').update({ 
            org_id: org.id, 
            role: 'pendente' 
        }).eq('id', data.user.id);
        
        // Wait for owner to approve
        alert('Cadastro realizado! Peça ao Dono (Admin) para aprovar seu acesso no Painel da Equipe.');
        window.location.reload();
    },

    async signOut() { 
        const { error } = await window.supabaseClient.auth.signOut(); 
        if(!error) window.location.href = (window.location.pathname.includes('/admin/')) ? '../index.html' : 'index.html'; 
    }, 
    
    async session() { 
        const { data: { session } } = await window.supabaseClient.auth.getSession(); 
        if (!session) return null; 
        const { data: profile } = await window.supabaseClient.from('profiles').select('*, organizations(*)').eq('id', session.user.id).single(); 
        
        // Enforce basic router security checks if not on correct page
        const path = window.location.pathname;
        const role = profile?.role;
        // Se for pendente, não deixa acessar nada produtivo
        if(role === 'pendente' && !path.includes('index.html')) {
            alert('Sua conta ainda não foi aprovada pelo Dono da Lanchonete.');
            this.signOut();
            return null;
        }

        return { ...session.user, profile }; 
    } 
}; 

window.auth = authHandler;
