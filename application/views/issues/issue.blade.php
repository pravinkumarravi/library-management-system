@extends('layouts.app')

@section('page_title', 'Issue a Book')
@section('title', 'Issue a Book')

@section('content')
<div class="mx-auto w-full max-w-xl rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
    <h2 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white/90">Issue a Book</h2>

    @if(count($members) == 0 || count($books) == 0)
        <p class="text-theme-sm text-gray-500 dark:text-gray-400">You need at least one member and one book before issuing.</p>
        <div class="mt-4 flex gap-2">
            <a href="{{ $base_url }}members/create"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs transition-colors hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                Add Member
            </a>
            <a href="{{ $base_url }}books/create"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs transition-colors hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                Add Book
            </a>
        </div>
    @else
        @php
            $default_due = date('Y-m-d', strtotime('+14 days'));
        @endphp
        <form method="post" action="">
            <div class="space-y-5">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400" for="member_id">Member<span class="text-error-500">*</span></label>
                    <select id="member_id" name="member_id" required
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        <option value="">— Select member —</option>
                        @foreach($members as $m)
                            @php($busy = isset($busy_member_ids[$m->id]))
                            <option value="{{ $m->id }}" @if($busy) disabled @endif>
                                {{ $m->name }}@if($m->email) ({{ $m->email }}) @endif
                                @if($busy) — already issued a book @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400" for="book_id">Book<span class="text-error-500">*</span></label>
                    <select id="book_id" name="book_id" required
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        <option value="">— Select book —</option>
                        @foreach($books as $b)
                            @if($b->available_copies > 0)
                                <option value="{{ $b->id }}">{{ $b->title }} — {{ $b->available_copies }} available</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400" for="due_date">Due Date<span class="text-error-500">*</span></label>
                    <input type="date" id="due_date" name="due_date" required value="{{ $default_due }}"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                </div>
            </div>

            <div class="mt-6 flex gap-2">
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs transition-colors hover:bg-brand-600">
                    Issue Book
                </button>
                <a href="{{ $base_url }}issues"
                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs transition-colors hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                    Cancel
                </a>
            </div>
        </form>
    @endif
</div>
@endsection
