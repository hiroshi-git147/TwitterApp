document.addEventListener("DOMContentLoaded", () => {
    const updateTweetForm = document.getElementById("updateTweetForm");

    if (!updateTweetForm) return;
    const messageArea = document.getElementById("message-area");
    const submitUpdateTweetBtn = document.getElementById("updateTweetButton");

    const showMessage = (message, isError = false) => {
        if (!messageArea) return;
        messageArea.textContent = message;
        messageArea.className = `mb-4 font-medium text-sm ${
            isError ? "text-red-600" : "text-green-600"
        }`;
    };

    // ページのURLからツイートIDを取得 (例: /tweets/20/edit -> 20)
    const tweetId = window.location.pathname.split("/")[2];

    updateTweetForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        showMessage("");
        submitUpdateTweetBtn.disabled = true;
        submitUpdateTweetBtn.textContent = "更新中...";

        const formData = new FormData(updateTweetForm);
        // _method を追加して、PATCHリクエストであることをLaravelに伝える
        formData.append("_method", "PATCH");

        try {
            // methodをPOSTに変更し、URLに動的に取得したIDを埋め込む
            const response = await fetch(`/api/tweets/${tweetId}`, {
                method: "POST", // PATCHではなくPOST
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    Accept: "application/json",
                },
                body: formData,
            });

            const data = await response.json();
            if (response.status === 422) {
                const firstError = Object.values(data.errors)[0][0];
                throw new Error(firstError || "入力内容に誤りがあります。");
            }

            if (!response.ok) {
                throw new Error(data.message || "エラーが発生しました。");
            }

            showMessage("ツイートを更新しました！");
            // 2秒後にツイート詳細ページへリダイレクト
            setTimeout(() => {
                window.location.href = `/tweets/${tweetId}`;
            }, 2000);
        } catch (error) {
            showMessage(error.message, true);
        } finally {
            submitUpdateTweetBtn.disabled = false;
            submitUpdateTweetBtn.textContent = "更新する";
        }
    });
});
