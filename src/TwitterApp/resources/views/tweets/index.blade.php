<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tweets') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    <div id="tweet-list" class="space-y-4">
        <!-- ここにJSでツイート一覧が動的に入る -->
    </div>
</x-app-layout>
<!-- 分離したJavaScriptファイルを読み込む -->
<script src="{{ asset('js/TweetJs/index.js') }}"></script>
