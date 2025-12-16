<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
  deck: Object,
});

const form = useForm({
  num: 10,
});

const startQuiz = () => {
  form.get(route('quiz.start', props.deck.id), {
    preserveScroll: true,
  });
};
</script>

<template>
  <AuthenticatedLayout>
    <Head :title="`Deck: ${deck.name}`" />

    <div class="py-8 max-w-3xl mx-auto">
      <Link
        :href="route('quiz.decks.index')"
        class="text-sm text-gray-600 hover:underline"
      >
        ← Quay lại danh sách deck
      </Link>

      <h1 class="text-2xl font-bold mt-4 mb-2">
        {{ deck.name }}
      </h1>
      <p class="text-sm text-gray-600">
        Ngôn ngữ: {{ deck.language }} • Level: {{ deck.level || 'N/A' }}
      </p>
      <p class="mt-2">
        {{ deck.description }}
      </p>
      <p class="text-xs text-gray-500 mt-1">
        {{ deck.words_count }} từ • {{ deck.questions.length }} câu hỏi
      </p>

      <div class="mt-6 border rounded-md p-4">
        <label class="block text-sm font-medium mb-2">
          Số câu hỏi trong 1 bài quiz
        </label>
        <input
          v-model.number="form.num"
          type="number"
          min="1"
          max="50"
          class="border rounded-md px-3 py-1 text-sm w-24"
        />

        <button
          type="button"
          class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm rounded-md"
          @click="startQuiz"
        >
          Bắt đầu ôn tập
        </button>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
