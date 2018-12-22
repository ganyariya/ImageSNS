<?php

include_once "C:\Users\megas\Documents\GitHub\ImageSNS\database\\entity\Post.php";

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
            $stmt = $this->pdo->prepare("DELETE FROM Users WHERE id = :id");
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

    //写真の定義が正しいかチェックで認証
    //trueならデータベースに登録してよし
    //falseならデータベースに登録してはいけない(再入力)
    public function validate(User $user)
    {
        $good = true;

        //認証チェック

        return $good;
    }

}