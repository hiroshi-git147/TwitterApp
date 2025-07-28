document.addEventListener("DOMContentLoaded", () => {
    const deleteTweetForm = document.getElementById("deleteTweetForm");

    if (!deleteTweetForm) return;

    const messageArea = document.getElementById("message-area");

    const submitDeleteTweetBtn = document.getElementById("deleteTweetButton");

    const showMessage = (message, isError = false) => {
        if (!messageArea) return;
        messageArea.textContent = message;
        messageArea.className = `mb-4 font-medium text-sm ${
            isError ? "text-red-600" : "text-green-600"
        }`;
    };

    // ページのURLからツイートIDを取得 (例: /tweets/20/edit -> 20)
    const tweetId = window.location.pathname.split("/")[2];

    deleteTweetForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        showMessage("");
        submitDeleteTweetBtn.disabled = true;
        submitDeleteTweetBtn.textContent = "削除中...";

        const formData = new FormData(deleteTweetForm);

        formData.append("_method", "DELETE");

        try {
            const response = await fetch(`/api/tweets/${tweetId}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: formData,
            });

            if (!response.ok) {
                // エラーレスポンスには通常ボディがあるのでjson()を呼ぶ
                const data = await response.json();
                if (response.status === 422) {
                    const firstError = Object.values(data.errors)[0][0];
                    throw new Error(firstError || "入力内容に誤りがあります。");
                }
                throw new Error(data.message || "エラーが発生しました。");
            }

            showMessage("ツイートを削除しました！");
            // 2秒後にツイート一覧ページへリダイレクト
            setTimeout(() => {
                window.location.href = `/tweets`;
            }, 2000);
        } catch (error) {
            showMessage(error.message, true);
        } finally {
            submitDeleteTweetBtn.disabled = false;
            submitDeleteTweetBtn.textContent = "削除する";
        }
    });
});
