<div class="container mt-5">
    <!-- alert  -->
    <div id="toast-message" class="d-none alert alert-success d-flex align-items-center" role="alert">
        <span style="width: 24px;height: 24px;margin-right: 0.6rem;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path fill="#0f5132" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/>
            </svg>
        </span>
        <div id="alert-message"></div>
    </div>
    <h2>User Management</h2>
    <div class="mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>
    </div>

    <!-- User Table -->
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="userList">
        <?php foreach ($users as $index => $user): ?>
            <tr id="row-user-id-<?= $user['id']; ?>">
                <td><?= $user['id']; ?></td>
                <td><?= $user['username']; ?></td>
                <td><?= $user['email']; ?></td>
                <td><?= $user['message']; ?></td>
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal" onclick="setEditUser(<?= $user['id']; ?>)">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteUser(<?= $user['id']; ?>)">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
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
                    <button type="submit" class="btn btn-primary">Add User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <div class="mb-3">
                        <label for="passwordUpdate" class="form-label">Password (password must be at least 8 characters long)</label>
                        <input type="password" class="form-control" id="passwordUpdate" name="password" placeholder="Enter your password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPasswordUpdate" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPasswordUpdate" placeholder="Confirm your password" required>
                        <div id="passwordErrorUpdate" class="text-danger mt-2" style="display: none;">Passwords do not match!</div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    let userId = null;
    const formAction = '/api/user/';
    const userList = document.getElementById('userList');
    const userRow = document.createElement('tr');
    const toastMessage = document.getElementById('toast-message');
    const alertMessage = document.getElementById('alert-message');

    function deleteUser(id) {
        if (confirm('Are you sure you want to delete this user?')) {
            fetch(formAction + id, {
                method: 'DELETE',
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 200) {
                    document.getElementById('row-user-id-' + id).remove();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }

    function showToast() {
        toastMessage.classList.remove('d-none');
        setTimeout(function () {
            toastMessage.classList.add('d-none');
        }, 3000);
    }

    const addUserForm = document.getElementById('addUserForm');
    addUserForm.addEventListener('submit', function(event) {
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

        const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
        const formData = new FormData(addUserForm);
        fetch('/api/user/', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 200) {
                    modal.hide();
                    userRow.innerHTML = addUser(data.user_Id, formData.get('username'), formData.get('email'), formData.get('message'));
                    userList.appendChild(userRow);
                    addUserForm.reset();
                    alertMessage.innerText = 'User was created successfully!';
                    showToast();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
    const editUserForm = document.getElementById('editUserForm');
    editUserForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const password = document.getElementById('passwordUpdate').value;
        const confirmPassword = document.getElementById('confirmPasswordUpdate').value;
        const passwordError = document.getElementById('passwordErrorUpdate');

        if (password !== confirmPassword) {
            passwordError.style.display = 'block';
            return;
        } else {
            passwordError.style.display = 'none';
        }

        const modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
        const formData = new FormData(editUserForm);

        fetch('/api/user/' + userId, {
            method: 'PUT',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 200) {
                    modal.hide();
                    editUserForm.reset();
                    alertMessage.innerText = 'User was password updated successfully!';
                    showToast();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    function setEditUser(id) {
        userId = id;
    }

    function addUser(id, user, email, massage) {
        return '<tr id="row-user-id-' + id + '"><td>' + id + '</td><td>' + user + '</td><td>' + email + '</td><td>' + massage + '</td><td><button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal" onclick="setEditUser(' + id + ')">Edit</button><button class="btn btn-danger btn-sm" onclick="deleteUser(' + id + ')">Delete</button></td></tr>';
    }
</script>