<script setup lang="ts">
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { route } from 'ziggy-js';

const name = ref('');
const email = ref('');
const errors = ref<Record<string, string[]>>({});
const processing = ref(false);
const success = ref(false);
const foundUser = ref<{ email: string; created_at: string } | null>(null);
const systemName = ref('Igreja On Line');
const churchName = ref('');

// Get system settings from props or data attribute
onMounted(() => {
    const appElement = document.getElementById('recover-username-app');
    if (appElement) {
        systemName.value = appElement.dataset.systemName || 'Igreja On Line';
        churchName.value = appElement.dataset.churchName || '';
    }
});

const submit = async () => {
    processing.value = true;
    errors.value = {};
    
    try {
        const response = await axios.post(route('username.recover.send'), {
            name: name.value,
            email: email.value,
            _token: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
        });
        
        success.value = true;
        foundUser.value = response.data.user;
    } catch (error: any) {
        if (error.response?.data?.errors) {
            errors.value = error.response.data.errors;
        } else if (error.response?.data?.message) {
            errors.value = { general: [error.response.data.message] };
        } else {
            console.error('Username recovery failed', error);
            errors.value = { general: ['Ocorreu um erro. Tente novamente.'] };
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

        <!-- Recover Username Card -->
        <div class="relative z-10 w-full max-w-md">
            <div v-if="success" class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(0,0,0,0.37)] rounded-3xl overflow-hidden p-8 sm:p-12">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center p-4 mb-6 rounded-full bg-blue-500/20 border border-blue-500/30">
                        <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-white mb-4">Usuário Encontrado!</h1>
                    
                    <div v-if="foundUser" class="bg-white/5 rounded-xl p-6 mb-6">
                        <p class="text-amber-200/70 text-sm mb-2">O usuário associado a esses dados é:</p>
                        <p class="text-white text-xl font-bold mb-2">{{ foundUser.email }}</p>
                        <p class="text-white/50 text-xs">Cadastrado em: {{ new Date(foundUser.created_at).toLocaleDateString('pt-BR') }}</p>
                    </div>
                    
                    <p class="text-amber-200/70 mb-6">Um lembrete foi enviado para o e-mail informado.</p>
                    
                    <div class="flex flex-col gap-3">
                        <a href="/login" class="inline-block bg-amber-600 hover:bg-amber-500 text-white font-bold py-3 px-6 rounded-xl transition-all">
                            Ir para Login
                        </a>
                        <button @click="success = false; name = ''; email = ''" class="text-amber-500 hover:text-amber-400 text-sm transition-colors">
                            Tentar novamente
                        </button>
                    </div>
                </div>
            </div>

            <div v-else class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(0,0,0,0.37)] rounded-3xl overflow-hidden p-8 sm:p-12 transition-all duration-500">
                
                <!-- Logo & Header -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center p-3 mb-4 rounded-2xl bg-gradient-to-br from-blue-500/30 to-indigo-500/30 border border-blue-500/30">
                        <i class="fas fa-user-secret text-blue-400 text-2xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-white tracking-tight mb-2 font-serif" 
                        style="background: linear-gradient(135deg, #60a5fa 0%, #818cf8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                        {{ systemName }}
                    </h1>
                    <p class="text-amber-200/70 text-sm font-medium tracking-wide uppercase">Recuperar Usuário</p>
                    <p v-if="churchName" class="text-white/50 text-xs mt-1">{{ churchName }}</p>
                </div>

                <div v-if="errors.general" class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-500/30 text-red-300 text-sm">
                    {{ errors.general[0] }}
                </div>

                <div class="mb-6 p-4 rounded-xl bg-blue-500/20 border border-blue-500/30 text-blue-300 text-sm text-center">
                    <p>Informe seu nome e e-mail para recuperar seu usuário.</p>
                </div>

                <form @submit.prevent="submit" class="space-y-5">
                    <!-- Name -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-medium text-amber-100/80">Nome Completo</label>
                        <div class="relative">
                            <input 
                                id="name" 
                                v-model="name"
                                type="text" 
                                required 
                                autofocus
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500/50 transition-all"
                                placeholder="Seu nome completo"
                            >
                        </div>
                        <p v-if="errors.name" class="text-red-400 text-xs mt-1">{{ errors.name[0] }}</p>
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-amber-100/80">E-mail Cadastrado</label>
                        <div class="relative">
                            <input 
                                id="email" 
                                v-model="email"
                                type="email" 
                                required 
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
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 disabled:from-blue-800 disabled:to-indigo-800 disabled:opacity-50 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-900/20 transform transition-all active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-blue-500/50"
                    >
                        <span v-if="processing" class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Buscando...
                        </span>
                        <span v-else>Recuperar Usuário</span>
                    </button>
                </form>

                <!-- Footer -->
                <div class="mt-8 text-center">
                    <div class="flex justify-center gap-4 flex-wrap">
                        <a href="/login" class="text-amber-500 hover:text-amber-400 text-sm transition-colors">Voltar ao Login</a>
                        <span class="text-white/20">|</span>
                        <a href="/password/reset" class="text-amber-500 hover:text-amber-400 text-sm transition-colors">Esqueci minha senha</a>
                        <span class="text-white/20">|</span>
                        <a href="/register" class="text-amber-500 hover:text-amber-400 text-sm transition-colors">Cadastrar-se</a>
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
