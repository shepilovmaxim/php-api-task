<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Login</div>

                <div class="card-body">
                    <div class="alert alert-danger text-center d-none" id="output"></div>
                    <form method="POST" action="/users/login">
                        <input type="hidden" id="csrf_token" name="csrf_token" value="<?php echo Security::generateCsrfToken(); ?>">
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button id="submit" class="btn btn-primary">
                                    Login
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
                fd.append('email', $("#email").val());
                fd.append('password', $("#password").val());
                $.ajax({
                    url: '/users/login',  
                    type: 'POST',
                    data: fd,
                    success: function(data){
                        if (data) {
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