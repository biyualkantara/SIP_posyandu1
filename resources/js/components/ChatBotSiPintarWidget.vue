<template>
  <div class="fixed bottom-4 right-4 z-40">
    <!-- Panel Chat -->
    <transition name="widget-fade">
      <div
        v-if="isOpen"
        :class="[
          'mb-3 w-[340px] sm:w-[380px] rounded-3xl shadow-xl border transition-colors',
          isDark ? 'bg-slate-900 border-slate-700' : 'bg-white border-slate-200'
        ]"
      >
        <!-- Header -->
        <div
          :class="[
            'flex items-center justify-between px-4 py-3 rounded-t-3xl',
            isDark ? 'bg-slate-800 border-b border-slate-700' : 'bg-sky-50 border-b border-sky-100'
          ]"
        >
          <div class="flex items-center gap-2">
            <img
              src="/assets/bot.png"
              alt="bot"
              class="h-8 w-8 rounded-full bg-yellow-100 p-1.5"
            />
            <div class="leading-tight">
              <p
                :class="[
                  'text-sm font-semibold',
                  isDark ? 'text-slate-50' : 'text-slate-800'
                ]"
              >
                Chat Bot SiPintar
              </p>
              <p class="text-[11px]" :class="isDark ? 'text-emerald-300' : 'text-emerald-600'">
                Online • Bantuan fitur eSIP Kota Cimahi
              </p>
            </div>
          </div>

          <div class="flex items-center gap-2">
            <!-- Dark mode toggle -->
            <button
              class="h-7 w-7 rounded-full flex items-center justify-center text-xs"
              :class="isDark ? 'bg-slate-700 text-amber-300' : 'bg-white text-slate-600 border border-slate-200'"
              @click.stop="toggleDark"
            >
              <span v-if="isDark">☾</span>
              <span v-else>☀︎</span>
            </button>

            <!-- Close -->
            <button
              class="h-7 w-7 rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-100"
              :class="isDark && 'hover:bg-slate-700 text-slate-300'"
              @click.stop="isOpen = false"
            >
              ✕
            </button>
          </div>
        </div>

        <!-- Body Chat -->
        <div class="px-4 pt-4 pb-3 max-h-[420px] overflow-y-auto">
          <!-- History chat dengan animasi -->
          <transition-group name="chat-bubble" tag="div" class="space-y-3">
            <div
              v-for="msg in messages"
              :key="msg.id"
              class="flex gap-2"
              :class="msg.from === 'bot' ? 'justify-start' : 'justify-end'"
            >
              <!-- avatar bot -->
              <template v-if="msg.from === 'bot'">
                <img
                  src="/assets/bot.png"
                  alt="bot"
                  class="h-8 w-8 rounded-full bg-yellow-100 p-1"
                />
                <div
                  class="max-w-[220px] px-3 py-2 rounded-2xl text-sm whitespace-pre-line shadow-sm"
                  :class="isDark ? 'bg-slate-800 text-slate-50' : 'bg-slate-50 text-slate-800'"
                >
                  {{ msg.text }}
                </div>
              </template>

              <!-- bubble user -->
              <template v-else>
                <div
                  class="ml-auto max-w-[220px] px-3 py-2 rounded-2xl text-sm whitespace-pre-line shadow-sm"
                  :class="isDark ? 'bg-sky-600 text-slate-50' : 'bg-sky-500 text-white'"
                >
                  {{ msg.text }}
                </div>
              </template>
            </div>
          </transition-group>

          <!-- Typing indicator -->
          <div v-if="isTyping" class="mt-3 flex gap-2">
            <img
              src="/assets/bot.png"
              alt="bot"
              class="h-8 w-8 rounded-full bg-yellow-100 p-1"
            />
            <div
              class="px-3 py-2 rounded-2xl shadow-sm flex items-center gap-1"
              :class="isDark ? 'bg-slate-800' : 'bg-slate-50'"
            >
              <span class="typing-dot"></span>
              <span class="typing-dot"></span>
              <span class="typing-dot"></span>
            </div>
          </div>

          <!-- Menu tombol -->
          <div v-if="menuOptions.length && !isTyping" class="mt-4 space-y-2">
            <button
              v-for="opt in menuOptions"
              :key="opt.id"
              @click="handleOptionClick(opt)"
              class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm shadow-sm border"
              :class="isDark
                ? 'bg-slate-900 border-slate-700 text-slate-100 hover:bg-slate-800'
                : 'bg-white border-slate-200 text-slate-800 hover:bg-slate-50'"
            >
              <span>{{ opt.label }}</span>
              <span class="text-sky-500 text-lg">›</span>
            </button>
          </div>
        </div>

        <!-- Footer kecil -->
        <div
          class="px-4 py-2 text-[10px] text-center rounded-b-3xl"
          :class="isDark ? 'bg-slate-900 text-slate-400' : 'bg-slate-50 text-slate-500'"
        >
          eSIP Kota Cimahi • Bantuan penggunaan website, bukan konsultasi medis.
        </div>
      </div>
    </transition>

    <!-- Tombol bulat untuk membuka widget -->
    <button
      @click="toggleOpen"
      class="h-14 w-14 rounded-full shadow-xl flex items-center justify-center border text-white text-2xl"
      :class="isDark ? 'bg-sky-700 border-slate-600' : 'bg-sky-500 border-sky-400'"
    >
      💬
    </button>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

// kalau mau, terima nama dari props / Inertia
const props = defineProps({
  username: {
    type: String,
    default: "Username",
  },
});

const isOpen = ref(false);
const isDark = ref(false);
const isTyping = ref(false);
const messages = ref([]);        // history chat
const menuOptions = ref([]);     // menu aktif
const currentNode = ref("root");
let msgId = 0;

function pushBotMessages(texts) {
  texts.forEach((text) => {
    messages.value.push({
      id: ++msgId,
      from: "bot",
      text,
    });
  });
}

function pushUserMessage(text) {
  messages.value.push({
    id: ++msgId,
    from: "user",
    text,
  });
}

async function loadNode(nodeId = "root") {
  currentNode.value = nodeId;
  isTyping.value = true;
  menuOptions.value = [];

  try {
    const res = await axios.post("/api/chatbot", {
      node: nodeId,
      name: props.username,
    });

    // sedikit delay biar animasi typing terasa
    setTimeout(() => {
      isTyping.value = false;
      pushBotMessages(res.data.messages || []);
      menuOptions.value = res.data.menu || [];
    }, 500);
  } catch (e) {
    isTyping.value = false;
    pushBotMessages(["Maaf, terjadi gangguan koneksi ke server."]);
  }
}

function handleOptionClick(opt) {
  // bubble user
  pushUserMessage(opt.label);
  // muat node berikutnya
  loadNode(opt.id);
}

function toggleOpen() {
  isOpen.value = !isOpen.value;
  if (isOpen.value && messages.value.length === 0) {
    // pertama kali dibuka, load root
    loadNode("root");
  }
}

function toggleDark() {
  isDark.value = !isDark.value;
}

onMounted(() => {
  // kalau mau auto-open di halaman tertentu, bisa panggil loadNode('root') di sini
});
</script>

<style scoped>
/* Animasi panel widget */
.widget-fade-enter-active,
.widget-fade-leave-active {
  transition: all 0.18s ease-out;
}
.widget-fade-enter-from,
.widget-fade-leave-to {
  opacity: 0;
  transform: translateY(10px) scale(0.98);
}

/* Animasi bubble chat */
.chat-bubble-enter-active,
.chat-bubble-leave-active {
  transition: all 0.15s ease-out;
}
.chat-bubble-enter-from,
.chat-bubble-leave-to {
  opacity: 0;
  transform: translateY(6px);
}

/* Typing dots */
.typing-dot {
  width: 6px;
  height: 6px;
  border-radius: 9999px;
  background-color: #9ca3af; /* slate-400 */
  animation: typing 1s infinite ease-in-out;
}
.typing-dot:nth-child(2) {
  animation-delay: 0.15s;
}
.typing-dot:nth-child(3) {
  animation-delay: 0.3s;
}
@keyframes typing {
  0%,
  80%,
  100% {
    transform: translateY(0);
    opacity: 0.4;
  }
  40% {
    transform: translateY(-3px);
    opacity: 1;
  }
}
</style>
