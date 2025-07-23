document.addEventListener("DOMContentLoaded", () => {
    const createTweetForm = document.getElementById("tweetForm");
    if (!createTweetForm) return;

    const messageArea = document.getElementById("message-area");
    const submitButton = createTweetForm.querySelector('button[type="submit"]');

    const showMessage = (message, isError = false) => {
        if (!messageArea) return;
        messageArea.textContent = message;
        messageArea.className = `mb-4 font-medium text-sm ${
            isError ? "text-red-600" : "text-green-600"
        }`;
    };

    createTweetForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        // 以前のメッセージをクリア
        showMessage("");
        submitButton.disabled = true;
        submitButton.textContent = "投稿中...";

        // フォームデータをまとめて取得
        const formData = new FormData(createTweetForm);

        try {
            const response = await fetch("/api/tweets", {
                method: "POST",
                headers: {
                    // CSRFトークンをヘッダーに追加 (必須)
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    Accept: "application/json",
                },
                body: formData,
            });

            const data = await response.json();
            // バリデーションエラー (422) の場合
            if (response.status === 422) {
                // ここで各入力フィールドの下にエラーを表示する処理を追加できます
                const firstError = Object.values(data.errors)[0][0];
                throw new Error(firstError || "入力内容に誤りがあります。");
            }

            if (!response.ok) {
                throw new Error(data.message || "エラーが発生しました。");
            }

            showMessage("ツイートを投稿しました！");
            // 2秒後にホームページへリダイレクト
            setTimeout(() => {
                window.location.href = "/tweets";
            }, 2000);
        } catch (error) {
            showMessage(error.message, true);
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = "投稿する";
        }
    });
});
