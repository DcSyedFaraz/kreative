<template>
  <div class="flex">
    <aside class="w-1/4 border-r p-4">
      <h2 class="font-bold mb-2">Chats</h2>
      <ul>
        <li v-for="r in rooms" :key="r.id" class="mb-1">
          <Link :href="`/chat/${otherUserId(r)}`" :class="{ 'font-bold': r.id === room.id }">
            {{ otherUserName(r) }}
          </Link>
        </li>
      </ul>
    </aside>
    <div class="flex-1 p-4">
      <div class="mb-4">
        <div v-for="m in messages" :key="m.id" class="mb-2">
          <strong>{{ m.user.name }}:</strong> {{ m.message }}
        </div>
      </div>
      <form @submit.prevent="send" class="flex gap-2">
        <input v-model="form.message" class="flex-1 border rounded p-2" placeholder="Type your message" />
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Send</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  room: Object,
  messages: Array,
  rooms: Array,
  userId: Number,
});

const messages = ref(props.messages);
const form = ref({ message: '' });

const otherUserId = (r) => r.client_id === props.userId ? r.service_provider_id : r.client_id;
const otherUserName = (r) => r.client_id === props.userId
  ? (r.service_provider.profile?.display_name || r.service_provider.name)
  : (r.client.profile?.display_name || r.client.name);

const send = () => {
  if (!form.value.message) return;
  axios.post('/chat/messages', {
    room_id: props.room.id,
    message: form.value.message,
  }).then(res => {
    messages.value.push(res.data.message);
    form.value.message = '';
  });
};

onMounted(() => {
  window.Echo.private(`chat.room.${props.room.id}`)
    .listen('MessageSent', (e) => {
      messages.value.push(e.message);
    });
});
</script>
