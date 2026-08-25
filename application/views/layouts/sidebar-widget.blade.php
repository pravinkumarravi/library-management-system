<div class="mx-auto mb-10 w-full max-w-60 rounded-2xl bg-gray-50 px-4 py-5 text-center dark:bg-white/[0.03]">
    <h3 class="mb-2 font-semibold text-gray-900 dark:text-white">
        {{ $site_name }}
    </h3>
    <p class="mb-4 text-gray-500 text-theme-sm dark:text-gray-400">
        @if($auth_user)
            {{ $auth_user['name'] }} · {{ $auth_user['username'] }}
        @else
            Library Management System
        @endif
    </p>
    <a href="{{ $base_url }}auth/logout"
        class="flex items-center justify-center gap-2 p-3 font-medium text-white rounded-lg bg-brand-500 text-theme-sm hover:bg-brand-600">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
        </svg>
        Sign Out
    </a>
</div>
