<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';
    import { computed } from 'vue';
    
    const props = defineProps({
      auth: Object,
      deck: {
        type: Object,
        default: null,
      },
    });
    
    const isEdit = computed(() => !!props.deck);
    
    const form = useForm({
      name: props.deck?.name ?? '',
      language: props.deck?.language ?? 'zh',
      level: props.deck?.level ?? '',
      description: props.deck?.description ?? '',
      is_public: props.deck?.is_public ?? false,
    });
    
    const submit = () => {
      if (isEdit.value) {
        form.put(route('quiz.my-decks.update', props.deck.id));
      } else {
        form.post(route('quiz.my-decks.store'));
      }
    };
    </script>
    
    <template>
      <AuthenticatedLayout :auth="auth">
        <Head :title="isEdit ? 'Sửa deck' : 'Tạo deck mới'" />
    
        <div class="py-8 max-w-xl mx-auto">
          <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold">
              {{ isEdit ? 'Sửa deck' : 'Tạo deck mới' }}
            </h1>
    
            <Link
              :href="route('quiz.my-decks.index')"
              class="text-sm text-gray-600 hover:underline"
            >
              ← Quay lại
            </Link>
          </div>
    
          <form @submit.prevent="submit" class="space-y-4">
            <div>
              <label class="block text-sm font-medium mb-1">Tên deck *</label>
              <input
                v-model="form.name"
                type="text"
                class="border rounded-md px-3 py-2 text-sm w-full"
              />
              <div v-if="form.errors.name" class="text-xs text-red-600 mt-1">
                {{ form.errors.name }}
              </div>
            </div>
    
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium mb-1">Ngôn ngữ</label>
                <input
                  v-model="form.language"
                  type="text"
                  class="border rounded-md px-3 py-2 text-sm w-full"
                  placeholder="zh, en, vi..."
                />
              </div>
    
              <div>
                <label class="block text-sm font-medium mb-1">Level</label>
                <input
                  v-model="form.level"
                  type="text"
                  class="border rounded-md px-3 py-2 text-sm w-full"
                  placeholder="HSK1, N3..."
                />
              </div>
            </div>
    
            <div>
              <label class="block text-sm font-medium mb-1">Mô tả</label>
              <textarea
                v-model="form.description"
                rows="3"
                class="border rounded-md px-3 py-2 text-sm w-full"
              />
            </div>
    
            <div class="flex items-center gap-2">
              <input
                id="is_public"
                v-model="form.is_public"
                type="checkbox"
                class="rounded border-gray-300"
              />
              <label for="is_public" class="text-sm">
                Cho phép deck này public (có thể dùng cho ôn tập chung)
              </label>
            </div>
    
            <button
              type="submit"
              class="mt-2 inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm rounded-md"
              :disabled="form.processing"
            >
              {{ isEdit ? 'Lưu thay đổi' : 'Tạo deck' }}
            </button>
          </form>
        </div>
      </AuthenticatedLayout>
    </template>
    