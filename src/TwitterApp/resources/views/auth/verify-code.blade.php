<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>メール認証</title>
        <!-- ここにCSSのリンクなどを追加 -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <!-- ロゴなどをここに配置 -->
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <div class="mb-4 text-sm text-gray-600">
                    ご登録ありがとうございます！ご登録いただいたメールアドレスに6桁の認証コードを送信しました。メールをご確認の上、以下のフォームに認証コードを入力してください。
                </div>

                <!-- 再送完了メッセージ -->
                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        新しい認証コードを送信しました。
                    </div>
                @endif

                <!-- エラー表示 -->
                @if ($errors->any())
                    <div class="mb-4">
                        <div class="font-medium text-red-600">エラーが発生しました</div>
                        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mt-4 flex items-center justify-between">
                    <form method="POST" action="{{ route('verification.verify') }}">
                        @csrf
                        <div>
                            <label for="code">認証コード</label>
                            <input id="code" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="code" required autofocus />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md">
                                認証する
                            </button>
                        </div>
                    </form>
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                            認証コードを再送信する
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
