<template>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center p-6">
        <div class="w-full max-w-4xl grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Calculator -->
            <div class="md:col-span-2 bg-white p-6 rounded-2xl shadow-xl">
                <h2 class="text-xl font-bold text-gray-700 mb-4">Enter your formula</h2>

                <div class="mb-2">
                    <input
                        v-model="expression"
                        @keyup.enter="calculate"
                        @input="clearError"
                        class="w-full p-6 text-right text-3xl font-mono bg-gray-50 border-2 rounded-xl focus:outline-none focus:border-blue-500 transition-colors"
                        :class="errorMessage ? 'border-red-500 bg-red-50' : 'border-gray-200'"
                    />
                    <div v-if="result !== null && !errorMessage" class="text-right text-gray-500 mt-2 text-lg font-mono">
                        = {{ result }}
                    </div>
                </div>

                <div class="h-8 mb-4 text-right">
                    <p v-if="errorMessage" class="text-red-500 font-bold text-sm animate-pulse">
                        ⚠️ {{ errorMessage }}
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <button
                        @click="clearInput"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-4 rounded-xl text-lg transition-all"
                    >
                        Clear
                    </button>
                    <button
                        @click="calculate"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl text-lg transition-all shadow-md active:scale-95"
                    >
                        Calculate
                    </button>
                </div>

                <p class="text-xs text-gray-400 mt-6 text-center">
                    Supports: + - * / ( ) sqrt() and ^
                </p>
            </div>

            <!-- Ticker Tape History -->
            <div class="bg-slate-800 text-white p-6 rounded-2xl shadow-xl flex flex-col h-[500px]">
                <div class="flex justify-between items-center mb-4 border-b border-slate-600 pb-2">
                    <h3 class="font-mono text-lg text-slate-300">TAPE HISTORY</h3>
                    <button
                        @click="clearAll"
                        class="text-xs bg-red-500/20 text-red-400 px-2 py-1 rounded hover:bg-red-500 hover:text-white transition-colors"
                    >
                        CLEAR
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto space-y-3 font-mono text-sm custom-scrollbar pr-2">
                    <div
                        v-for="calc in history"
                        :key="calc.id"
                        class="group flex justify-between items-center p-3 bg-slate-700/50 rounded hover:bg-slate-700 transition-colors border-l-4 border-blue-500 gap-2"
                    >
                        <div class="truncate">
                            <div class="text-slate-400 text-xs">{{ calc.expression }}</div>
                            <div class="text-white text-lg font-bold">{{ calc.result }}</div>
                        </div>
                        <button
                            @click="deleteCalc(calc.id)"
                            class="opacity-50 group-hover:opacity-100 text-slate-400 hover:text-red-400 transition-opacity"
                        >
                            x
                        </button>
                    </div>

                    <div v-if="history.length === 0" class="text-center text-slate-500 mt-10 italic">
                        Tape is empty...
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

axios.defaults.baseURL = 'http://127.0.0.1:8000';

const expression = ref('');
const result = ref(null);
const history = ref([]);
const errorMessage = ref('');

const fetchHistory = async () => {
    try {
        const { data } = await axios.get('/api/calculations');
        history.value = data;
    } catch (e) {
        console.error("API Error", e);
    }
};

const calculate = async () => {
    errorMessage.value = '';

    if (!expression.value) {
        errorMessage.value = "Please enter an expression";
        return;
    }

    try {
        const { data } = await axios.post('/api/calculations', { expression: expression.value });
        result.value = data.result;
        history.value.unshift(data);
    } catch (error) {
        errorMessage.value = error.response?.data?.errors?.expression?.[0]
            || error.response?.data?.message
            || "Invalid Calculation";
        result.value = null;
    }
};

const clearError = () => {
    errorMessage.value = '';
};

const clearInput = () => {
    expression.value = '';
    result.value = null;
    errorMessage.value = '';
};

const deleteCalc = async (id) => {
    await axios.delete(`/api/calculations/${id}`);
    history.value = history.value.filter(c => c.id !== id);
};

const clearAll = async () => {
    if(!confirm('Clear entire tape?')) return;
    await axios.delete('/api/calculations');
    history.value = [];
};

onMounted(fetchHistory);
</script>
