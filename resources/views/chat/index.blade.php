@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card shadow-lg border-0">
                <!-- Header -->
                <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="mb-0">🤖 Trợ Lý AI Hỗ Trợ</h5>
                        <small class="text-white-50">Sẵn sàng giúp bạn 24/7</small>
                    </div>
                </div>

                <!-- Chat Messages -->
                <div class="card-body chat-box" id="chat-box" style="height: 500px; overflow-y: auto; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
                    <div id="messages-container">
                        <!-- Initial welcome message -->
                        <div class="mb-3 p-3 rounded" style="background: #e8f4f8; border-left: 4px solid #0066cc;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="font-size: 24px;">🤖</span>
                                <div>
                                    <strong>Chatbot:</strong>
                                    <p class="mb-0" style="color: #333;">Xin chào! 👋 Tôi là chatbot hỗ trợ khách hàng. Tôi có thể giúp bạn tìm hiểu về sản phẩm, giá cả, vận chuyển, thanh toán, v.v. Hãy hỏi tôi gì đó!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Input Area -->
                <div class="card-footer bg-light border-top">
                    <div class="input-group" style="gap: 8px;">
                        <input 
                            type="text" 
                            id="message-input" 
                            class="form-control form-control-lg" 
                            placeholder="Nhập tin nhắn (ví dụ: 'giá sản phẩm', 'sản phẩm Nike', 'khuyến mãi')..."
                            autocomplete="off"
                            style="border-radius: 20px;"
                        >
                        <button class="btn btn-primary btn-lg" id="send-btn" style="border-radius: 20px; padding: 0 25px;">
                            <span id="send-icon">📤</span>
                        </button>
                    </div>
                    <small class="text-muted mt-2 d-block">💡 Gợi ý: hỏi về "sản phẩm", "giá", "Nike", "Adidas", "khuyến mãi", v.v.</small>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card mt-4 border-0 bg-light">
                <div class="card-body">
                    <p class="mb-0">
                        <strong>ℹ️ Lưu ý:</strong> Đây là chatbot thử nghiệm sử dụng phản hồi mẫu. 
                        <a href="/support">Tạo yêu cầu hỗ trợ</a> để được hỗ trợ chuyên nghiệp từ nhân viên.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .chat-box {
        border-radius: 15px;
        scroll-behavior: smooth;
    }

    .user-message {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 15px;
    }

    .user-message .message-content {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 12px 18px;
        border-radius: 18px;
        max-width: 70%;
        word-wrap: break-word;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .bot-message {
        display: flex;
        justify-content: flex-start;
        margin-bottom: 15px;
    }

    .bot-message .message-content {
        background: white;
        color: #333;
        padding: 12px 18px;
        border-radius: 18px;
        max-width: 70%;
        word-wrap: break-word;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        border-left: 4px solid #0066cc;
    }

    .typing-indicator {
        display: flex;
        align-items: center;
        gap: 5px;
        padding: 12px 18px;
        background: white;
        border-radius: 18px;
        width: fit-content;
        border-left: 4px solid #0066cc;
    }

    .typing-indicator span {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #0066cc;
        animation: typing 1.4s infinite;
    }

    .typing-indicator span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .typing-indicator span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes typing {
        0%, 60%, 100% { 
            opacity: 0.5;
            transform: translateY(0);
        }
        30% { 
            opacity: 1;
            transform: translateY(-10px);
        }
    }

    #send-btn:hover {
        transform: scale(1.05);
        transition: all 0.3s ease;
    }

    .card {
        border-radius: 15px;
        transition: box-shadow 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
</style>

<script>
const sessionId = 'session_' + Date.now();
const token = "{{ csrf_token() }}";
let isLoading = false;

// Event listeners
document.getElementById('send-btn').addEventListener('click', sendMessage);
document.getElementById('message-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter' && !isLoading) {
        sendMessage();
    }
});

function sendMessage() {
    const messageInput = document.getElementById('message-input');
    const message = messageInput.value.trim();
    
    if (!message || isLoading) return;

    isLoading = true;
    document.getElementById('send-btn').disabled = true;

    // Hiển thị tin nhắn user
    addMessage(message, 'user');
    messageInput.value = '';

    // Hiển thị typing indicator
    showTypingIndicator();

    // Gửi đến server
    fetch('{{ route("chat.send") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            message: message,
            session_id: sessionId
        })
    })
    .then(res => res.json())
    .then(data => {
        removeTypingIndicator();
        if (data.success) {
            addMessage(data.message, 'bot');
        } else {
            addMessage('❌ Lỗi: ' + data.error, 'bot');
        }
    })
    .catch(err => {
        removeTypingIndicator();
        addMessage('❌ Lỗi kết nối: ' + err.message, 'bot');
    })
    .finally(() => {
        isLoading = false;
        document.getElementById('send-btn').disabled = false;
        document.getElementById('message-input').focus();
    });
}

function addMessage(text, sender) {
    const container = document.getElementById('messages-container');
    const div = document.createElement('div');
    
    if (sender === 'user') {
        div.className = 'user-message';
        div.innerHTML = `<div class="message-content">${escapeHtml(text)}</div>`;
    } else {
        div.className = 'bot-message';
        div.innerHTML = `<div class="message-content">🤖 ${text}</div>`;
    }
    
    container.appendChild(div);
    scrollToBottom();
}

function showTypingIndicator() {
    const container = document.getElementById('messages-container');
    const div = document.createElement('div');
    div.id = 'typing-indicator';
    div.className = 'bot-message';
    div.innerHTML = `<div class="typing-indicator"><span></span><span></span><span></span></div>`;
    container.appendChild(div);
    scrollToBottom();
}

function removeTypingIndicator() {
    const indicator = document.getElementById('typing-indicator');
    if (indicator) {
        indicator.remove();
    }
}

function scrollToBottom() {
    const chatBox = document.getElementById('chat-box');
    chatBox.scrollTop = chatBox.scrollHeight;
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Focus vào input khi load
document.getElementById('message-input').focus();
</script>
@endsection
