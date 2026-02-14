<template>
    <div>
        <h1 class="text-2xl font-bold mb-6">Contact Messages</h1>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Messages</p>
                        <p class="text-2xl font-bold">{{ statistics.total }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="pi pi-envelope text-blue-500 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Pending</p>
                        <p class="text-2xl font-bold text-orange-500">{{ statistics.pending }}</p>
                    </div>
                    <div class="bg-orange-100 p-3 rounded-full">
                        <i class="pi pi-clock text-orange-500 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Read</p>
                        <p class="text-2xl font-bold text-green-500">{{ statistics.read }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="pi pi-check-circle text-green-500 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <div class="flex gap-2">
                <button
                    @click="filterStatus = ''"
                    :class="filterStatus === '' ? 'bg-blue-500 text-white' : 'bg-gray-200'"
                    class="px-4 py-2 rounded"
                >
                    All
                </button>
                <button
                    @click="filterStatus = 'pending'"
                    :class="filterStatus === 'pending' ? 'bg-orange-500 text-white' : 'bg-gray-200'"
                    class="px-4 py-2 rounded"
                >
                    Pending
                </button>
                <button
                    @click="filterStatus = 'read'"
                    :class="filterStatus === 'read' ? 'bg-green-500 text-white' : 'bg-gray-200'"
                    class="px-4 py-2 rounded"
                >
                    Read
                </button>
            </div>
        </div>

        <!-- Messages List -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div v-if="loading" class="p-8 text-center">
                <i class="pi pi-spin pi-spinner text-4xl text-gray-400"></i>
            </div>

            <div v-else-if="messages.length === 0" class="p-8 text-center text-gray-500">
                No messages found
            </div>

            <div v-else>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                From
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Subject
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr
                            v-for="message in messages"
                            :key="message.id"
                            :class="message.status === 'pending' ? 'bg-orange-50' : ''"
                        >
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <div class="text-sm font-medium text-gray-900">{{ message.name }}</div>
                                    <div class="text-sm text-gray-500">{{ message.email }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ message.subject }}</div>
                                <div class="text-sm text-gray-500 truncate max-w-xs">{{ message.message }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ formatDate(message.created_at) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    :class="{
                                        'bg-orange-100 text-orange-800': message.status === 'pending',
                                        'bg-green-100 text-green-800': message.status === 'read'
                                    }"
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                >
                                    {{ message.status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button
                                    @click="viewMessage(message)"
                                    class="text-blue-600 hover:text-blue-900 mr-3"
                                >
                                    <i class="pi pi-eye"></i>
                                </button>
                                <button
                                    v-if="message.status === 'pending'"
                                    @click="markAsRead(message.id)"
                                    class="text-green-600 hover:text-green-900 mr-3"
                                    title="Mark as Read"
                                >
                                    <i class="pi pi-check"></i>
                                </button>
                                <button
                                    @click="deleteMessage(message.id)"
                                    class="text-red-600 hover:text-red-900"
                                >
                                    <i class="pi pi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div v-if="pagination.last_page > 1" class="px-6 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} results
                        </div>
                        <div class="flex gap-2">
                            <button
                                @click="changePage(pagination.current_page - 1)"
                                :disabled="pagination.current_page === 1"
                                class="px-3 py-1 border rounded disabled:opacity-50"
                            >
                                Previous
                            </button>
                            <button
                                @click="changePage(pagination.current_page + 1)"
                                :disabled="pagination.current_page === pagination.last_page"
                                class="px-3 py-1 border rounded disabled:opacity-50"
                            >
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Message Modal -->
        <div
            v-if="selectedMessage"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            @click.self="selectedMessage = null"
        >
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h2 class="text-2xl font-bold">Message Details</h2>
                        <button @click="selectedMessage = null" class="text-gray-500 hover:text-gray-700">
                            <i class="pi pi-times text-xl"></i>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">From:</label>
                            <p class="text-lg">{{ selectedMessage.name }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Email:</label>
                            <p class="text-lg">{{ selectedMessage.email }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Subject:</label>
                            <p class="text-lg font-semibold">{{ selectedMessage.subject }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Message:</label>
                            <p class="text-gray-700 whitespace-pre-wrap">{{ selectedMessage.message }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Date:</label>
                            <p>{{ formatDate(selectedMessage.created_at) }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Status:</label>
                            <span
                                :class="{
                                    'bg-orange-100 text-orange-800': selectedMessage.status === 'pending',
                                    'bg-green-100 text-green-800': selectedMessage.status === 'read'
                                }"
                                class="px-2 py-1 text-xs font-semibold rounded-full"
                            >
                                {{ selectedMessage.status }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-2">
                        <button
                            v-if="selectedMessage.status === 'pending'"
                            @click="markAsRead(selectedMessage.id)"
                            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
                        >
                            Mark as Read
                        </button>
                        <button
                            @click="selectedMessage = null"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';

interface ContactMessage {
    id: number;
    name: string;
    email: string;
    subject: string;
    message: string;
    status: 'pending' | 'read';
    read_at: string | null;
    created_at: string;
    updated_at: string;
}

interface Pagination {
    current_page: number;
    from: number;
    to: number;
    total: number;
    last_page: number;
}

const loading = ref(false);
const messages = ref<ContactMessage[]>([]);
const selectedMessage = ref<ContactMessage | null>(null);
const filterStatus = ref('');
const statistics = ref({
    total: 0,
    pending: 0,
    read: 0,
});

const pagination = ref<Pagination>({
    current_page: 1,
    from: 0,
    to: 0,
    total: 0,
    last_page: 1,
});

// Fetch messages
const fetchMessages = async (page = 1) => {
    loading.value = true;
    try {
        const params: any = { page };
        if (filterStatus.value) {
            params.status = filterStatus.value;
        }

        const response = await axios.get('/api/admin/contact-messages', { params });

        if (response.data.success) {
            messages.value = response.data.data.data;
            pagination.value = {
                current_page: response.data.data.current_page,
                from: response.data.data.from,
                to: response.data.data.to,
                total: response.data.data.total,
                last_page: response.data.data.last_page,
            };
        }
    } catch (error) {
        console.error('Error fetching messages:', error);
        window.showErrorToast?.('Failed to load messages');
    } finally {
        loading.value = false;
    }
};

// Fetch statistics
const fetchStatistics = async () => {
    try {
        const response = await axios.get('/api/admin/contact-messages/statistics');
        if (response.data.success) {
            statistics.value = response.data.data;
        }
    } catch (error) {
        console.error('Error fetching statistics:', error);
    }
};

// Mark as read
const markAsRead = async (id: number) => {
    try {
        const response = await axios.patch(`/api/admin/contact-messages/${id}/mark-as-read`);
        if (response.data.success) {
            window.showSuccessToast?.('Message marked as read');
            await fetchMessages(pagination.value.current_page);
            await fetchStatistics();
            if (selectedMessage.value && selectedMessage.value.id === id) {
                selectedMessage.value = response.data.data;
            }
        }
    } catch (error) {
        console.error('Error marking message as read:', error);
        window.showErrorToast?.('Failed to mark message as read');
    }
};

// Delete message
const deleteMessage = async (id: number) => {
    if (!confirm('Are you sure you want to delete this message?')) {
        return;
    }

    try {
        const response = await axios.delete(`/api/admin/contact-messages/${id}`);
        if (response.data.success) {
            window.showSuccessToast?.('Message deleted successfully');
            await fetchMessages(pagination.value.current_page);
            await fetchStatistics();
            if (selectedMessage.value && selectedMessage.value.id === id) {
                selectedMessage.value = null;
            }
        }
    } catch (error) {
        console.error('Error deleting message:', error);
        window.showErrorToast?.('Failed to delete message');
    }
};

// View message
const viewMessage = (message: ContactMessage) => {
    selectedMessage.value = message;
};

// Change page
const changePage = (page: number) => {
    if (page >= 1 && page <= pagination.value.last_page) {
        fetchMessages(page);
    }
};

// Format date
const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    return date.toLocaleString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};

// Watch filter changes
watch(filterStatus, () => {
    fetchMessages(1);
});

// Load data on mount
onMounted(() => {
    fetchMessages();
    fetchStatistics();
});
</script>

<style scoped>
/* Add any custom styles here */
</style>

