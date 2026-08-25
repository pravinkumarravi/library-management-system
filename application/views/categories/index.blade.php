@extends('layouts.app')

@section('page_title', 'Categories')
@section('title', 'Categories')

@section('content')
<div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
    <div class="flex flex-col gap-3 mb-4 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">Book Categories</h2>
        <a href="{{ $base_url }}categories/create"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs transition-colors hover:bg-brand-600">
            + Add Category
        </a>
    </div>

    @if(count($categories) == 0)
        <p class="text-theme-sm text-gray-500 dark:text-gray-400">No categories yet.</p>
    @else
        <div class="max-w-full overflow-x-auto custom-scrollbar">
            <table class="min-w-full">
                <thead>
                    <tr class="border-t border-gray-100 dark:border-gray-800">
                        <th class="py-3 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Name</p></th>
                        <th class="py-3 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Description</p></th>
                        <th class="py-3 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Books</p></th>
                        <th class="py-3 text-right"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Actions</p></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $c)
                        <tr class="border-t border-gray-100 dark:border-gray-800">
                            <td class="py-3 whitespace-nowrap">
                                <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">{{ $c->name }}</p>
                            </td>
                            <td class="py-3 whitespace-nowrap">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $c->description ?: '—' }}</p>
                            </td>
                            <td class="py-3 whitespace-nowrap">
                                <span class="rounded-full bg-gray-50 px-2 py-0.5 text-theme-xs font-medium text-gray-600 dark:bg-gray-500/15 dark:text-gray-400">{{ $c->book_count }}</span>
                            </td>
                            <td class="py-3 whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ $base_url }}categories/edit/{{ $c->id }}" title="Edit"
                                        class="inline-flex items-center justify-center h-9 w-9 rounded-lg border border-gray-300 bg-white text-gray-700 shadow-theme-xs transition-colors hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ $base_url }}categories/delete/{{ $c->id }}" title="Delete" onclick="return confirm('Delete this category?');"
                                        class="inline-flex items-center justify-center h-9 w-9 rounded-lg bg-error-500 text-white shadow-theme-xs transition-colors hover:bg-error-600">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M3 6h18"></path>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
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
