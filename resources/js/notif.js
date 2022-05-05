let notifications = document.querySelectorAll('.notification');

notifications.forEach(notification => {
    const buttonClose = notification.querySelector('button');
    buttonClose.addEventListener('click', (event) => {
        event.target.parentElement.classList.add('notification-animation');
    });
});