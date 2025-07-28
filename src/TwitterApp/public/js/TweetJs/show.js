document.addEventListener("DOMContentLoaded", async () => {
    const contentTextarea = document.getElementById("content");
    const messageArea = document.getElementById("message-area");

    const showMessage = (message, isError = false) => {
        messageArea.textContent = message;
        messageArea.className = `mb-4 font-medium text-sm ${
            isError ? "text-red-600" : "text-green-600"
        }`;
    };

    // ページのURLからツイートIDを取得 (例: /tweets/20/edit -> 20)
    const tweetId = window.location.pathname.split("/")[2];

    try {
        const response = await fetch(`/api/tweets/${tweetId}`, {
            method: "GET",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                Accept: "application/json",
            },
        });
        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(
                errorData.message || "ツイートの読み込みに失敗しました。"
            );
        }
        // TODO ユーザー名等もAPIに入ってるのでそれもinnerTextで取得する
        const data = await response.json();

        contentTextarea.innerText = data.tweet.content;
    } catch (error) {
        showMessage(error.message, true);
    }

    // ページが読み込まれたらツイート情報を取得
    fetchTweet();
});
