<script setup lang="ts">
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { route } from 'ziggy-js';

const email = ref('');
const errors = ref<Record<string, string[]>>({});
const processing = ref(false);
const success = ref(false);
const status = ref('');
const systemName = ref('Igreja On Line');
const churchName = ref('');

// Get system settings from props or data attribute
onMounted(() => {
    const appElement = document.getElementById('forgot-password-app');
    if (appElement) {
        systemName.value = appElement.dataset.systemName || 'Igreja On Line';
        churchName.value = appElement.dataset.churchName || '';
    }
});

const submit = async () => {
    processing.value = true;
    errors.value = {};
    
    try {
        const response = await axios.post(route('password.email'), {
            email: email.value,
            _token: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
        });
        
        success.value = true;
        status.value = response.data.status || 'Um link de recuperação de senha foi enviado para seu e-mail.';
    } catch (error: any) {
        if (error.response?.data?.errors) {
            errors.value = error.response.data.errors;
        } else if (error.response?.data?.status) {
            success.value = true;
            status.value = error.response.data.status;
        } else {
            console.error('Password reset request failed', error);
            errors.value = { email: ['Ocorreu um erro. Tente novamente.'] };
        }
    } finally {
        processing.value = false;
    }
};
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat relative p-4" 
         style="background-image: url('/images/login-bg.png')">
        
        <!-- Overlay for darker background -->
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

        <!-- Forgot Password Card -->
        <div class="relative z-10 w-full max-w-md">
            <div v-if="success" class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(0,0,0,0.37)] rounded-3xl overflow-hidden p-8 sm:p-12">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center p-4 mb-6 rounded-full bg-green-500/20 border border-green-500/30">
                        <svg class="w-12 h-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-white mb-4">Verifique seu E-mail</h1>
                    <p class="text-amber-200/70 mb-6">{{ status }}</p>
                    <p class="text-white/50 text-sm mb-6">Se não encontrar o e-mail, verifique sua caixa de spam.</p>
                    <button @click="success = false" class="inline-block bg-amber-600 hover:bg-amber-500 text-white font-bold py-3 px-6 rounded-xl transition-all">
                        Enviar Novamente
                    </button>
                </div>
            </div>

            <div v-else class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(0,0,0,0.37)] rounded-3xl overflow-hidden p-8 sm:p-12 transition-all duration-500">
                
                <!-- Logo & Header -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center p-3 mb-4 rounded-2xl bg-gradient-to-br from-red-500/30 to-orange-500/30 border border-red-500/30">
                        <i class="fas fa-key text-red-400 text-2xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-white tracking-tight mb-2 font-serif" 
                        style="background: linear-gradient(135deg, #f87171 0%, #fb923c 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                        {{ systemName }}
                    </h1>
                    <p class="text-amber-200/70 text-sm font-medium tracking-wide uppercase">Recuperar Senha</p>
                    <p v-if="churchName" class="text-white/50 text-xs mt-1">{{ churchName }}</p>
                </div>

                <div class="mb-6 p-4 rounded-xl bg-blue-500/20 border border-blue-500/30 text-blue-300 text-sm text-center">
                    <p>Informe seu e-mail e enviaremos um link para redefinir sua senha.</p>
                </div>

                <form @submit.prevent="submit" class="space-y-5">
                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-amber-100/80">E-mail Cadastrado</label>
                        <div class="relative">
                            <input 
                                id="email" 
                                v-model="email"
                                type="email" 
                                required 
                                autofocus
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500/50 transition-all"
                                placeholder="seu@email.com"
                            >
                        </div>
                        <p v-if="errors.email" class="text-red-400 text-xs mt-1">{{ errors.email[0] }}</p>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        :disabled="processing"
                        class="w-full bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-500 hover:to-orange-500 disabled:from-red-800 disabled:to-orange-800 disabled:opacity-50 text-white font-bold py-4 rounded-xl shadow-lg shadow-red-900/20 transform transition-all active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-red-500/50"
                    >
                        <span v-if="processing" class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Enviando...
                        </span>
                        <span v-else>Enviar Link de Recuperação</span>
                    </button>
                </form>

                <!-- Footer -->
                <div class="mt-8 text-center">
                    <div class="flex justify-center gap-4 flex-wrap">
                        <a href="/login" class="text-amber-500 hover:text-amber-400 text-sm transition-colors">Voltar ao Login</a>
                        <span class="text-white/20">|</span>
                        <a href="/register" class="text-amber-500 hover:text-amber-400 text-sm transition-colors">Cadastrar-se</a>
                        <span class="text-white/20">|</span>
                        <a href="/username/recover" class="text-amber-500 hover:text-amber-400 text-sm transition-colors">Esqueci meu usuário</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.font-serif {
    font-family: 'Cinzel', serif;
}

:deep(.font-sans) {
    font-family: 'Inter', sans-serif;
}
</style>
