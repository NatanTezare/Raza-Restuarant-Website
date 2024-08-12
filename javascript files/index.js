/* reservation */
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reservationForm');
    const reservationResponse = document.getElementById('formResponse');

    form.addEventListener('submit', function(event) {
        const phoneInput = document.getElementById('phone');
        const phoneValue = phoneInput.value.trim();

        // Ensure phone number contains only digits
        if (!/^\d+$/.test(phoneValue)) {
            event.preventDefault();
            reservationResponse.textContent = 'Please enter a valid phone number.';
            reservationResponse.style.color = 'red';
            return;
        }

        // Basic form validation
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const date = document.getElementById('date').value;
        const time = document.getElementById('time').value;
        const guests = document.getElementById('guests').value;

        if (name === '' || email === '' || phone === '' || date === '' || time === '' || guests === '') {
            event.preventDefault();
            reservationResponse.textContent = 'Please fill in all required fields.';
            reservationResponse.style.color = 'red';
            return;
        }
    });
});


// menu
function toggleNav() {
    const topnav = document.getElementById('myTopnav');
    if (topnav.className === 'topnav') {
        topnav.className += ' responsive';
    } else {
        topnav.className = 'topnav';
    }
}

function handleOrder() {
    const orderButtons = document.querySelectorAll('.menu-item button.order-button');

    orderButtons.forEach(button => {
        button.addEventListener('click', function () {
            const menuItem = button.closest('.menu-item');
            const itemName = menuItem.querySelector('h3').innerText;
            const itemPrice = menuItem.querySelector('p:nth-of-type(2)').innerText.replace('Price: ', '');

            // Check if the user is logged in
            if (!sessionStorage.getItem('user_id')) {
                alert('Please log in to place an order.');
                window.location.href = 'login.html'; // Redirect to login page
                return;
            }

            // Populate and submit the hidden form
            document.getElementById('orderItemName').value = itemName;
            document.getElementById('orderItemPrice').value = itemPrice;
            document.getElementById('orderForm').submit();
        });
    });
}

function updateNavLinks() {
    const loginLogoutLink = document.getElementById('login-logout-link');
    if (sessionStorage.getItem('user_id')) {
        loginLogoutLink.textContent = 'Logout';
        loginLogoutLink.href = 'logout.html';
        loginLogoutLink.addEventListener('click', function(event) {
            event.preventDefault();
            sessionStorage.removeItem('user_id');
            window.location.href = 'homepage.html';
        });
    } else {
        loginLogoutLink.textContent = 'Login';
        loginLogoutLink.href = 'login.html';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    handleOrder();
    updateNavLinks();
});



// contact us
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const formResponse = document.getElementById('formResponse');

    form.addEventListener('submit', function(event) {
        event.preventDefault();


        // Basic form validation
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const message = document.getElementById('message').value.trim();
        const terms = document.getElementById('terms').checked;

        if (name === '') {
            formResponse.textContent = 'Please enter your name';
            formResponse.style.color = 'red';
            return;
        }

        if (email === '' || !isValidEmail(email)) {
            formResponse.textContent = 'Please enter a valid email address';
            formResponse.style.color = 'red';
            return;
        }

        if (message === '') {
            formResponse.textContent = 'Please enter your message';
            formResponse.style.color = 'red';
            return;
        }

        if (!terms) {
            formResponse.textContent = 'Please accept the Terms of Service';
            formResponse.style.color = 'red';
            return;
        }

        // Submit the form
        form.submit();
    });

    // Function to validate email format
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
});


