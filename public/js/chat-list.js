async function loadConversation(chatId) {
    const newUrl = new URL(window.location);
    newUrl.searchParams.set('chat_id', chatId);
    window.history.pushState({ path: newUrl.href }, '', newUrl.href);
    window.currentChatId = chatId;

    document.querySelectorAll('.conversation').forEach(el => {
        el.classList.toggle('active', el.dataset.id == chatId);
    });

    await fetchAndDisplayMessages(chatId);
}

async function addConversationToList(title = 'New Chat') {
    const response = await fetch('api/conversations.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'title=' + encodeURIComponent(title)
    });
    if (!response.ok) throw new Error(`HTTP ${response.status}`);
    
    const data = await response.json();
    const chatId = data.id;

    const list = document.getElementById('chat-list');
    if (!list) return chatId;

    const div = document.createElement('div');
    div.className = 'conversation active';
    div.dataset.id = chatId;
    div.onclick = () => loadConversation(chatId);

    const span = document.createElement('span');
    span.textContent = data.title;

    const btn = document.createElement('button');
    btn.className = 'delete-btn';
    btn.textContent = '✕';
    btn.onclick = (e) => {
        e.stopPropagation();
        deleteConversation(e, chatId);
    };

    div.appendChild(span);
    div.appendChild(btn);
    list.insertBefore(div, list.firstChild);

    document.querySelectorAll('.conversation').forEach(el => {
        if (el !== div) el.classList.remove('active');
    });

    return chatId;
}

async function startNewChat() { 
    const newChatId = await addConversationToList();
    if (newChatId) {
        window.currentChatId = newChatId;
        const newUrl = new URL(window.location);
        newUrl.searchParams.set('chat_id', newChatId);
        window.history.pushState({ path: newUrl.href }, '', newUrl.href);
        
        const chatSession = document.getElementById("chat-session");
        if (chatSession) chatSession.innerHTML = '';
        createMessageElement('professor', "Përshëndetje! Si mund t'ju ndihmoj sot?");
        return newChatId; 
    }
}

function deleteConversation(event, chatId) {
    fetch('api/conversations.php', {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `chat_id=${chatId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const conversationElem = document.querySelector(`.conversation[data-id="${chatId}"]`);
            if (conversationElem) conversationElem.remove();
            if (window.currentChatId == chatId) {
                window.currentChatId = null;
                window.location.href = window.location.pathname;
            }
        }
    });
}