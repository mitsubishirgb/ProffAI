function loadConversation(chatId) {
    window.location.href = `index.php?chat_id=${chatId}`;
}

function deleteConversation(event, chatId) {
    event.stopPropagation();

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
                addConversationToList();
            }
        } else {
            alert("Gabim gjatë fshirjes: " + (data.error || "Provoni përsëri."));
        }
    })
    .catch(err => {
        console.error("Delete error:", err);
        alert("Problem me serverin. Provoni përsëri.");
    });
}

async function loadConversationList() { 
    const response = await fetch('api/conversations.php');
    if (!response.ok) {
        throw new Error(`HTTP ${response.status}`);
    }
    const conversations = await response.json();
    const list = document.getElementById('chat-list');
    if (!list) return;
    list.innerHTML = '';
    conversations.forEach(conv => {
        const div = document.createElement('div');
        div.className = 'conversation ' + conv.role + (window.currentChatId == conv.id ? ' active' : '');
        div.dataset.id = conv.id;
        div.onclick = () => loadConversation(conv.id);
        list.appendChild(div);
    });
}

async function addConversationToList(title = 'New Chat') {

    const response = await fetch('api/conversations.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'title=' + encodeURIComponent(title)
    });
    if (!response.ok) {
        throw new Error(`HTTP ${response.status}`);
    }
    const data = await response.json();
    chatId = data.id;
    

    const list = document.getElementById('chat-list');
    if (!list) return;

    const existing = document.querySelector(`.conversation[data-id="${chatId}"]`);
    if (existing) {
        existing.classList.add('active');
        return;
    }

    const div = document.createElement('div');
    div.className = 'conversation active';
    div.dataset.id = chatId;
    div.onclick = () => loadConversation(chatId);

    const span = document.createElement('span');
    span.textContent = title;

    const btn = document.createElement('button');
    btn.className = 'delete-btn';
    btn.textContent = '✕';
    btn.onclick = (e) => deleteConversation(e, chatId);

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
        loadConversation(newChatId);
    }
}