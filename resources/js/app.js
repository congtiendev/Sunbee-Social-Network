function toggleDropdown(button, dropdown) {
    if (button && dropdown) {
        button.addEventListener('click', function () {
            dropdown.classList.toggle('show');
        });

        document.addEventListener('click', function (event) {
            if (!dropdown.contains(event.target) && !button.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });
    }
}

// Show/hide the dropdown for the user's account information
toggleDropdown(
    document.querySelector('.btn-account'),
    document.querySelector('.dropdown-account')
);
// Show/hide the dropdown for the messages
toggleDropdown(
    document.querySelector('.btn-messages'),
    document.querySelector('.dropdown-messages')
);
// Show/hide the notification dropdown and its options notifications
toggleDropdown(
    document.querySelector('.btn-notification'),
    document.querySelector('.dropdown-notification')
);

// Show/hide the mobile menu
toggleDropdown(
    document.querySelector('.btn-menu-mobile'),
    document.querySelector('.menu-mobile')
);



