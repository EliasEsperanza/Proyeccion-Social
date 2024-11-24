let selectedChatId = null;
let currentUserId = null;

const socket = io("wss://chat-ues-production.up.railway.app", {
    transports: ["websocket"],
});

document.addEventListener("DOMContentLoaded", async () => {
    try {
        const response = await fetch('/curret-user');
        const user = await response.json();
        currentUserId = user.id_usuario.id_usuario;
        loadUsers();
        console.log("Usuario actual:", currentUserId);
    } catch (error) {
        console.error("Error al obtener usuario actual:", error);
    }
});

socket.on("connect", () => console.log("Conexión establecida con WebSocket."));
socket.on("disconnect", () => console.log("Conexión cerrada."));
socket.on("connect_error", (error) =>
    console.error("Error en la conexión de WebSocket:", error)
);

// Evento para recibir mensajes en tiempo real
socket.on("server:nuevoMensaje", (message) => {
    console.log("Mensaje recibido:", message);
    console.log("Chat actual:", selectedChatId);
    // Verificar si el mensaje pertenece a la conversación actual
    if (
        selectedChatId && 
        ((message.senderId == selectedChatId && message.receiverId == currentUserId) ||
        (message.senderId == currentUserId && message.receiverId == selectedChatId))
    ) {
        renderMessage(message);
    }
});

function loadUsers() {
    fetch("/usuarios2")
        .then((response) => response.json())
        .then((users) => {
            const chatList = document.getElementById("chatList");
            chatList.innerHTML = "";
            users
                .filter(user => user.id_usuario != currentUserId)
                .forEach((user) => {
                    chatList.innerHTML += `
                        <div class="chat-item rounded-3" 
                             onclick="selectChat('${user.id_usuario}', '${user.name}', '${user.role || "Sin Rol"}')">
                            <img src="https://via.placeholder.com/40" alt="User">
                            <div>
                                <strong>${user.name}</strong><br>
                            </div>
                        </div>
                    `;
                });
        })
        .catch((error) => console.error("Error al cargar los usuarios:", error));
}

function selectChat(chatId, chatName, chatRole) {
    selectedChatId = chatId;
    document.getElementById("chatName").textContent = chatName;
    document.getElementById("chatRole").textContent = chatRole;

    const messageContainer = document.getElementById("messageContainer");
    messageContainer.innerHTML = '<p class="text-center text-muted">Cargando mensajes...</p>';

    socket.emit("client:requestMessages", { chatId });

    // Removemos los listeners anteriores para evitar duplicados
    socket.off("server:chatMessages");
    socket.on("server:chatMessages", handleChatMessages);
}

function handleChatMessages(messages) {
    if (!selectedChatId) return;
    
    const messageContainer = document.getElementById("messageContainer");
    messageContainer.innerHTML = "";
    
    messages.forEach(message => {
        // Mostrar mensajes solo si pertenecen a la conversación actual
        if ((message.senderId == currentUserId && message.receiverId == selectedChatId) ||
            (message.senderId == selectedChatId && message.receiverId == currentUserId)) {
            console.log("Renderizando mensaje histórico:", message);
            renderMessage(message);
        }
    });
}

function renderMessage(message) {
    const messageContainer = document.getElementById("messageContainer");
    const isOwnMessage = message.senderId == currentUserId;
    
    console.log("Renderizando mensaje - senderId:", message.senderId, "currentUserId:", currentUserId, "isOwnMessage:", isOwnMessage);
    
    const messageClass = isOwnMessage ? "sent" : "received";
    const messageStyle = isOwnMessage 
        ? 'margin-left: auto; background-color: #DCF8C6; margin-right: 10px;' 
        : 'margin-right: auto; background-color: #E8E8E8; margin-left: 10px;';
    
    messageContainer.innerHTML += `
        <div class="message ${messageClass}" style="${messageStyle}">
            ${message.text}
            <small class="text-muted">${message.time}</small>
        </div>
    `;
    messageContainer.scrollTop = messageContainer.scrollHeight;
}

function sendMessage(event) {
    if (event.key === "Enter" || event.type === "click") {
        const input = document.getElementById("messageInput");
        const message = input.value.trim();

        if (message !== "" && selectedChatId !== null) {
            const data = {
                chatId: selectedChatId,
                text: message,
                senderId: currentUserId,
                receiverId: selectedChatId,
                time: new Date().toLocaleTimeString(),
            };

            console.log("Enviando mensaje al servidor:", data);
            socket.emit("client:nuevoMensaje", data);
            
            // Renderizar inmediatamente solo los mensajes que envío
            renderMessage(data);
            
            input.value = "";
        }
    }
}

const style = document.createElement('style');
style.textContent = `
    .message {
        max-width: 70%;
        padding: 10px;
        border-radius: 10px;
        margin-bottom: 10px;
        word-wrap: break-word;
        color: #000000; /* Color negro para el texto */
    }
    
    .sent {
        margin-left: auto;
        background-color: #DCF8C6;
        margin-right: 10px;
        text-align: right;
    }
    
    .received {
        margin-right: auto;
        background-color: #E8E8E8;
        margin-left: 10px;
        text-align: left;
    }

    .message small {
        display: block;
        font-size: 0.8em;
        margin-top: 5px;
        color: #666666; /* Color gris oscuro para la hora */
    }
`;
document.head.appendChild(style);