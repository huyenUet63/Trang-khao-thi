<?php 
session_start();
require "connection.php";
$email = "";
$name = "";
$errors = array();

//khi nguoi dung nhan dang ky
if(isset($_POST['signup'])){
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
    if($password !== $cpassword){
        $errors['password'] = "Mật khẩu nhập lại không trùng khớp!";
    }
    $email_check = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($con, $email_check);
    if(mysqli_num_rows($res) > 0){
        $errors['email'] = "Email này đã tồn tại!";
    }
    if(count($errors) === 0){
        $encpass = password_hash($password, PASSWORD_BCRYPT);
        $code = rand(999999, 111111);
        $status = "notverified";
        $insert_data = "INSERT INTO users (name, email, password, code, status)
                        values('$name', '$email', '$encpass', '$code', '$status')";
        $data_check = mysqli_query($con, $insert_data);
        if($data_check){
            $subject = "Email xác nhận";
            $message = "Mã xác nhận của bạn là $code";
            $sender = "From: a3411791@gmail.com";
            if(mail($email, $subject, $message, $sender)){
                $info = "Chúng tôi đã gửi mã xác nhận đến email của bạn - $email";
                $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                header('location: user-otp.php');
                exit();
            }else{
                $errors['otp-error'] = "Thất bại khi gửi mã xác nhận!";

                $info = "Chúng tôi đã gửi mã xác nhận đến email của bạn - $email";
                $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                header('location: user-otp.php');
                exit();

                
            }
        }else{
            $errors['db-error'] = "Không thể thêm dữ liệu vào cơ sở dữ liệu!";
        }
    }

}
    //khi nhan nut xac nhan ma code
    if(isset($_POST['check'])){
        $_SESSION['info'] = "";
        $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
        $check_code = "SELECT * FROM users WHERE code = $otp_code";
        $code_res = mysqli_query($con, $check_code);
        if(mysqli_num_rows($code_res) > 0){
            $fetch_data = mysqli_fetch_assoc($code_res);
            $fetch_code = $fetch_data['code'];
            $email = $fetch_data['email'];
            $code = 0;
            $status = 'user';
            $update_otp = "UPDATE users SET code = $code, status = '$status' WHERE code = $fetch_code";
            $update_res = mysqli_query($con, $update_otp);
            if($update_res){
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                header('location: index.php');
                exit();
            }else{
                $errors['otp-error'] = "Thất bại khi cập nhật mã xác nhận!";
            }
        }else{
            $errors['otp-error'] = "Bạn nhập sai mã xác nhận!";
        }
    }

    //khi nhan nut dang nhap
    if(isset($_POST['login'])){
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $check_email = "SELECT * FROM users WHERE email = '$email'";
        $res = mysqli_query($con, $check_email);
        if(mysqli_num_rows($res) > 0){
            $fetch = mysqli_fetch_assoc($res);
            $fetch_pass = $fetch['password'];
            if(password_verify($password, $fetch_pass)){
                $_SESSION['email'] = $email;
                $status = $fetch['status'];
                if(($status == 'user') || ($status == 'admin')){
                  $_SESSION['email'] = $email;
                  $_SESSION['password'] = $password;
                    header('location: index.php');
                }else{
                    $info = "Có vẻ bạn vẫn chưa xác nhận email của mình - $email";
                    $_SESSION['info'] = $info;
                    header('location: user-otp.php');
                }
            }else{
                $errors['email'] = "Nhập sai email hoặc mật khẩu!";
            }
        }else{
            $errors['email'] = "Có vẻ bạn vẫn chưa là thành viên! Nhấn vào link bên dưới để đăng ký.";
        }
    }

    //nhan nut tiep tup khi thay doi mat khau
    if(isset($_POST['check-email'])){
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $check_email = "SELECT * FROM users WHERE email='$email'";
        $run_sql = mysqli_query($con, $check_email);
        if(mysqli_num_rows($run_sql) > 0){
            $code = rand(999999, 111111);
            $insert_code = "UPDATE users SET code = $code WHERE email = '$email'";
            $run_query =  mysqli_query($con, $insert_code);
            if($run_query){
                $subject = "Mã thay đổi mật khẩu";
                $message = "Mã xác nhận của bạn là $code";
                $sender = "From: tathihuyen1203@gmail.com";
                if(mail($email, $subject, $message, $sender)){
                    $info = "Chúng tôi đã gửi mã xác nhận thay đổi mật khẩu vào email của bạn - $email";
                    $_SESSION['info'] = $info;
                    $_SESSION['email'] = $email;
                    header('location: reset-code.php');
                    exit();
                }else{
                    $errors['otp-error'] = "Thất bại khi gửi mã!";

                    $info = "Chúng tôi đã gửi mã xác nhận thay đổi mật khẩu vào email của bạn - $email";
                    $_SESSION['info'] = $info;
                    $_SESSION['email'] = $email;
                    header('location: reset-code.php');
                    exit();
                }
            }else{
                $errors['db-error'] = "Lỗi dữ liệu!";
            }
        }else{
            $errors['email'] = "Tài khoản email này không tồn tại!";
        }
    }

    //nhấn nút gửi lại mã
    if(isset($_POST['check-reset-otp'])){
        $_SESSION['info'] = "";
        $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
        $check_code = "SELECT * FROM users WHERE code = $otp_code";
        $code_res = mysqli_query($con, $check_code);
        if(mysqli_num_rows($code_res) > 0){
            $fetch_data = mysqli_fetch_assoc($code_res);
            $email = $fetch_data['email'];
            $_SESSION['email'] = $email;
            $info = "Xin hãy tạo mật khẩu mới để đảm bảo tính bảo mật.";
            $_SESSION['info'] = $info;
            header('location: new-password.php');
            exit();
        }else{
            $errors['otp-error'] = "Nhập sai mã xác nhận!";
        }
    }

    //nhấn nút đổi mật khẩu
    if(isset($_POST['change-password'])){
        $_SESSION['info'] = "";
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
        if($password !== $cpassword){
            $errors['password'] = "Mật khẩu nhập lại không trùng khớp!";
        }else{
            $code = 0;
            $email = $_SESSION['email']; //getting this email using session
            $encpass = password_hash($password, PASSWORD_BCRYPT);
            $update_pass = "UPDATE users SET code = $code, password = '$encpass' WHERE email = '$email'";
            $run_query = mysqli_query($con, $update_pass);
            if($run_query){
                $info = "Mật khẩu của bạn đã thay đổi. Bạn có thể đăng nhập lại bằng mật khẩu mới.";
                $_SESSION['info'] = $info;
                header('Location: password-changed.php');
            }else{
                $errors['db-error'] = "Thất bại khi thay đổi mật khẩu!";
            }
        }
    }
    
   //nhan nut dang nhap
    if(isset($_POST['login-now'])){
        header('Location: login-user.php');
    }
?>