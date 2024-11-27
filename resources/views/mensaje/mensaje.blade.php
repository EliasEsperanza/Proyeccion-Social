@extends(auth()->user()->getRoleNames()->first() === 'Estudiante' ? 'layouts.appE' : 'layouts.app')

@section('title', 'Mensajes')

@section('content')
<script src="https://cdn.socket.io/4.8.0/socket.io.min.js"></script>
<script src="{{ asset('js/chat.js') }}"></script>
<script src="{{ asset('js/modal.js') }}"></script>

<div class="container-fluid">
    <div class="row chat-container">
      
      <!-- Sidebar de navegación -->
      <div class="col-12 col-md-3 sidebar d-flex flex-column rounded-3" id="sidebar">
        <h5 class="px-3">Chats</h5>
        <div class="d-flex justify-content-between align-items-center px-3 py-2">
            <div class="input-group">
                <span class="input-group-text bg-white border-0"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control border-0" placeholder="Buscar">
            </div>
            <!-- Botón para abrir el modal de usuarios -->
            <button id="createChatBtn" class="btn btn-link text-danger text-uppercase fw-bold ms-2" data-bs-toggle="modal" data-bs-target="#userModal">Chat +</button>
        </div>
        <div class="chat-list" id="chatList">
          <!-- Lista de chats cargada dinámicamente -->
        </div>
      </div>

      <!-- Ventana de chat -->
      <div class="col-12 col-md-9 ventana d-flex flex-column">
        <div id="chatHeader" class="chat-header d-flex align-items-center rounded-top-4">
            <img src="{{ asset('img/user3.png') }}" id="chatImage" class="rounded-circle me-2" alt="User">
            <div>
                <strong id="chatName">Seleccione un chat</strong><br>
                <small id="chatRole">---</small>
            </div>
        </div>

        <div id="messageContainer" class="chat-messages d-flex flex-column p-3">
          <p class="text-center text-muted">Seleccione un chat para ver los mensajes</p>
        </div>

        <div class="chat-footer d-flex align-items-center rounded-bottom-3">
            <input type="text" id="messageInput" class="form-control" placeholder="Escriba un mensaje" onkeydown="sendMessage(event)">
            <button class="btn" onclick="sendMessage(event)"><i class="bi bi-send"></i></button>
        </div>
      </div>
    </div>
</div>

@endsection
