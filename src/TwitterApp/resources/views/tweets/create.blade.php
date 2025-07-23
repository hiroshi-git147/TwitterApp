<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('New Tweet') }}
        </h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <!-- メッセージ表示エリア -->
            <div id="message-area" class="mb-4 font-medium text-sm"></div>

            <form id="tweetForm" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="content" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">本文</label>
                    <textarea name="content" id="content" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600">{{ old('content') }}</textarea>
                    
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">画像（任意）</label>
                    <input type="file" name="image" id="image" class="w-full text-gray-700 dark:text-gray-300">
                   
                </div>

                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">投稿する</button>
            </form>
        </div>
    </div>
</x-app-layout>
<script src="{{ asset('js/TweetJs/create.js') }}"></script>
