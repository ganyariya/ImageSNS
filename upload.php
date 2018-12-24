<?php
    include_once "database/Session.php";
    include_once "database/table/PostsTable.php";
    include_once "database/entity/Post.php";
    include_once "database/Database.php";

    $session = New Session();

    //headerで使う
    $is_login = $session->is_login();
    $user_id = $session->get_user_id();
    $username = $session->get_user_name();

    $db = new Database();
    $pdo = $db->pdo();

    $postsTable = new PostsTable($pdo);

    $bad_extension = null;

    if ($session->is_login() === false) {
        header('Location: /login.php');
    } else {
        if (isset($_POST['btnUpload'])) {
            $filename = $session->get_user_id() . date('dmYHis') . $_FILES['image']['name'];
            $comment = $_POST['comment'];
            $bad_extension = true;

            $extensions = array("image/png", "image/jpeg", "image/png");
            foreach ($extensions as $extension) if (mime_content_type($_FILES['image']['tmp_name']) == $extension) $bad_extension = false;

            if (move_uploaded_file($_FILES['image']['tmp_name'], './images/' . $filename) && !$bad_extension) {
                $post = new Post(0, $session->get_user_id(), $filename, 0, $comment, "", "", "");
                $postsTable->add($post);
                header('Location: /index.php');
            }

        }
    }
?>
<!doctype html>
<html lang="jp">
<head>
    <?php include_once dirname(__FILE__) . "/meta.php" ?>
</head>

<body class="bg-light">
    <style>
        .imagePreview {
            width: 100%;
            height: 500px;
            background-position: center center;
            background-size: cover;
            -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
            display: inline-block;
        }
    </style>
    <?php include_once dirname(__FILE__) . "/header.php" ?>
    <div class="container" style="margin-top: 2rem;">
        <div class="text-center">
            <h2>画像のアップロード</h2>
        </div>
        <div class="col-md-8 order-md-1 signup" style="margin: 0 auto;">
            <form class="needs-validation" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="FILE">FILE</label>
                    <div class="imagePreview"></div>
                    <div class="input-group">
                        <label class="input-group-btn">
                                <span class="btn btn-primary">
                                    Choose File<input type="file" style="display:none" name="image" class="form-control"
                                                      required>
                                </span>
                        </label>
                        <input type="text" class="form-control" readonly="">
                    </div>
                    <?php
                        if($bad_extension){
                            echo ("jpg, png, gifの画像のみアップロードできます。");
                        }
                    ?>
                </div>

                <div class="mb-3">
                    <label>Comment <span class="text-muted">(Optional)</span></label>
                    <textarea name="comment" type="text" class="form-control" placeholder="Comment"></textarea>
                </div>

                <hr class="mb-4">
                <button name="btnUpload" class="btn btn-primary btn-lg btn-block" type="submit">Upload</button>
            </form>
        </div>
    </div>

    <?php include_once dirname(__FILE__) . "/footer.php" ?>

    <script>
        $(document).on('change', ':file', function () {
            var input = $(this),
                numFiles = input.get(0).files ? input.get(0).files.length : 1,
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.parent().parent().next(':text').val(label);

            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
            if (/^image/.test(files[0].type)) { // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file
                reader.onloadend = function () { // set image data as background of div
                    input.parent().parent().parent().prev('.imagePreview').css("background-image", "url(" + this.result + ")");
                }
            }
        });
    </script>
</body>
</html>
