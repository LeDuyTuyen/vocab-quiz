<script setup>
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { Head, Link } from '@inertiajs/vue3';
  import { computed } from 'vue';
  
  const props = defineProps({
    auth: Object,
    session: Object,
  });
  
  const percentage = computed(() => {
    if (!props.session?.total_questions) return 0;
    return (
      (props.session.correct_answers / props.session.total_questions) * 100
    ).toFixed(1);
  });
  </script>
  
  <template>
    <AuthenticatedLayout :auth="auth">
      <Head title="Kết quả quiz" />
  
      <div class="py-8 max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-2">
          Kết quả ôn tập
        </h1>
  
        <p class="text-sm text-gray-700">
          Deck: <strong>{{ session.deck.name }}</strong>
        </p>
        <p class="mt-1">
          Điểm:
          <strong>{{ session.correct_answers }} / {{ session.total_questions }}</strong>
          ({{ percentage }}%)
        </p>
  
        <Link
          :href="route('quiz.decks.index')"
          class="inline-block mt-3 text-sm text-indigo-600 hover:underline"
        >
          ← Quay lại danh sách deck
        </Link>
  
        <hr class="my-6" />
  
        <div class="space-y-4">
          <div
            v-for="answer in session.answers"
            :key="answer.id"
            class="border rounded-md p-4"
          >
            <p class="font-semibold mb-1">
              {{ answer.question.prompt }}
            </p>
  
            <div class="text-sm space-y-1">
              <div
                v-for="opt in [...answer.question.options].sort((a, b) => a.option_order - b.option_order)"
                :key="opt.id"
              >
                <span class="font-mono">
                  {{ String.fromCharCode(64 + opt.option_order) }}.
                </span>
                <span>
                  {{ opt.option_text }}
                </span>
  
                <span v-if="opt.is_correct" class="ml-2 text-xs text-green-600">
                  (Đáp án đúng)
                </span>
  
                <span
                  v-if="answer.selected_option_id === opt.id"
                  class="ml-2 text-xs text-blue-600"
                >
                  [Mày chọn]
                </span>
              </div>
            </div>
  
            <p class="mt-2 text-sm">
              Kết quả:
              <span v-if="answer.is_correct" class="text-green-600">✅ Đúng</span>
              <span v-else class="text-red-600">❌ Sai</span>
            </p>
  
            <p v-if="answer.question.explanation" class="mt-1 text-xs text-gray-600">
              <strong>Giải thích:</strong> {{ answer.question.explanation }}
            </p>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>
  