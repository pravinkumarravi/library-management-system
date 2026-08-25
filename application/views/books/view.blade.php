@extends('layouts.app')

@section('page_title', $book->title)
@section('title', 'Book Details')

@section('content')
@php($today = date('Y-m-d'))

<div class="space-y-4">
    <div class="flex items-center justify-between">
        <a href="{{ $base_url }}books"
            class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs transition-colors hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
            &larr; Back to Books
        </a>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <div class="flex flex-wrap items-center gap-2">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ $book->title }}</h2>
                    @if($category)
                        <span class="rounded-full bg-brand-50 px-2.5 py-1 text-theme-xs font-medium text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">{{ $category }}</span>
                    @endif
                </div>
                <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">by {{ $book->author }}</p>
                <code class="mt-2 inline-block rounded-md bg-gray-100 px-2 py-1 text-theme-xs text-gray-500 dark:bg-gray-800 dark:text-gray-400">{{ $book->slug }}</code>
            </div>
            <span class="rounded-full bg-gray-50 px-3 py-1.5 text-theme-sm font-medium text-gray-600 dark:bg-gray-500/15 dark:text-gray-400">{{ $book->available_copies }} of {{ $book->total_copies }} copies available</span>
        </div>

        <div class="mt-5 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
            <div>
                <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">ISBN</p>
                <p class="mt-1 text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $book->isbn ?: '—' }}</p>
            </div>
            <div>
                <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Publisher</p>
                <p class="mt-1 text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $book->publisher ?: '—' }}</p>
            </div>
            <div>
                <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Year</p>
                <p class="mt-1 text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $book->year ?: '—' }}</p>
            </div>
            <div>
                <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Category</p>
                <p class="mt-1 text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $category ?: '—' }}</p>
            </div>
            <div>
                <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Copies</p>
                <p class="mt-1 text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $book->available_copies }} / {{ $book->total_copies }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Who has taken this book</h3>
            <span class="rounded-full bg-gray-50 px-3 py-1 text-theme-xs font-medium text-gray-600 dark:bg-gray-500/15 dark:text-gray-400">{{ count($taken_by) }} record(s)</span>
        </div>

        @if(count($taken_by) == 0)
            <p class="text-theme-sm text-gray-500 dark:text-gray-400">No one has taken this book yet.</p>
        @else
            <div class="max-w-full overflow-x-auto custom-scrollbar">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-t border-gray-100 dark:border-gray-800">
                            <th class="py-3 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Member</p></th>
                            <th class="py-3 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Email</p></th>
                            <th class="py-3 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Issue Date</p></th>
                            <th class="py-3 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Due Date</p></th>
                            <th class="py-3 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Return Date</p></th>
                            <th class="py-3 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</p></th>
                            <th class="py-3 text-right"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Fine</p></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($taken_by as $row)
                            @php($overdue = $row->status == 'issued' && $row->due_date < $today)
                            <tr class="border-t border-gray-100 dark:border-gray-800">
                                <td class="py-3 whitespace-nowrap">
                                    <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">{{ $row->member_name }}</p>
                                </td>
                                <td class="py-3 whitespace-nowrap">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $row->member_email ?: '—' }}</p>
                                </td>
                                <td class="py-3 whitespace-nowrap">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $row->issue_date }}</p>
                                </td>
                                <td class="py-3 whitespace-nowrap">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $row->due_date }}</p>
                                </td>
                                <td class="py-3 whitespace-nowrap">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $row->return_date ?: '—' }}</p>
                                </td>
                                <td class="py-3 whitespace-nowrap">
                                    @if($overdue)
                                        <span class="rounded-full bg-error-50 px-2 py-0.5 text-theme-xs font-medium text-error-600 dark:bg-error-500/15 dark:text-error-400">Overdue</span>
                                    @elseif($row->status == 'issued')
                                        <span class="rounded-full bg-warning-50 px-2 py-0.5 text-theme-xs font-medium text-warning-600 dark:bg-warning-500/15 dark:text-warning-400">Issued</span>
                                    @else
                                        <span class="rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">Returned</span>
                                    @endif
                                </td>
                                <td class="py-3 whitespace-nowrap">
                                    <p class="text-right font-medium text-gray-800 text-theme-sm dark:text-white/90">{{ money($row->fine) }}</p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
