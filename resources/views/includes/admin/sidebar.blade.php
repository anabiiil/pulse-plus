<!-- Start::app-sidebar -->
<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="#" class="header-logo">
            <img src="{{ asset('../assets/images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
            <img src="{{ asset('../assets/images/brand-logos/toggle-logo.png') }}" alt="logo" class="toggle-logo">
            <img src="{{ asset('../assets/images/brand-logos/desktop-dark.png') }}" alt="logo" class="desktop-dark">
            <img src="{{ asset('../assets/images/brand-logos/toggle-dark.png') }}" alt="logo" class="toggle-dark">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Dashboard</span></li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
                <li class="slide">

                    <a href="{{ route('admin.home') }}"
                       class="side-menu__item @if(request()->route()->uri == 'admin') active @endif">
                        <i class="bx bx-home side-menu__icon"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>


                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item ">
                        <i class="bx bxs-shopping-bag side-menu__icon"></i>
                        <span class="side-menu__label">General

                        </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1"
                        style="position: relative; left: 0px; top: 0px; margin: 0px; transform: translate(120px, 572px); display: none; box-sizing: border-box;"
                        data-popper-placement="bottom">

                        <li class="slide">
                            <a href="{{ route('admin.country') }}" class="side-menu__item">

                                <span class="side-menu__label">

                                    Countries

                                </span>
                            </a>
                        </li>


                        {{-- <li class="slide">--}}
                        {{-- <a href="{{ route('admin.nationality') }}" class="side-menu__item">--}}

                        {{-- <span class="side-menu__label">--}}

                        {{-- Nationalities--}}

                        {{-- </span>--}}
                        {{-- </a>--}}
                        {{-- </li>--}}

                        <li class="slide">
                            <a href="{{ route('admin.seasons.index') }}" class="side-menu__item">

                                <span class="side-menu__label">

                                    Seasons

                                </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ route('admin.instructions.index') }}" class="side-menu__item">

                                <span class="side-menu__label">

                                    Instructions

                                </span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.calculate-point.index') }}" class="side-menu__item">

                                <span class="side-menu__label">
                                    Calculate Points
                                </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ route('admin.stadiums.index') }}" class="side-menu__item">

                                <span class="side-menu__label">

                                    Stadiums

                                </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ route('admin.static_pages.index') }}" class="side-menu__item">

                                <span class="side-menu__label">

                                    Static Pages

                                </span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.sliders.index') }}" class="side-menu__item">

                                <span class="side-menu__label">

                                    Sliders

                                </span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.on_boarding.index') }}" class="side-menu__item">

                                <span class="side-menu__label">

                                    Onboardings

                                </span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="fas fa-user-lock side-menu__icon"></i>

                        <span class="side-menu__label">Admins

                        </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>

                    </a>
                    <ul class="slide-menu child1"
                        style="position: relative; left: 0px; top: 0px; margin: 0px; transform: translate(120px, 572px); display: none; box-sizing: border-box;"
                        data-popper-placement="bottom">

                        <li class="slide">
                            <a href="{{ route('admin.admins.index') }}" class="side-menu__item">

                                <span class="side-menu__label">

                                    Admins

                                </span>
                            </a>
                        </li>


                    </ul>
                </li>

                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="fa fa-users side-menu__icon" aria-hidden="true"></i>


                        <span class="side-menu__label">Users

                        </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>

                    </a>
                    <ul class="slide-menu child1"
                        style="position: relative; left: 0px; top: 0px; margin: 0px; transform: translate(120px, 572px); display: none; box-sizing: border-box;"
                        data-popper-placement="bottom">

                        <li class="slide">
                            <a href="{{ route('admin.users.index') }}" class="side-menu__item">

                                <span class="side-menu__label">

                                    Users

                                </span>
                            </a>
                        </li>


                    </ul>
                </li>
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="bx bx-group side-menu__icon"></i>
                        <span class="side-menu__label">Players

                        </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1"
                        style="position: relative; left: 0px; top: 0px; margin: 0px; transform: translate(120px, 572px); display: none; box-sizing: border-box;"
                        data-popper-placement="bottom">

                        <li class="slide">
                            <a href="{{ route('admin.player.index') }}" class="side-menu__item">

                                <span class="side-menu__label">

                                    Players

                                </span>
                            </a>
                        </li>


                    </ul>
                </li>

                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="fas fa-layer-group side-menu__icon"></i>
                        <span class="side-menu__label">Clubs

                        </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>

                    </a>
                    <ul class="slide-menu child1"
                        style="position: relative; left: 0px; top: 0px; margin: 0px; transform: translate(120px, 572px); display: none; box-sizing: border-box;"
                        data-popper-placement="bottom">

                        <li class="slide">
                            <a href="{{ route('admin.clubs.index') }}" class="side-menu__item">

                                <span class="side-menu__label">

                                    All

                                </span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ route('admin.coaches') }}" class="side-menu__item">

                                <span class="side-menu__label">

                                    Coaches

                                </span>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="fas fa-globe side-menu__icon"></i>
                        <span class="side-menu__label">Nations
                            <i class="fa-solid fa-people-group"></i>
                        </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>

                    </a>
                    <ul class="slide-menu child1"
                        style="position: relative; left: 0px; top: 0px; margin: 0px; transform: translate(120px, 572px); display: none; box-sizing: border-box;"
                        data-popper-placement="bottom">

                        <li class="slide">
                            <a href="{{ route('admin.clubs.index.nations') }}" class="side-menu__item">

                                <span class="side-menu__label">

                                    All

                                </span>
                            </a>
                        </li>


                    </ul>
                </li>
                {{-- <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="fas fa-layer-group side-menu__icon"></i>
                        <span class="side-menu__label">international

                        </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>

                    </a>
                    <ul class="slide-menu child1" style="position: relative; left: 0px; top: 0px; margin: 0px; transform: translate(120px, 572px); display: none; box-sizing: border-box;" data-popper-placement="bottom">
                        <li class="slide">
                            <a href="{{ route('admin.clubs.index') }}" class="side-menu__item">
                                <span class="side-menu__label">All</span>
                            </a>
                        </li>
                    </ul>
                </li> --}}

                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="fas fa-sort-amount-up-alt side-menu__icon"></i>

                        <span class="side-menu__label">Leagues

                        </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>

                    </a>
                    <ul class="slide-menu child1"
                        style="position: relative; left: 0px; top: 0px; margin: 0px; transform: translate(120px, 572px); display: none; box-sizing: border-box;"
                        data-popper-placement="bottom">

                        <li class="slide">
                            <a href="{{ route('admin.leagues.index') }}" class="side-menu__item">

                                <span class="side-menu__label">

                                    All

                                </span>
                            </a>
                        </li>


                    </ul>
                </li>

                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="fas fa-calendar-week side-menu__icon"></i>

                        <span class="side-menu__label">Competitions

                        </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>

                    </a>
                    <ul class="slide-menu child1"
                        style="position: relative; left: 0px; top: 0px; margin: 0px; transform: translate(120px, 572px); display: none; box-sizing: border-box;"
                        data-popper-placement="bottom">

                        <li class="slide">
                            <a href="{{ route('admin.competitions.index') }}" class="side-menu__item">

                                <span class="side-menu__label">
                                    Competitions
                                </span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.competition_weeks.index') }}" class="side-menu__item">

                                <span class="side-menu__label">
                                    Competition Weeks
                                </span>
                            </a>
                        </li>


                    </ul>
                </li>

                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="fas fa-sort-amount-up-alt side-menu__icon"></i>
                        <span class="side-menu__label">Fixtures

                        </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1"
                        style="position: relative; left: 0px; top: 0px; margin: 0px; transform: translate(120px, 572px); display: none; box-sizing: border-box;"
                        data-popper-placement="bottom">

                        <li class="slide">
                            <a href="{{ route('admin.fixtures.index') }}" class="side-menu__item">

                                <span class="side-menu__label">

                                    Fixtures

                                </span>
                            </a>
                        </li>


                    </ul>
                </li>


                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="fas fa-icons  side-menu__icon"></i>
                        <span class="side-menu__label">Icons

                        </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1"
                        style="position: relative; left: 0px; top: 0px; margin: 0px; transform: translate(120px, 572px); display: none; box-sizing: border-box;"
                        data-popper-placement="bottom">

                        <li class="slide">
                            <a href="{{ route('admin.icon_categories.index') }}" class="side-menu__item">
                                <span class="side-menu__label">
                                    Icon Categories
                                </span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.icons.index') }}" class="side-menu__item">
                                <span class="side-menu__label">
                                    Icons
                                </span>
                            </a>
                        </li>


                    </ul>
                </li>


                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="fas fa-icons  side-menu__icon"></i>
                        <span class="side-menu__label">Notifications Center

                        </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1"
                        style="position: relative; left: 0px; top: 0px; margin: 0px; transform: translate(120px, 572px); display: none; box-sizing: border-box;"
                        data-popper-placement="bottom">

                        <li class="slide">
                            <a href="{{ route('admin.notifications') }}" class="side-menu__item">
                                <span class="side-menu__label">
                                    Send Notification
                                </span>
                            </a>
                        </li>


                    </ul>
                </li>

                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="fas fa-icons  side-menu__icon"></i>
                        <span class="side-menu__label">Backups

                        </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1"
                        style="position: relative; left: 0px; top: 0px; margin: 0px; transform: translate(120px, 572px); display: none; box-sizing: border-box;"
                        data-popper-placement="bottom">

                        <li class="slide">
                            <a href="{{ url('admin/backups') }}" class="side-menu__item">
                                <span class="side-menu__label">
                                    Backup List
                                </span>
                            </a>
                        </li>



                    </ul>
                </li>


            </ul>
            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg>
            </div>


        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
