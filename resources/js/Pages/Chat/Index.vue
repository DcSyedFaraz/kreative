<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50">
        <div class="mx-auto max-w-4xl p-6">
            <!-- Header -->
            <div class="mb-8 text-center relative">
                <!-- Back to Dashboard button -->
                <div class="absolute left-0 top-1/2 transform -translate-y-1/2">
                    <a :href="route('dashboard')"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur-sm rounded-xl border border-gray-200/50 text-gray-700 hover:bg-white hover:shadow-lg transition-all duration-300 group">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" class="h-4 w-4 group-hover:scale-110 transition-transform duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a>
                </div>

                <h1
                    class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    Your Conversations
                </h1>
                <p class="text-gray-600 mt-2">Stay connected with all your important chats</p>
            </div>

            <!-- Chat list -->
            <div class="bg-white/80 backdrop-blur-xl rounded-3xl border border-gray-200/50 shadow-xl overflow-hidden">
                <div class="p-6 border-b border-gray-100/50 bg-gradient-to-r from-blue-500/5 to-purple-500/5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-gradient-to-br from-blue-100 to-purple-100 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="font-semibold text-gray-800">Recent Messages</h2>
                                <p class="text-sm text-gray-500">
                                    {{ rooms.length }} conversation{{ rooms.length !== 1 ? 's' : '' }}
                                    <span v-if="totalUnread > 0" class="ml-2 text-red-600 font-medium">
                                        • {{ totalUnread }} unread message{{ totalUnread !== 1 ? 's' : '' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-sm text-green-600 font-medium">Online</span>
                        </div>
                    </div>
                </div>

                <div class="divide-y divide-gray-100/50">
                    <div v-for="r in rooms" :key="r.id"
                        class="group hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-purple-50/50 transition-all duration-300">
                        <Link :href="`/chat/${otherUserId(r)}`"
                            class="flex items-center gap-4 px-6 py-4 hover:scale-[1.01] transition-all duration-300">

                        <!-- Avatar with enhanced styling -->
                        <div class="relative">
                            <div
                                class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-100 to-purple-100 text-blue-700 font-bold text-lg shadow-md group-hover:shadow-lg group-hover:scale-110 transition-all duration-300">
                                {{ initials(otherUserName(r)) }}
                            </div>
                            <div
                                class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 border-3 border-white rounded-full shadow-sm">
                            </div>
                            <!-- Unread message indicator -->
                            <div v-if="r.unread_count > 0"
                                class="absolute -top-1 -right-1 w-3 h-3 bg-gradient-to-r from-orange-400 to-red-500 rounded-full shadow-sm animate-pulse">
                            </div>
                        </div>

                        <!-- Chat info -->
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <h3
                                    class="truncate font-semibold text-gray-900 group-hover:text-blue-700 transition-colors"
                                    :class="{ 'font-bold': r.unread_count > 0 }">
                                    {{ otherUserName(r) }}
                                </h3>
                                <span class="text-xs text-gray-400 font-medium">{{ formatTime(r.last_message?.created_at) }}</span>
                            </div>
                            <p class="text-sm text-gray-500 truncate" :class="{ 'font-medium text-gray-700': r.unread_count > 0 }">
                                {{ getLastMessagePreview(r) }}
                            </p>
                            <div class="flex items-center gap-2 mt-2">
                                <div class="flex items-center gap-1 text-xs text-green-600">
                                    <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
                                    Active now
                                </div>
                                <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                                <span class="text-xs text-gray-400">Direct message</span>
                                <!-- Unread message indicator -->
                                <div v-if="r.unread_count > 0" class="ml-auto">
                                    <span
                                        class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
                                        {{ r.unread_count > 99 ? '99+' : r.unread_count }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Arrow indicator -->
                        <div class="flex items-center">
                            <div
                                class="p-2 rounded-full bg-gray-100/50 group-hover:bg-blue-100 transition-all duration-300 group-hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 text-gray-400 group-hover:text-blue-600 transition-colors"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                        </Link>
                    </div>

                    <!-- Empty state -->
                    <div v-if="rooms.length === 0" class="px-6 py-12 text-center">
                        <div
                            class="mx-auto w-16 h-16 bg-gradient-to-br from-blue-100 to-purple-100 rounded-2xl flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">No conversations yet</h3>
                        <p class="text-gray-500">Start a new chat to begin connecting with others</p>
                    </div>
                </div>
            </div>

            <!-- Stats or additional info -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-4 border border-gray-200/50">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-100 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-800">{{ rooms.length }}</div>
                            <div class="text-sm text-gray-500">Active Chats</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-4 border border-gray-200/50">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-green-100 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-800">Online</div>
                            <div class="text-sm text-gray-500">Status</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-4 border border-gray-200/50">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-purple-100 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-800">Instant</div>
                            <div class="text-sm text-gray-500">Delivery</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    rooms: Array,
    userId: Number,
    totalUnread: { type: Number, default: 0 },
});

const otherUserId = (r) => r.client_id === props.userId ? r.service_provider_id : r.client_id;
const otherUserName = (r) => r.client_id === props.userId
    ? (r.service_provider?.profile?.display_name || r.service_provider?.name)
    : (r.client?.profile?.display_name || r.client?.name);

const initials = (name) => {
    if (!name) return 'U';
    const parts = String(name).trim().split(/\s+/);
    return parts.slice(0, 2).map(p => p.charAt(0).toUpperCase()).join('');
};

const formatTime = (timestamp) => {
    if (!timestamp) return '';

    const date = new Date(timestamp);
    const now = new Date();
    const diffInHours = (now - date) / (1000 * 60 * 60);

    if (diffInHours < 1) {
        const diffInMinutes = Math.floor((now - date) / (1000 * 60));
        return diffInMinutes < 1 ? 'now' : `${diffInMinutes}m ago`;
    } else if (diffInHours < 24) {
        return `${Math.floor(diffInHours)}h ago`;
    } else if (diffInHours < 168) { // 7 days
        return `${Math.floor(diffInHours / 24)}d ago`;
    } else {
        return date.toLocaleDateString();
    }
};

const getLastMessagePreview = (room) => {
    if (!room.last_message) {
        return 'No messages yet';
    }

    const message = room.last_message.message;
    const isOwnMessage = room.last_message.user_id === props.userId;

    if (isOwnMessage) {
        return `You: ${message.length > 50 ? message.substring(0, 50) + '...' : message}`;
    } else {
        return message.length > 60 ? message.substring(0, 60) + '...' : message;
    }
};
</script>
