export interface OrderStatusOption {
    value: string;
    label: string;
}

export const ORDER_STATUSES: OrderStatusOption[] = [
    { value: 'pending', label: 'Pending' },
    { value: 'confirmed', label: 'Confirmed' },
    { value: 'in_progress', label: 'In Progress' },
    { value: 'on_way', label: 'On Way' },
    { value: 'completed', label: 'Completed' },
    { value: 'canceled', label: 'Canceled' },
    { value: 'canceled_by_client', label: 'Canceled by Client' },
];

const STATUS_CLASSES: Record<string, string> = {
    pending: 'bg-warning',
    confirmed: 'bg-info',
    in_progress: 'bg-primary',
    on_way: 'bg-purple',
    completed: 'bg-success',
    canceled: 'bg-danger',
    canceled_by_client: 'bg-danger',
};

export function orderStatusClass(status: string): string {
    return STATUS_CLASSES[status] || 'bg-secondary';
}
