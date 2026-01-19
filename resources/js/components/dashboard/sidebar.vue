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
                                 <!--                        <span class="badge bg-success ms-auto menu-badge">1</span>-->
                             </span>
                    </router-link>
                </li>

                <li class="slide has-sub mb-1" :class="activeItem == 'general' ? 'active  open' : ''">
                    <a href="#" class="side-menu__item" @click.prevent="selectActiveItem('general')">
                        <span class="me-2">
<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
     class="icon icon-tabler icons-tabler-outline icon-tabler-brand-metabrainz"><path stroke="none" d="M0 0h24v24H0z"
                                                                                      fill="none"/><path
    d="M3 7v10l7 4v-18z"/><path d="M21 7v10l-7 4v-18z"/></svg>
                        </span>
                        <span class="side-menu__label">General</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1" :class="activeItem == 'general' ? 'active d-block' : ''">
                        <li class="slide">
                            <router-link to="/dash/calculation-points" class="side-menu__item">
                                <span class="side-menu__label">Calculation Points</span>
                                <!--                                                        <span class="badge bg-success ms-auto menu-badge">1</span>-->
                            </router-link>
                        </li>

                        <li class="slide">
                            <router-link to="/dash/coaches" class="side-menu__item">
                                <span class="side-menu__label">Coaches</span>
                                <!--                                                        <span class="badge bg-success ms-auto menu-badge">1</span>-->
                            </router-link>
                        </li>

                        <li class="slide">
                            <router-link to="/dash/slider" class="side-menu__item">
                                <span class="side-menu__label">Slider</span>
                                <!--                                                        <span class="badge bg-success ms-auto menu-badge">1</span>-->
                            </router-link>
                        </li>

                        <li class="slide">
                            <router-link to="/dash/country" class="side-menu__item">
                                <span class="side-menu__label">Countries</span>
                                <!--                        <span class="badge bg-success ms-auto menu-badge">1</span>-->
                            </router-link>
                        </li>


                    </ul>
                </li>


                <li class="slide">
                    <router-link to="/dash/employees" class="side-menu__item">
                             <span class="me-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="icon icon-tabler icons-tabler-outline icon-tabler-user-cog">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"/>
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h2.5"/>
                            <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/>
                            <path d="M19.001 15.5v1.5"/>
                            <path d="M19.001 21v1.5"/>
                            <path d="M22.032 17.25l-1.299 .75"/>
                            <path d="M17.27 20l-1.3 .75"/>
                            <path d="M15.97 17.25l1.3 .75"/>
                            <path d="M20.733 20l1.3 .75"/>
                        </svg>
                             </span>
                        <span class="side-menu__label">Employees</span>
                        <!--                        <span class="badge bg-success ms-auto menu-badge">1</span>-->
                    </router-link>
                </li>

                <li class="slide">
                    <router-link to="/dash/competitions" class="side-menu__item">
                             <span class="me-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-month"><path
                            stroke="none" d="M0 0h24v24H0z" fill="none"/><path
                            d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"/><path
                            d="M16 3v4"/><path d="M8 3v4"/><path d="M4 11h16"/><path d="M7 14h.013"/><path
                            d="M10.01 14h.005"/><path d="M13.01 14h.005"/><path d="M16.015 14h.005"/><path
                            d="M13.015 17h.005"/><path d="M7.01 17h.005"/><path d="M10.01 17h.005"/></svg>
                             </span>
                        <span class="side-menu__label">Competitions</span>
                        <!--                        <span class="badge bg-success ms-auto menu-badge">1</span>-->
                    </router-link>
                </li>


                <li class="slide">
                    <router-link to="/dash/clubs" class="side-menu__item">
                             <span class="me-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                       stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                       class="icon icon-tabler icons-tabler-outline icon-tabler-ball-football"><path stroke="none"
                                                                                                     d="M0 0h24v24H0z"
                                                                                                     fill="none"/><path
                      d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/><path
                      d="M12 7l4.76 3.45l-1.76 5.55h-6l-1.76 -5.55z"/><path
                      d="M12 7v-4m3 13l2.5 3m-.74 -8.55l3.74 -1.45m-11.44 7.05l-2.56 2.95m.74 -8.55l-3.74 -1.45"/></svg>
                             </span>
                        <span class="side-menu__label">Clubs</span>
                        <!--                        <span class="badge bg-success ms-auto menu-badge">1</span>-->
                    </router-link>
                </li>


                <li class="slide">
                    <router-link to="/dash/national-teams" class="side-menu__item">
                             <span class="me-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                       stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                       class="icon icon-tabler icons-tabler-outline icon-tabler-ball-football"><path stroke="none"
                                                                                                     d="M0 0h24v24H0z"
                                                                                                     fill="none"/><path
                      d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/><path
                      d="M12 7l4.76 3.45l-1.76 5.55h-6l-1.76 -5.55z"/><path
                      d="M12 7v-4m3 13l2.5 3m-.74 -8.55l3.74 -1.45m-11.44 7.05l-2.56 2.95m.74 -8.55l-3.74 -1.45"/></svg>
                             </span>
                        <span class="side-menu__label">National Teams</span>
                        <!--                        <span class="badge bg-success ms-auto menu-badge">1</span>-->
                    </router-link>
                </li>

                <li class="slide">
                    <router-link to="/dash/players" class="side-menu__item">
                             <span class="me-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                       stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                       class="icon icon-tabler icons-tabler-outline icon-tabler-play-basketball"><path stroke="none"
                                                                                                       d="M0 0h24v24H0z"
                                                                                                       fill="none"/><path
                      d="M10 4a1 1 0 1 0 2 0a1 1 0 0 0 -2 0"/><path d="M5 21l3 -3l.75 -1.5"/><path
                      d="M14 21v-4l-4 -3l.5 -6"/><path d="M5 12l1 -3l4.5 -1l3.5 3l4 1"/><path
                      d="M18.5 16a.5 .5 0 1 0 0 -1a.5 .5 0 0 0 0 1z" fill="currentColor"/></svg>
                             </span>
                        <span class="side-menu__label">Players</span>
                        <!--                        <span class="badge bg-success ms-auto menu-badge">1</span>-->
                    </router-link>
                </li>


                <li class="slide">
                    <router-link to="/dash/onboarding" class="side-menu__item">
                             <span class="me-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                             fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-circles"><path
                            stroke="none" d="M0 0h24v24H0z" fill="none"/><path
                            d="M6.5 12a5 5 0 1 1 -4.995 5.217l-.005 -.217l.005 -.217a5 5 0 0 1 4.995 -4.783z"/><path
                            d="M17.5 12a5 5 0 1 1 -4.995 5.217l-.005 -.217l.005 -.217a5 5 0 0 1 4.995 -4.783z"/><path
                            d="M12 2a5 5 0 1 1 -4.995 5.217l-.005 -.217l.005 -.217a5 5 0 0 1 4.995 -4.783z"/></svg>
                             </span>
                        <span class="side-menu__label">Onboarding</span>
                        <!--                        <span class="badge bg-success ms-auto menu-badge">1</span>-->
                    </router-link>
                </li>

                <li class="slide">
                    <router-link to="/dash/ranking" class="side-menu__item">
                             <span class="me-2">
                       <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-stars"><path stroke="none"
                                                                                                  d="M0 0h24v24H0z"
                                                                                                  fill="none"/><path
                           d="M17.8 19.817l-2.172 1.138a.392 .392 0 0 1 -.568 -.41l.415 -2.411l-1.757 -1.707a.389 .389 0 0 1 .217 -.665l2.428 -.352l1.086 -2.193a.392 .392 0 0 1 .702 0l1.086 2.193l2.428 .352a.39 .39 0 0 1 .217 .665l-1.757 1.707l.414 2.41a.39 .39 0 0 1 -.567 .411l-2.172 -1.138z"/><path
                           d="M6.2 19.817l-2.172 1.138a.392 .392 0 0 1 -.568 -.41l.415 -2.411l-1.757 -1.707a.389 .389 0 0 1 .217 -.665l2.428 -.352l1.086 -2.193a.392 .392 0 0 1 .702 0l1.086 2.193l2.428 .352a.39 .39 0 0 1 .217 .665l-1.757 1.707l.414 2.41a.39 .39 0 0 1 -.567 .411l-2.172 -1.138z"/><path
                           d="M12 9.817l-2.172 1.138a.392 .392 0 0 1 -.568 -.41l.415 -2.411l-1.757 -1.707a.389 .389 0 0 1 .217 -.665l2.428 -.352l1.086 -2.193a.392 .392 0 0 1 .702 0l1.086 2.193l2.428 .352a.39 .39 0 0 1 .217 .665l-1.757 1.707l.414 2.41a.39 .39 0 0 1 -.567 .411l-2.172 -1.138z"/></svg>
                             </span>
                        <span class="side-menu__label">Ranking</span>
                        <!--                        <span class="badge bg-success ms-auto menu-badge">1</span>-->
                    </router-link>
                </li>

                <li class="slide">
                    <router-link to="/dash/notifications" class="side-menu__item">
                             <span class="me-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="icon icon-tabler icons-tabler-outline icon-tabler-bell-plus"><path stroke="none"
                                                                                           d="M0 0h24v24H0z"
                                                                                           fill="none"/><path
                d="M12.5 17h-8.5a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6a2 2 0 1 1 4 0a7 7 0 0 1 4 6v1"/><path
                d="M9 17v1a3 3 0 0 0 3.51 2.957"/><path d="M16 19h6"/><path d="M19 16v6"/></svg>
                             </span>
                        <span class="side-menu__label">Notification Center</span>
                        <!--                        <span class="badge bg-success ms-auto menu-badge">1</span>-->
                    </router-link>
                </li>


                <li class="slide">
                    <router-link to="/dash/fixtures" class="side-menu__item">
                             <span class="me-2">
<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
     class="icon icon-tabler icons-tabler-outline icon-tabler-building-stadium"><path stroke="none" d="M0 0h24v24H0z"
                                                                                      fill="none"/><path
    d="M12 12m-8 0a8 2 0 1 0 16 0a8 2 0 1 0 -16 0"/><path
    d="M4 12v7c0 .94 2.51 1.785 6 2v-3h4v3c3.435 -.225 6 -1.07 6 -2v-7"/><path d="M15 6h4v-3h-4v7"/><path
    d="M7 6h4v-3h-4v7"/></svg>
                             </span>
                        <span class="side-menu__label">Fixtures</span>
                        <!--                        <span class="badge bg-success ms-auto menu-badge">1</span>-->
                    </router-link>
                </li>

                <li class="slide">
                    <router-link to="/dash/leagues" class="side-menu__item">
                             <span class="me-2">
<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
     class="icon icon-tabler icons-tabler-outline icon-tabler-trophy"><path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none"/><path d="M8 21l8 0"/><path
    d="M12 17l0 4"/><path d="M7 4l10 0"/><path d="M17 4v8a5 5 0 0 1 -10 0v-8"/><path
    d="M5 9m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/><path d="M19 9m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/></svg>
                             </span>
                        <span class="side-menu__label">Leagues</span>
                        <!--                        <span class="badge bg-success ms-auto menu-badge">1</span>-->
                    </router-link>
                </li>


                <li class="slide has-sub mb-1" :class="activeItem == 'users' ? 'active  open' : ''">
                    <a href="#" class="side-menu__item" @click.prevent="selectActiveItem('users')">
                        <span class="me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-users"><path
                                d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7"
                                                                                             r="4"></circle><path
                                d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        </span>
                        <span class="side-menu__label">Users</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1" :class="activeItem == 'users' ? 'active d-block' : ''">
                        <li class="slide">
                            <router-link to="/dash/users/new" class="side-menu__item">
                                <span class="side-menu__label">New Users</span>
                                <!--                                                        <span class="badge bg-success ms-auto menu-badge">1</span>-->
                            </router-link>
                        </li>

                        <li class="slide">
                            <router-link to="/dash/users/old" class="side-menu__item">
                                <span class="side-menu__label">Old Users</span>
                                <!--                                                        <span class="badge bg-success ms-auto menu-badge">1</span>-->
                            </router-link>
                        </li>

                    </ul>
                </li>


                <li class="slide has-sub mb-1" :class="activeItem == 'avatars' ? 'active  open' : ''">
                    <a href="#" class="side-menu__item" @click.prevent="selectActiveItem('avatars')">
                        <span class="me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-users"><path
                                d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7"
                                                                                             r="4"></circle><path
                                d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        </span>
                        <span class="side-menu__label">Avatars</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1" :class="activeItem == 'avatars' ? 'active d-block' : ''">

                        <li class="slide">
                            <router-link to="/dash/avatars-categories/leagues" class="side-menu__item">
                                <span class="side-menu__label">Leagues Avatars Categories</span>
                                <!--                                                        <span class="badge bg-success ms-auto menu-badge">1</span>-->
                            </router-link>
                        </li>
                        <!--                        <li class="slide">-->
                        <!--                            <router-link to="/dash/avatars/leagues" class="side-menu__item">-->
                        <!--                                <span class="side-menu__label">Leagues Avatars</span>-->
                        <!--                                &lt;!&ndash;                                                        <span class="badge bg-success ms-auto menu-badge">1</span>&ndash;&gt;-->
                        <!--                            </router-link>-->
                        <!--                        </li>-->


                        <li class="slide">
                            <router-link to="/dash/avatars-categories/avatars" class="side-menu__item">
                                <span class="side-menu__label">Users Avatars Categories</span>
                                <!--                                                        <span class="badge bg-success ms-auto menu-badge">1</span>-->
                            </router-link>
                        </li>
                        <!--                        <li class="slide">-->
                        <!--                            <router-link to="/dash/avatars/avatars" class="side-menu__item">-->
                        <!--                                <span class="side-menu__label">Users Avatars</span>-->
                        <!--                                &lt;!&ndash;                                                        <span class="badge bg-success ms-auto menu-badge">1</span>&ndash;&gt;-->
                        <!--                            </router-link>-->
                        <!--                        </li>-->


                    </ul>
                </li>


                <li class="slide">

                </li>
                <li class="slide">
                    <router-link to="/dash/backups" class="side-menu__item">
                        <span class="me-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="icon icon-tabler icons-tabler-outline icon-tabler-database-import"><path stroke="none"
                                                                                                 d="M0 0h24v24H0z"
                                                                                                 fill="none"/><path
                d="M4 6c0 1.657 3.582 3 8 3s8 -1.343 8 -3s-3.582 -3 -8 -3s-8 1.343 -8 3"/><path
                d="M4 6v6c0 1.657 3.582 3 8 3c.856 0 1.68 -.05 2.454 -.144m5.546 -2.856v-6"/><path
                d="M4 12v6c0 1.657 3.582 3 8 3c.171 0 .341 -.002 .51 -.006"/><path d="M19 22v-6"/><path
                d="M22 19l-3 -3l-3 3"/></svg>
                        </span>
                        <span class="side-menu__label">Backups</span>
                        <!--                        <span class="badge bg-success ms-auto menu-badge">1</span>-->
                    </router-link>
                </li>


                <li class="slide">
                    <router-link to="/dash/seasons" class="side-menu__item">
                        <span class="me-2">
         <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-clock-hour-10"><path stroke="none"
                                                                                            d="M0 0h24v24H0z"
                                                                                            fill="none"/><path
             d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/><path d="M12 12l-3 -2"/><path d="M12 7v5"/></svg>
                        </span>
                        <span class="side-menu__label">Seasons</span>
                        <!--                        <span class="badge bg-success ms-auto menu-badge">1</span>-->
                    </router-link>
                </li>


                <li class="slide">
                    <router-link to="/dash/translations" class="side-menu__item">
                        <span class="me-2">
<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
     class="icon icon-tabler icons-tabler-outline icon-tabler-language"><path stroke="none" d="M0 0h24v24H0z"
                                                                              fill="none"/><path d="M4 5h7"/><path
    d="M9 3v2c0 4.418 -2.239 8 -5 8"/><path d="M5 9c0 2.144 2.952 3.908 6.7 4"/><path d="M12 20l4 -9l4 9"/><path
    d="M19.1 18h-6.2"/></svg>
                        </span>
                        <span class="side-menu__label">Translations</span>
                        <!--                        <span class="badge bg-success ms-auto menu-badge">1</span>-->
                    </router-link>
                </li>


                <!-- End::slide -->
                <!-- Start::slide -->

                <!-- End::slide -->

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
