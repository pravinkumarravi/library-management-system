@extends('layouts.app')

@section('page_title', 'Dashboard')
@section('title', 'Dashboard')

@section('content')
    <!-- ===== Metric Cards ===== -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4 md:gap-6">
        <!-- Books -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
            <div class="flex items-center justify-center w-12 h-12 bg-gray-100 rounded-xl dark:bg-gray-800">
                <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 2H6C4.9 2 4 2.9 4 4V20C4 21.1 4.9 22 6 22H18C19.1 22 20 21.1 20 20V4C20 2.9 19.1 2 18 2ZM6 4H11V12L8.5 10.5L6 12V4Z" fill="" />
                </svg>
            </div>
            <div class="flex items-end justify-between mt-5">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Books</span>
                    <h4 class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90">{{ $total_books }}</h4>
                </div>
                <span class="flex items-center gap-1 rounded-full bg-success-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">
                    <svg class="fill-current" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.56462 1.62393C5.70193 1.47072 5.90135 1.37432 6.12329 1.37432C6.1236 1.37432 6.12391 1.37432 6.12422 1.37432C6.31631 1.37415 6.50845 1.44731 6.65505 1.59381L9.65514 4.5918C9.94814 4.88459 9.94831 5.35947 9.65552 5.65246C9.36273 5.94546 8.88785 5.94562 8.59486 5.65283L6.87329 3.93247L6.87329 10.125C6.87329 10.5392 6.53751 10.875 6.12329 10.875C5.70908 10.875 5.37329 10.5392 5.37329 10.125L5.37329 3.93578L3.65516 5.65282C3.36218 5.94562 2.8873 5.94547 2.5945 5.65248C2.3017 5.35949 2.30185 4.88462 2.59484 4.59182L5.56462 1.62393Z" fill="" />
                    </svg>
                    {{ $available_copies }} available
                </span>
            </div>
        </div>

        <!-- Members -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
            <div class="flex items-center justify-center w-12 h-12 bg-gray-100 rounded-xl dark:bg-gray-800">
                <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.80443 5.60156C7.59109 5.60156 6.60749 6.58517 6.60749 7.79851C6.60749 9.01185 7.59109 9.99545 8.80443 9.99545C10.0178 9.99545 11.0014 9.01185 11.0014 7.79851C11.0014 6.58517 10.0178 5.60156 8.80443 5.60156ZM5.10749 7.79851C5.10749 5.75674 6.76267 4.10156 8.80443 4.10156C10.8462 4.10156 12.5014 5.75674 12.5014 7.79851C12.5014 9.84027 10.8462 11.4955 8.80443 11.4955C6.76267 11.4955 5.10749 9.84027 5.10749 7.79851ZM4.86252 15.3208C4.08769 16.0881 3.70377 17.0608 3.51705 17.8611C3.48384 18.0034 3.5211 18.1175 3.60712 18.2112C3.70161 18.3141 3.86659 18.3987 4.07591 18.3987H13.4249C13.6343 18.3987 13.7992 18.3141 13.8937 18.2112C13.9797 18.1175 14.017 18.0034 13.9838 17.8611C13.7971 17.0608 13.4132 16.0881 12.6383 15.3208C11.8821 14.572 10.6899 13.955 8.75042 13.955C6.81096 13.955 5.61877 14.572 4.86252 15.3208ZM3.8071 14.2549C4.87163 13.2009 6.45602 12.455 8.75042 12.455C11.0448 12.455 12.6292 13.2009 13.6937 14.2549C14.7397 15.2906 15.2207 16.5607 15.4446 17.5202C15.7658 18.8971 14.6071 19.8987 13.4249 19.8987H4.07591C2.89369 19.8987 1.73504 18.8971 2.05628 17.5202C2.28015 16.5607 2.76117 15.2906 3.8071 14.2549ZM15.3042 11.4955C14.4702 11.4955 13.7006 11.2193 13.0821 10.7533C13.3742 10.3314 13.6054 9.86419 13.7632 9.36432C14.1597 9.75463 14.7039 9.99545 15.3042 9.99545C16.5176 9.99545 17.5012 9.01185 17.5012 7.79851C17.5012 6.58517 16.5176 5.60156 15.3042 5.60156C14.7039 5.60156 14.1597 5.84239 13.7632 6.23271C13.6054 5.73284 13.3741 5.26561 13.082 4.84371C13.7006 4.37777 14.4702 4.10156 15.3042 4.10156C17.346 4.10156 19.0012 5.75674 19.0012 7.79851C19.0012 9.84027 17.346 11.4955 15.3042 11.4955ZM19.9248 19.8987H16.3901C16.7014 19.4736 16.9159 18.969 16.9827 18.3987H19.9248C20.1341 18.3987 20.2991 18.3141 20.3936 18.2112C20.4796 18.1175 20.5169 18.0034 20.4837 17.861C20.2969 17.0607 19.913 16.088 19.1382 15.3208C18.4047 14.5945 17.261 13.9921 15.4231 13.9566C15.2232 13.6945 14.9995 13.437 14.7491 13.1891C14.5144 12.9566 14.262 12.7384 13.9916 12.5362C14.3853 12.4831 14.8044 12.4549 15.2503 12.4549C17.5447 12.4549 19.1291 13.2008 20.1936 14.2549C21.2395 15.2906 21.7206 16.5607 21.9444 17.5202C22.2657 18.8971 21.107 19.8987 19.9248 19.8987Z" fill="" />
                </svg>
            </div>
            <div class="flex items-end justify-between mt-5">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Members</span>
                    <h4 class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90">{{ $total_members }}</h4>
                </div>
                <span class="flex items-center gap-1 rounded-full bg-gray-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-gray-600 dark:bg-gray-500/15 dark:text-gray-400">
                    {{ $total_categories }} categories
                </span>
            </div>
        </div>

        <!-- Issued -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
            <div class="flex items-center justify-center w-12 h-12 bg-gray-100 rounded-xl dark:bg-gray-800">
                <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.665 3.75621C11.8762 3.65064 12.1247 3.65064 12.3358 3.75621L18.7807 6.97856L12.3358 10.2009C12.1247 10.3065 11.8762 10.3065 11.665 10.2009L5.22014 6.97856L11.665 3.75621ZM4.29297 8.19203V16.0946C4.29297 16.3787 4.45347 16.6384 4.70757 16.7654L11.25 20.0366V11.6513C11.1631 11.6205 11.0777 11.5843 10.9942 11.5426L4.29297 8.19203ZM12.75 20.037L19.2933 16.7654C19.5474 16.6384 19.7079 16.3787 19.7079 16.0946V8.19202L13.0066 11.5426C12.9229 11.5844 12.8372 11.6208 12.75 11.6516V20.037ZM13.0066 2.41456C12.3732 2.09786 11.6277 2.09786 10.9942 2.41456L4.03676 5.89319C3.27449 6.27432 2.79297 7.05342 2.79297 7.90566V16.0946C2.79297 16.9469 3.27448 17.726 4.03676 18.1071L10.9942 21.5857L11.3296 20.9149L10.9942 21.5857C11.6277 21.9024 12.3732 21.9024 13.0066 21.5857L19.9641 18.1071C20.7264 17.726 21.2079 16.9469 21.2079 16.0946V7.90566C21.2079 7.05342 20.7264 6.27432 19.9641 5.89319L13.0066 2.41456Z" fill="" />
                </svg>
            </div>
            <div class="flex items-end justify-between mt-5">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Issued</span>
                    <h4 class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90">{{ $issued }}</h4>
                </div>
                <span class="flex items-center gap-1 rounded-full bg-success-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">
                    <svg class="fill-current" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.56462 1.62393C5.70193 1.47072 5.90135 1.37432 6.12329 1.37432C6.1236 1.37432 6.12391 1.37432 6.12422 1.37432C6.31631 1.37415 6.50845 1.44731 6.65505 1.59381L9.65514 4.5918C9.94814 4.88459 9.94831 5.35947 9.65552 5.65246C9.36273 5.94546 8.88785 5.94562 8.59486 5.65283L6.87329 3.93247L6.87329 10.125C6.87329 10.5392 6.53751 10.875 6.12329 10.875C5.70908 10.875 5.37329 10.5392 5.37329 10.125L5.37329 3.93578L3.65516 5.65282C3.36218 5.94562 2.8873 5.94547 2.5945 5.65248C2.3017 5.35949 2.30185 4.88462 2.59484 4.59182L5.56462 1.62393Z" fill="" />
                    </svg>
                    {{ $returned }} returned
                </span>
            </div>
        </div>

        <!-- Overdue -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
            <div class="flex items-center justify-center w-12 h-12 bg-gray-100 rounded-xl dark:bg-gray-800">
                <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.5 2 2 6.5 2 12S6.5 22 12 22 22 17.5 22 12 17.5 2 12 2ZM16.2 16.2L11 13V7H12.5V12.3L17 15L16.2 16.2Z" fill="" />
                </svg>
            </div>
            <div class="flex items-end justify-between mt-5">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Overdue</span>
                    <h4 class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90">{{ $overdue }}</h4>
                </div>
                <span class="flex items-center gap-1 rounded-full bg-error-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-error-600 dark:bg-error-500/15 dark:text-error-500">
                    <svg class="fill-current" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.31462 10.3761C5.45194 10.5293 5.65136 10.6257 5.87329 10.6257C5.8736 10.6257 5.8739 10.6257 5.87421 10.6257C6.0663 10.6259 6.25845 10.5527 6.40505 10.4062L9.40514 7.4082C9.69814 7.11541 9.69831 6.64054 9.40552 6.34754C9.11273 6.05454 8.63785 6.05438 8.34486 6.34717L6.62329 8.06753L6.62329 1.875C6.62329 1.46079 6.28751 1.125 5.87329 1.125C5.45908 1.125 5.12329 1.46079 5.12329 1.875L5.12329 8.06422L3.40516 6.34719C3.11218 6.05439 2.6373 6.05454 2.3445 6.34752C2.0517 6.64051 2.05185 7.11538 2.34484 7.40818L5.31462 10.3761Z" fill="" />
                    </svg>
                    {{ $issued }} active issues
                </span>
            </div>
        </div>
    </div>

    <!-- ===== Charts & Widgets ===== -->
    <div class="grid grid-cols-12 gap-4 mt-6 md:gap-6">
        <!-- Monthly Issues -->
        <div class="col-span-12 xl:col-span-7">
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-5 pt-5 sm:px-6 sm:pt-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        Issues by Month
                    </h3>
                    <span class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 px-2.5 py-1.5 text-theme-xs font-medium text-gray-500 dark:border-gray-800 dark:text-gray-400">
                        Last 12 months
                    </span>
                </div>

                <div class="max-w-full overflow-x-auto custom-scrollbar">
                    <div
                        id="chartOne"
                        data-labels='@json($monthly_labels)'
                        data-data='@json($monthly_data)'
                        class="-ml-5 h-full min-w-[690px] pl-2 xl:min-w-full"
                    ></div>
                </div>
            </div>
        </div>

        <!-- Collection Status -->
        <div class="col-span-12 xl:col-span-5">
            <div class="rounded-2xl border border-gray-200 bg-gray-100 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="shadow-default rounded-2xl bg-white px-5 pb-11 pt-5 dark:bg-gray-900 sm:px-6 sm:pt-6">
                    <div class="flex justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                Collection Status
                            </h3>
                            <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">
                                Copies available vs total collection
                            </p>
                        </div>
                    </div>
                    <div class="relative h-[195px]">
                        <div
                            id="chartTwo"
                            data-value="{{ $availability_pct }}"
                            class="h-full"
                        ></div>
                        <span class="absolute bottom-2 left-1/2 -translate-x-1/2 rounded-full bg-success-50 px-3 py-1 text-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">+{{ $issued_this_month }} this month</span>
                    </div>
                    <p class="mx-auto mt-1.5 w-full max-w-[380px] text-center text-sm text-gray-500 sm:text-base">
                        {{ $available_copies }} of {{ $total_copies }} copies are currently available. Keep up the good work!
                    </p>
                </div>

                <div class="flex items-center justify-center gap-5 px-6 py-3.5 sm:gap-8 sm:py-5">
                    <div>
                        <p class="mb-1 text-center text-theme-xs text-gray-500 dark:text-gray-400 sm:text-sm">Total Copies</p>
                        <p class="flex items-center justify-center gap-1 text-base font-semibold text-gray-800 dark:text-white/90 sm:text-lg">
                            {{ $total_copies }}
                        </p>
                    </div>

                    <div class="h-7 w-px bg-gray-200 dark:bg-gray-800"></div>

                    <div>
                        <p class="mb-1 text-center text-theme-xs text-gray-500 dark:text-gray-400 sm:text-sm">Available</p>
                        <p class="flex items-center justify-center gap-1 text-base font-semibold text-gray-800 dark:text-white/90 sm:text-lg">
                            {{ $available_copies }}
                        </p>
                    </div>

                    <div class="h-7 w-px bg-gray-200 dark:bg-gray-800"></div>

                    <div>
                        <p class="mb-1 text-center text-theme-xs text-gray-500 dark:text-gray-400 sm:text-sm">Issued</p>
                        <p class="flex items-center justify-center gap-1 text-base font-semibold text-gray-800 dark:text-white/90 sm:text-lg">
                            {{ $issued }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Categories -->
        <div class="col-span-12 xl:col-span-5">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
                <div class="flex justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                            Top Categories
                        </h3>
                        <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">
                            Books per category
                        </p>
                    </div>
                </div>

                <div class="space-y-5 mt-6">
                    @if(count($category_stats) == 0)
                        <p class="text-theme-sm text-gray-500 dark:text-gray-400">No categories yet.</p>
                    @else
                        @foreach($category_stats as $category)
                            @php($pct = $total_books > 0 ? round($category->total / $total_books * 100) : 0)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <p class="text-theme-sm font-semibold text-gray-800 dark:text-white/90">
                                            {{ $category->name }}
                                        </p>
                                        <span class="block text-theme-xs text-gray-500 dark:text-gray-400">
                                            {{ $category->total }} Books
                                        </span>
                                    </div>
                                </div>

                                <div class="flex w-full max-w-[140px] items-center gap-3">
                                    <div class="relative block h-2 w-full max-w-[100px] rounded-sm bg-gray-200 dark:bg-gray-800">
                                        <div
                                            class="absolute left-0 top-0 flex h-full w-(--pct) items-center justify-center rounded-sm bg-brand-500 text-xs font-medium text-white"
                                            style="--pct: {{ $pct }}%"
                                        ></div>
                                    </div>
                                    <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ $pct }}%
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Issues -->
        <div class="col-span-12 xl:col-span-7">
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6">
                <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Recent Issues</h3>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ $base_url }}issues" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                            See all
                        </a>
                    </div>
                </div>

                <div class="max-w-full overflow-x-auto custom-scrollbar">
                    @if(count($recent_issues) == 0)
                        <p class="py-6 text-center text-theme-sm text-gray-500 dark:text-gray-400">No transactions yet.</p>
                    @else
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-t border-gray-100 dark:border-gray-800">
                                    <th class="py-3 text-left">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Book</p>
                                    </th>
                                    <th class="py-3 text-left">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Member</p>
                                    </th>
                                    <th class="py-3 text-left">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Issue Date</p>
                                    </th>
                                    <th class="py-3 text-left">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Due Date</p>
                                    </th>
                                    <th class="py-3 text-left">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($today = date('Y-m-d'))
                                @foreach($recent_issues as $row)
                                    <tr class="border-t border-gray-100 dark:border-gray-800">
                                        <td class="py-3 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-[50px] w-[50px] items-center justify-center overflow-hidden rounded-md bg-brand-50 dark:bg-brand-500/10">
                                                    <svg class="fill-brand-500" width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M18 2H6C4.9 2 4 2.9 4 4V20C4 21.1 4.9 22 6 22H18C19.1 22 20 21.1 20 20V4C20 2.9 19.1 2 18 2ZM6 4H11V12L8.5 10.5L6 12V4Z" fill="" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                                        {{ $row->book_title }}
                                                    </p>
                                                    <span class="text-gray-500 text-theme-xs dark:text-gray-400">
                                                        {{ $row->book_author }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 whitespace-nowrap">
                                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $row->member_name }}</p>
                                        </td>
                                        <td class="py-3 whitespace-nowrap">
                                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $row->issue_date }}</p>
                                        </td>
                                        <td class="py-3 whitespace-nowrap">
                                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $row->due_date }}</p>
                                        </td>
                                        <td class="py-3 whitespace-nowrap">
                                            @if($row->status == 'returned')
                                                <span class="rounded-full px-2 py-0.5 text-theme-xs font-medium bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500">Returned</span>
                                            @elseif($row->due_date < $today)
                                                <span class="rounded-full px-2 py-0.5 text-theme-xs font-medium bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500">Overdue</span>
                                            @else
                                                <span class="rounded-full px-2 py-0.5 text-theme-xs font-medium bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-orange-400">Issued</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ $base_url }}assets/js/charts.min.js"></script>
    <script src="{{ $base_url }}assets/js/dashboard.js"></script>
@endsection
