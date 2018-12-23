<header>
    <div class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container d-flex justify-content-between">
            <a href="/index.php" class="navbar-brand d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                    <circle cx="12" cy="13" r="4"></circle>
                </svg>
                <strong>IMAGE SNS</strong>
            </a>

            <div class="my-2 my-lg-0" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <?php
                    global $is_login;
                    global $username;
                    if ($is_login === true) {
                        echo '
      <li class="nav-item">
        <a href="upload.php"><button type="button" style="margin-right: 10px; vertical-align: center" class="btn btn-success">Upload</button></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';

          echo $username;
        echo '</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="/mypage.php">My Page</a>
          <a class="dropdown-item" href="logout.php">Logout</a>
        </div>
      </li>';
                    } else {
                        echo '<a href="login.php"><button type="button" style="margin-right: 10px; vertical-align: center" class="btn btn-success">Login</button></a>';
                    } ?>
                </ul>
            </div>
        </div>
    </div>
</header>