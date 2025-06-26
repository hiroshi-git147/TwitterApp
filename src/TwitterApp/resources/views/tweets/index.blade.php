<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tweets') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif
    
    @foreach ($tweets as $tweet)
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-4">
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">投稿者: {{ $tweet->user->name }} / {{ $tweet->created_at->format('Y-m-d H:i') }}</p>
            <a href="{{ route('tweets.show', $tweet) }}" class="text-blue-500 hover:text-blue-700 mt-2 inline-block">詳細</a>
            <p class="text-gray-900 dark:text-gray-100">{{ $tweet->content }}</p>
            @if ($tweet->image_path)
                <img src="{{ asset('storage/' . $tweet->image_path) }}" class="mt-2 max-w-lg rounded" alt="画像">
            @endif
        </div>
    @endforeach
</x-app-layout>
