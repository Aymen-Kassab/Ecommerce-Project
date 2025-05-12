<div class="blur-bg-overlay"></div>
    <div class="box login">
    <span class="close-btn material-symbols-rounded">close</span>
    <span class="borderline"></span>
    <form id="signin-form" action="home.php" method="post" enctype="multipart/form-data">
        <h2>Sign in</h2>
        <div id="notification-signin">message</div>
        <div class="input-box">
            <input class="input-form" type="text" name="username" required> <span>Username</span>
            <i></i>
        </div>
        <div class="input-box">
            <input class="input-form" type="password" name="password" required> <span>Password</span>
            <i></i>
        </div>
        <div class="links">
            <a href="#">Forgot Password?</a>
            <a href="#" class="sign-btn" id="signup-link">Sign up</a>
        </div>
            <input type="submit" value="Sign in" name="signin">
    </form>
</div>