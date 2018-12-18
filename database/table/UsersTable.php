<?php

    include_once "./../entity/User.php";

    class UsersTable
    {
        private $pdo;

        public function __construct($pdo)
        {
            $this->pdo = $pdo;
        }

        //ユーザーの追加
        public function add(User $user)
        {
            try {
                $stmt = $this->pdo->prepare("INSERT INTO Users(username, password, mail, user_type) VALUES (:username, :password, :mail, :user_type)");
                $stmt->bindParam(':username', $user->getUsername(), PDO::PARAM_STR);
                $stmt->bindParam(':password', password_hash($user->getPassword(), PASSWORD_DEFAULT), PDO::PARAM_STR);
                $stmt->bindParam(':mail', $user->getMail(), PDO::PARAM_STR);
                $stmt->bindParam(':user_type', $user->getUserType(), PDO::PARAM_INT);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
                exit();
            }
        }

        //ユーザーの削除
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

        //ユーザの定義が正しいかチェックで認証
        //trueならデータベースに登録してよし
        //falseならデータベースに登録してはいけない(再入力)
        public function validate(User $user)
        {
            $good = true;

            //認証チェック


            return $good;
        }

    }