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
        loadUsers();
        console.log("Usuario actual:", currentUserId);
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

// Cargar lista de usuarios disponibles para chat
function loadUsers() {
    fetch("/usuarios2")
        .then((response) => response.json())
        .then((users) => {
            const chatList = document.getElementById("chatList");
            chatList.innerHTML = "";
            // Filtrar para no mostrar al usuario actual
            users
                .filter(user => user.id_usuario != currentUserId)
                .forEach((user) => {
                    chatList.innerHTML += `
                        <div class="chat-item rounded-3" 
                             onclick="selectChat('${user.id_usuario}', '${user.name}', '${user.role || "Sin Rol"}')">
                             <img src="{{ asset('img/user3.png') }}" alt="User Image">
                            <div>
                                <strong>${user.name}</strong><br>
                            </div>
                        </div>
                    `;
                });
        })
        .catch((error) => console.error("Error al cargar los usuarios:", error));
}

// Seleccionar un chat y cargar sus mensajes
function selectChat(chatId, chatName, chatRole, senderChat) {
    selectedChatId = chatId;
    document.getElementById("chatName").textContent = chatName;
    document.getElementById("chatRole").textContent = chatRole;

    const messageContainer = document.getElementById("messageContainer");
    messageContainer.innerHTML = '<p class="text-center text-muted">Cargando mensajes...</p>';


    /*Aqui cambia lo que deba del sockets para hacer lo que te dije en los mensaje hopes  */
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
        // Asegurarse de que el mensaje tenga sender y chatId
        const sender = String(message.sender || message.id_emisor);
        const chatId = String(message.chatId || message.id_receptor);
        const currentUserIdStr = String(currentUserId);
        const selectedChatIdStr = String(selectedChatId);
/*        console.log(renderMessage({
            sender: sender,
            chatId: chatId,
            text: message.text,
            time: message.time
        }))
*/
        // Verificar mensajes tanto como emisor o receptor
        if ((sender === currentUserIdStr && chatId === selectedChatIdStr) /*||
            (sender === selectedChatIdStr && chatId === currentUserIdStr)*/) {
            console.log("Renderizando mensaje histórico:", message);
            renderMessage({
                sender: sender,
                chatId: chatId,
                text: message.text,
                time: message.time
            });
        }
        else{
            console.log("Renderizando mensaje histórico:", message);
            renderMessage({
                sender: chatId,
                chatId: sender,
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

    // Determinamos el texto a mostrar
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

    // Asegura que el contenedor se desplace al final para ver los nuevos mensajes
    messageContainer.scrollTop = messageContainer.scrollHeight;
}



// Enviar un nuevo mensaje
function sendMessage(event) {
    if (event.key === "Enter" || event.type === "click") {
        const input = document.getElementById("messageInput");
        const message = input.value.trim();

        if (message !== "" && selectedChatId !== null) {
            const data = {
                chatId: String(selectedChatId),  // ID del destinatario
                sender: String(currentUserId),   // ID del emisor (usuario actual)
                text: message,
                time: new Date().toLocaleTimeString()
            };

            console.log("Enviando mensaje al servidor:", data);
            socket.emit("client:nuevoMensaje", data);
            
            // Mostrar el mensaje enviado inmediatamente
            //renderMessage(data);
            
            input.value = "";
        }
    }
}
