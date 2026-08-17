<template>
    <div class="col-xl-12">
        <div class="text-start my-4 d-flex flex-wrap gap-2">
            <router-link to="/dash/orders" class="btn btn-secondary btn-b">
                <i class="las la-arrow-alt-circle-left"></i> Back to Orders
            </router-link>
            <button v-if="order" class="btn btn-primary btn-b" @click="printWaybill">
                <i class="fe fe-printer me-1"></i> Print Waybill
            </button>
        </div>

        <div v-if="loading" class="text-center py-5">
            <v-progress-circular indeterminate color="primary"></v-progress-circular>
        </div>

        <div v-else-if="order">
            <!-- Header + status -->
            <div class="card custom-card">
                <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <h4 class="mb-1">{{ order.order_number }}</h4>
                        <small class="text-muted">{{ $formatDate(order.created_at) }}</small>
                        <span class="badge ms-2" :class="statusClass(order.status)">{{ order.status_label }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <label class="form-label mb-0 me-2">Status</label>
                        <select v-model="statusToSave" class="form-control" style="width:auto">
                            <option v-for="s in STATUSES" :key="s.value" :value="s.value">{{ s.label }}</option>
                        </select>
                        <button class="btn btn-primary" :disabled="savingStatus" @click="saveStatus">
                            {{ savingStatus ? 'Saving...' : 'Update Status' }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Customer info box -->
                <div class="col-lg-6">
                    <div class="card custom-card">
                        <div class="card-header"><div class="card-title">Customer Details</div></div>
                        <div class="card-body">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr><th style="width:40%">Name</th><td>{{ order.customer_name }}</td></tr>
                                    <tr><th>Phone</th><td>{{ order.customer_phone }}</td></tr>
                                    <tr v-if="order.email"><th>Account Email</th><td>{{ order.email }}</td></tr>
                                    <tr><th>Governorate</th><td>{{ order.governorate_name }}</td></tr>
                                    <tr><th>Address</th><td>{{ order.address }}</td></tr>
                                    <tr v-if="order.notes"><th>Notes</th><td>{{ order.notes }}</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Payment + summary -->
                <div class="col-lg-6">
                    <div class="card custom-card">
                        <div class="card-header"><div class="card-title">Payment & Summary</div></div>
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <img v-if="order.payment_method_image" :src="order.payment_method_image" alt="" style="height:32px;width:32px;object-fit:contain">
                                <span class="fw-bold">{{ order.payment_method_name || '—' }}</span>
                            </div>
                            <div v-if="order.receipt_url" class="mb-3">
                                <a :href="order.receipt_url" target="_blank" class="btn btn-sm btn-info-light">
                                    <i class="fe fe-file-text me-1"></i> View transfer receipt
                                </a>
                            </div>
                            <p class="mb-1 d-flex justify-content-between"><span>Subtotal</span><span>{{ order.subtotal }} EGP</span></p>
                            <p class="mb-1 d-flex justify-content-between text-success" v-if="Number(order.discount) > 0">
                                <span>Discount <span v-if="order.coupon_code" class="badge bg-light text-dark ms-1">{{ order.coupon_code }}</span></span>
                                <span>- {{ order.discount }} EGP</span>
                            </p>
                            <p class="mb-1 d-flex justify-content-between"><span>Shipping</span><span>{{ order.shipping_price }} EGP</span></p>
                            <p class="mb-0 d-flex justify-content-between fw-bold fs-5"><span>Total</span><span>{{ order.total }} EGP</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items -->
            <div class="card custom-card">
                <div class="card-header"><div class="card-title">Items</div></div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="it in order.items" :key="it.id">
                                <td>{{ it.product_name }}</td>
                                <td class="text-center">{{ it.product_price }}</td>
                                <td class="text-center">{{ it.quantity }}</td>
                                <td class="text-end">{{ it.line_total }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import { useHead } from '@vueuse/head';
import { ORDER_STATUSES, orderStatusClass } from './statuses';

useHead({ title: 'Order Details' });

const route = useRoute();
const STATUSES = ORDER_STATUSES;

const order = ref<any>(null);
const loading = ref(true);
const statusToSave = ref('pending');
const savingStatus = ref(false);

function statusClass(status: string) {
    return orderStatusClass(status);
}

async function fetchOrder() {
    loading.value = true;
    try {
        const response = await axios.get(`/orders/${route.params.id}`);
        order.value = response.data.data;
        statusToSave.value = order.value.status;
    } catch (error) {
        order.value = null;
    } finally {
        loading.value = false;
    }
}

function escapeHtml(value: any): string {
    return String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

/**
 * Open a print-ready shipping waybill for the current order in a new window.
 */
function printWaybill() {
    const o = order.value;
    if (!o) {
        return;
    }

    const itemsRows = (o.items || []).map((it: any) => `
        <tr>
            <td>${escapeHtml(it.product_name)}</td>
            <td class="c">${escapeHtml(it.quantity)}</td>
            <td class="c">${escapeHtml(it.product_price)}</td>
            <td class="e">${escapeHtml(it.line_total)}</td>
        </tr>`).join('');

    const discountRow = Number(o.discount) > 0
        ? `<tr><td>الخصم${o.coupon_code ? ' (' + escapeHtml(o.coupon_code) + ')' : ''}</td><td class="e">- ${escapeHtml(o.discount)} ج.م</td></tr>`
        : '';

    const html = `<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<title>بوليصة شحن - ${escapeHtml(o.order_number)}</title>
<style>
    * { box-sizing: border-box; }
    body { font-family: "Segoe UI", Tahoma, Arial, sans-serif; color: #111; margin: 0; padding: 16px; }
    .sheet { max-width: 800px; margin: 0 auto; border: 2px solid #111; border-radius: 8px; padding: 16px; }
    .top { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #111; padding-bottom: 10px; margin-bottom: 12px; }
    .brand { font-size: 26px; font-weight: 800; }
    .logo { height: 56px; width: auto; max-width: 200px; object-fit: contain; margin-bottom: 4px; }
    .muted { color: #555; font-size: 13px; }
    .ordno { font-size: 20px; font-weight: 800; letter-spacing: 1px; }
    h3 { margin: 14px 0 6px; font-size: 15px; border-inline-start: 4px solid #111; padding-inline-start: 8px; }
    table { width: 100%; border-collapse: collapse; font-size: 14px; }
    .info td { padding: 6px 4px; vertical-align: top; }
    .info td.k { width: 130px; font-weight: 700; color: #333; }
    .items th, .items td { border: 1px solid #999; padding: 8px; }
    .items th { background: #f0f0f0; text-align: right; }
    .c { text-align: center; }
    .e { text-align: left; }
    .totals { margin-top: 10px; width: 320px; margin-inline-start: auto; }
    .totals td { padding: 5px 4px; }
    .totals .grand td { border-top: 2px solid #111; font-weight: 800; font-size: 17px; }
    .cod { margin-top: 14px; border: 2px dashed #111; padding: 10px; text-align: center; font-size: 18px; font-weight: 800; }
    .foot { margin-top: 22px; display: flex; justify-content: space-between; font-size: 13px; color: #333; }
    .foot div { border-top: 1px solid #999; padding-top: 6px; width: 45%; text-align: center; }
    @media print { body { padding: 0; } .sheet { border: none; } }
</style>
</head>
<body onload="window.print()">
    <div class="sheet">
        <div class="top">
            <div>
                <img src="${window.location.origin}/website/img/logo.png" alt="Pulse" class="logo" onerror="this.style.display='none'">
                <div class="muted">بوليصة شحن / Shipping Waybill</div>
            </div>
            <div style="text-align:left">
                <div class="ordno">${escapeHtml(o.order_number)}</div>
                <div class="muted">${escapeHtml(o.created_at)}</div>
            </div>
        </div>

        <h3>بيانات المستلم</h3>
        <table class="info">
            <tr><td class="k">الاسم</td><td>${escapeHtml(o.customer_name)}</td></tr>
            <tr><td class="k">رقم الهاتف</td><td>${escapeHtml(o.customer_phone)}</td></tr>
            <tr><td class="k">المحافظة</td><td>${escapeHtml(o.governorate_name)}</td></tr>
            <tr><td class="k">العنوان</td><td>${escapeHtml(o.address)}</td></tr>
        </table>

        <h3>المنتجات</h3>
        <table class="items">
            <thead>
                <tr><th>المنتج</th><th class="c">الكمية</th><th class="c">السعر</th><th class="e">الإجمالي</th></tr>
            </thead>
            <tbody>${itemsRows}</tbody>
        </table>

        <table class="totals">
            <tr><td>الإجمالي الفرعي</td><td class="e">${escapeHtml(o.subtotal)} ج.م</td></tr>
            ${discountRow}
            <tr><td>الشحن</td><td class="e">${escapeHtml(o.shipping_price)} ج.م</td></tr>
            <tr class="grand"><td>الإجمالي</td><td class="e">${escapeHtml(o.total)} ج.م</td></tr>
        </table>

        <div class="cod">
            طريقة الدفع: ${escapeHtml(o.payment_method_name || '—')} — المطلوب تحصيله: ${escapeHtml(o.total)} ج.م
        </div>

        <div class="foot">
            <div>توقيع المندوب</div>
        </div>
    </div>
</body>
</html>`;

    // Render into a hidden iframe so no blank popup window appears
    const existing = document.getElementById('waybill-print-frame');
    if (existing) {
        existing.remove();
    }

    const iframe = document.createElement('iframe');
    iframe.id = 'waybill-print-frame';
    iframe.style.cssText = 'position:fixed;right:0;bottom:0;width:0;height:0;border:0;';
    document.body.appendChild(iframe);

    const doc = iframe.contentWindow?.document;
    if (!doc) {
        iframe.remove();
        return;
    }

    iframe.contentWindow?.addEventListener('afterprint', () => {
        setTimeout(() => iframe.remove(), 300);
    });

    doc.open();
    doc.write(html);
    doc.close();
}

async function saveStatus() {
    if (!order.value) return;
    savingStatus.value = true;
    try {
        const response = await axios.patch(`/orders/${order.value.id}/status`, { status: statusToSave.value });
        order.value = response.data.data;
        (window as any).showSuccessToast?.('Order status updated');
    } catch (error) {
        (window as any).showErrorToast?.('Failed to update status');
    } finally {
        savingStatus.value = false;
    }
}

onMounted(fetchOrder);
</script>
