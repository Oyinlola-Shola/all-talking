// ALL TALKING Chat System - Complete JavaScript
// Global variables
let currentUser = null;
let chats = [];
let messages = {};
let typingUsers = {};
let emojiPickerActive = false;
let statusUpdates = [];
let currentChatId = null;

// DOM Content Loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
    
    // Check if user is logged in
    if (localStorage.getItem('currentUser')) {
        currentUser = JSON.parse(localStorage.getItem('currentUser'));
    }
    
    // Initialize page-specific functionality
    const path = window.location.pathname;
    if (path.includes('index.html') || path.endsWith('/')) {
        initLandingPage();
    } else if (path.includes('login.html')) {
        initLoginPage();
    } else if (path.includes('register.html')) {
        initRegisterPage();
    } else if (path.includes('chat.html')) {
        if (!currentUser) {
            window.location.href = '../index.html';
            return;
        }
        initChatPage();
    } else if (path.includes('profile.html')) {
        if (!currentUser) {
            window.location.href = '../index.html';
            return;
        }
        initProfilePage();
    } else if (path.includes('settings.html')) {
        if (!currentUser) {
            window.location.href = '../index.html';
            return;
        }
        initSettingsPage();
    }
});

// Initialize app
function initializeApp() {
    // Load users and chats from localStorage
    if (!localStorage.getItem('users')) {
        localStorage.setItem('users', JSON.stringify([]));
    }
    
    if (!localStorage.getItem('chats')) {
        localStorage.setItem('chats', JSON.stringify([]));
    }
    
    if (!localStorage.getItem('messages')) {
        localStorage.setItem('messages', JSON.stringify({}));
    }
    
    if (!localStorage.getItem('statusUpdates')) {
        localStorage.setItem('statusUpdates', JSON.stringify([]));
    }
    
    // Load theme preference
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    
    // Initialize sample data if needed
    initSampleData();
}

// Initialize sample data
function initSampleData() {
    const users = JSON.parse(localStorage.getItem('users'));
    if (users.length === 0) {
        const sampleUsers = [
            {
                id: 1,
                name: 'Alex Johnson',
                email: 'alex@example.com',
                phone: '+1234567890',
                password: 'password123',
                avatar: null
            },
            {
                id: 2,
                name: 'Sarah Miller',
                email: 'sarah@example.com',
                phone: '+1234567891',
                password: 'password123',
                avatar: null
            },
            {
                id: 3,
                name: 'Mike Wilson',
                email: 'mike@example.com',
                phone: '+1234567892',
                password: 'password123',
                avatar: null
            },
            {
                id: 4,
                name: 'Emma Davis',
                email: 'emma@example.com',
                phone: '+1234567893',
                password: 'password123',
                avatar: null
            },
            {
                id: 5,
                name: 'David Brown',
                email: 'david@example.com',
                phone: '+1234567894',
                password: 'password123',
                avatar: null
            },
            {
                id: 6,
                name: 'Lisa Taylor',
                email: 'lisa@example.com',
                phone: '+1234567895',
                password: 'password123',
                avatar: null
            }
        ];
        localStorage.setItem('users', JSON.stringify(sampleUsers));
    }
    
    const chatsData = JSON.parse(localStorage.getItem('chats'));
    if (chatsData.length === 0) {
        const sampleChats = [
            {
                id: 1,
                name: 'Alex Johnson',
                type: 'private',
                participants: [1, 7], // Assuming current user has id 7
                lastMessage: 'Hey, are we still meeting tomorrow?',
                lastMessageTime: new Date().toISOString(),
                unread: 2
            },
            {
                id: 2,
                name: 'Sarah Miller',
                type: 'private',
                participants: [2, 7],
                lastMessage: 'Thanks for your help yesterday!',
                lastMessageTime: new Date(Date.now() - 3600000).toISOString(),
                unread: 0
            },
            {
                id: 3,
                name: 'Work Group',
                type: 'group',
                participants: [1, 2, 3, 7],
                lastMessage: 'Mike: The meeting is postponed to 3 PM',
                lastMessageTime: new Date(Date.now() - 7200000).toISOString(),
                unread: 5
            },
            {
                id: 4,
                name: 'Mike Wilson',
                type: 'private',
                participants: [3, 7],
                lastMessage: 'Can you send me those files?',
                lastMessageTime: new Date(Date.now() - 86400000).toISOString(),
                unread: 0
            },
            {
                id: 5,
                name: 'Emma Davis',
                type: 'private',
                participants: [4, 7],
                lastMessage: 'The party starts at 8 PM, don\'t be late!',
                lastMessageTime: new Date(Date.now() - 172800000).toISOString(),
                unread: 1
            },
            {
                id: 6,
                name: 'David Brown',
                type: 'private',
                participants: [5, 7],
                lastMessage: 'Did you watch the game last night?',
                lastMessageTime: new Date(Date.now() - 259200000).toISOString(),
                unread: 0
            }
        ];
        localStorage.setItem('chats', JSON.stringify(sampleChats));
    }
    
    const messagesData = JSON.parse(localStorage.getItem('messages'));
    if (Object.keys(messagesData).length === 0) {
        const sampleMessages = {
            1: [
                {
                    id: 1,
                    senderId: 1,
                    content: 'Hey, are we still meeting tomorrow?',
                    timestamp: new Date(Date.now() - 600000).toISOString(),
                    type: 'text'
                },
                {
                    id: 2,
                    senderId: 7,
                    content: 'Yes, definitely! 7 PM at the usual place.',
                    timestamp: new Date(Date.now() - 300000).toISOString(),
                    type: 'text'
                },
                {
                    id: 3,
                    senderId: 1,
                    content: 'Perfect! See you then 👋',
                    timestamp: new Date(Date.now() - 120000).toISOString(),
                    type: 'text'
                }
            ],
            2: [
                {
                    id: 1,
                    senderId: 2,
                    content: 'Thanks for your help yesterday!',
                    timestamp: new Date(Date.now() - 3600000).toISOString(),
                    type: 'text'
                },
                {
                    id: 2,
                    senderId: 7,
                    content: 'No problem! Happy to help.',
                    timestamp: new Date(Date.now() - 3500000).toISOString(),
                    type: 'text'
                },
                {
                    id: 3,
                    senderId: 2,
                    content: 'Let me know if you need anything from me too!',
                    timestamp: new Date(Date.now() - 3400000).toISOString(),
                    type: 'text'
                }
            ],
            3: [
                {
                    id: 1,
                    senderId: 1,
                    content: 'Team, we need to discuss the new project',
                    timestamp: new Date(Date.now() - 86400000).toISOString(),
                    type: 'text'
                },
                {
                    id: 2,
                    senderId: 3,
                    content: 'I\'ve prepared the initial specs',
                    timestamp: new Date(Date.now() - 86000000).toISOString(),
                    type: 'text'
                },
                {
                    id: 3,
                    senderId: 2,
                    content: 'When should we schedule the meeting?',
                    timestamp: new Date(Date.now() - 85000000).toISOString(),
                    type: 'text'
                },
                {
                    id: 4,
                    senderId: 7,
                    content: 'How about tomorrow at 10 AM?',
                    timestamp: new Date(Date.now() - 84000000).toISOString(),
                    type: 'text'
                },
                {
                    id: 5,
                    senderId: 3,
                    content: 'The meeting is postponed to 3 PM',
                    timestamp: new Date(Date.now() - 7200000).toISOString(),
                    type: 'text'
                }
            ],
            4: [
                {
                    id: 1,
                    senderId: 3,
                    content: 'Can you send me those files?',
                    timestamp: new Date(Date.now() - 86400000).toISOString(),
                    type: 'text'
                },
                {
                    id: 2,
                    senderId: 7,
                    content: 'Sure, I\'ll send them over in a bit',
                    timestamp: new Date(Date.now() - 86000000).toISOString(),
                    type: 'text'
                }
            ],
            5: [
                {
                    id: 1,
                    senderId: 4,
                    content: 'Hey! Are you coming to the party on Saturday?',
                    timestamp: new Date(Date.now() - 172800000).toISOString(),
                    type: 'text'
                },
                {
                    id: 2,
                    senderId: 7,
                    content: 'Yes, I\'ll be there!',
                    timestamp: new Date(Date.now() - 172000000).toISOString(),
                    type: 'text'
                },
                {
                    id: 3,
                    senderId: 4,
                    content: 'Great! The party starts at 8 PM, don\'t be late!',
                    timestamp: new Date(Date.now() - 171500000).toISOString(),
                    type: 'text'
                }
            ],
            6: [
                {
                    id: 1,
                    senderId: 5,
                    content: 'Did you watch the game last night?',
                    timestamp: new Date(Date.now() - 259200000).toISOString(),
                    type: 'text'
                },
                {
                    id: 2,
                    senderId: 7,
                    content: 'Yes, it was amazing! That last goal was incredible!',
                    timestamp: new Date(Date.now() - 258000000).toISOString(),
                    type: 'text'
                },
                {
                    id: 3,
                    senderId: 5,
                    content: 'I know right! Best game of the season so far',
                    timestamp: new Date(Date.now() - 257000000).toISOString(),
                    type: 'text'
                }
            ]
        };
        localStorage.setItem('messages', JSON.stringify(sampleMessages));
    }
    
    const statusData = JSON.parse(localStorage.getItem('statusUpdates'));
    if (statusData.length === 0) {
        const sampleStatuses = [
            {
                id: 1,
                userId: 1,
                userName: 'Alex Johnson',
                text: 'At the beach!',
                media: null,
                timestamp: new Date().toISOString(),
                expiresAt: new Date(Date.now() + 24 * 60 * 60 * 1000).toISOString()
            },
            {
                id: 2,
                userId: 2,
                userName: 'Sarah Miller',
                text: 'Working on new project',
                media: null,
                timestamp: new Date(Date.now() - 2 * 60 * 60 * 1000).toISOString(),
                expiresAt: new Date(Date.now() + 22 * 60 * 60 * 1000).toISOString()
            },
            {
                id: 3,
                userId: 3,
                userName: 'Mike Wilson',
                text: 'Game night!',
                media: null,
                timestamp: new Date(Date.now() - 5 * 60 * 60 * 1000).toISOString(),
                expiresAt: new Date(Date.now() + 19 * 60 * 60 * 1000).toISOString()
            },
            {
                id: 4,
                userId: 4,
                userName: 'Emma Davis',
                text: 'Coffee time ☕',
                media: null,
                timestamp: new Date(Date.now() - 8 * 60 * 60 * 1000).toISOString(),
                expiresAt: new Date(Date.now() + 16 * 60 * 60 * 1000).toISOString()
            }
        ];
        localStorage.setItem('statusUpdates', JSON.stringify(sampleStatuses));
    }
}

// Landing Page
function initLandingPage() {
    // No specific functionality needed for landing page
}

// Login Page
function initLoginPage() {
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            const users = JSON.parse(localStorage.getItem('users'));
            const user = users.find(u => (u.email === email || u.name === email) && u.password === password);
            
            if (user) {
                currentUser = user;
                localStorage.setItem('currentUser', JSON.stringify(user));
                window.location.href = 'chat.html';
            } else {
                alert('Invalid email/username or password');
            }
        });
    }
}

// Register Page
function initRegisterPage() {
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (password !== confirmPassword) {
                alert('Passwords do not match');
                return;
            }
            
            const users = JSON.parse(localStorage.getItem('users'));
            
            // Check if email already exists
            if (users.find(u => u.email === email)) {
                alert('Email already registered');
                return;
            }
            
            // Create new user
            const newUser = {
                id: users.length > 0 ? Math.max(...users.map(u => u.id)) + 1 : 1,
                name,
                email,
                phone,
                password,
                avatar: null
            };
            
            users.push(newUser);
            localStorage.setItem('users', JSON.stringify(users));
            
            alert('Registration successful! Please login.');
            window.location.href = 'login.html';
        });
    }
}

// Chat Page
function initChatPage() {
    loadStatusUpdates();
    loadChats();
    setupChatEventListeners();
    startMessageRefresh();
    
    // If a chat is selected from URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const chatId = urlParams.get('chat');
    if (chatId) {
        openChat(parseInt(chatId));
    }
}

// Load status updates
function loadStatusUpdates() {
    statusUpdates = JSON.parse(localStorage.getItem('statusUpdates')) || [];
    const statusList = document.getElementById('statusList');
    if (!statusList) return;
    
    statusList.innerHTML = '';
    
    // Add "my status" item
    const myStatusItem = document.createElement('div');
    myStatusItem.className = 'status-item';
    myStatusItem.innerHTML = `
        <div class="status-avatar add-status">
            <i class="fas fa-plus"></i>
            <div class="add-status-btn">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="status-name">My Status</div>
    `;
    
    myStatusItem.addEventListener('click', showAddStatusModal);
    statusList.appendChild(myStatusItem);
    
    // Add other statuses
    statusUpdates.forEach(status => {
        if (status.userId !== currentUser.id) {
            const statusItem = document.createElement('div');
            statusItem.className = 'status-item';
            statusItem.innerHTML = `
                <div class="status-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="status-name">${status.userName}</div>
            `;
            
            statusList.appendChild(statusItem);
        }
    });
}

// Show add status modal
function showAddStatusModal() {
    const modal = document.getElementById('addStatusModal');
    if (!modal) return;
    
    modal.classList.add('active');
    
    // Setup event listeners for the modal
    document.getElementById('closeStatusModal').addEventListener('click', () => {
        modal.classList.remove('active');
    });
    
    document.getElementById('cancelStatusBtn').addEventListener('click', () => {
        modal.classList.remove('active');
    });
    
    // Upload area click handler
    const uploadArea = document.getElementById('uploadArea');
    if (uploadArea) {
        uploadArea.addEventListener('click', () => {
            document.getElementById('statusMedia').click();
        });
    }
    
    // Post status button
    document.getElementById('postStatusBtn').addEventListener('click', postStatus);
}

// Post a new status
function postStatus() {
    const statusText = document.getElementById('statusText').value;
    const statusMedia = document.getElementById('statusMedia').files[0];
    
    if (!statusText.trim() && !statusMedia) {
        alert('Please add text or media to your status');
        return;
    }
    
    const newStatus = {
        id: statusUpdates.length > 0 ? Math.max(...statusUpdates.map(s => s.id)) + 1 : 1,
        userId: currentUser.id,
        userName: currentUser.name,
        text: statusText,
        media: null,
        timestamp: new Date().toISOString(),
        expiresAt: new Date(Date.now() + 24 * 60 * 60 * 1000).toISOString()
    };
    
    statusUpdates.push(newStatus);
    localStorage.setItem('statusUpdates', JSON.stringify(statusUpdates));
    
    // Close modal
    document.getElementById('addStatusModal').classList.remove('active');
    
    // Reload status updates
    loadStatusUpdates();
    
    // Reset form
    document.getElementById('statusText').value = '';
    document.getElementById('statusMedia').value = '';
}

// Load chats from localStorage
function loadChats() {
    chats = JSON.parse(localStorage.getItem('chats')) || [];
    messages = JSON.parse(localStorage.getItem('messages')) || {};
    
    const chatsList = document.getElementById('chatsList');
    if (!chatsList) return;
    
    chatsList.innerHTML = '';
    
    chats.forEach(chat => {
        const chatElement = document.createElement('div');
        chatElement.className = 'chat-item';
        chatElement.dataset.chatId = chat.id;
        
        const users = JSON.parse(localStorage.getItem('users'));
        const otherParticipants = chat.participants.filter(id => id !== currentUser.id);
        const participantNames = otherParticipants.map(id => {
            const user = users.find(u => u.id === id);
            return user ? user.name : 'Unknown User';
        });
        
        const chatName = chat.type === 'group' ? chat.name : participantNames[0] || 'Unknown';
        
        chatElement.innerHTML = `
            <div class="chat-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="chat-details">
                <div class="chat-name">${chatName}</div>
                <div class="chat-preview-message">${chat.lastMessage}</div>
            </div>
            <div class="chat-meta">
                <div class="chat-time">${formatTime(chat.lastMessageTime)}</div>
                ${chat.unread > 0 ? <div class="chat-unread">${chat.unread}</div> : ''}
            </div>
        `;
        
        chatElement.addEventListener('click', () => {
            openChat(chat.id);
        });
        
        chatsList.appendChild(chatElement);
    });
}

// Open a chat
function openChat(chatId) {
    const chat = chats.find(c => c.id === chatId);
    if (!chat) return;
    
    currentChatId = chatId;
    
    // Update URL without reloading
    window.history.pushState({}, '', chat.html?chat=${chatId});
    
    // Show chat interface
    document.getElementById('chatsView').classList.add('hidden');
    document.getElementById('chatView').classList.remove('hidden');
    
    // Load chat messages
    loadChatMessages(chatId);
    
    // Update chat header
    const chatHeader = document.getElementById('chatHeader');
    const users = JSON.parse(localStorage.getItem('users'));
    const otherParticipants = chat.participants.filter(id => id !== currentUser.id);
    const participantNames = otherParticipants.map(id => {
        const user = users.find(u => u.id === id);
        return user ? user.name : 'Unknown User';
    });
    
    const chatName = chat.type === 'group' ? chat.name : participantNames[0] || 'Unknown';
    const status = chat.type === 'group' ? ${chat.participants.length} participants : 'Online';
    
    chatHeader.innerHTML = `
        <button class="back-button" id="backToChats">
            <i class="fas fa-arrow-left"></i>
        </button>
        <div class="chat-title">
            <h2>${chatName}</h2>
            <p id="chatStatus">${status}</p>
        </div>
        <div class="chat-actions">
            <button class="btn-icon" id="voiceCallBtn">
                <i class="fas fa-phone"></i>
            </button>
            <button class="btn-icon" id="videoCallBtn">
                <i class="fas fa-video"></i>
            </button>
            <button class="btn-icon" id="chatMenuBtn">
                <i class="fas fa-ellipsis-v"></i>
            </button>
        </div>
    `;
    
    // Add back button event listener
    document.getElementById('backToChats').addEventListener('click', () => {
        document.getElementById('chatsView').classList.remove('hidden');
        document.getElementById('chatView').classList.add('hidden');
        window.history.pushState({}, '', 'chat.html');
        currentChatId = null;
    });
    
    // Add call button event listeners
    document.getElementById('voiceCallBtn').addEventListener('click', () => {
        alert(Voice call to ${chatName} would start here);
    });
    
    document.getElementById('videoCallBtn').addEventListener('click', () => {
        alert(Video call to ${chatName} would start here);
    });
    
    document.getElementById('chatMenuBtn').addEventListener('click', () => {
        alert(Chat menu for ${chatName} would open here);
    });
    
    // Mark messages as read
    markChatAsRead(chatId);
}

// Load messages for a chat
function loadChatMessages(chatId) {
    const messagesContainer = document.getElementById('messagesContainer');
    if (!messagesContainer) return;
    
    messagesContainer.innerHTML = '';
    
    const chatMessages = messages[chatId] || [];
    const users = JSON.parse(localStorage.getItem('users'));
    const chat = chats.find(c => c.id === chatId);
    
    chatMessages.forEach(msg => {
        const messageElement = document.createElement('div');
        messageElement.className = message ${msg.senderId === currentUser.id ? 'sent' : 'received'};
        
        const sender = users.find(u => u.id === msg.senderId);
        const senderName = sender ? sender.name : 'Unknown';
        
        messageElement.innerHTML = `
            ${msg.senderId !== currentUser.id && chat.type === 'group' ? 
                <div class="message-sender">${senderName}</div> : ''}
            <div class="message-content">
                <p>${msg.content}</p>
                <div class="message-time">${formatTime(msg.timestamp)}</div>
            </div>
        `;
        
        messagesContainer.appendChild(messageElement);
    });
    
    // Scroll to bottom
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
    
    // Update input placeholder and send button
    const messageInput = document.getElementById('messageInput');
    const sendButton = document.getElementById('sendButton');
    
    if (messageInput && sendButton) {
        const users = JSON.parse(localStorage.getItem('users'));
        const otherParticipants = chat.participants.filter(id => id !== currentUser.id);
        const participantNames = otherParticipants.map(id => {
            const user = users.find(u => u.id === id);
            return user ? user.name : 'Unknown User';
        });
        
        const chatName = chat.type === 'group' ? chat.name : participantNames[0] || 'Unknown';
        
        messageInput.placeholder = Message ${chatName};
        messageInput.dataset.chatId = chatId;
        
        // Add event listeners for sending messages
        sendButton.addEventListener('click', sendMessage);
        messageInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });
        
        // Typing indicator
        messageInput.addEventListener('input', () => {
            if (messageInput.value.trim()) {
                showTypingIndicator(chatId);
            } else {
                hideTypingIndicator(chatId);
            }
        });
    }
}

// Send a message
function sendMessage() {
    const messageInput = document.getElementById('messageInput');
    const chatId = parseInt(messageInput.dataset.chatId);
    
    if (!messageInput.value.trim() || !chatId) return;
    
    const chat = chats.find(c => c.id === chatId);
    if (!chat) return;
    
    // Create new message
    const newMessage = {
        id: messages[chatId] ? Math.max(...messages[chatId].map(m => m.id)) + 1 : 1,
        senderId: currentUser.id,
        content: messageInput.value,
        timestamp: new Date().toISOString(),
        type: 'text'
    };
    
    // Add to messages
    if (!messages[chatId]) {
        messages[chatId] = [];
    }
    messages[chatId].push(newMessage);
    
    // Update chat last message
    chat.lastMessage = newMessage.content;
    chat.lastMessageTime = newMessage.timestamp;
    
    // Save to localStorage
    localStorage.setItem('messages', JSON.stringify(messages));
    localStorage.setItem('chats', JSON.stringify(chats));
    
    // Clear input
    messageInput.value = '';
    
    // Hide typing indicator
    hideTypingIndicator(chatId);
    
    // Reload messages
    loadChatMessages(chatId);
}

// Show typing indicator
function showTypingIndicator(chatId) {
    const typingIndicator = document.getElementById('typingIndicator');
    const chatStatus = document.getElementById('chatStatus');
    const chat = chats.find(c => c.id === chatId);
    
    if (typingIndicator && chatStatus && chat) {
        const users = JSON.parse(localStorage.getItem('users'));
        const otherParticipants = chat.participants.filter(id => id !== currentUser.id);
        const participantNames = otherParticipants.map(id => {
            const user = users.find(u => u.id === id);
            return user ? user.name : 'Unknown User';
        });
        
        const userName = chat.type === 'group' ? 'Someone' : participantNames[0] || 'Unknown';
        
        document.getElementById('typingText').textContent = ${userName} is typing;
        typingIndicator.classList.remove('hidden');
        chatStatus.textContent = 'Typing...';
    }
}

// Hide typing indicator
function hideTypingIndicator(chatId) {
    const typingIndicator = document.getElementById('typingIndicator');
    const chatStatus = document.getElementById('chatStatus');
    const chat = chats.find(c => c.id === chatId);
    
    if (typingIndicator && chatStatus && chat) {
        typingIndicator.classList.add('hidden');
        chatStatus.textContent = chat.type === 'group' ? ${chat.participants.length} participants : 'Online';
    }
}

// Mark chat as read
function markChatAsRead(chatId) {
    const chat = chats.find(c => c.id === chatId);
    if (chat && chat.unread > 0) {
        chat.unread = 0;
        localStorage.setItem('chats', JSON.stringify(chats));
        loadChats();
    }
}

// Format time for display
function formatTime(timestamp) {
    const date = new Date(timestamp);
    const now = new Date();
    const diff = now - date;
    
    if (diff < 86400000) { // Less than 24 hours
        return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    } else if (diff < 604800000) { // Less than 7 days
        return date.toLocaleDateString([], { weekday: 'short' });
    } else {
        return date.toLocaleDateString([], { month: 'short', day: 'numeric' });
    }
}

// Setup event listeners for chat page
function setupChatEventListeners() {
    // Add chat button
    const addChatBtn = document.getElementById('addChatBtn');
    if (addChatBtn) {
        addChatBtn.addEventListener('click', showAddChatModal);
    }
    
    // Emoji picker
    const emojiButton = document.getElementById('emojiButton');
    const emojiPicker = document.getElementById('emojiPicker');
    
    if (emojiButton && emojiPicker) {
        emojiButton.addEventListener('click', (e) => {
            e.stopPropagation();
            emojiPickerActive = !emojiPickerActive;
            emojiPicker.classList.toggle('active', emojiPickerActive);
            
            if (emojiPickerActive) {
                loadEmojiPicker();
            }
        });
        
        // Close emoji picker when clicking outside
        document.addEventListener('click', (e) => {
            if (!emojiPicker.contains(e.target) && e.target !== emojiButton) {
                emojiPickerActive = false;
                emojiPicker.classList.remove('active');
            }
        });
    }
    
    // Modal close buttons
    const closeModalBtn = document.getElementById('closeModalBtn');
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', () => {
            document.getElementById('addChatModal').classList.remove('active');
        });
    }
    
    const closeModal = document.getElementById('closeModal');
    if (closeModal) {
        closeModal.addEventListener('click', () => {
            document.getElementById('addChatModal').classList.remove('active');
        });
    }
    
    // Search functionality
    const searchButton = document.querySelector('.status-actions .btn-icon:first-child');
    if (searchButton) {
        searchButton.addEventListener('click', () => {
            alert('Search functionality would open here');
        });
    }
    
    // Menu functionality
    const menuButton = document.querySelector('.status-actions .btn-icon:last-child');
    if (menuButton) {
        menuButton.addEventListener('click', () => {
            alert('Chat list menu would open here');
        });
    }
}

// Show add chat modal
function showAddChatModal() {
    const modal = document.getElementById('addChatModal');
    if (!modal) return;
    
    const users = JSON.parse(localStorage.getItem('users'));
    const otherUsers = users.filter(u => u.id !== currentUser.id);
    
    const userList = document.getElementById('userList');
    userList.innerHTML = '';
    
    otherUsers.forEach(user => {
        const userElement = document.createElement('div');
        userElement.className = 'user-item';
        userElement.innerHTML = `
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="user-details">
                <div class="user-name">${user.name}</div>
                <div class="user-email">${user.email}</div>
            </div>
            <input type="checkbox" class="user-checkbox" value="${user.id}">
        `;
        userList.appendChild(userElement);
    });
    
    modal.classList.add('active');
    
    // Create chat button
    document.getElementById('createChat').addEventListener('click', createNewChat);
}

// Create new chat
function createNewChat() {
    const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked'))
        .map(cb => parseInt(cb.value));
    
    if (selectedUsers.length === 0) {
        alert('Please select at least one user');
        return;
    }
    
    const chatNameInput = document.getElementById('chatName');
    let chatName = chatNameInput.value;
    
    const users = JSON.parse(localStorage.getItem('users'));
    
    // If it's a private chat with one user, use their name
    if (selectedUsers.length === 1 && !chatName) {
        const user = users.find(u => u.id === selectedUsers[0]);
        chatName = user.name;
    }
    
    // If it's a group chat without a name, generate one
    if (selectedUsers.length > 1 && !chatName) {
        const userNames = selectedUsers.map(id => {
            const user = users.find(u => u.id === id);
            return user ? user.name : 'Unknown';
        });
        chatName = ${userNames.join(', ')};
        if (chatName.length > 30) {
            chatName = chatName.substring(0, 27) + '...';
        }
    }
    
    // Create new chat
    const newChat = {
        id: chats.length > 0 ? Math.max(...chats.map(c => c.id)) + 1 : 1,
        name: chatName,
        type: selectedUsers.length > 1 ? 'group' : 'private',
        participants: [currentUser.id, ...selectedUsers],
        lastMessage: 'Chat created',
        lastMessageTime: new Date().toISOString(),
        unread: 0
    };
    
    chats.push(newChat);
    localStorage.setItem('chats', JSON.stringify(chats));
    
    // Initialize empty messages array for this chat
    if (!messages[newChat.id]) {
        messages[newChat.id] = [];
        localStorage.setItem('messages', JSON.stringify(messages));
    }
    
    // Close modal
    document.getElementById('addChatModal').classList.remove('active');
    
    // Reload chats
    loadChats();
    
    // Open the new chat
    openChat(newChat.id);
}

// Load emoji picker
function loadEmojiPicker() {
    const emojiPicker = document.getElementById('emojiPicker');
    if (!emojiPicker) return;
    
    // Sample emojis
    const emojiCategories = {
        'Smileys & People': ['😀', '😃', '😄', '😁', '😆', '😅', '😂', '🤣', '😊', '😇', '🙂', '🙃', '😉', '😌', '😍', '🥰', '😘', '😗', '😙', '😚', '😋', '😛', '😝', '😜', '🤪', '🤨', '🧐', '🤓', '😎', '🤩', '🥳'],
        'Animals & Nature': ['🐵', '🐒', '🦍', '🦧', '🐶', '🐕', '🦮', '🐩', '🐺', '🦊', '🦝', '🐱', '🐈', '🦁', '🐯', '🐅', '🐆', '🐴', '🐎', '🦄', '🦓', '🦌', '🐮', '🐂', '🐃', '🐄', '🐷', '🐖', '🐗', '🐽', '🐏', '🐑'],
        'Food & Drink': ['🍎', '🍐', '🍊', '🍋', '🍌', '🍉', '🍇', '🍓', '🫐', '🍈', '🍒', '🍑', '🥭', '🍍', '🥥', '🥝', '🍅', '🍆', '🥑', '🥦', '🥬', '🥒', '🌶', '🫑', '🌽', '🥕', '🫒', '🧄', '🧅', '🥔', '🍠'],
        'Travel & Places': ['🚗', '🚕', '🚙', '🚌', '🚎', '🏎', '🚓', '🚑', '🚒', '🚐', '🛻', '🚚', '🚛', '🚜', '🏍', '🛵', '🚲', '🛴', '🛹', '🛼', '🚁', '✈', '🛩', '🛫', '🛬', '🪂', '💺', '🚀', '🛸', '🚉', '🚊'],
        'Activities': ['⚽', '🏀', '🏈', '⚾', '🥎', '🎾', '🏐', '🏉', '🥏', '🎱', '🪀', '🏓', '🏸', '🏒', '🏑', '🥍', '🏏', '🪃', '🥅', '⛳', '🪁', '🏹', '🎣', '🤿', '🥊', '🥋', '🎽', '🛹', '🛼', '🛷', '⛸'],
        'Objects': ['⌚', '📱', '📲', '💻', '⌨', '🖥', '🖨', '🖱', '🖲', '🕹', '🗜', '💽', '💾', '💿', '📀', '📼', '📷', '📸', '📹', '🎥', '📽', '🎞', '📞', '☎', '📟', '📠', '📺', '📻', '🎙', '🎚', '🎛'],
        'Symbols': ['❤', '🧡', '💛', '💚', '💙', '💜', '🖤', '🤍', '🤎', '💔', '❣', '💕', '💞', '💓', '💗', '💖', '💘', '💝', '💟', '☮', '✝', '☪', '🕉', '☸', '✡', '🔯', '🕎', '☯', '☦', '🛐', '⛎'],
        'Flags': ['🏳', '🏴', '🏁', '🚩', '🏳‍🌈', '🏳‍⚧', '🏴‍☠', '🇦🇫', '🇦🇽', '🇦🇱', '🇩🇿', '🇦🇸', '🇦🇩', '🇦🇴', '🇦🇮', '🇦🇶', '🇦🇬', '🇦🇷', '🇦🇲', '🇦🇼', '🇦🇺', '🇦🇹', '🇦🇿', '🇧🇸', '🇧🇭', '🇧🇩', '🇧🇧', '🇧🇾', '🇧🇪', '🇧🇿', '🇧🇯']
    };
    
    emojiPicker.innerHTML = '';
    
    for (const [category, emojis] of Object.entries(emojiCategories)) {
        const categoryElement = document.createElement('div');
        categoryElement.className = 'emoji-category';
        
        const categoryTitle = document.createElement('h4');
        categoryTitle.textContent = category;
        categoryElement.appendChild(categoryTitle);
        
        const emojiGrid = document.createElement('div');
        emojiGrid.className = 'emoji-grid';
        
        emojis.forEach(emoji => {
            const emojiElement = document.createElement('div');
            emojiElement.className = 'emoji';
            emojiElement.textContent = emoji;
            emojiElement.addEventListener('click', () => {
                const messageInput = document.getElementById('messageInput');
                messageInput.value += emoji;
                messageInput.focus();
                
                // Show typing indicator when adding emoji
                if (currentChatId) {
                    showTypingIndicator(currentChatId);
                }
            });
            emojiGrid.appendChild(emojiElement);
        });
        
        categoryElement.appendChild(emojiGrid);
        emojiPicker.appendChild(categoryElement);
    }
}

// Start message refresh interval
function startMessageRefresh() {
    setInterval(() => {
        if (document.getElementById('chatView') && 
            !document.getElementById('chatView').classList.contains('hidden') &&
            currentChatId) {
            loadChatMessages(currentChatId);
        }
    }, 200); // Refresh every 0.2 seconds
}

// Profile Page
function initProfilePage() {
    loadProfileData();
    
    const editProfileBtn = document.getElementById('editProfileBtn');
    if (editProfileBtn) {
        editProfileBtn.addEventListener('click', toggleProfileEdit);
    }
    
    const saveProfileBtn = document.getElementById('saveProfileBtn');
    if (saveProfileBtn) {
        saveProfileBtn.addEventListener('click', saveProfile);
    }
    
    const cancelEditBtn = document.getElementById('cancelEditBtn');
    if (cancelEditBtn) {
        cancelEditBtn.addEventListener('click', toggleProfileEdit);
    }
    
    const avatarEdit = document.querySelector('.avatar-edit');
    if (avatarEdit) {
        avatarEdit.addEventListener('click', changeAvatar);
    }
}

// Load profile data
function loadProfileData() {
    if (!currentUser) return;
    
    document.getElementById('profileName').textContent = currentUser.name;
    document.getElementById('profileEmail').textContent = currentUser.email;
    document.getElementById('profilePhone').textContent = currentUser.phone;
    
    // Edit form values
    document.getElementById('editName').value = currentUser.name;
    document.getElementById('editEmail').value = currentUser.email;
    document.getElementById('editPhone').value = currentUser.phone;
}

// Toggle profile edit mode
function toggleProfileEdit() {
    document.getElementById('profileView').classList.toggle('hidden');
    document.getElementById('editView').classList.toggle('hidden');
}

// Save profile
function saveProfile() {
    const name = document.getElementById('editName').value;
    const email = document.getElementById('editEmail').value;
    const phone = document.getElementById('editPhone').value;
    
    // Update current user
    currentUser.name = name;
    currentUser.email = email;
    currentUser.phone = phone;
    
    // Update in localStorage
    localStorage.setItem('currentUser', JSON.stringify(currentUser));
    
    // Update users list
    const users = JSON.parse(localStorage.getItem('users'));
    const userIndex = users.findIndex(u => u.id === currentUser.id);
    if (userIndex !== -1) {
        users[userIndex] = currentUser;
        localStorage.setItem('users', JSON.stringify(users));
    }
    
    // Reload profile data
    loadProfileData();
    toggleProfileEdit();
    
    alert('Profile updated successfully!');
}

// Change avatar
function changeAvatar() {
    // Create a file input element
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = 'image/*';
    
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                // In a real app, you would upload the image and save the URL
                alert('Avatar updated! In a real app, this would save your new profile picture.');
            };
            
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    fileInput.click();
}

// Settings Page
function initSettingsPage() {
    loadSettings();
    
    // Theme toggle
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        themeToggle.addEventListener('change', toggleTheme);
    }
    
    // Update settings form
    const updateSettingsForm = document.getElementById('updateSettingsForm');
    if (updateSettingsForm) {
        updateSettingsForm.addEventListener('submit', updateSettings);
    }
    
    // Privacy settings
    const privacySelects = document.querySelectorAll('.settings-section select');
    privacySelects.forEach(select => {
        select.addEventListener('change', function() {
            alert(Privacy setting updated: ${this.value});
        });
    });
}

// Load settings
function loadSettings() {
    if (!currentUser) return;
    
    // Set current values
    document.getElementById('settingsName').value = currentUser.name;
    document.getElementById('settingsEmail').value = currentUser.email;
    document.getElementById('settingsPhone').value = currentUser.phone;
    
    // Set theme toggle
    const currentTheme = localStorage.getItem('theme') || 'light';
    document.getElementById('themeToggle').checked = currentTheme === 'dark';
}

// Toggle theme
function toggleTheme() {
    const isDark = document.getElementById('themeToggle').checked;
    const theme = isDark ? 'dark' : 'light';
    
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
}

// Update settings
function updateSettings(e) {
    e.preventDefault();
    
    const name = document.getElementById('settingsName').value;
    const email = document.getElementById('settingsEmail').value;
    const phone = document.getElementById('settingsPhone').value;
    
    // Update current user
    currentUser.name = name;
    currentUser.email = email;
    currentUser.phone = phone;
    
    // Update in localStorage
    localStorage.setItem('currentUser', JSON.stringify(currentUser));
    
    // Update users list
    const users = JSON.parse(localStorage.getItem('users'));
    const userIndex = users.findIndex(u => u.id === currentUser.id);
    if (userIndex !== -1) {
        users[userIndex] = currentUser;
        localStorage.setItem('users', JSON.stringify(users));
    }
    
    alert('Settings updated successfully!');
}