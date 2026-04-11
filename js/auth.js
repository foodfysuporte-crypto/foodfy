const authHandler = {
    async signIn(email, password) {
        return await window.supabaseClient.auth.signInWithPassword({ email, password });
    },
    async signOut() {
        const { error } = await window.supabaseClient.auth.signOut();
        if(!error) window.location.href = 'index.html';
    },
    async session() {
        const { data: { session } } = await window.supabaseClient.auth.getSession();
        return session ? session.user : null;
    }
};
window.auth = authHandler;
