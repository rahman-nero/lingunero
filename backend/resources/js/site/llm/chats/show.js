const form = document.getElementById('chatForm');
const input = document.getElementById('chatInput');
const messages = document.getElementById('chatMessages');
const loader = document.getElementById('chatLoader');

const path = window.location.pathname; // "/llm/chats/1"
const parts = path.split('/');// ["", "llm", "chats", "1"]
const chatId = parts[3];// "1" (строка)


function scrollToBottom() {
    messages.scrollTop = messages.scrollHeight;
}

function addMessage(text, type) {
    const wrapper = document.createElement('div');
    wrapper.className = `chat-message chat-message--${type}`;

    const bubble = document.createElement('div');
    bubble.className = 'chat-message__bubble';
    bubble.innerHTML = text;

    wrapper.appendChild(bubble);
    messages.appendChild(wrapper);

    scrollToBottom();
}

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const text = input.value.trim();
    if (!text) return;

    // сообщение пользователя
    addMessage(text, 'outgoing');
    input.value = '';

    // loader
    loader.classList.add('is-visible');
    scrollToBottom();

    try {
        const response = await fetch(`/llm/${chatId}/messages`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content'),
            },
            body: JSON.stringify({
                message: text,
            }),
        });

        const data = await response.json();

        // ответ ИИ
        addMessage(data.response, 'incoming');
    } catch (e) {
        addMessage('Ошибка получения ответа 😢', 'incoming');
    } finally {
        loader.classList.remove('is-visible');
    }
});
