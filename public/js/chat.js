// Variables globales para mantener el estado del chat
let selectedChatId = null;
let currentUserId = null;

// Inicializar conexión WebSocket
const socket = io("wss://chat-ues-production.up.railway.app", {
    transports: ["websocket"],
});

// Cuando el DOM está listo, obtener el usuario actual
document.addEventListener("DOMContentLoaded", async () => {
    try {
        const response = await fetch('/curret-user');
        const user = await response.json();
        currentUserId = user.id_usuario.id_usuario;
        console.log("Usuario actual:", currentUserId);

        // Solicitar los chats asociados al usuario actual
        socket.emit("client:requestUserChats", currentUserId);
    } catch (error) {
        console.error("Error al obtener usuario actual:", error);
    }
});

// Eventos de conexión WebSocket
socket.on("connect", () => console.log("Conexión establecida con WebSocket."));
socket.on("disconnect", () => console.log("Conexión cerrada."));
socket.on("connect_error", (error) =>
    console.error("Error en la conexión de WebSocket:", error)
);

// Escuchar nuevos mensajes en tiempo real
socket.on("server:nuevoMensaje", (message) => {
    console.log("Mensaje recibido:", message);
    console.log("Chat actual:", selectedChatId);
    
    // Convertir todos los IDs a string para comparación
    const sender = String(message.sender);
    const chatId = String(message.chatId);
    const currentUserIdStr = String(currentUserId);
    const selectedChatIdStr = String(selectedChatId);

    // Verificar si estamos en la conversación correcta
    if (
        (sender === selectedChatIdStr && chatId === currentUserIdStr) || // Soy receptor
        (sender === currentUserIdStr && chatId === selectedChatIdStr)    // Soy emisor
    ) {
        renderMessage({
            sender: sender,
            chatId: chatId,
            text: message.text,
            time: message.time || new Date().toLocaleTimeString()
        });
    }
});

// Manejar la lista de chats del usuario
socket.on("server:userChatsList", (chatList) => {
    console.log("Lista de chats recibida:", chatList);
    const chatListContainer = document.getElementById("chatList");
    chatListContainer.innerHTML = "";

    chatList.forEach((chat) => {
        chatListContainer.innerHTML += `
            <div class="chat-item rounded-3" 
                onclick="selectChat('${chat.id}', '${chat.name}', '${chat.role}')">
                <img src="img/user3.png" alt="User Image">
                <div>
                    <strong>${chat.name}</strong><br>
                    <small>${chat.role}</small>
                </div>
            </div>
        `;
    });
});

// Seleccionar un chat y cargar sus mensajes
function selectChat(chatId, chatName, chatRole) {
    selectedChatId = chatId;
    document.getElementById("chatName").textContent = chatName;
    document.getElementById("chatRole").textContent = chatRole;

    const messageContainer = document.getElementById("messageContainer");
    messageContainer.innerHTML = '<p class="text-center text-muted">Cargando mensajes...</p>';

    // Solicitar mensajes históricos al servidor
    socket.emit("client:requestMessages", { chatId });

    // Evitar duplicación de listeners
    socket.off("server:chatMessages");
    socket.on("server:chatMessages", handleChatMessages);
}

// Manejar los mensajes históricos recibidos del servidor
function handleChatMessages(messages) {
    if (!selectedChatId) return;
    
    const messageContainer = document.getElementById("messageContainer");
    messageContainer.innerHTML = "";
    
    messages.forEach(message => {
        const sender = String(message.sender);
        const chatId = String(message.chatId);
        const currentUserIdStr = String(currentUserId);
        const selectedChatIdStr = String(selectedChatId);

        if ((sender === currentUserIdStr && chatId === selectedChatIdStr) ||
            (sender === selectedChatIdStr && chatId === currentUserIdStr)) {
            renderMessage({
                sender: sender,
                chatId: chatId,
                text: message.text,
                time: message.time
            });
        }
    });
}

// Renderizar un mensaje individual en el contenedor
function renderMessage(message) {
    const messageContainer = document.getElementById("messageContainer");
    const isOwnMessage = message.sender === String(currentUserId);

    const textToShow = message.text;
    const messageClass = isOwnMessage ? "sent" : "received";
    const messageStyle = isOwnMessage 
        ? 'margin-left: auto; margin-right: 10px; width: 40%;' 
        : 'margin-right: auto; background-color: #3766fa; margin-left: 10px; width: 40%;';  

    messageContainer.innerHTML += `
        <div class="message ${messageClass}" style="${messageStyle}">
            ${textToShow}
             <small class="text-muted" style="color: white;">${message.time}</small>  
        </div>
    `;

    messageContainer.scrollTop = messageContainer.scrollHeight;
}
