@extends('layouts.app')

@section('page_title', 'Members')
@section('title', 'Members')

@section('content')
<div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
    <div class="flex flex-col gap-3 mb-4 sm:flex-row sm:items-center sm:justify-between">
        <form method="get" action="{{ $base_url }}members" class="flex gap-2">
            <input type="text" name="search" value="{{ $search }}" placeholder="Search name, email or phone..."
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 sm:w-72">
            <button type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs transition-colors hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                Search
            </button>
        </form>
        <a href="{{ $base_url }}members/create"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs transition-colors hover:bg-brand-600">
            + Add Member
        </a>
    </div>

    @if(count($members) == 0)
        <p class="text-theme-sm text-gray-500 dark:text-gray-400">No members found.</p>
    @else
        <div class="max-w-full overflow-x-auto custom-scrollbar">
            <table class="min-w-full">
                <thead>
                    <tr class="border-t border-gray-100 dark:border-gray-800">
                        <th class="py-3 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Name</p></th>
                        <th class="py-3 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Email</p></th>
                        <th class="py-3 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Phone</p></th>
                        <th class="py-3 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Membership</p></th>
                        <th class="py-3 text-left"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</p></th>
                        <th class="py-3 text-right"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Actions</p></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $m)
                        <tr class="border-t border-gray-100 dark:border-gray-800">
                            <td class="py-3 whitespace-nowrap">
                                <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">{{ $m->name }}</p>
                            </td>
                            <td class="py-3 whitespace-nowrap">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $m->email ?: '—' }}</p>
                            </td>
                            <td class="py-3 whitespace-nowrap">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $m->phone ?: '—' }}</p>
                            </td>
                            <td class="py-3 whitespace-nowrap">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $m->membership_date ?: '—' }}</p>
                            </td>
                            <td class="py-3 whitespace-nowrap">
                                @if($m->status == 'active')
                                    <span class="rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">Active</span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-2 py-0.5 text-theme-xs font-medium text-gray-500 dark:bg-gray-500/15 dark:text-gray-400">Inactive</span>
                                @endif
                            </td>
                            <td class="py-3 whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ $base_url }}members/edit/{{ $m->id }}"
                                        class="inline-flex items-center justify-center gap-1 rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-theme-xs font-medium text-gray-700 shadow-theme-xs transition-colors hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                                        Edit
                                    </a>
                                    <a href="{{ $base_url }}members/delete/{{ $m->id }}" onclick="return confirm('Delete this member?');"
                                        class="inline-flex items-center justify-center gap-1 rounded-lg bg-error-500 px-3 py-1.5 text-theme-xs font-medium text-white shadow-theme-xs transition-colors hover:bg-error-600">
                                        Delete
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
