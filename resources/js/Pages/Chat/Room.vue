<!-- ChatView.vue -->
<template>
    <div class="flex h-[calc(100vh-6rem)] bg-gradient-to-br from-slate-50 via-blue-50/30 to-purple-50/30">
        <!-- Fallback if props not ready -->
        <div v-if="!ready" class="m-auto text-gray-600">
            Loading…
        </div>

        <template v-else>
            <!-- Mobile slide-over sidebar -->
            <div v-if="sidebarOpen" class="fixed inset-0 z-40 md:hidden">
                <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="sidebarOpen = false"></div>
                <aside
                    class="absolute inset-y-0 left-0 w-80 max-w-[85%] bg-white/95 backdrop-blur-xl border-r border-gray-200/50 p-5 overflow-y-auto shadow-2xl">
                    <div class="mb-6 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse shadow-sm"></div>
                            Chats
                        </h2>
                        <button type="button" @click="sidebarOpen = false"
                            class="p-2.5 rounded-xl hover:bg-gray-100/80 transition-all duration-300 group"
                            aria-label="Close chats">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5"
                                class="h-5 w-5 group-hover:rotate-90 transition-transform duration-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <ul class="space-y-2">
                        <li v-for="r in (rooms || [])" :key="r?.id">
                            <Link :href="`/chat/${r.uuid}`" @click="sidebarOpen = false"
                                class="flex items-center gap-3 rounded-2xl px-4 py-3.5 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-300 group border border-transparent hover:border-blue-100/50 hover:shadow-lg hover:scale-[1.02]"
                                :class="{
                                    'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-xl border-blue-200/50': r?.id === room?.id
                                }">
                            <div class="relative">
                                <div class="flex h-11 w-11 items-center justify-center rounded-2xl text-sm font-bold transition-all duration-300 shadow-md"
                                    :class="r?.id === room?.id
                                        ? 'bg-white/20 text-white'
                                        : 'bg-gradient-to-br from-blue-100 to-purple-100 text-blue-700 group-hover:scale-110 group-hover:shadow-lg'">
                                    {{ initials(otherUserName(r)) }}
                                </div>
                                <div
                                    class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-emerald-400 border-2 border-white rounded-full shadow-sm">
                                </div>
                                <!-- Unread indicator -->
                                <div v-if="r?.unread_count > 0"
                                    class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full shadow-sm animate-pulse">
                                </div>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="truncate font-semibold text-base flex items-center justify-between"
                                    :class="r?.id === room?.id ? 'text-white' : 'text-gray-900 group-hover:text-blue-700'">
                                    <span :class="{ 'font-bold': r?.unread_count > 0 }">{{ otherUserName(r) || 'User' }}</span>
                                    <span v-if="r?.unread_count > 0"
                                        class="inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none rounded-full"
                                        :class="r?.id === room?.id ? 'bg-white/20 text-white' : 'bg-red-500 text-white'">
                                        {{ r.unread_count > 99 ? '99+' : r.unread_count }}
                                    </span>
                                </div>
                                <div class="text-xs opacity-75 mt-1 truncate">
                                    {{ getLastMessagePreview(r) }}
                                </div>
                            </div>
                            </Link>
                        </li>
                    </ul>
                </aside>
            </div>

            <!-- Desktop sidebar -->
            <aside
                class="hidden md:block w-1/4 bg-gradient-to-b from-white via-blue-50/20 to-purple-50/20 border-r border-gray-200/50 p-6 overflow-y-auto backdrop-blur-sm">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-3">
                        <div class="p-2 bg-gradient-to-br from-blue-100 to-purple-100 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        Messages
                    </h2>
                    <div class="flex items-center gap-2 mt-2">
                        <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                        <span class="text-sm text-gray-600">
                            {{ roomsCount }} active conversation{{ roomsCount !== 1 ? 's' : '' }}
                            <span v-if="totalUnread > 0" class="ml-2 text-red-600 font-medium">
                                • {{ totalUnread }} unread
                            </span>
                        </span>
                    </div>
                </div>

                <ul class="space-y-3">
                    <li v-for="r in (rooms || [])" :key="r?.id">
                        <Link :href="`/chat/${r.uuid}`"
                            class="flex items-center gap-4 rounded-2xl px-4 py-4 transition-all duration-300 group border border-transparent hover:border-blue-100/50 hover:shadow-lg hover:scale-[1.02]"
                            :class="{
                                'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-xl border-blue-200/50': r?.id === room?.id
                            }">
                        <div class="relative">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl text-sm font-bold transition-all duration-300 shadow-md"
                                :class="r?.id === room?.id
                                    ? 'bg-white/20 text-white'
                                    : 'bg-gradient-to-br from-blue-100 to-purple-100 text-blue-700 group-hover:scale-110 group-hover:shadow-lg'">
                                {{ initials(otherUserName(r)) }}
                            </div>
                            <!-- Unread indicator -->
                            <div v-if="r?.unread_count > 0"
                                class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full shadow-sm animate-pulse">
                            </div>
                        </div>

                        <div class="min-w-0 flex-1">
                            <div class="truncate font-semibold text-base capitalize flex items-center justify-between"
                                :class="r?.id === room?.id ? 'text-white' : 'text-gray-900 group-hover:text-blue-700'">
                                <span :class="{ 'font-bold': r?.unread_count > 0 }">{{ otherUserName(r) || 'User' }}</span>
                                <span v-if="r?.unread_count > 0"
                                    class="inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none rounded-full"
                                    :class="r?.id === room?.id ? 'bg-white/20 text-white' : 'bg-red-500 text-white'">
                                    {{ r.unread_count > 99 ? '99+' : r.unread_count }}
                                </span>
                            </div>
                            <div class="text-xs opacity-75 mt-1 truncate">
                                {{ getLastMessagePreview(r) }}
                            </div>
                        </div>
                        </Link>
                    </li>
                </ul>
            </aside>

            <!-- Main chat area -->
            <div class="flex-1 flex flex-col">
                <!-- Header -->
                <header
                    class="flex items-center gap-4 border-b border-gray-200/50 px-6 py-5 bg-white/90 backdrop-blur-xl shadow-sm">
                    <!-- Back button -->
                    <Link :href="route('chat.index')"
                        class="p-2.5 rounded-xl hover:bg-gray-100/80 transition-all duration-300 group"
                        aria-label="Back to chats">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" class="h-5 w-5 group-hover:scale-110 transition-transform duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </Link>

                    <button type="button"
                        class="md:hidden p-2.5 rounded-xl hover:bg-gray-100/80 transition-all duration-300 group"
                        @click="sidebarOpen = true" aria-label="Open chats">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" class="h-5 w-5 group-hover:scale-110 transition-transform duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="relative">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-100 to-purple-100 text-blue-700 font-bold shadow-md">
                            {{ initials(activeOtherUserName || 'U') }}
                        </div>
                        <div
                            class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-400 border-2 border-white rounded-full shadow-sm">
                        </div>
                    </div>

                    <div class="flex-1">
                        <div class="font-bold text-gray-900 capitalize text-lg">{{ activeOtherUserName || 'User' }}</div>
                        <!-- <div class="text-sm text-emerald-600 flex items-center gap-2 mt-0.5">
                            <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                            Online • Active now
                        </div> -->
                    </div>

                    <div class="flex items-center gap-2">
                        <button class="p-2.5 rounded-xl hover:bg-gray-100/80 transition-all duration-300 group">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-gray-500 group-hover:text-blue-600 group-hover:scale-110 transition-all"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="1" />
                                <circle cx="19" cy="12" r="1" />
                                <circle cx="5" cy="12" r="1" />
                            </svg>
                        </button>
                    </div>
                </header>

                <!-- Messages -->
                <div ref="scrollContainer" class="flex-1 overflow-y-auto px-6 py-6 space-y-6">
                    <template v-for="m in (localMessages || [])" :key="m?.id || Math.random()">
                        <div class="flex items-end gap-3 group" :class="isOwn(m) ? 'justify-end' : 'justify-start'">
                            <div v-if="!isOwn(m)" class="relative">
                                <div
                                    class="h-9 w-9 flex items-center justify-center rounded-full bg-gradient-to-br from-gray-100 to-gray-200 text-gray-600 text-sm font-semibold shadow-md group-hover:shadow-lg transition-all duration-300">
                                    {{ initials(m?.user?.name || 'U') }}
                                </div>
                            </div>

                            <div :class="bubbleClass(m)" class="group-hover:scale-[1.02] transition-all duration-300">
                                <div class="whitespace-pre-wrap break-words leading-relaxed">{{ m?.message || '' }}
                                </div>
                                <div class="mt-2 text-[11px] opacity-70 font-medium">{{ formatTime(m?.created_at) }}
                                </div>
                            </div>

                            <div v-if="isOwn(m)" class="relative">
                                <div
                                    class="h-9 w-9 flex items-center justify-center rounded-full bg-gradient-to-br from-blue-100 to-purple-100 text-blue-700 text-sm font-semibold shadow-md group-hover:shadow-lg transition-all duration-300">
                                    {{ initials(currentUserName) }}
                                </div>
                            </div>
                        </div>
                    </template>

                    <div v-if="sending" class="flex justify-end pr-12">
                        <div
                            class="flex items-center gap-3 px-4 py-2 bg-white/80 backdrop-blur-sm rounded-full shadow-lg border border-gray-200/50">
                            <div class="flex gap-1">
                                <div class="w-2 h-2 rounded-full animate-bounce bg-blue-500"></div>
                                <div class="w-2 h-2 rounded-full animate-bounce bg-blue-500"
                                    style="animation-delay:.15s"></div>
                                <div class="w-2 h-2 rounded-full animate-bounce bg-blue-500"
                                    style="animation-delay:.3s"></div>
                            </div>
                            <span class="text-sm text-gray-600 font-medium">Sending...</span>
                        </div>
                    </div>

                    <button v-if="showScrollToBottom" @click="scrollToBottom(true)"
                        class="fixed bottom-32 right-8 z-20 rounded-2xl bg-blue-600 text-white shadow-xl px-5 py-3 text-sm font-semibold hover:bg-blue-700 transition-all duration-300 hover:scale-110 hover:shadow-2xl flex items-center gap-2 border border-blue-700/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                        New messages
                    </button>
                </div>

                <!-- Message input -->
                <form @submit.prevent="send" class="border-t border-gray-200/50 p-5 bg-white">
                    <div class="flex items-end gap-4">
                        <div class="flex-1 relative">
                            <textarea v-model="form.message" @keydown.enter.exact.prevent="send"
                                @keydown.enter.shift.exact.stop @input="handleInput" rows="1" ref="inputEl"
                                class="w-full resize-none rounded-2xl border border-gray-300 bg-white px-5 py-4 pr-14 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 placeholder-gray-500 text-gray-900 shadow-sm"
                                placeholder="Type your message..."></textarea>
                            <div class="absolute right-4 bottom-4 flex items-center gap-2">
                                <kbd
                                    class="px-2 py-1 bg-gray-100/80 rounded-lg text-[10px] font-mono text-gray-500 border border-gray-200/50">⏎</kbd>
                            </div>
                        </div>

                        <button type="submit" :disabled="!form.message.trim() || sending"
                            class="rounded-2xl bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4 text-white font-semibold disabled:opacity-50 disabled:cursor-not-allowed hover:from-blue-700 hover:to-purple-700 transition-all duration-300 hover:scale-105 hover:shadow-xl disabled:hover:scale-100 disabled:hover:shadow-none flex items-center gap-2 shadow-lg border border-white/20 backdrop-blur-sm">
                            <svg v-if="!sending" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            <div v-else class="flex gap-1">
                                <div class="w-1.5 h-1.5 bg-blue-200 rounded-full animate-bounce"></div>
                                <div class="w-1.5 h-1.5 bg-blue-200 rounded-full animate-bounce"
                                    style="animation-delay:.1s"></div>
                                <div class="w-1.5 h-1.5 bg-blue-200 rounded-full animate-bounce"
                                    style="animation-delay:.2s"></div>
                            </div>
                            {{ sending ? '' : 'Send' }}
                        </button>
                    </div>

                    <div class="mt-3 flex items-center justify-between">
                        <div class="flex items-center gap-4 text-xs text-gray-500">
                            <span class="flex items-center gap-1.5">
                                <kbd
                                    class="px-2 py-1 bg-gray-100/80 rounded-md text-[10px] font-mono border border-gray-200/50">Enter</kbd>
                                to send
                            </span>
                            <span class="flex items-center gap-1">
                                <kbd
                                    class="px-2 py-1 bg-gray-100/80 rounded-md text-[10px] font-mono border border-gray-200/50">Shift</kbd>
                                <span class="text-[10px]">+</span>
                                <kbd
                                    class="px-2 py-1 bg-gray-100/80 rounded-md text-[10px] font-mono border border-gray-200/50">Enter</kbd>
                                for new line
                            </span>
                        </div>

                        <div class="flex items-center gap-1 text-xs text-emerald-600">
                            <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></div>
                            Connected
                        </div>
                    </div>
                </form>
            </div>
        </template>
    </div>
</template>

<script setup>
import { ref, onMounted, nextTick, watch, computed, onBeforeUnmount } from 'vue'
import axios from 'axios'
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

const props = defineProps({
    room: { type: Object, default: null },
    messages: { type: Array, default: () => [] },
    rooms: { type: Array, default: () => [] },
    userId: { type: [Number, String], required: true },
})

/* ---- state ---- */
const localMessages = ref((props.messages || []).slice())
const form = ref({ message: '' })
const sending = ref(false)
const scrollContainer = ref(null)
const inputEl = ref(null)
const showScrollToBottom = ref(false)
const sidebarOpen = ref(false)
let echoChannel = null

/* ---- readiness ---- */
const ready = computed(() => Array.isArray(props.rooms) && !!props.userId)

/* ---- helpers ---- */
const otherUserId = (r) =>
    r?.client_id === props.userId ? r?.service_provider_id : r?.client_id

const otherUserName = (r) =>
    r?.client_id === props.userId
        ? (r?.service_provider?.profile?.display_name || r?.service_provider?.name || 'User')
        : (r?.client?.profile?.display_name || r?.client?.name || 'User')

const currentUserName = computed(() => {
    const pr = props?.room
    if (!pr) return 'You'
    return pr.client_id === props.userId
        ? (pr?.client?.profile?.display_name || pr?.client?.name || 'You')
        : (pr?.service_provider?.profile?.display_name || pr?.service_provider?.name || 'You')
})

const activeOtherUserName = computed(() =>
    props?.room ? otherUserName(props.room) : 'User'
)

const roomsCount = computed(() => (Array.isArray(props.rooms) ? props.rooms.length : 0))

const totalUnread = computed(() => {
    return props.rooms?.reduce((total, room) => total + (room.unread_count || 0), 0) || 0
})

const isOwn = (m) => Number(m?.user_id || m?.user?.id) === Number(props?.userId)

const bubbleClass = (m) => {
    const base = 'max-w-[75%] rounded-2xl px-5 py-3.5 text-sm shadow transition-colors duration-200 border'
    return isOwn(m)
        ? `${base} bg-blue-600 text-white rounded-br-md border-blue-700 shadow-blue-200`
        : `${base} bg-gray-100 text-gray-900 rounded-bl-md border-gray-200`
}

const initials = (name) => {
    if (!name) return 'U'
    const parts = String(name).trim().split(/\s+/)
    return parts.slice(0, 2).map(p => p.charAt(0).toUpperCase()).join('')
}

const formatTime = (ts) => {
    try {
        const d = ts ? new Date(ts) : new Date()
        return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
    } catch {
        return ''
    }
}

const getLastMessagePreview = (room) => {
    if (!room.last_message) {
        return 'No messages yet';
    }

    const message = room.last_message.message;
    const isOwnMessage = room.last_message.user_id === props.userId;

    if (isOwnMessage) {
        return `You: ${message.length > 30 ? message.substring(0, 30) + '...' : message}`;
    } else {
        return message.length > 40 ? message.substring(0, 40) + '...' : message;
    }
}

/* ---- scrolling ---- */
const scrollToBottom = async (smooth = false) => {
    await nextTick()
    const el = scrollContainer.value
    if (!el) return
    el.scrollTo({ top: el.scrollHeight, behavior: smooth ? 'smooth' : 'auto' })
    showScrollToBottom.value = false
}

const handleScroll = () => {
    const el = scrollContainer.value
    if (!el) return
    const threshold = 80
    const atBottom = el.scrollHeight - el.scrollTop - el.clientHeight < threshold
    showScrollToBottom.value = !atBottom
}

const autoResize = () => {
    const el = inputEl.value
    if (!el) return
    el.style.height = 'auto'
    el.style.height = `${Math.min(200, el.scrollHeight)}px`
}

const handleInput = () => {
    autoResize()
}

/* ---- actions ---- */
const send = async () => {
    const text = form.value.message?.trim()
    if (!text || sending.value || !props?.room?.id) return
    sending.value = true
    try {
        const res = await axios.post('/chat/messages', {
            room_id: props.room.id,
            message: text,
        })
        if (res?.data?.message) {
            localMessages.value.push(res.data.message)
        }
        form.value.message = ''
        autoResize()
        await scrollToBottom(true)
    } finally {
        sending.value = false
    }
}

/* ---- lifecycle ---- */
onMounted(async () => {
    autoResize()
    await scrollToBottom()
    const el = scrollContainer.value
    if (el) {
        el.addEventListener('scroll', handleScroll, { passive: true })
    }

    // Mark messages as read when entering the room
    if (props?.room?.id) {
        try {
            // await axios.post(`/chat/${props.room.id}/mark-read`)
            await axios.post(route('chat.messages.mark-read', { room: props.room.id }))
        } catch (error) {
            console.error('Failed to mark messages as read:', error)
        }
    }

    // Laravel Echo (optional)
    if (window?.Echo && props?.room?.id) {
        echoChannel = window.Echo.private(`chat.room.${props.room.id}`)
            .listen('MessageSent', (e) => {
                if (e?.message) {
                    localMessages.value.push(e.message)
                    const nearBottom = !showScrollToBottom.value
                    if (nearBottom) scrollToBottom(true)
                }
            })
    }
})

onBeforeUnmount(() => {
    const el = scrollContainer.value
    if (el) el.removeEventListener('scroll', handleScroll)
    if (echoChannel?.stopListening) {
        echoChannel.stopListening('MessageSent')
    }
})

watch(() => props.messages, (next) => {
    localMessages.value = Array.isArray(next) ? next.slice() : []
    scrollToBottom()
})
</script>
