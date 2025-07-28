<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Tweet') }}
        </h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">

            <!-- メッセージ表示エリア -->
            <div id="message-area" class="mb-4 font-medium text-sm"></div>

            <form id="updateTweetForm" enctype="multipart/form-data" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label for="content" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">本文</label>
                    <textarea name="content" id="content" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600">{{ old('content', $tweet->content) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">画像（任意）</label>
                    @if ($tweet->image_path)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $tweet->image_path) }}" class="max-w-xs rounded" alt="現在の画像">
                            <p class="text-xs text-gray-500 mt-1">現在の画像です。新しい画像をアップロードすると置き換えられます。</p>
                        </div>
                    @endif
                    <input type="file" name="image" id="image" class="w-full text-gray-700 dark:text-gray-300">
                </div>

                <button id="updateTweetButton" type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">更新する</button>
            </form>


            @can('destroy', $tweet)
                <form id="deleteTweetForm" method="POST" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <button id="deleteTweetButton" type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">削除する</button>
                </form>
            @endcan
        </div>
    </div>
</x-app-layout>

<script src="{{ asset('js/TweetJs/update.js') }}"></script>
<script src="{{ asset('js/TweetJs/delete.js') }}"></script>
