@extends('layouts.app')

@section('page_title', 'Notifications')
@section('title', 'Notifications')

@section('content')
@php
    $typeBadge = array(
        'issue'        => 'bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400',
        'return'       => 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500',
        'blocked'      => 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-400',
        'overdue'      => 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-400',
        'due_soon'     => 'bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-warning-400',
        'out_of_stock' => 'bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-warning-400',
    );
    $typeLabel = array(
        'issue'        => 'Issued',
        'return'       => 'Returned',
        'blocked'      => 'Blocked',
        'overdue'      => 'Overdue',
        'due_soon'     => 'Due soon',
        'out_of_stock' => 'Out of stock',
    );
@endphp

<div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
    <div class="flex flex-col gap-3 mb-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-3">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">All Notifications</h2>
            @if($unread_notifications > 0)
                <span class="rounded-full bg-brand-50 px-2.5 py-1 text-theme-xs font-medium text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">{{ $unread_notifications }} unread</span>
            @endif
        </div>
        <form method="post" action="{{ $base_url }}notifications/mark_all_read">
            <button type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs transition-colors hover:bg-brand-600">
                Mark all as read
            </button>
        </form>
    </div>

    @if(count($notifications) == 0)
        <p class="text-theme-sm text-gray-500 dark:text-gray-400">No notifications yet.</p>
    @else
        <ul class="flex flex-col gap-2">
            @foreach($notifications as $n)
                <li>
                    <a href="{{ $base_url }}notifications/read/{{ $n->id }}"
                        class="flex flex-col gap-1 rounded-xl border border-gray-100 p-4 transition-colors hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-white/[0.03] {{ $n->is_read ? '' : 'bg-brand-50/40 dark:bg-brand-500/[0.06]' }}">
                        <span class="flex items-center justify-between gap-2">
                            <span class="flex items-center gap-2">
                                <span class="rounded-full px-2.5 py-1 text-theme-xs font-medium {{ $typeBadge[$n->type] ?? 'bg-gray-100 text-gray-600 dark:bg-gray-500/15 dark:text-gray-400' }}">{{ $typeLabel[$n->type] ?? ucfirst($n->type) }}</span>
                                @if(!$n->is_read)
                                    <span class="w-1.5 h-1.5 rounded-full bg-brand-500"></span>
                                @endif
                            </span>
                            <span class="text-theme-xs text-gray-500 dark:text-gray-400">{{ relative_time($n->created_at) }}</span>
                        </span>
                        <span class="mt-1 block">
                            <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">{{ $n->title }}</span>
                            <span class="mt-0.5 block text-theme-sm text-gray-500 dark:text-gray-400">{{ $n->message }}</span>
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
