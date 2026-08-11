<template>
    <div class="text-start my-4">
        <router-link to="/dash/coupons" class="btn btn-secondary me-2 btn-b">
            <i class="las la-arrow-alt-circle-left"></i>
            Back
        </router-link>
    </div>
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">
                    Delete Coupon
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="hidden-columns_wrapper" class="dataTables_wrapper dt-bootstrap5">
                        <form class="container" @submit.prevent="handleDelete" v-if="!loading">
                            <div class="row">
                                <div class="col-12 my-4">
                                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                                        <div>
                                            Are you sure you want to delete <strong>{{ coupon?.code }}</strong>? This action cannot be undone.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center my-4">
                                    <button type="submit" class="btn btn-danger" :disabled="deleting">
                                        {{ deleting ? 'Deleting...' : 'Delete' }}
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div v-else class="text-center py-4">
                            <v-progress-circular indeterminate color="primary"></v-progress-circular>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useHead } from '@vueuse/head';
import { useCoupons } from '../../../../composables/useCoupons';

useHead({ title: 'Delete Coupon' });

const router = useRouter();
const route = useRoute();
const { delete: deleteCoupon, getCoupon, coupon } = useCoupons();

const loading = ref(true);
const deleting = ref(false);
const couponId = ref(Number(route.params.id));

const loadCoupon = async () => {
    try {
        loading.value = true;
        await getCoupon(couponId.value);
        if (!coupon.value) {
            window.showErrorToast?.('Coupon not found');
            await router.push('/dash/coupons');
        }
    } catch (error) {
        window.showErrorToast?.('Failed to load coupon');
        await router.push('/dash/coupons');
    } finally {
        loading.value = false;
    }
};

const handleDelete = async () => {
    deleting.value = true;
    try {
        await deleteCoupon(couponId.value);
        window.showSuccessToast?.('Coupon deleted successfully');
        await router.push('/dash/coupons');
    } catch (error: any) {
        window.showErrorToast?.(error?.response?.data?.message || 'Failed to delete coupon');
    } finally {
        deleting.value = false;
    }
};

onMounted(() => {
    loadCoupon();
});
</script>
