@extends('layouts.app')

@section('page_title', $category ? 'Edit Category' : 'Add Category')
@section('title', $category ? 'Edit Category' : 'Add Category')

@section('content')
<div class="mx-auto w-full max-w-xl rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
    <h2 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white/90">{{ $category ? 'Edit Category' : 'Add Category' }}</h2>

    <form method="post" action="">
        @if($category)
            <input type="hidden" name="id" value="{{ $category->id }}">
        @endif

        <div class="space-y-5">
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400" for="name">Name<span class="text-error-500">*</span></label>
                <input type="text" id="name" name="name" required value="{{ $category ? $category->name : '' }}"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400" for="description">Description</label>
                <textarea id="description" name="description" rows="3"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">{{ $category ? $category->description : '' }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex gap-2">
            <button type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs transition-colors hover:bg-brand-600">
                Save
            </button>
            <a href="{{ $base_url }}categories"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs transition-colors hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
