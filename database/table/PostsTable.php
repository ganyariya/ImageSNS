<?php

    include_once dirname(__FILE__) . "/../entity/Post.php";

    class PostsTable
    {
        private $pdo;

        public function __construct($pdo)
        {
            $this->pdo = $pdo;
        }

        //写真の追加
        public function add(Post $post)
        {
            $user_id = $post->getUserId();
            $url = $post->getUrl();
            $likes = $post->getLikes();
            $comment = $post->getComment();

            try {
                $stmt = $this->pdo->prepare("INSERT INTO Posts(user_id, url, likes, comment) VALUES (:user_id, :url, :likes, :comment)");
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->bindParam(':url', $url, PDO::PARAM_STR);
                $stmt->bindParam(':likes', $likes, PDO::PARAM_INT);
                $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
                exit();
            }
        }

        //写真の削除
        public function delete($id)
        {
            try {
                $stmt = $this->pdo->prepare("DELETE FROM Posts WHERE id = :id");
                $stmt->bindParam(':id', $id);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
                exit();
            }
        }

        public function getAllPostByUserId($user_id)
        {
            $ret = array();

            try {
                $stmt = $this->pdo->prepare("SELECT * FROM Posts WHERE user_id=:user_id ORDER BY post_date DESC");
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->execute();

                $array = $stmt->fetchAll();
                foreach ($array as $row) {
                    $id = $row['id'];
                    $user_id = $row['user_id'];
                    $url = $row['url'];
                    $like = $row['likes'];
                    $comment = $row['comment'];
                    $post_date = $row['post_date'];
                    $created_at = $row['created_at'];
                    $updated_at = $row['updated_at'];

                    $ret[] = new Post($id, $user_id, $url, $like, $comment, $post_date, $created_at, $updated_at);
                }

                return $ret;
            } catch (PDOException $e) {
                echo $e->getMessage();
                exit();
            }
        }

        public function getAllPostByUserIdWithUser($user_id)
        {
            $ret = array();

            try {
                $stmt = $this->pdo->prepare("
                    SELECT P.id, P.user_id, P.url, P.likes, P.comment, P.post_date, P.created_at, P.updated_at, U.username
                    FROM Posts AS P
                    INNER JOIN Users AS U
                    on P.user_id = U.id
                    WHERE P.user_id = :user_id
                    ORDER BY post_date
                    DESC
                ");
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->execute();

                $array = $stmt->fetchAll();
                foreach ($array as $row) {
                    $id = $row['id'];
                    $user_id = $row['user_id'];
                    $url = $row['url'];
                    $like = $row['likes'];
                    $comment = $row['comment'];
                    $post_date = $row['post_date'];
                    $created_at = $row['created_at'];
                    $updated_at = $row['updated_at'];
                    $username = $row['username'];

                    $post = new Post($id, $user_id, $url, $like, $comment, $post_date, $created_at, $updated_at);

                    //dynamic追加
                    $post->username = $username;
                    $ret[] = $post;
                }

                return $ret;

            } catch (PDOException $e) {
                echo $e->getMessage();
                exit();
            }
        }

        public function getAllPost()
        {
            $ret = array();

            try {
                $stmt = $this->pdo->prepare("SELECT * FROM Posts ORDER BY post_date DESC");
                $stmt->execute();

                $array = $stmt->fetchAll();

                foreach ($array as $row) {
                    $id = $row['id'];
                    $user_id = $row['user_id'];
                    $url = $row['url'];
                    $like = $row['likes'];
                    $comment = $row['comment'];
                    $post_date = $row['post_date'];
                    $created_at = $row['created_at'];
                    $updated_at = $row['updated_at'];

                    $ret[] = new Post($id, $user_id, $url, $like, $comment, $post_date, $created_at, $updated_at);
                }

                return $ret;
            } catch (PDOException $e) {
                echo $e->getMessage();
                exit();
            }
        }

        //ポストIDにあったポストを返す
        public function getPostById($id)
        {
            try {
                $stmt = $this->pdo->prepare("SELECT * FROM Posts WHERE id = :id");
                $stmt->bindParam(':id', $id);
                $stmt->execute();

                $row = $stmt->fetch();

                //ポストIDに一致するものがない
                if ($stmt->rowCount() == 0) return -1;

                $id = $row['id'];
                $user_id = $row['user_id'];
                $url = $row['url'];
                $like = $row['likes'];
                $comment = $row['comment'];
                $post_date = $row['post_date'];
                $created_at = $row['created_at'];
                $updated_at = $row['updated_at'];

                $post = new Post($id, $user_id, $url, $like, $comment, $post_date, $created_at, $updated_at);
                return $post;
            } catch (PDOException $e) {
                echo $e->getMessage();
                exit();
            }
        }

        public function getAllPostWithUser()
        {
            $ret = array();

            try {
                $stmt = $this->pdo->prepare("
                    SELECT P.id, P.user_id, P.url, P.likes, P.comment, P.post_date, P.created_at, P.updated_at, U.username
                    FROM Posts AS P
                    INNER JOIN Users AS U
                    on P.user_id = U.id
                    ORDER BY post_date
                    DESC
                ");

                $stmt->execute();
                $array = $stmt->fetchAll();

                foreach ($array as $row) {
                    $id = $row['id'];
                    $user_id = $row['user_id'];
                    $url = $row['url'];
                    $like = $row['likes'];
                    $comment = $row['comment'];
                    $post_date = $row['post_date'];
                    $created_at = $row['created_at'];
                    $updated_at = $row['updated_at'];
                    $username = $row['username'];

                    $post = new Post($id, $user_id, $url, $like, $comment, $post_date, $created_at, $updated_at);

                    //dynamic追加
                    $post->username = $username;
                    $ret[] = $post;
                }

                return $ret;

            } catch (PDOException $e) {
                echo $e->getMessage();
                exit();
            }
        }

        public function getLimitPostWithUser($page_start)
        {
            $ret = array();

            try {
                $stmt = $this->pdo->prepare("
                    SELECT P.id, P.user_id, P.url, P.likes, P.comment, P.post_date, P.created_at, P.updated_at, U.username
                    FROM Posts AS P
                    INNER JOIN Users AS U
                    on P.user_id = U.id
                    ORDER BY post_date DESC
                    LIMIT $page_start, 10
                ");
                $stmt->bindParam(':page_start', $page_start);
                $stmt->execute();
                $array = $stmt->fetchAll();

                foreach ($array as $row) {
                    $id = $row['id'];
                    $user_id = $row['user_id'];
                    $url = $row['url'];
                    $like = $row['likes'];
                    $comment = $row['comment'];
                    $post_date = $row['post_date'];
                    $created_at = $row['created_at'];
                    $updated_at = $row['updated_at'];
                    $username = $row['username'];

                    $post = new Post($id, $user_id, $url, $like, $comment, $post_date, $created_at, $updated_at);

                    //dynamic追加
                    $post->username = $username;
                    $ret[] = $post;
                }

                return $ret;

            } catch (PDOException $e) {
                echo $e->getMessage();
                exit();
            }
        }

        //ポストの投稿数の全体の数のみを返す
        public function getAllPostCount()
        {
            try {
                $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Posts");
                $stmt->execute();
                $ret = $stmt->fetchColumn();
                return $ret;
            } catch (PDOException $e) {
                echo $e->getMessage();
                exit();
            }
        }

        public function incrementLike($id)
        {
            try {
                $stmt = $this->pdo->prepare("UPDATE Posts SET likes = likes + 1 WHERE id = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->rowCount();
            } catch (PDOException $e) {
                exit();
            }
        }

        //写真の定義が正しいかチェックで認証
        //trueならデータベースに登録してよし
        //falseならデータベースに登録してはいけない(再入力)
        public function validate(Post $post)
        {
            $good = true;

            //認証チェック

            return $good;
        }

    }