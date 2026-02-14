<template>
    <div class="col-xl-12">
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex align-items-top justify-content-between">
                            <div>
                                <span class="avatar avatar-md avatar-rounded bg-primary">
                                    <i class="ti ti-mail fs-16"></i>
                                </span>
                            </div>
                            <div class="flex-fill ms-3">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div>
                                        <p class="text-muted mb-0">Total Messages</p>
                                        <h4 class="fw-semibold mt-1">{{ statistics.total }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex align-items-top justify-content-between">
                            <div>
                                <span class="avatar avatar-md avatar-rounded bg-warning">
                                    <i class="ti ti-clock fs-16"></i>
                                </span>
                            </div>
                            <div class="flex-fill ms-3">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div>
                                        <p class="text-muted mb-0">Pending</p>
                                        <h4 class="fw-semibold mt-1 text-warning">{{ statistics.pending }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex align-items-top justify-content-between">
                            <div>
                                <span class="avatar avatar-md avatar-rounded bg-success">
                                    <i class="ti ti-check fs-16"></i>
                                </span>
                            </div>
                            <div class="flex-fill ms-3">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div>
                                        <p class="text-muted mb-0">Read</p>
                                        <h4 class="fw-semibold mt-1 text-success">{{ statistics.read }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    Contact Messages
                </div>
                <!-- Filters -->
                <div class="d-flex gap-2">
                    <button
                        @click="filterStatus = ''"
                        :class="filterStatus === '' ? 'btn-primary' : 'btn-light'"
                        class="btn btn-sm"
                    >
                        All
                    </button>
                    <button
                        @click="filterStatus = 'pending'"
                        :class="filterStatus === 'pending' ? 'btn-warning' : 'btn-light'"
                        class="btn btn-sm"
                    >
                        Pending
                    </button>
                    <button
                        @click="filterStatus = 'read'"
                        :class="filterStatus === 'read' ? 'btn-success' : 'btn-light'"
                        class="btn btn-sm"
                    >
                        Read
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div v-if="loading" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <div v-else-if="messages.length === 0" class="text-center py-5 text-muted">
                    <i class="ti ti-inbox fs-1 d-block mb-3"></i>
                    <p>No messages found</p>
                </div>

                <div v-else class="table-responsive">
                    <table class="table text-nowrap table-hover border table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">From</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Date</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="message in messages"
                                :key="message.id"
                                :class="message.status === 'pending' ? 'table-warning' : ''"
                            >
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">{{ message.name }}</span>
                                        <span class="text-muted fs-12">{{ message.email }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">{{ message.subject }}</span>
                                        <span class="text-muted fs-12 text-truncate" style="max-width: 300px;">{{ message.message }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted fs-12">{{ formatDate(message.created_at) }}</span>
                                </td>
                                <td>
                                    <span
                                        :class="{
                                            'badge bg-warning': message.status === 'pending',
                                            'badge bg-success': message.status === 'read'
                                        }"
                                    >
                                        {{ message.status }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button
                                            @click="viewMessage(message)"
                                            class="btn btn-sm btn-primary-light"
                                            title="View"
                                        >
                                            <i class="ti ti-eye"></i>
                                        </button>
                                        <button
                                            v-if="message.status === 'pending'"
                                            @click="markAsRead(message.id)"
                                            class="btn btn-sm btn-success-light"
                                            title="Mark as Read"
                                        >
                                            <i class="ti ti-check"></i>
                                        </button>
                                        <button
                                            @click="deleteMessage(message.id)"
                                            class="btn btn-sm btn-danger-light"
                                            title="Delete"
                                        >
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <nav v-if="pagination.last_page > 1" aria-label="Page navigation" class="mt-3">
                        <ul class="pagination justify-content-between align-items-center">
                            <li class="page-item">
                                <span class="text-muted">
                                    Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} entries
                                </span>
                            </li>
                            <li class="d-flex gap-2">
                                <button
                                    @click="changePage(pagination.current_page - 1)"
                                    :disabled="pagination.current_page === 1"
                                    class="btn btn-sm btn-primary-light"
                                >
                                    <i class="ti ti-chevron-left"></i> Previous
                                </button>
                                <button
                                    @click="changePage(pagination.current_page + 1)"
                                    :disabled="pagination.current_page === pagination.last_page"
                                    class="btn btn-sm btn-primary-light"
                                >
                                    Next <i class="ti ti-chevron-right"></i>
                                </button>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <!-- View Message Modal -->
        <div v-if="selectedMessage" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">Message Details</h6>
                        <button @click="selectedMessage = null" type="button" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">From:</label>
                                <p class="text-muted">{{ selectedMessage.name }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email:</label>
                                <p class="text-muted">{{ selectedMessage.email }}</p>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Subject:</label>
                                <p class="text-muted">{{ selectedMessage.subject }}</p>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Message:</label>
                                <p class="text-muted" style="white-space: pre-wrap;">{{ selectedMessage.message }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Date:</label>
                                <p class="text-muted">{{ formatDate(selectedMessage.created_at) }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status:</label>
                                <div>
                                    <span
                                        :class="{
                                            'badge bg-warning': selectedMessage.status === 'pending',
                                            'badge bg-success': selectedMessage.status === 'read'
                                        }"
                                    >
                                        {{ selectedMessage.status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            v-if="selectedMessage.status === 'pending'"
                            @click="markAsRead(selectedMessage.id)"
                            class="btn btn-success"
                        >
                            <i class="ti ti-check me-2"></i> Mark as Read
                        </button>
                        <button @click="selectedMessage = null" class="btn btn-secondary">
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

