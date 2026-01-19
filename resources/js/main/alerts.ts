import { useToast } from "vue-toastification";

// Define toast types
export type ToastType = 'success' | 'error' | 'warning' | 'info';

// Extend the Window interface to include our custom properties
declare global {
    interface Window {
        showToast: (message: string, type?: ToastType) => void;
        showErrorToast: (message: string) => void;
        showSuccessToast: (message: string) => void;
        showWarningToast: (message: string) => void;
        showInfoToast: (message: string) => void;
    }
}

// Lazy-load toast instance
let toastInstance: ReturnType<typeof useToast> | null = null;

function getToast() {
    if (!toastInstance) {
        toastInstance = useToast();
    }
    return toastInstance;
}

// Make toast functions available globally
window.showToast = function (message: string, type: ToastType = 'success') {
    console.log(type)
    const toast = getToast();
    switch (type) {
        case 'success':
            toast.success(message);
            break;
        case 'error':
            toast.error(message);
            break;
        case 'warning':
            toast.warning(message);
            break;
        case 'info':
            toast.info(message);
            break;
        default:
            toast(message);
    }
}

window.showErrorToast = function (message: string) {
    getToast().error(message);
}

window.showSuccessToast = function (message: string) {
    getToast().success(message);
}

window.showWarningToast = function (message: string) {
    getToast().warning(message);
}

window.showInfoToast = function (message: string) {
    getToast().info(message);
}

export { getToast };

