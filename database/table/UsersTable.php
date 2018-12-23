<?php
    include_once dirname(__FILE__) . "/../entity/User.php";

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
            $username = $user->getUsername();
            $password = password_hash($user->getPassword(), PASSWORD_DEFAULT);
            $mail = $user->getMail();
            $user_type = $user->getUserType();
            try {
                $stmt = $this->pdo->prepare("INSERT INTO Users(username, password, mail, user_type) VALUES (:username, :password, :mail, :user_type)");
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
                $stmt->bindParam(':user_type', $user_type, PDO::PARAM_INT);

                $stmt->execute();

                return $this->pdo->lastInsertId();
            } catch (PDOException $e) {
                echo $e->getMessage();
                exit();
            }
        }

        public function getUserById($id)
        {
            try {
                $stmt = $this->pdo->prepare("SELECT * FROM Users WHERE id = :id");
                $stmt->bindParam(':id', $id);
                $stmt->execute();

                $result = $stmt->fetch();

                $username = $result['username'];
                $password = $result['password'];
                $mail = $result['mail'];
                $user_type = $result['user_type'];
                $created_at = $result['created_at'];
                $updated_at = $result['updated_at'];

                $user = new User($id, $username, $password, $mail, $user_type, $created_at, $updated_at);

                return $user;
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
            $username = $user->getUsername();

            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Users WHERE username=:username");
            $stmt->bindParam('username', $username);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            $result = $stmt->fetchColumn();

            return $result <= 0;
        }

        //ユーザの存在をチェック
        //存在したらidを返す
        //存在しないなら-1返す
        public function isUserExists($username, $password)
        {
            try {
                $query = $this->pdo->prepare("SELECT id, password FROM Users WHERE username=:username");
                $query->bindParam('username', $username);
                $query->execute();
                $result = $query->fetchAll();
                foreach ($result as $row) {
                    if (password_verify($password, $row['password'])) return $row['id'];
                }

                return -1;
            } catch (PDOException $e) {
                echo $e->getMessage();
                exit();
            }
        }

    }