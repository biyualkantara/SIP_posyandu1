<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const chat = ref([]);
const menus = ref([]);
const typing = ref(false);
const showGuide = ref(false);

const props = defineProps({
    auth: Object
});

const username = props.auth?.user?.nama_pengguna ?? "Pengguna";

async function loadNode(node = "root", userSelectedText = null) {
    if (userSelectedText) {
        chat.value.push({
            from: "user",
            text: userSelectedText,
            animate: true
        });
    }

    typing.value = true;

    const res = await axios.post("/sipintar/chatbot/api", {
        node,
        name: username
    });

    menus.value = res.data.menu;

    setTimeout(() => {
        chat.value.push({
            from: "bot",
            text: res.data.messages.join("\n"),
            animate: true
        });

        typing.value = false;
    }, 400);
}

onMounted(() => {
    loadNode("root");

    // popup panduan muncul sekali
    setTimeout(() => {
        showGuide.value = true;
    }, 300);
});

function closeGuide() {
    showGuide.value = false;
}
</script>

<template>
    <div class="w-full bg-white pb-24">
        <!-- TITLE -->
        <div class="mt-3 p-4 bg-white">

            <h1 class="text-[30px] font-semibold text-gray-800 tracking-wide">
                Chat Bot SiPintar
            </h1>

            <div class="mt-2 w-full h-[1.3px] bg-gray-300"></div>
        </div>
        <!--  CONTAINER CHAT -->
        <div class="pl-[90px] pr-[180px] max-w-[1200px]">

            <!-- LOOP PESAN -->
            <div
                v-for="(msg, i) in chat"
                :key="i"
                class="mb-6 flex"
                :class="msg.from === 'bot' ? 'justify-start' : 'justify-end'"
            >
                <!-- BOT -->
                <div
                    v-if="msg.from === 'bot'"
                    class="flex gap-4 items-start max-w-[420px]"
                    :class="msg.animate ? 'animate-zoom' : ''"
                >
                    <div class="w-12 h-12 rounded-full bg-[#DCE8FF] flex items-center justify-center shadow">
                        <span class="text-[12px]">🤖</span>
                    </div>

                    <div class="bg-[#F7F9FD] rounded-2xl shadow px-6 py-4 leading-relaxed text-gray-700 whitespace-pre-line">
                        {{ msg.text }}
                    </div>
                </div>

                <!-- USER -->
                <div
                    v-if="msg.from === 'user'"
                    class="flex gap-4 items-start max-w-[400px]"
                    :class="msg.animate ? 'animate-zoom' : ''"
                >
                    <div class="bg-[#D6EBFF] rounded-2xl shadow px-6 py-4 text-gray-800 font-medium">
                        {{ msg.text }}
                    </div>

                    <div class="w-10 h-10 rounded-full bg-[#C3DFFF] flex items-center justify-center shadow">
                        <span class="text-[12px]">🙂</span>
                    </div>
                </div>
            </div>

            <!-- TYPING -->
            <div v-if="typing" class="flex gap-4 items-start mt-4">
                <div class="w-12 h-12 rounded-full bg-[#DCE8FF] flex items-center justify-center shadow">
                    <span class="text-[12px]">🤖</span>
                </div>

                <div class="bg-[#F7F9FD] rounded-2xl shadow px-6 py-3 w-[80px] animate-pulse">
                    ...
                </div>
            </div>

            <!-- MENU BUTTONS -->
            <div v-if="menus.length > 0" class="flex flex-col gap-3 mt-6 w-[380px]">
                <button
                    v-for="item in menus"
                    :key="item.id"
                    @click="loadNode(item.id, item.label)"
                    class="w-full bg-white border shadow-sm rounded-xl px-5 py-3 
                           flex justify-between hover:bg-gray-50 transition text-left font-medium text-gray-700 animate-zoom"
                >
                    <span>{{ item.label }}</span>

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- POP UP PANDUAN -->
        <div
            v-if="showGuide"
            class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50"
        >
            <div class="bg-white rounded-3xl shadow-2xl p-8 w-[400px] animate-zoom border border-gray-200">

                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <span class="text-blue-600 text-2xl">💡</span>
                    </div>
                    <h2 class="text-xl font-semibold">Panduan Singkat</h2>
                </div>

                <p class="text-gray-700 leading-relaxed">
                    • Klik menu yang tersedia untuk melihat langkah-langkah.<br>
                    • Pesan akan muncul otomatis seperti bot asli.<br>
                    • Klik “Kembali ke menu utama” untuk mengulang dari awal.
                </p>

                <button
                    @click="closeGuide"
                    class="mt-6 w-full bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-xl py-2.5 font-medium hover:opacity-90 transition"
                >
                    Mengerti
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes zoomIn {
    0% { transform: scale(0.7); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}

.animate-zoom {
    animation: zoomIn 0.23s ease-out;
}
</style>