function scrollToBottom() {
    const chatSession = document.getElementById("chat-session");
    if (chatSession) chatSession.scrollTop = chatSession.scrollHeight;
}

function createMessageElement(role, text, isThinking = false) {
    const chatSession = document.getElementById("chat-session");
    if (!chatSession) return;
    
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

async function fetchAndDisplayMessages(chatId) {
    try {
        const response = await fetch('api/messages.php?chat_id=' + encodeURIComponent(chatId));
        if (!response.ok) throw new Error("Failed to fetch messages");
        
        const data = await response.json();
        const messages = data.messages || [];
        const chatSession = document.getElementById("chat-session");
        if (chatSession) chatSession.innerHTML = '';
        
        createMessageElement('professor', "Përshëndetje! Si mund t'ju ndihmoj sot?");
        messages.forEach(msg => {
            createMessageElement(msg.role, msg.content);
        });
    } catch (error) {
        console.error("Error loading messages:", error);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const submitBtn = document.querySelector('#send-button');
    const inputField = document.querySelector('#user-input');
    const chatSession = document.getElementById("chat-session");

    if (!submitBtn || !inputField || !chatSession) return;

    const params = new URLSearchParams(window.location.search);
    const initialChatId = params.get('chat_id');
    if (initialChatId) {
        window.currentChatId = initialChatId;
        fetchAndDisplayMessages(initialChatId);
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
        if (!response.ok) throw new Error(`HTTP ${response.status}`);
    }

    async function handleChat() {
        const message = inputField.value.trim();
        if (!message) return;

        if (!window.currentChatId) {
            const newId = await startNewChat();
            window.currentChatId = newId; 
        }

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
                    chat_id: window.currentChatId
                })
            });

            if (!response.ok) throw new Error(`HTTP ${response.status}`);

            const data = await response.json();

            if (chatSession.contains(thinkingMsg)) {
                chatSession.removeChild(thinkingMsg);
            }

            let aiText = data?.choices?.[0]?.message?.content || data?.reply || "Përgjigje e papritur.";
            
            await saveMessageToBackend('professor', aiText);
            createMessageElement('professor', aiText);

        } catch (error) {
            console.error(error);
            if (chatSession.contains(thinkingMsg)) {
                const bubble = thinkingMsg.querySelector('.chat-bubble');
                if (bubble) bubble.innerHTML = "Ndodhi një gabim.";
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

window.addEventListener('popstate', () => {
    const params = new URLSearchParams(window.location.search);
    const chatId = params.get('chat_id');
    if (chatId) {
        window.currentChatId = chatId;
        fetchAndDisplayMessages(chatId);
    }
});