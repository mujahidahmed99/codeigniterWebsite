<html lang="en">
<body>

    <nav class="navbar grid">
        <a href="#" id="navMenu"><i class="fas fa-bars fa-2x"></i></a>
        <h1>Expense Tracker</h1>
    </nav>

    <section id="userNameInfo" class="grid">
        <div class="chat-header">
            <h3>Chat with the community!</h3>
            <span>Username:</span>
            <span id="userName">Mujahid</span>
        </div>
    </section>
    <section id="chatMsg" class="grid">
        <div id="chatWindow">
        </div>
    </section>
    <section id="userMsg" class="grid">
        <input type="text" id="userMsgInput">
        <button id="sendMsg" Type="button">Send</button>
    </section>
    <section id="footer">
        <div class="footer"></div>
    </section>
</body>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="<?php echo base_url();?>/assets/chat.js" async></script>
</html>