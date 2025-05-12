<div class="box signup" style="display: none">
    <span class="close-btn material-symbols-rounded">close</span>
    <span class="borderline"></span>
    <form id="signup-form" action="home.php" method="post" enctype="multipart/form-data">
        <h2>Sign up</h2>
        <div id="notification-signup">message</div>
        <div class="input-box">
            <input type="text" name="username" required> <span>Username</span>
            <i></i>
        </div>
        <div class="input-box">
            <input type="email" name="email" required> <span>Email Address</span>
            <i></i>
        </div>
        <div class="input-box">
            <input type="password" name="password" required> <span>Password</span>
            <i></i>
        </div>
        <div class="links">
            <a href="#">Already have an account</a>
            <a href="#" class="sign-btn" id="signin-link">Sign in</a>
        </div>
        <input type="submit" value="Sign up" name="signup">
    </form>
</div>