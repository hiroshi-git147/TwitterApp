<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tweet Detail') }}
        </h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <p class="text-gray-900 dark:text-gray-100" id="content"></p>
            @if ($tweet->image_path)
                <img src="{{ asset('storage/' . $tweet->image_path) }}" class="mt-2 max-w-lg rounded" alt="画像">
            @endif
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">投稿者: {{ $tweet->user->name }} / {{ $tweet->created_at->format('Y-m-d H:i') }}</p>

            @can('update', $tweet)
                <div class="mt-4">
                    <a href="{{ route('tweets.edit', $tweet) }}" class="text-blue-500 hover:text-blue-700">編集</a>
                </div>
            @endcan
        </div>
    </div>
</x-app-layout>
<script src="{{ asset('js/TweetJs/show.js') }}"></script>
