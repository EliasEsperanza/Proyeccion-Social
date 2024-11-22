let selectedChatId = null;

// Conexión al servidor WebSocket con socket.io
const socket = io("wss://chat-ues-production.up.railway.app", {
    transports: ["websocket"],
});

// Manejo de eventos de WebSocket
socket.on("connect", () => console.log("Conexión establecida con WebSocket."));
socket.on("disconnect", () => console.log("Conexión cerrada."));
socket.on("connect_error", (error) =>
    console.error("Error en la conexión de WebSocket:", error)
);

// Evento para recibir mensajes en tiempo real
socket.on("server:nuevoMensaje", (message) => {
    if (message.chatId === selectedChatId) {
        renderMessage(message);
    }
});

// Cargar la lista de chats al iniciar
document.addEventListener("DOMContentLoaded", () => {
    fetch("/usuarios2")
        .then((response) => response.json())
        .then((users) => {
            const chatList = document.getElementById("chatList");
            chatList.innerHTML = "";
            users.forEach((user) => {
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
});
// Función para seleccionar un chat y cargar mensajes
function selectChat(chatId, chatName, chatRole) {
    selectedChatId = chatId;

    document.getElementById("chatName").textContent = chatName;
    document.getElementById("chatRole").textContent = chatRole;

    const messageContainer = document.getElementById("messageContainer");
    messageContainer.innerHTML = '<p class="text-center text-muted">Cargando mensajes...</p>';

    // Solicitar mensajes al servidor vía WebSocket
    socket.emit("client:requestMessages", { chatId });

    socket.on("server:chatMessages", (messages) => {
        if (selectedChatId === chatId) {
            messageContainer.innerHTML = "";
            messages.forEach(renderMessage);
        }
    });
}

// Renderizar un mensaje en la interfaz
function renderMessage(message) {
    const messageContainer = document.getElementById("messageContainer");
    const messageClass = message.sender === "me" ? "sent" : "received";
    messageContainer.innerHTML += `
        <div class="message ${messageClass}">
            ${message.text}
            <small class="text-muted">${message.time}</small>
        </div>
    `;
    messageContainer.scrollTop = messageContainer.scrollHeight;
}

// Enviar un mensaje desde el cliente
function sendMessage(event) {
    if (event.key === "Enter" || event.type === "click") {
        const input = document.getElementById("messageInput");
        const message = input.value.trim();

        if (message !== "" && selectedChatId !== null) {
            const data = {
                chatId: selectedChatId,
                text: message,
                sender: "me", // Esto puede ser el usuario autenticado.
                time: new Date().toLocaleTimeString(),
            };

            console.log("Enviando mensaje al servidor:", data);

            // Emitir el mensaje al servidor, pero no lo renderices aún
            socket.emit("client:nuevoMensaje", data);

            // Limpiar el campo de entrada
            input.value = "";
        }
    }
}

