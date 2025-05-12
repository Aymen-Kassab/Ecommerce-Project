document.getElementById('signin-form').addEventListener('submit', async function(event) {
    event.preventDefault();
    const notification = document.getElementById("notification-signin");
    const formData = new FormData(this);

    formData.append('signin', '1');

    const response = await fetch('home.php', {
        method: 'POST',
        body: formData
    });

    const data = await response.json();
    console.log(data);

    if (data.success) {
        window.location.href = data.redirect;
    } else {
        notification.textContent = data.message;
        notification.style.visibility = 'visible';

        document.querySelector(".close-btn").addEventListener("click", () => {
            notification.style.visibility = 'hidden';
        });

        document.querySelectorAll(".input-form").forEach(input => {
            input.textContent = "";
        });
    }
});

document.getElementById('signup-form').addEventListener('submit', async function(event) {
    event.preventDefault();
    const notification = document.getElementById("notification-signup");
    const formData = new FormData(this);

    formData.append('signup', '1');

    const response = await fetch('home.php', {
        method: 'POST',
        body: formData
    });

    const data = await response.json();
    console.log(data);

    if (data.success) {
        window.location.href = data.redirect;
    } else {
        notification.textContent = data.message;
        notification.style.visibility = 'visible';

        document.querySelector(".close-btn").addEventListener("click", () => {
            notification.style.visibility = 'hidden';
        });

        document.querySelectorAll(".input-form").forEach(input => {
            input.textContent = "";
        });
    }
});
