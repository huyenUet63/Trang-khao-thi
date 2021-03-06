<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trang khảo thí</title>

    <!--Custom Style-->
    <link rel="stylesheet" href="./css/home_style.css">

    <!--font awesome icon-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
    <header id="header">
        <div class="text">
            <p>Some thing here</p>
        </div>
        <nav class="nav">
            <input type="checkbox" id="show-search">
            <input type="checkbox" id="show-menu">
            <label for="show-menu" class="menu-icon"><i class="fas fa-bars"></i></label>
            <div class="content">
                <div class="logo">                   
                    <a href="index.html" class="nav-brand"><img src="./assets/logo-full.png" class="image-fluid" alt="logo" width="130" height="54"></a>            
                </div>
                <ul class="links">
                    <li><a href="#">Giới thiệu</a></li>
                    <li><a href="#">Thông báo</a></li>
                    <li>
                        <a href="#" class="desktop-link">Đăng ký thi <i class="fas fa-caret-down"></i></a>
                        <input type="checkbox" id="show-info">
                        <label for="show-info">Đăng ký thi</label>
                        <ul>
                            <li><a href="#">Menu 1</a></li>
                            <li><a href="#">Menu 2</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="desktop-link">Diễn đàn <i class="fas fa-caret-down"></i></a>
                        <input type="checkbox" id="show-forum">
                        <label for="show-forum">Diễn đàn</label>
                        <ul>
                            <li><a href="#">Menu 1</a></li>
                            <li><a href="#">Menu 2</a></li>
                            <li><a href="#">Menu 3</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Tra cứu</a></li>
                </ul>
                <div class="log">
                    <a href="logout-user.php" class="btn transparent">Đăng nhập</a>
                </div>
            </div>
            <label for="show-search" class="search-icon"><i class="fas fa-search"></i></label>
            <form action="#" class="search-box">
                <input type="text" placeholder="Nhập để tìm kiếm..." required>
                <button type="submit" class="go-icon"><i class="fas fa-long-arrow-alt-right"></i></button>
            </form>
        </nav>
    </header>

    <main id="main-site">
        <section>
            <h2>WELCOME</h2>
        </section>  
    </main>
</body>
</html>