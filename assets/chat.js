var hamburger_menu = document.getElementById('navMenu');
var menu_overlay = document.getElementById('overlay');
var close_menu_overlay = document.getElementById('closeOverlay');

hamburger_menu.addEventListener('click', ()=>{
    menu_overlay.classList.add('active');
});

close_menu_overlay.addEventListener('click', ()=>{
    menu_overlay.classList.remove('active');
});

var pusher = new Pusher('581290458e10eb5de59c', {
    cluster: 'eu'
});

var chatName = document.getElementById("userName");
var messageInput = document.getElementById("userMsgInput");
var button = document.getElementById("sendMsg");
button.addEventListener("click", function() {
const data = { 
    message: messageInput.value,
    name: chatName.innerHTML
};

fetch('http://localhost/expense_tracker/pages/chat', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify(data),
});

messageInput.value = "";
});

var channel = pusher.subscribe('my-channel');
channel.bind('my-event', function(data) {
if (data) {
    chat = document.getElementById("chatWindow");
    node = document.createElement('P');
    node.insertAdjacentHTML("beforeend", `<i class="name">${data["name"]}</i>: ${data['message']}`);
    chat.appendChild(node);
}
});