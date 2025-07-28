document.addEventListener("DOMContentLoaded", async () => {
    const tweetList = document.getElementById("tweet-list");

    try {
        const response = await fetch("api/tweets");
        if (!response.ok) throw new Error("Api通信に失敗しました");

        const data = await response.json();

        const tweets = data.tweets;

        // ツイートがない場合
        if (!tweets.length) {
            tweetList.innerHTML = "<p>ツイートがありません</p>";
            return;
        }

        tweetList.innerHTML = tweets
            .map(
                (tweet) => `
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-4">
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">投稿者: ${
                    tweet.user.name
                }  ${new Date(tweet.created_at).toLocaleString()}</p>
                <p class="mt-2 text-gray-900 dark:text-gray-100">${
                    tweet.content
                }</p>
                ${
                    tweet.image_path
                        ? `<img src="/storage/${tweet.image_path}" class="mt-2 max-w-lg rounded" alt="画像">`
                        : ""
                }
                <a href="/tweets/${
                    tweet.id
                }" class="text-blue-500 hover:text-blue-700 mt-2 inline-block">詳細</a>
            </div>
        `
            )
            .join("");
    } catch (error) {
        tweetList.innerHTML = `<p class="text-red-500">エラーが発生しました: ${error.message}</p>`;
    }
});
