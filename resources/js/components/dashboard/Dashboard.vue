<template>
    <!-- Start::row-1 -->
    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                    <div class="col-xxl-3 col-lg-6 col-md-6">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex align-items-top justify-content-between">
                                    <div>
                                        <span class="avatar avatar-md avatar-rounded bg-primary">
                                            <i class="ti ti-users fs-16"></i>
                                        </span>
                                    </div>
                                    <div class="flex-fill ms-3">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                                            <div>
                                                <p class="text-muted mb-0">Total Users</p>
                                                <h4 class="fw-semibold mt-1">{{ stats.users || 0 }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-lg-6 col-md-6">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex align-items-top justify-content-between">
                                    <div>
                                        <span class="avatar avatar-md avatar-rounded bg-secondary">
                                            <i class="ti ti-briefcase fs-16"></i>
                                        </span>
                                    </div>
                                    <div class="flex-fill ms-3">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                                            <div>
                                                <p class="text-muted mb-0">Services</p>
                                                <h4 class="fw-semibold mt-1">{{ stats.services || 0 }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-lg-6 col-md-6">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex align-items-top justify-content-between">
                                    <div>
                                        <span class="avatar avatar-md avatar-rounded bg-success">
                                            <i class="ti ti-package fs-16"></i>
                                        </span>
                                    </div>
                                    <div class="flex-fill ms-3">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                                            <div>
                                                <p class="text-muted mb-0">Products</p>
                                                <h4 class="fw-semibold mt-1">{{ stats.products || 0 }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-lg-6 col-md-6">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex align-items-top justify-content-between">
                                    <div>
                                        <span class="avatar avatar-md avatar-rounded bg-info">
                                            <i class="ti ti-photo fs-16"></i>
                                        </span>
                                    </div>
                                    <div class="flex-fill ms-3">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                                            <div>
                                                <p class="text-muted mb-0">Sliders</p>
                                                <h4 class="fw-semibold mt-1">{{ stats.sliders || 0 }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <!-- End::row-1 -->

    <!-- Welcome Card -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Welcome to Pulse Dashboard</h5>
                    <p class="card-text">This is your dashboard overview. Use the sidebar to navigate through different sections.</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';

interface Stats {
    users: number;
    services: number;
    products: number;
    sliders: number;
}

const stats = ref<Stats>({
    users: 0,
    services: 0,
    products: 0,
    sliders: 0
});

onMounted(() => {
    // You can fetch real stats from your API here
    // For now, using placeholder values
    stats.value = {
        users: 0,
        services: 0,
        products: 0,
        sliders: 0
    };
});
</script>

<style scoped>
.card {
    margin-bottom: 1rem;
}
</style>

