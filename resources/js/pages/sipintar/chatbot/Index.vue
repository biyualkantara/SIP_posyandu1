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

    menus.value = res.data.menu || [];

    setTimeout(() => {
        chat.value.push({
            from: "bot",
            text: res.data.messages.join("\n"),
            animate: true
        });

        typing.value = false;
    }, 450);
}

onMounted(() => {
    loadNode("root");

    setTimeout(() => {
        showGuide.value = true;
    }, 300);
});

function closeGuide() {
    showGuide.value = false;
}
</script>

<template>
    <div class="chat-root">

        <!-- HEADER -->
        <div class="chat-header">
            <div class="chat-title">
                <span class="bot-avatar">🤖</span>
                <div>
                    <h1>SiPintar Chatbot</h1>
                    <p>Asisten Digital Posyandu</p>
                </div>
            </div>
        </div>

        <!-- CHAT AREA -->
        <div class="chat-container">

            <!-- CHAT LOOP -->
            <div
                v-for="(msg, i) in chat"
                :key="i"
                class="chat-row"
                :class="msg.from === 'bot' ? 'bot' : 'user'"
            >
                <!-- BOT -->
                <div v-if="msg.from === 'bot'" class="bubble bot-bubble animate-zoom">
                    {{ msg.text }}
                </div>

                <!-- USER -->
                <div v-if="msg.from === 'user'" class="bubble user-bubble animate-zoom">
                    {{ msg.text }}
                </div>
            </div>

            <!-- TYPING -->
            <div v-if="typing" class="chat-row bot">
                <div class="bubble bot-bubble typing">
                    <span></span><span></span><span></span>
                </div>
            </div>

            <!-- MENU -->
            <div v-if="menus.length" class="menu-area">
                <button
                    v-for="item in menus"
                    :key="item.id"
                    @click="loadNode(item.id, item.label)"
                    class="menu-btn"
                >
                    <span>{{ item.label }}</span>
                    <span class="arrow">›</span>
                </button>
            </div>
        </div>

        <!-- GUIDE POPUP -->
        <div v-if="showGuide" class="guide-backdrop">
            <div class="guide-card animate-zoom">
                <h2>💡 Panduan Singkat</h2>
                <ul>
                    <li>Klik menu untuk bertanya</li>
                    <li>Jawaban muncul otomatis</li>
                    <li>Gunakan menu utama untuk reset</li>
                </ul>
                <button @click="closeGuide">Mengerti</button>
            </div>
        </div>

    </div>
</template>

<style scoped>
.chat-root {
    height: 100vh;
    background: #eef3fb;
    display: flex;
    flex-direction: column;
    font-family: Inter, system-ui, sans-serif;
}

.chat-header {
    background: linear-gradient(135deg, #2563eb, #1e40af);
    color: white;
    padding: 16px 24px;
    box-shadow: 0 4px 14px rgba(0,0,0,.15);
}

.chat-title {
    display: flex;
    align-items: center;
    gap: 12px;
}

.chat-title h1 {
    font-size: 20px;
    font-weight: 700;
    margin: 0;
}

.chat-title p {
    font-size: 13px;
    opacity: .9;
}

.bot-avatar {
    font-size: 32px;
}

.chat-container {
    flex: 1;
    overflow-y: auto;
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.chat-row {
    display: flex;
}

.chat-row.bot {
    justify-content: flex-start;
}

.chat-row.user {
    justify-content: flex-end;
}
.bubble {
    max-width: 70%;
    padding: 14px 18px;
    border-radius: 18px;
    font-size: 15px;
    line-height: 1.6;
    box-shadow: 0 4px 12px rgba(0,0,0,.08);
    white-space: pre-line;
}

.bot-bubble {
    background: white;
    color: #0f172a;
    border-top-left-radius: 6px;
}

.user-bubble {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border-top-right-radius: 6px;
}

.typing {
    display: flex;
    gap: 6px;
}

.typing span {
    width: 8px;
    height: 8px;
    background: #94a3b8;
    border-radius: 50%;
    animation: blink 1.4s infinite both;
}

.typing span:nth-child(2) { animation-delay: .2s; }
.typing span:nth-child(3) { animation-delay: .4s; }

@keyframes blink {
    0% { opacity: .2; }
    20% { opacity: 1; }
    100% { opacity: .2; }
}

.menu-area {
    margin-top: 12px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.menu-btn {
    background: white;
    border-radius: 14px;
    padding: 14px 18px;
    font-size: 15px;
    font-weight: 600;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 3px 10px rgba(0,0,0,.08);
    cursor: pointer;
    transition: .2s;
}

.menu-btn:hover {
    background: #f1f5f9;
    transform: translateY(-1px);
}

.arrow {
    font-size: 18px;
    color: #64748b;
}

.guide-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.45);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 50;
}

.guide-card {
    background: white;
    padding: 28px;
    border-radius: 24px;
    width: 360px;
    box-shadow: 0 20px 40px rgba(0,0,0,.3);
}

.guide-card h2 {
    font-size: 20px;
    margin-bottom: 12px;
}

.guide-card ul {
    font-size: 14px;
    color: #334155;
    padding-left: 18px;
}

.guide-card button {
    margin-top: 18px;
    width: 100%;
    background: #2563eb;
    color: white;
    padding: 12px;
    border-radius: 14px;
    font-weight: 600;
}

@keyframes zoomIn {
    0% { transform: scale(.85); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}

.animate-zoom {
    animation: zoomIn .25s ease-out;
}
</style>