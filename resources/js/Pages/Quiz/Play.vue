<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
  deck: Object,
  session: Object,
  questions: Array,
});

const form = useForm({
  answers: {},
});

const percentage = computed(() => {
  if (!props.session?.total_questions) return 0;
  return (
    (props.session.correct_answers / props.session.total_questions) * 100
  ).toFixed(1);
});
</script>

<template>
  <AuthenticatedLayout>
    <Head :title="`Quiz: ${deck.name}`" />

    <div class="py-8 max-w-4xl mx-auto">
      <h1 class="text-2xl font-bold mb-2">
        Ôn tập: {{ deck.name }}
      </h1>
      <p class="text-sm text-gray-600 mb-4">
        Quiz #{{ session.id }} • {{ questions.length }} câu
      </p>

      <form @submit.prevent="submitQuiz" class="space-y-6">
        <div
          v-for="(q, idx) in questions"
          :key="q.id"
          class="border rounded-md p-4"
        >
          <h2 class="font-semibold mb-1">
            Câu {{ idx + 1 }}
          </h2>
          <p class="mb-3">
            {{ q.prompt }}
          </p>

          <div class="space-y-1">
            <label
              v-for="opt in [...q.options].sort((a,b) => a.option_order - b.option_order)"
              :key="opt.id"
              class="flex items-center gap-2 text-sm cursor-pointer"
            >
              <input
                type="radio"
                :name="`answers[${q.id}]`"
                :value="opt.id"
                v-model="form.answers[q.id]"
              />
              <span>
                {{ String.fromCharCode(64 + opt.option_order) }}.
                {{ opt.option_text }}
              </span>
            </label>
          </div>
        </div>

        <button
          type="submit"
          class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md text-sm"
          :disabled="form.processing"
        >
          Nộp bài
        </button>
      </form>
    </div>
  </AuthenticatedLayout>
</template>
