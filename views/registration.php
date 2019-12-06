<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Register</div>

                <div class="card-body">
                    <div class="alert alert-danger text-center d-none" id="output"></div>
                    <form method="POST" action="/users/registration" enctype="multipart/form-data" id="register_form">
                        <input type="hidden" id="csrf_token" name="csrf_token" value="<?php echo Security::generateCsrfToken(); ?>">

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
        $(document).ready(function(){
            $('#submit').on('click', function(e){ 
                e.preventDefault();
                var fd = new FormData();
                fd.append('csrf_token', $("#csrf_token").val());
                fd.append('name', $("#name").val());
                fd.append('email', $("#email").val());
                fd.append('password', $("#password").val());
                fd.append('recaptcha', $("#g-recaptcha-response").val());
                fd.append('file', $("#photo")[0].files[0]);
                $.ajax({
                    url: '/users/registration',  
                    type: 'POST',
                    data: fd,
                    success: function(data){
                        if (data) {
                            console.log(data);
                            var parsedData = JSON.parse(data);
                            if (parsedData.redirect) {
                                window.location.href = parsedData.redirect;
                            } else {
                                $('#output').html(parsedData.message);
                                $('#output').removeClass('d-none');
                            }
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });
        });
    </script>
</div>