<template>

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
<!--        <a href="/dash" class="header-logo">-->
<!--            <img src="../../images/website/logo.png" alt="Pulse Logo" class="desktop-logo" style="max-height: 45px; width: auto;">-->
<!--            <img src="../../images/website/logo.png" alt="Pulse Logo" class="toggle-logo" style="max-height: 35px; width: auto;">-->
<!--            <img src="../../images/website/logo.png" alt="Pulse Logo" class="desktop-white" style="max-height: 45px; width: auto;">-->
<!--            <img src="../../images/website/logo.png" alt="Pulse Logo" class="toggle-white" style="max-height: 35px; width: auto;">-->
<!--        </a>-->
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" style="margin-block-start:0 !important; margin-top:0" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="20" height="20" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu mt-12">
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name mt-6">Main</span></li>
                <!-- End::slide__category -->


                <li class="slide">
                    <router-link to="/dash" class="side-menu__item">
                        <span class="me-2">
                              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                   fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                   stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </span>
                        <span class="side-menu__label">Index</span>
                    </router-link>
                </li>

                <li class="slide">
                    <router-link to="/dash/nationality" class="side-menu__item">
                        <span class="me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="icon icon-tabler icons-tabler-outline icon-tabler-brand-metabrainz">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M3 7v10l7 4v-18z"/>
                                <path d="M21 7v10l-7 4v-18z"/>
                            </svg>
                        </span>
                        <span class="side-menu__label">Nationalities</span>
                    </router-link>
                </li>

                <li class="slide">
                    <router-link to="/dash/services" class="side-menu__item">
                        <span class="me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-briefcase"><rect x="2" y="7" width="20"
                                                                                                 height="14" rx="2"
                                                                                                 ry="2"></rect><path
                                d="M16 7v-2a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"></path></svg>
                        </span>
                        <span class="side-menu__label">Services</span>
                    </router-link>
                </li>

                <li class="slide">
                    <router-link to="/dash/products" class="side-menu__item">
                        <span class="me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-package"><line x1="16.5" y1="9.4"
                                                                                               x2="7.5"
                                                                                               y2="4.21"></line><path
                                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline
                                points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12"
                                                                                        y2="12"></line></svg>
                        </span>
                        <span class="side-menu__label">Products</span>
                    </router-link>
                </li>

                <li class="slide">
                    <router-link to="/dash/sliders" class="side-menu__item">
                        <span class="me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18"
                                                                                             height="18" rx="2"
                                                                                             ry="2"></rect><circle
                                cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        </span>
                        <span class="side-menu__label">Sliders</span>
                    </router-link>
                </li>

                <li class="slide">
                    <router-link to="/dash/users" class="side-menu__item">
                        <span class="me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-users"><path
                                d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7"
                                                                                             r="4"></circle><path
                                d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        </span>
                        <span class="side-menu__label">Users</span>
                    </router-link>
                </li>

                <li class="slide">
                    <router-link to="/dash/settings" class="side-menu__item">
                        <span class="me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12"
                                                                                                   r="3"></circle><path
                                d="M12 1v6m0 6v6m6-6h6M1 12h6m4.2-6.8l4.2-4.2m0 16.2l-4.2-4.2m9.9-4.2l-4.2 4.2m-12-4.2l4.2 4.2"></path></svg>
                        </span>
                        <span class="side-menu__label">Settings</span>
                    </router-link>
                </li>

                <li class="slide">
                    <router-link to="/dash/contact-messages" class="side-menu__item">
                        <span class="me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-mail">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </span>
                        <span class="side-menu__label">Contact Messages</span>
                    </router-link>
                </li>

            </ul>
            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="20" height="20" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg>
            </div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->
</template>
<script setup lang="ts">
</script>
<style scoped>
.main-sidebar {
    margin-block-start: 0;
    padding-block-start: .5rem;
    padding-block-end: 5rem;
    height: 100vh;
    position: relative;
    overflow: auto;
}
</style>
