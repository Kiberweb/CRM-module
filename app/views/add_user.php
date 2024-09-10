<div class="container mt-5">
    <!-- alert  -->
    <div id="toast-message" class="d-none alert alert-success d-flex align-items-center" role="alert">
        <span style="width: 24px;height: 24px;margin-right: 0.6rem;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path fill="#0f5132" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/>
            </svg>
        </span>
        <div>
            User was created successfully!
        </div>
    </div>
    <!-- -->
    <div class="row">
        <div class="col-10">
            <h2><span style="width: 24px; height: 24px; display: inline-block;margin-right: 0.5rem;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z"/></svg></span>Create new User</h2>
        </div>
        <div class="col-2">
            <a href="/users" class="btn btn-primary">View users</a>
        </div>
    </div>

    <form id="create_user">
        <div class="mb-3">
            <label for="username" class="form-label">Name</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your name">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password (password must be at least 8 characters long)</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
        </div>
        <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm your password" required>
            <div id="passwordError" class="text-danger mt-2" style="display: none;">Passwords do not match!</div>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="4" placeholder="Your message"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    const formAction = '/api/user/';
    const formUser = document.getElementById('create_user');
    const toastMessage = document.getElementById('toast-message');

    formUser.addEventListener('submit', (event) => {
        event.preventDefault();

        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        const passwordError = document.getElementById('passwordError');

        if (password !== confirmPassword) {
            passwordError.style.display = 'block';
            return;
        } else {
            passwordError.style.display = 'none';
        }

        const formData = new FormData(formUser);

        fetch(formAction, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 200) {
                toastMessage.classList.remove('d-none');
                formUser.reset();

                setTimeout(function() {
                    toastMessage.classList.add('d-none');
                }, 3000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>