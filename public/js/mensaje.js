function sendMessage(event) {
    
    if (event.key === 'Enter' || event.type === 'click') {
       
        const messageInput = document.getElementById('messageInput');
        const messageText = messageInput.value.trim();

       
        if (messageText) {
        
            const messageContainer = document.getElementById('messageContainer');
            const newMessage = document.createElement('div');
            newMessage.className = 'message sent';
            newMessage.innerHTML = `${messageText}<small class="text-white-50">${new Date().toLocaleTimeString()}</small>`;

            messageContainer.appendChild(newMessage);

           
            messageInput.value = '';

            messageContainer.scrollTop = messageContainer.scrollHeight;
        }
    }
}

function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("show");
}


document.getElementById('fileInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        console.log("Archivo seleccionado:", file.name);
    }
});
