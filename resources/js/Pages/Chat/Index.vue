<template>
  <div class="max-w-xl mx-auto p-4">
    <h2 class="text-lg font-bold mb-4">Your Chats</h2>
    <ul>
      <li v-for="r in rooms" :key="r.id" class="mb-2">
        <Link :href="`/chat/${otherUserId(r)}`" class="text-blue-600 hover:underline">
          {{ otherUserName(r) }}
        </Link>
      </li>
      <li v-if="rooms.length === 0">No chats yet.</li>
    </ul>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  rooms: Array,
  userId: Number,
});

const otherUserId = (r) => r.client_id === props.userId ? r.service_provider_id : r.client_id;
const otherUserName = (r) => r.client_id === props.userId
  ? (r.service_provider.profile?.display_name || r.service_provider.name)
  : (r.client.profile?.display_name || r.client.name);
</script>
