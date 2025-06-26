<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit') }}
    </x-slot>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            @can('update', $tweet)
                <form action="{{ route('tweets.update', $tweet) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label for="content" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">本文</label>
                        <textarea name="content" id="content" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600">{{ old('content', $tweet->content) }}</textarea>
                        @error('content') <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">更新する</button>
                </form>
            @endcan


            @can('destroy', $tweet)
                <form action="{{ route('tweets.destroy', $tweet) }}" method="POST" class="mt-4" onsubmit="return confirm('本当に削除しますか？');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">削除する</button>
                </form>
            @endcan
        </div>
    </div>
</x-app-layout>
