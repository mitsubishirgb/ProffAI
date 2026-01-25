document.addEventListener('DOMContentLoaded', () => {
    const submitBtn = document.querySelector('#send-button');
    const inputField = document.querySelector('#user-input');

    if (!submitBtn || !inputField) {
        console.error("Critical Error: UI elements not found. Check HTML IDs.");
        return;
    }

    submitBtn.addEventListener('click', () => {
        askAI();
    });

    inputField.addEventListener('keypress', (event) => {
        if (event.key === 'Enter') {
            askAI();
        }
    });
});

const chatSession = document.getElementById("chat-session");

function addUserMessage(text) {
    const msg = document.createElement("div");
    msg.className = "chat-message user";

    const bubble = document.createElement("div");
    bubble.className = "chat-bubble";
    bubble.textContent = text;

    msg.appendChild(bubble);
    chatSession.appendChild(msg);
}

function addAIMessage(text) {
    const msg = document.createElement("div");
    msg.className = "chat-message ai";

    const avatar = document.createElement("img");
    avatar.src = "assets/icons/cheerful-elderly-man-with-glasses.png";

    const bubble = document.createElement("div");
    bubble.className = "chat-bubble";
    bubble.textContent = text;

    msg.append(avatar, bubble);
    chatSession.appendChild(msg);
}

async function askAI() {
    const input = document.getElementById("user-input");
    const tmpInput = input.value.trim();

    if (!tmpInput) return;

    addUserMessage(tmpInput);
    input.value = "";

    addAIMessage("Thinking...");

    try {
        const response = await fetch('../api/ai.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message: tmpInput })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        console.log("AI RAW RESPONSE:", data);

        let aiText = "";

        // Groq / OpenAI format
        if (data?.choices?.[0]?.message?.content) {
            aiText = data.choices[0].message.content;
        }

        else if (data?.candidates?.[0]?.content?.parts?.[0]?.text) {
            aiText = data.candidates[0].content.parts[0].text;
        }

        else if (data?.error?.message) {
            aiText = "Gabim nga AI: " + data.error.message;
        }
        // Unknown format
        else {
            throw new Error("Invalid API response structure");
        }

        document.querySelector('.chat-message.ai:last-child .chat-bubble').innerText = aiText;

    } catch (error) {
        console.error("AI Error:", error);
        document.querySelector('.chat-message.ai:last-child .chat-bubble').innerText =
            "Ndodhi një gabim. Provo përsëri.";
    }
}