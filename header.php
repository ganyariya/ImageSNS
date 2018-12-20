<header>
    <div class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container d-flex justify-content-between">
            <a href="../../" class="navbar-brand d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                    <circle cx="12" cy="13" r="4"></circle>
                </svg>
                <strong>IMAGE SNS</strong>
            </a>
            <?php
            if ($session->is_login()) {
                echo '<a>' . "aaa" . '</a>';
            } else {
                echo '<a href="login.php"><button type="button" style="margin-right: 10px; vertical-align: center" class="btn btn-success">Login</button></a>';
            } ?>
        </div>
    </div>
</header>