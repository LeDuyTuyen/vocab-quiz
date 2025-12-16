<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
  decks: Array,
});
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Quiz decks" />

    <div class="py-8 max-w-4xl mx-auto">
      <h1 class="text-2xl font-bold mb-4">Decks ôn tập</h1>

      <div v-if="!decks.length">Chưa có deck nào.</div>

      <div v-else class="space-y-4">
        <div
          v-for="deck in decks"
          :key="deck.id"
          class="border rounded-md p-4 flex justify-between items-center"
        >
          <div>
            <h2 class="font-semibold text-lg">
              {{ deck.name }} ({{ deck.language }})
            </h2>
            <p class="text-sm text-gray-600">
              {{ deck.description }}
            </p>
            <p class="text-xs text-gray-500 mt-1">
              {{ deck.words_count }} từ
            </p>
          </div>
          <Link
            :href="route('quiz.decks.show', deck.id)"
            class="text-sm px-3 py-2 bg-indigo-600 text-white rounded-md"
          >
            Chi tiết / Ôn tập
          </Link>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
