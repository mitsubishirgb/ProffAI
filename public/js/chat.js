document.addEventListener('DOMContentLoaded', () => {
    const submitBtn = document.querySelector('#send-button');
    const inputField = document.querySelector('#user-input');
    const chatSession = document.getElementById("chat-session");

    if (!submitBtn || !inputField || !chatSession) return;

    function scrollToBottom() {
        chatSession.scrollTop = chatSession.scrollHeight;
    }

    function createMessageElement(role, text, isThinking = false) {
        const msg = document.createElement("div");
        msg.className = `chat-message ${role}`;

        if (role === 'professor') {
            const avatar = document.createElement("img");
            avatar.src = "assets/icons/cheerful-elderly-man-with-glasses.png";
            avatar.alt = "ProffAI";
            msg.appendChild(avatar);
        }

        const bubble = document.createElement("div");
        bubble.className = "chat-bubble";
        bubble.innerHTML = isThinking ? "Duke menduar..." : text.replace(/\n/g, '<br>');

        msg.appendChild(bubble);
        chatSession.appendChild(msg);
        scrollToBottom();

        return msg;
    }

    async function saveMessageToBackend(role, content) {
        const response = await fetch('api/messages.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                chat_id: window.currentChatId,
                role: role,
                content: content
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }
    }

    async function handleChat() {
        const message = inputField.value.trim();
        if (!message) return;

        inputField.value = "";

        try {
            await saveMessageToBackend('user', message);
            createMessageElement('user', message);
        } catch (error) {
            console.error(error);
            return;
        }

        const thinkingMsg = createMessageElement('professor', '', true);

        try {
            const response = await fetch('api/ai.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    message: message,
                    chat_id: window.currentChatId || null
                })
            });

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }

            const data = await response.json();

            if (chatSession.contains(thinkingMsg)) {
                chatSession.removeChild(thinkingMsg);
            }

            let aiText = "";
            if (data?.choices?.[0]?.message?.content) {
                aiText = data.choices[0].message.content;
            } else if (data?.reply) {
                aiText = data.reply;
            } else if (data?.error) {
                aiText = "Gabim: " + (data.error.message || JSON.stringify(data.error));
            } else {
                aiText = "Përgjigje e papritur nga serveri.";
            }

            await saveMessageToBackend('professor', aiText);
            createMessageElement('professor', aiText);

            if (data.chat_id && !window.currentChatId) {
                window.currentChatId = data.chat_id;

                const suggestedTitle = data.title || (message.slice(0, 30) + (message.length > 30 ? '...' : ''));

                if (typeof addConversationToList === "function") {
                    addConversationToList(data.chat_id, suggestedTitle);
                }

                const newUrl = new URL(window.location);
                newUrl.searchParams.set('chat_id', data.chat_id);
                window.history.pushState({ path: newUrl.href }, '', newUrl.href);
            }

        } catch (error) {
            console.error(error);
            if (chatSession.contains(thinkingMsg)) {
                const bubble = thinkingMsg.querySelector('.chat-bubble');
                if (bubble) bubble.innerHTML = "Ndodhi një gabim. Provo sërish.";
            }
        }
    }

    submitBtn.addEventListener('click', handleChat);
    inputField.addEventListener('keypress', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            handleChat();
        }
    });

    inputField.focus();
});