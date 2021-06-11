<?php require_once "controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đăng nhập</title>

    <!--Bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!--Custom Style-->
    <link rel="stylesheet" href="./css/log_sign.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form login-form">
                <form action="login-user.php" method="POST" autocomplete="">
                    <h2 class="text-center">Đăng nhập</h2>
                    <p class="text-center">Đăng nhập với email và mật khẩu của bạn.</p>
                    <?php
                    if(count($errors) > 0){
                        ?>
                        <div class="alert alert-danger text-center">
                            <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" placeholder="Địa chỉ Email" required value="<?php echo $email ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" placeholder="Mật khẩu" required>
                    </div>
                    <div class="link forget-pass text-left"><a href="forgot-password.php">Quên mật khẩu?</a></div>
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="login" value="Đăng nhập">
                    </div>
                    <div class="link login-link text-center">Chưa có tài khoản? <a href="signup-user.php">Đăng ký ngay</a></div>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>