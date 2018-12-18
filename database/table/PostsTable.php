<?php

    include_once "./../entity/Post.php";

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
            try {
                $stmt = $this->pdo->prepare("INSERT INTO Posts(user_id, url, likes, comment) VALUES (:user_id, :url, :likes, :comment)");
                $stmt->bindParam(':user_id', $post->getUserId(), PDO::PARAM_INT);
                $stmt->bindParam(':url', $post->getUrl(), PDO::PARAM_STR);
                $stmt->bindParam(':likes',$post->getLikes(), PDO::PARAM_INT);
                $stmt->bindParam(':comment', $post->getComment(), PDO::PARAM_STR);
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

        //写真の定義が正しいかチェックで認証
        //trueならデータベースに登録してよし
        //falseならデータベースに登録してはいけない(再入力)
        public function validate(User $user){
            $good = true;

            //認証チェック

            return $good;
        }

    }