<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';
    
    const props = defineProps({
      auth: Object,
      decks: Array,
    });
    </script>
    
    <template>
      <AuthenticatedLayout :auth="auth">
        <Head title="Deck của tôi" />
    
        <div class="py-8 max-w-5xl mx-auto">
          <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Deck của tôi</h1>
    
            <Link
              :href="route('quiz.my-decks.create')"
              class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md"
            >
              + Tạo deck mới
            </Link>
          </div>
    
          <div v-if="!decks.length" class="text-sm text-gray-600">
            Chưa có deck nào. Bấm "Tạo deck mới" để bắt đầu.
          </div>
    
          <table v-else class="min-w-full text-sm border rounded-md overflow-hidden">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-4 py-2 text-left">Tên deck</th>
                <th class="px-4 py-2 text-left">Ngôn ngữ</th>
                <th class="px-4 py-2 text-left">Level</th>
                <th class="px-4 py-2 text-left">Công khai?</th>
                <th class="px-4 py-2 text-right">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="deck in decks"
                :key="deck.id"
                class="border-t"
              >
                <td class="px-4 py-2 font-medium">
                  {{ deck.name }}
                </td>
                <td class="px-4 py-2">
                  {{ deck.language || '-' }}
                </td>
                <td class="px-4 py-2">
                  {{ deck.level || '-' }}
                </td>
                <td class="px-4 py-2">
                  <span
                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs"
                    :class="deck.is_public ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700'"
                  >
                    {{ deck.is_public ? 'Public' : 'Private' }}
                  </span>
                </td>
                <td class="px-4 py-2 text-right space-x-2">
                  <Link
                    :href="route('quiz.my-decks.edit', deck.id)"
                    class="text-xs px-3 py-1 border rounded-md hover:bg-gray-50"
                  >
                    Sửa
                  </Link>
                  <Link
                    :href="route('quiz.decks.show', deck.id)"
                    class="text-xs px-3 py-1 border rounded-md hover:bg-gray-50"
                  >
                    Xem & ôn tập
                  </Link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </AuthenticatedLayout>
    </template>
    