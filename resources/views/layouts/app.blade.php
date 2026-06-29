{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Clinic System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .sidebar-scroll::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: #1e293b;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 10px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        #sidebar {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1),
                transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            width: 288px;
            overflow: hidden;
            white-space: nowrap;
        }

        #sidebar.collapsed {
            width: 70px;
        }

        /* Mobile: slide in/out */
        @media (max-width: 1023px) {
            #sidebar {
                width: 288px !important;
                transform: translateX(-100%);
            }

            #sidebar.mobile-open {
                transform: translateX(0);
            }
        }

        #main-content {
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-left: 288px;
        }

        #main-content.expanded {
            margin-left: 0px;
        }

        @media (max-width: 1023px) {
            #main-content {
                margin-left: 0 !important;
            }
        }

        .sidebar-overlay {
            transition: opacity 0.3s ease;
        }

        /* Toggle button */
        #toggle-sidebar {
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 50;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(30, 41, 59, 0.9);
            border: 1px solid #334155;
            border-radius: 8px;
            color: #94a3b8;
            cursor: pointer;
            transition: all 0.2s;
        }

        #toggle-sidebar:hover {
            background: #334155;
            color: #fff;
        }

        /* Hide toggle on desktop when sidebar open (it's inside sidebar header) */
        @media (min-width: 1024px) {
            #toggle-sidebar-float {
                display: none;
            }

            #sidebar:not(.collapsed)~* #toggle-sidebar-float,
            body:not(.sidebar-collapsed) #toggle-sidebar-float {
                display: none;
            }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 min-h-screen">

    {{-- Mobile Header --}}
    <div class="lg:hidden fixed top-0 left-0 right-0 bg-slate-900/95 backdrop-blur-md border-b border-slate-700 z-30 flex items-center justify-between px-4 py-3">
        <button id="mobile-menu-btn" class="p-2 rounded-lg hover:bg-slate-800 transition">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center font-bold text-sm text-white">+</div>
            <h1 class="text-lg font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">Clinic System</h1>
        </div>
        <div class="w-8"></div>
    </div>


    {{-- Mobile Overlay --}}
    <div id="sidebar-overlay" class="sidebar-overlay fixed inset-0 bg-black/50 backdrop-blur-sm z-40 hidden lg:hidden"></div>

    {{-- Sidebar --}}
    <aside id="sidebar" class="fixed top-0 left-0 h-full bg-gradient-to-b from-slate-900 to-slate-800 border-r border-slate-700 z-50 flex flex-col">

        {{-- Sidebar Header with toggle --}}
        <div class="flex items-center gap-3 px-4 py-5 border-b border-slate-700">
            {{-- Toggle button (desktop) --}}
            <button id="toggle-sidebar-desktop" title="Toggle sidebar"
                class="hidden lg:flex w-8 h-8 rounded-lg hover:bg-slate-700 transition items-center justify-center text-slate-400 hover:text-white flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <div class="sidebar-text flex items-center gap-3 overflow-hidden">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center font-bold text-lg shadow-lg text-white flex-shrink-0">+</div>
                <div>
                    <h1 class="text-base font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent leading-tight">Clinic System</h1>
                    <p class="text-xs text-slate-400">Healthcare Management</p>
                </div>
            </div>
        </div>

        {{-- User Profile --}}
        @auth
        <div class="px-4 py-4 border-b border-slate-700">
            <div class="flex items-center gap-3">
                <div class="relative flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-base shadow-lg">
                        {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                    </div>
                    <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 rounded-full border-2 border-slate-800"></div>
                </div>
                <div class="sidebar-text flex-1 min-w-0 overflow-hidden">
                    <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>
        @endauth

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5 sidebar-scroll overflow-y-auto overflow-x-hidden">

            {{-- Notifications --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                    class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all duration-200 w-full">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="sidebar-text text-sm font-medium">Notifications</span>
                    <span id="notification-count" class="sidebar-text ml-auto text-xs bg-red-500 text-white px-2 py-0.5 rounded-full hidden"></span>
                </button>
                <div x-show="open" @click.outside="open = false"
                    class="absolute left-0 mt-1 w-80 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl z-50 overflow-hidden"
                    style="display: none;">
                    <div class="flex items-center justify-between px-4 py-3 border-b border-slate-700">
                        <span class="text-sm font-semibold text-white">Notifications</span>
                        <button id="mark-all-read" class="text-xs text-blue-400 hover:text-blue-300 transition">Mark all read</button>
                    </div>
                    <div id="notification-list" class="max-h-80 overflow-y-auto divide-y divide-slate-700">
                        <div id="no-notifications" class="px-4 py-6 text-center text-slate-400 text-sm">No notifications</div>
                    </div>
                </div>
            </div>

            @can('view users')
            <a href="{{ route('users.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all duration-200">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="sidebar-text text-sm font-medium">Users</span>
            </a>
            @endcan

            @can('view roles')
            <a href="{{ route('roles.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all duration-200">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a1 1 0 00-1 1v2H7a2 2 0 00-2 2v3H3v2h2v3a2 2 0 002 2h3v2a1 1 0 001 1h2a1 1 0 001-1v-2h3a2 2 0 002-2v-3h2v-2h-2V9a2 2 0 00-2-2h-3V5a1 1 0 00-1-1h-2z" />
                </svg>
                <span class="sidebar-text text-sm font-medium">Roles</span>
            </a>
            @endcan

            @can('view dashboard')
            <a href="{{ route('dashboard') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all duration-200">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="sidebar-text text-sm font-medium">Dashboard</span>
            </a>
            @endcan

            @can('view patients')
            <a href="{{ route('patients.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all duration-200">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span class="sidebar-text text-sm font-medium">Patients</span>
                @php $patientCount = \App\Models\Patient::count(); @endphp
                @if($patientCount > 0)
                <span class="sidebar-text ml-auto text-xs bg-slate-700 text-slate-300 px-2 py-0.5 rounded-full">{{ $patientCount }}</span>
                @endif
            </a>
            @endcan

            @can('view doctors')
            <a href="{{ route('doctors.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all duration-200">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <span class="sidebar-text text-sm font-medium">Doctors</span>
            </a>
            @endcan

            @can('view appointments')
            <a href="{{ route('appointments.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all duration-200">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="sidebar-text text-sm font-medium">Appointments</span>
                @php $pendingCount = \App\Models\Appointment::where('status', 'pending')->count(); @endphp
                @if($pendingCount > 0)
                <span class="sidebar-text ml-auto text-xs bg-red-500/20 text-red-400 px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                @endif
            </a>
            @endcan

            @can('view medical-records')
            <a href="{{ route('medical-records.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all duration-200">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="sidebar-text text-sm font-medium">Medical Records</span>
            </a>
            @endcan

            @can('view activity-logs')
            <a href="{{ route('activity-logs.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all duration-200">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6m3 6V7m3 10v-4m3 8H6a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2v14a2 2 0 01-2 2z" />
                </svg>
                <span class="sidebar-text text-sm font-medium">Activity Logs</span>
            </a>
            @endcan

            @can('view payments')
            <a href="{{ route('payments.index') }}"
                class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all duration-200">

                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 9V7a5 5 0 00-10 0v2M5 9h14l-1 10H6L5 9zm4 4h6" />
                </svg>

                <span class="sidebar-text text-sm font-medium">Payments</span>
            </a>
            @endcan

            <div class="my-3 border-t border-slate-700/60"></div>

            <!-- <a href="#" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all duration-200">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94-1.543.826-3.31-2.37-2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="sidebar-text text-sm font-medium">Settings</span>
            </a> -->
        </nav>

        {{-- Footer / Logout --}}
        <div class="p-3 border-t border-slate-700 bg-slate-800/50 flex-shrink-0">
            @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-all duration-200">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span class="sidebar-text text-sm font-medium">Logout</span>
                </button>
            </form>
            @else
            <div class="space-y-2">
                <a href="{{ route('login') }}" class="sidebar-text w-full flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 transition text-sm font-medium text-white">Login</a>
                <a href="{{ route('register') }}" class="sidebar-text w-full flex items-center justify-center gap-2 px-4 py-2 rounded-xl border border-slate-600 hover:bg-slate-700 transition text-sm font-medium text-slate-300">Register</a>
            </div>
            @endauth
        </div>
    </aside>

    {{-- Main Content --}}
    <main id="main-content" class="min-h-screen">
        <div class="pt-16 lg:pt-0">
            @yield('content')
        </div>
    </main>

    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const overlay = document.getElementById('sidebar-overlay');
        const sidebarTexts = document.querySelectorAll('.sidebar-text');

        // ── Desktop toggle ──
        const desktopBtn = document.getElementById('toggle-sidebar-desktop');
        let collapsed = false;

        function collapseDesktop() {
            collapsed = true;
            sidebar.classList.add('collapsed');
            mainContent.style.marginLeft = '0';
            sidebarTexts.forEach(el => el.style.display = 'none');
        }

        function expandDesktop() {
            collapsed = false;
            sidebar.classList.remove('collapsed');
            mainContent.style.marginLeft = '288px';
            sidebarTexts.forEach(el => el.style.display = '');
        }

        if (desktopBtn) {
            desktopBtn.addEventListener('click', () => {
                collapsed ? expandDesktop() : collapseDesktop();
            });
        }

        // ── Mobile toggle ──
        const mobileBtn = document.getElementById('mobile-menu-btn');

        function openMobile() {
            sidebar.classList.add('mobile-open');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeMobile() {
            sidebar.classList.remove('mobile-open');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        if (mobileBtn) mobileBtn.addEventListener('click', openMobile);
        if (overlay) overlay.addEventListener('click', closeMobile);

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeMobile();
        });

        // ── Active link ──
        const currentPath = window.location.pathname;
        document.querySelectorAll('.nav-link').forEach(link => {
            const href = link.getAttribute('href');
            if (href && href !== '#' && currentPath.startsWith(href)) {
                link.classList.add('bg-gradient-to-r', 'from-blue-500/20', 'to-purple-500/20', 'text-white', 'border', 'border-blue-500/30');
                link.classList.remove('text-slate-300');
            }
        });
    </script>

    @auth
    <script>
        const notificationCount = document.getElementById('notification-count');
        const notificationList = document.getElementById('notification-list');
        const markAllRead = document.getElementById('mark-all-read');
        let notifications = [];

        fetch('/notifications')
            .then(r => r.json())
            .then(data => {
                notifications = data.map(item => ({
                    id: item.id,
                    title: item.data.title,
                    message: item.data.message,
                    time: new Date(item.created_at).toLocaleString(),
                    read: item.read_at !== null
                }));
                renderNotifications();
            });

        function renderNotifications() {
            const unread = notifications.filter(n => !n.read);
            if (unread.length > 0) {
                notificationCount.textContent = unread.length;
                notificationCount.classList.remove('hidden');
            } else {
                notificationCount.classList.add('hidden');
            }

            if (notifications.length === 0) {
                notificationList.innerHTML = '<div class="px-4 py-6 text-center text-slate-400 text-sm">No notifications</div>';
                return;
            }

            notificationList.innerHTML = notifications.map(n => `
                <div class="px-4 py-3 hover:bg-slate-700/50 transition cursor-pointer ${n.read ? 'opacity-60' : ''}" data-id="${n.id}">
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0 ${n.read ? 'bg-slate-600' : 'bg-blue-400'}"></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-white font-medium truncate">${n.title}</p>
                            <p class="text-xs text-slate-400 mt-0.5">${n.message}</p>
                            <p class="text-xs text-slate-500 mt-1">${n.time}</p>
                        </div>
                    </div>
                </div>
            `).join('');

            notificationList.querySelectorAll('[data-id]').forEach(el => {
                el.addEventListener('click', () => {
                    const id = el.dataset.id;
                    notifications = notifications.map(n => n.id == id ? {
                        ...n,
                        read: true
                    } : n);
                    renderNotifications();
                });
            });
        }

        if (markAllRead) {
            markAllRead.addEventListener('click', () => {
                notifications = notifications.map(n => ({
                    ...n,
                    read: true
                }));
                renderNotifications();
            });
        }

        @if(class_exists('\App\Models\User') && auth() -> check())
        window.Echo.private(`App.Models.User.{{ auth()->id() }}`)
            .notification(notification => {
                notifications.unshift({
                    id: Date.now(),
                    title: notification.title ?? 'New Notification',
                    message: notification.message ?? '',
                    time: 'Just now',
                    read: false
                });
                renderNotifications();
            });
        @endif
    </script>
    @endauth

</body>

</html>