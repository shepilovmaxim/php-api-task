<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Register</div>

                <div class="card-body">
                    <div class="alert alert-danger text-center d-none" id="output"></div>
                    <form method="POST" action="/users/registration" enctype="multipart/form-data" id="register_form">
                        <input type="hidden" id="csrf_token" name="csrf_token" value="<?php echo Security::getCsrfSession() ?>">

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" pattern="[A-Z][a-z]*|[А-ЯЁ][а-яё]*" class="form-control" maxlength="20" name="name" required autocomplete="name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" required autocomplete="email">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" minlength="6" class="form-control" name="password" required autocomplete="password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="photo" class="col-md-4 col-form-label text-md-right">Photo</label>

                            <div class="col-md-6">
                                <input id="photo" type="file" accept=".jpg, .jpeg, .png" class="form-control-file" name="photo" required>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-md-6">
                                <div class="g-recaptcha" data-sitekey="6Ld8UsUUAAAAAEMQ9oBtouywD9gqX1KloG45E2Ju"></div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button id="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>

    document.getElementById('submit').addEventListener('click', async (e) => {
        e.preventDefault();
        let fd = new FormData();
        fd.append('csrf_token', document.getElementById("csrf_token").value);
        fd.append('name', document.getElementById("name").value);
        fd.append('email', document.getElementById("email").value);
        fd.append('password', document.getElementById("password").value);
        fd.append('recaptcha', document.getElementById("g-recaptcha-response").value);
        fd.append('file', document.getElementById("photo").files[0]);
        let response = await fetch('/users/registration', {
            method: 'POST',
            body: fd
        });
        let parsedData = await response.json();
        if (parsedData.redirect) {
            window.location.href = parsedData.redirect;
        } else {
            document.getElementById('output').textContent = parsedData.message;
            document.getElementById('output').classList.remove('d-none');
        }
    });

    </script>
</div>