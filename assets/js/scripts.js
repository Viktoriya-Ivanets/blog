function addSystemMessage(systemMessage) {
    if (document.querySelector('.system_message')) return;

    var messageContainer = document.createElement('div');
    messageContainer.classList.add('system_message');
    messageContainer.innerHTML = systemMessage;
    document.body.insertBefore(messageContainer, document.querySelector('main'));

    setTimeout(function() {
        messageContainer.parentNode.removeChild(messageContainer);
    }, 5000);
}