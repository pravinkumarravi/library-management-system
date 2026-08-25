@extends('layouts.app')

@section('page_title', 'Overdue Books')
@section('title', 'Overdue Books')

@section('content')
<div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
    <div class="flex flex-col gap-3 mb-4 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">Overdue Books</h2>
        <a href="{{ $base_url }}issues"
            class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs transition-colors hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
            View Issued
        </a>
    </div>

    @if(count($issues) == 0)
        <p class="text-theme-sm text-gray-500 dark:text-gray-400">No overdue books.</p>
    @else
        <div class="max-w-full overflow-x-auto custom-scrollbar">
            <table class="min-w-full">
                <thead>
                    <tr class="border-t border-gray-100 dark:border-gray-800">
                        <th class="py-3 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Book</p></th>
                        <th class="py-3 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Member</p></th>
                        <th class="py-3 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Due Date</p></th>
                        <th class="py-3 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Days Late</p></th>
                        <th class="py-3 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Est. Fine</p></th>
                        <th class="py-3 text-right"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Action</p></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($issues as $row)
                        @php
                            $days = floor((strtotime(date('Y-m-d')) - strtotime($row->due_date)) / 86400);
                            $fine = $days * 5;
                        @endphp
                        <tr class="border-t border-gray-100 dark:border-gray-800">
                            <td class="py-3 whitespace-nowrap">
                                <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">{{ $row->book_title }}</p>
                                <span class="text-gray-500 text-theme-xs dark:text-gray-400">{{ $row->book_author }}</span>
                            </td>
                            <td class="py-3 whitespace-nowrap">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $row->member_name }}</p>
                            </td>
                            <td class="py-3 whitespace-nowrap">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $row->due_date }}</p>
                            </td>
                            <td class="py-3 whitespace-nowrap">
                                <span class="rounded-full bg-error-50 px-2 py-0.5 text-theme-xs font-medium text-error-600 dark:bg-error-500/15 dark:text-error-500">{{ $days }}</span>
                            </td>
                            <td class="py-3 whitespace-nowrap">
                                <p class="font-medium text-error-600 text-theme-sm dark:text-error-500">{{ money($fine) }}</p>
                            </td>
                            <td class="py-3 whitespace-nowrap">
                                <div class="flex justify-end">
                                    <a href="{{ $base_url }}issues/return_book/{{ $row->id }}" title="Return" onclick="return confirm('Return this book?');"
                                        class="inline-flex items-center justify-center h-9 w-9 rounded-lg bg-brand-500 text-white shadow-theme-xs transition-colors hover:bg-brand-600">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 4v6h6"></path>
                                            <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
