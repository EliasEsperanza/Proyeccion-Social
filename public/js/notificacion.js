document.addEventListener('DOMContentLoaded', function() {
    const notificationBell = document.getElementById('notification-bell');
    const notificationDropdown = document.querySelector('.notification-dropdown');
    const notificationCount = document.querySelector('.notification-count');
    const notificationList = document.querySelector('.notification-list');
    const markAllReadBtn = document.querySelector('.mark-all-read');

    // Toggle dropdown
    notificationBell.addEventListener('click', function(e) {
        e.stopPropagation();
        notificationDropdown.classList.toggle('show');
        if (notificationDropdown.classList.contains('show')) {
            loadNotifications();
        }
    });

    // Cerrar dropdown al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!notificationBell.contains(e.target)) {
            notificationDropdown.classList.remove('show');
        }
    });

    // Cargar notificaciones
    function loadNotifications() {
        fetch('/notifications')
            .then(response => response.json())
            .then(data => {
                updateNotifications(data);
            })
            .catch(error => console.error('Error:', error));
    }

    // Actualizar interfaz de notificaciones
    function updateNotifications(notifications) {
        const unreadCount = notifications.filter(n => !n.read_at).length;
        notificationCount.textContent = unreadCount;
        notificationCount.style.display = unreadCount > 0 ? 'block' : 'none';

        notificationList.innerHTML = notifications.map(notification => `
            <div class="notification-item ${!notification.read_at ? 'unread' : ''}" data-id="${notification.id}">
                <div class="notification-message">${notification.message}</div>
                <div class="notification-time">${timeAgo(new Date(notification.created_at))}</div>
            </div>
        `).join('');

        // Agregar event listeners a las notificaciones
        document.querySelectorAll('.notification-item').forEach(item => {
            item.addEventListener('click', () => markAsRead(item.dataset.id));
        });
    }

    // Marcar como leída
    function markAsRead(id) {
        fetch(`/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(() => loadNotifications());
    }

    // Marcar todas como leídas
    markAllReadBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        fetch('/notifications/mark-all-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(() => loadNotifications());
    });

    // Función helper para tiempo relativo
    function timeAgo(date) {
        const seconds = Math.floor((new Date() - date) / 1000);
        
        let interval = seconds / 31536000;
        if (interval > 1) return Math.floor(interval) + ' años';
        
        interval = seconds / 2592000;
        if (interval > 1) return Math.floor(interval) + ' meses';
        
        interval = seconds / 86400;
        if (interval > 1) return Math.floor(interval) + ' días';
        
        interval = seconds / 3600;
        if (interval > 1) return Math.floor(interval) + ' horas';
        
        interval = seconds / 60;
        if (interval > 1) return Math.floor(interval) + ' minutos';
        
        return Math.floor(seconds) + ' segundos';
    }

    // Cargar notificaciones iniciales
    loadNotifications();

    // Configurar Laravel Echo si está disponible
    if (typeof Echo !== 'undefined') {
        Echo.private(`App.Models.User.${userId}`)
            .notification((notification) => {
                loadNotifications();
            });
    }
});