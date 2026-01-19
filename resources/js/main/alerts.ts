import Swal, { SweetAlertIcon } from "sweetalert2";

// Extend the Window interface to include our custom properties
declare global {
    interface Window {
        Toast: typeof Toast;
        showToast: (message: string, icon?: SweetAlertIcon) => void;
        showErrorToast: (message: string) => void;
        showSuccessToast: (message: string) => void;
    }
}

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end', // Options: 'top', 'top-start', 'top-end', 'center', etc.
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

window.Toast = Toast; // Make it available globally
window.showToast = function (message: string, icon: SweetAlertIcon = 'success') {
    Toast.fire({
        icon: icon,
        title: message
    });
}

window.showErrorToast = function (message: string) {
    window.showToast(message, 'error');
}

window.showSuccessToast = function (message: string) {
    window.showToast(message, 'success');
}

export { Toast };

