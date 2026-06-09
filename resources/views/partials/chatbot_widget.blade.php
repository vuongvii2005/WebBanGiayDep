@if(auth()->check())
<style>
    /* Chatbot Widget */
    .chatbot-widget {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 999;
    }

    .chatbot-toggle-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        transition: all 0.3s ease;
    }

    .chatbot-toggle-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
    }

    .chatbot-toggle-btn.active {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }

    .chatbot-widget-box {
        position: absolute;
        bottom: 80px;
        right: 0;
        width: 380px;
        height: 500px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 5px 40px rgba(0, 0, 0, 0.16);
        display: none;
        flex-direction: column;
        overflow: hidden;
        animation: slideIn 0.3s ease;
    }

    .chatbot-widget-box.active {
        display: flex;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .chatbot-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chatbot-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
    }

    .chatbot-close {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        font-size: 20px;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chatbot-messages {
        flex: 1;
        overflow-y: auto;
        padding: 16px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        scroll-behavior: smooth;
    }

    .chatbot-message {
        margin-bottom: 12px;
        display: flex;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .chatbot-message.user {
        justify-content: flex-end;
    }

    .chatbot-message.bot {
        justify-content: flex-start;
    }

    .chatbot-message-content {
        max-width: 75%;
        padding: 10px 14px;
        border-radius: 12px;
        word-wrap: break-word;
        font-size: 14px;
        line-height: 1.4;
    }

    .chatbot-message.user .chatbot-message-content {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-bottom-right-radius: 4px;
    }

    .chatbot-message.bot .chatbot-message-content {
        background: white;
        color: #333;
        border: 1px solid #e0e0e0;
        border-bottom-left-radius: 4px;
        white-space: pre-wrap;
        word-break: break-word;
    }

    .chatbot-message-content a {
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
        border-bottom: 1px solid #667eea;
    }

    .chatbot-message-content a:hover {
        color: #764ba2;
        border-bottom-color: #764ba2;
    }

    .chatbot-input-area {
        padding: 12px;
        background: white;
        border-top: 1px solid #e0e0e0;
        display: flex;
        gap: 8px;
    }

    .chatbot-input-area input {
        flex: 1;
        border: 1px solid #e0e0e0;
        border-radius: 20px;
        padding: 10px 14px;
        font-size: 13px;
        outline: none;
        transition: border-color 0.3s ease;
    }

    .chatbot-input-area input:focus {
        border-color: #667eea;
    }

    .chatbot-send-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .chatbot-send-btn:hover {
        transform: scale(1.05);
    }

    .chatbot-send-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .chatbot-typing {
        display: flex;
        gap: 4px;
        padding: 10px 14px;
    }

    .chatbot-typing span {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #667eea;
        animation: typing 1.4s infinite;
    }

    .chatbot-typing span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .chatbot-typing span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes typing {
        0%, 60%, 100% {
            opacity: 0.5;
            transform: translateY(0);
        }
        30% {
            opacity: 1;
            transform: translateY(-8px);
        }
    }

    .chatbot-welcome {
        background: #e8f4f8;
        border-left: 4px solid #667eea;
        padding: 10px 14px;
        border-radius: 8px;
        font-size: 13px;
        color: #333;
    }

    @media (max-width: 480px) {
        .chatbot-widget-box {
            width: calc(100vw - 20px);
            height: 70vh;
            right: 10px;
            bottom: 70px;
        }

        .chatbot-message-content {
            max-width: 85%;
        }
    }
</style>

<!-- Chatbot Widget -->
<div class="chatbot-widget">
    <!-- Toggle Button -->
    <button class="chatbot-toggle-btn" id="chatbot-toggle" title="Mở chat">
        🤖
    </button>

    <!-- Chat Box -->
    <div class="chatbot-widget-box" id="chatbot-box">
        <!-- Header -->
        <div class="chatbot-header">
            <h3>💬 AI Hỗ Trợ</h3>
            <button class="chatbot-close" id="chatbot-close">✕</button>
        </div>

        <!-- Messages -->
        <div class="chatbot-messages" id="chatbot-messages">
            <div class="chatbot-message bot">
                <div class="chatbot-welcome">
                    👋 Xin chào! Tôi là trợ lý AI hỗ trợ. Hãy hỏi tôi bất cứ điều gì về sản phẩm, giá cả, vận chuyển, v.v.
                </div>
            </div>
        </div>

        <!-- Input -->
        <div class="chatbot-input-area">
            <input
                type="text"
                id="chatbot-input"
                placeholder="Nhập tin nhắn..."
                autocomplete="off"
            >
            <button class="chatbot-send-btn" id="chatbot-send">📤</button>
        </div>
    </div>
</div>

<script>
(() => {
    const sessionId = `session_${Date.now()}`;
    const token = "{{ csrf_token() }}";
    const chatRoute = '{{ route("chat.send") }}';

    let isLoading = false;

    const elements = {
        toggle: document.getElementById('chatbot-toggle'),
        box: document.getElementById('chatbot-box'),
        closeBtn: document.getElementById('chatbot-close'),
        input: document.getElementById('chatbot-input'),
        sendBtn: document.getElementById('chatbot-send'),
        messagesContainer: document.getElementById('chatbot-messages')
    };

    if (Object.values(elements).some((el) => !el)) {
        return;
    }

    const { toggle, box, closeBtn, input, sendBtn, messagesContainer } = elements;

    const linkPatterns = [
        {
            regex: /\/product\/(\d+)/g,
            replacement: '<a href="/product/$1" target="_blank" rel="noopener noreferrer">Xem sản phẩm</a>'
        },
        {
            regex: /\/orders/g,
            replacement: '<a href="/orders" target="_blank" rel="noopener noreferrer">Xem đơn hàng</a>'
        },
        {
            regex: /\/support/g,
            replacement: '<a href="/support" target="_blank" rel="noopener noreferrer">Hỗ trợ</a>'
        }
    ];

    toggle.addEventListener('click', () => {
        setWidgetOpen(!box.classList.contains('active'));
    });

    closeBtn.addEventListener('click', () => {
        setWidgetOpen(false);
    });

    sendBtn.addEventListener('click', sendMessage);
    input.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' && !isLoading) {
            sendMessage();
        }
    });

    function setWidgetOpen(isOpen) {
        box.classList.toggle('active', isOpen);
        toggle.classList.toggle('active', isOpen);

        if (isOpen) {
            input.focus();
        }
    }

    async function sendMessage() {
        const message = input.value.trim();
        if (!message || isLoading) {
            return;
        }

        isLoading = true;
        sendBtn.disabled = true;

        addMessage(message, 'user');
        input.value = '';
        showTyping();

        try {
            const response = await fetch(chatRoute, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    message,
                    session_id: sessionId
                })
            });

            const data = await response.json();
            removeTyping();

            if (data.success) {
                addMessage(data.message, 'bot');
                return;
            }

            addMessage(`❌ Lỗi: ${data.error}`, 'bot');
        } catch (_error) {
            removeTyping();
            addMessage('❌ Lỗi kết nối', 'bot');
        } finally {
            isLoading = false;
            sendBtn.disabled = false;
            input.focus();
        }
    }

    function addMessage(text, sender) {
        const wrapper = document.createElement('div');
        wrapper.className = `chatbot-message ${sender}`;

        const content = document.createElement('div');
        content.className = 'chatbot-message-content';
        content.innerHTML = `${sender === 'bot' ? '🤖 ' : ''}${formatMessage(text)}`;

        wrapper.appendChild(content);
        messagesContainer.appendChild(wrapper);
        scrollToBottom();
    }

    function formatMessage(text) {
        let formattedText = escapeHtml(text).replace(/\n/g, '<br>');

        linkPatterns.forEach(({ regex, replacement }) => {
            formattedText = formattedText.replace(regex, replacement);
        });

        return formattedText;
    }

    function showTyping() {
        const indicator = document.createElement('div');
        indicator.id = 'typing-indicator';
        indicator.className = 'chatbot-message bot';
        indicator.innerHTML = '<div class="chatbot-typing"><span></span><span></span><span></span></div>';

        messagesContainer.appendChild(indicator);
        scrollToBottom();
    }

    function removeTyping() {
        const typing = document.getElementById('typing-indicator');
        if (typing) {
            typing.remove();
        }
    }

    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
})();
</script>
@endif
