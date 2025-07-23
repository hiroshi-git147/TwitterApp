document.addEventListener("DOMContentLoaded", () => {
    const verifyForm = document.getElementById("verify-form");
    const resendButton = document.getElementById("resend-button");
    const messageArea = document.getElementById("message-area");
    const emailInput = document.getElementById("email");
    const csrfTokenInput = document.querySelector('input[name="_token"]');

    if (
        !verifyForm ||
        !resendButton ||
        !messageArea ||
        !csrfTokenInput ||
        !emailInput
    ) {
        // 必要な要素が見つからない場合は何もしない
        return;
    }

    const csrfToken = csrfTokenInput.value;

    // メッセージを表示するヘルパー関数
    const showMessage = (message, isError = false) => {
        messageArea.textContent = message;
        messageArea.className = `mb-4 font-medium text-sm ${
            isError ? "text-red-600" : "text-green-600"
        }`;
    };

    // 認証フォームの送信処理
    verifyForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        const code = document.getElementById("code").value;
        const email = emailInput.value;

        try {
            const response = await fetch("/api/verify-code", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify({ email: email, code: code }),
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || "エラーが発生しました。");
            }

            showMessage(data.message);
            // 認証成功後、2秒後にホームページへリダイレクト
            setTimeout(() => {
                window.location.href = "/dashboard"; // 認証後のダッシュボードなど
            }, 2000);
        } catch (error) {
            showMessage(error.message, true);
        }
    });

    // 再送ボタンの処理
    resendButton.addEventListener("click", async () => {
        const email = emailInput.value;

        try {
            const response = await fetch("/api/resend-verification-code", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify({ email: email }),
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || "エラーが発生しました。");
            }

            showMessage(data.message);
        } catch (error) {
            showMessage(error.message, true);
        }
    });
});
