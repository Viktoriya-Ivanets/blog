function addSystemMessage(systemMessage) {
    if (document.querySelector('.system_message')) return;

    var messageContainer = document.createElement('div');
    messageContainer.classList.add('system_message');
    messageContainer.innerHTML = systemMessage;
    var mainElement = document.querySelector('main');
    mainElement.parentNode.insertBefore(messageContainer, mainElement);

    setTimeout(function () {
        messageContainer.parentNode.removeChild(messageContainer);
    }, 5000);
}
