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

                <!-- メッセージ表示エリア -->
                <div id="message-area" class="mb-4 font-medium text-sm"></div>

                <!-- 隠しフィールドでメールアドレスを保持 -->
                <input type="hidden" id="email" value="{{ $email ?? '' }}">

                <!-- 認証フォーム -->
                <form id="verify-form">
                    @csrf
                    <div>
                        <label for="code">認証コード</label>
                        <input id="code" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="code" required autofocus />
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <!-- 認証ボタン -->
                        <button type="submit" class="ml-4 px-4 py-2 bg-gray-800 text-white rounded-md">
                            認証する
                        </button>
                    </div>
                </form>

                <div class="mt-4 flex items-center justify-between">
                    <!-- 再送ボタン -->
                    <button id="resend-button" class="underline text-sm text-gray-600 hover:text-gray-900">
                        認証コードを再送信する
                    </button>

                    <!-- ログアウトフォーム -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">ログアウトしてサインイン画面へ</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- 分離したJavaScriptファイルを読み込む -->
        <script src="{{ asset('js/verify-code.js') }}"></script>
    </body>
</html>
