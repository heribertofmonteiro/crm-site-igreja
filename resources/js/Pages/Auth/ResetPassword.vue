<script setup lang="ts">
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { route } from 'ziggy-js';

const token = ref('');
const email = ref('');
const password = ref('');
const password_confirmation = ref('');
const errors = ref<Record<string, string[]>>({});
const processing = ref(false);
const success = ref(false);
const systemName = ref('Igreja On Line');
const churchName = ref('');

// Get props from the page
const props = defineProps<{
    token: string;
    email: string;
}>();

onMounted(() => {
    token.value = props.token;
    email.value = props.email;
    
    const appElement = document.getElementById('reset-password-app');
    if (appElement) {
        systemName.value = appElement.dataset.systemName || 'Igreja On Line';
        churchName.value = appElement.dataset.churchName || '';
    }
});

const submit = async () => {
    processing.value = true;
    errors.value = {};
    
    try {
        await axios.post(route('password.update'), {
            token: token.value,
            email: email.value,
            password: password.value,
            password_confirmation: password_confirmation.value,
            _token: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
        });
        
        success.value = true;
    } catch (error: any) {
        if (error.response?.data?.errors) {
            errors.value = error.response.data.errors;
        } else {
            console.error('Password reset failed', error);
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

        <!-- Reset Password Card -->
        <div class="relative z-10 w-full max-w-md">
            <div v-if="success" class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(0,0,0,0.37)] rounded-3xl overflow-hidden p-8 sm:p-12">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center p-4 mb-6 rounded-full bg-green-500/20 border border-green-500/30">
                        <svg class="w-12 h-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-white mb-4">Senha Redefinida!</h1>
                    <p class="text-amber-200/70 mb-6">Sua senha foi alterada com sucesso. Você já pode fazer login.</p>
                    <a href="/login" class="inline-block bg-amber-600 hover:bg-amber-500 text-white font-bold py-3 px-6 rounded-xl transition-all">
                        Ir para Login
                    </a>
                </div>
            </div>

            <div v-else class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(0,0,0,0.37)] rounded-3xl overflow-hidden p-8 sm:p-12 transition-all duration-500">
                
                <!-- Logo & Header -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center p-3 mb-4 rounded-2xl bg-gradient-to-br from-green-500/30 to-teal-500/30 border border-green-500/30">
                        <i class="fas fa-lock text-green-400 text-2xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-white tracking-tight mb-2 font-serif" 
                        style="background: linear-gradient(135deg, #4ade80 0%, #2dd4bf 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                        {{ systemName }}
                    </h1>
                    <p class="text-amber-200/70 text-sm font-medium tracking-wide uppercase">Nova Senha</p>
                    <p v-if="churchName" class="text-white/50 text-xs mt-1">{{ churchName }}</p>
                </div>

                <form @submit.prevent="submit" class="space-y-5">
                    <!-- Email (read-only) -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-amber-100/80">E-mail</label>
                        <div class="relative">
                            <input 
                                id="email" 
                                v-model="email"
                                type="email" 
                                required 
                                readonly
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white/50 cursor-not-allowed"
                            >
                        </div>
                        <p v-if="errors.email" class="text-red-400 text-xs mt-1">{{ errors.email[0] }}</p>
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-amber-100/80">Nova Senha</label>
                        <div class="relative">
                            <input 
                                id="password" 
                                v-model="password"
                                type="password" 
                                required 
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500/50 transition-all"
                                placeholder="••••••••"
                            >
                        </div>
                        <p v-if="errors.password" class="text-red-400 text-xs mt-1">{{ errors.password[0] }}</p>
                    </div>

                    <!-- Password Confirmation -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-sm font-medium text-amber-100/80">Confirmar Nova Senha</label>
                        <div class="relative">
                            <input 
                                id="password_confirmation" 
                                v-model="password_confirmation"
                                type="password" 
                                required 
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500/50 transition-all"
                                placeholder="••••••••"
                            >
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        :disabled="processing"
                        class="w-full bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-500 hover:to-teal-500 disabled:from-green-800 disabled:to-teal-800 disabled:opacity-50 text-white font-bold py-4 rounded-xl shadow-lg shadow-green-900/20 transform transition-all active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-green-500/50"
                    >
                        <span v-if="processing" class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Salvando...
                        </span>
                        <span v-else>Redefinir Senha</span>
                    </button>
                </form>

                <!-- Footer -->
                <div class="mt-8 text-center">
                    <a href="/login" class="text-amber-500 hover:text-amber-400 text-sm transition-colors">Voltar ao Login</a>
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
