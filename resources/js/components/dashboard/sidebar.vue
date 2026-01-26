<template>

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="" class="header-logo">
            <img src="../../images/brand-logos/desktop-logo.svg" alt="logo" class="desktop-logo">
            <img src="../../images/brand-logos/desktop-logo.svg" alt="logo" class="toggle-logo">
            <img src="../../images/brand-logos/desktop-logo.svg" alt="logo" class="desktop-white">
            <img src="../../images/brand-logos/desktop-logo.svg" alt="logo" class="toggle-white">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="20" height="20" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Main</span></li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
                <li class="slide">
                    <router-link to="/" class="side-menu__item">
                             <span class="me-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none"/>
                            <path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/>
                            <path
                                d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/>
                        </svg>
                        <span class="side-menu__label">Index</span>
                             </span>
                    </router-link>
                </li>

                <li class="slide">
                    <router-link to="/dash/nationality" class="side-menu__item">
                        <span class="me-2">
<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
     class="icon icon-tabler icons-tabler-outline icon-tabler-brand-metabrainz"><path stroke="none" d="M0 0h24v24H0z"
                                                                                      fill="none"/><path
    d="M3 7v10l7 4v-18z"/><path d="M21 7v10l-7 4v-18z"/></svg>
                        </span>
                        <span class="side-menu__label">Nationalities</span>
                    </router-link>
                </li>

                <li class="slide">
                    <router-link to="/dash/services" class="side-menu__item">
                        <span class="me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 7v-2a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"></path></svg>
                        </span>
                        <span class="side-menu__label">Services</span>
                    </router-link>
                </li>

                <li class="slide">
                    <router-link to="/users" class="side-menu__item">
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
import {ref} from 'vue'

const activeItem = ref('index')
const selectActiveItem = (item: string) => {
    if (activeItem.value === item) {
        activeItem.value = ''
        return
    }
    activeItem.value = item
}
</script>
