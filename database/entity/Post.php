<?php

    class Post
    {
        private $id;
        private $user_id;
        private $url;
        private $likes;
        private $comment;
        private $post_date;
        private $created_at;
        private $updated_at;

        public function __construct($id, $user_id, $url, $likes, $comment, $post_date, $created_at, $updated_at)
        {
            //引数が一つのとき(PDOのStatementオブジェクトのとき)
            if (func_num_args() == 1) {
                $row = $id;
                $this->id = $row['id'];
                $this->user_id = $row['user_id'];
                $this->url = $row['url'];
                $this->likes = $row['likes'];
                $this->comment = $row['comment'];
                $this->post_date = $row['post_date'];
                $this->created_at = $row['created_at'];
                $this->updated_at = $row['updated_at'];
            } else {
                $this->id = $id;
                $this->user_id = $user_id;
                $this->url = $url;
                $this->likes = $likes;
                $this->comment = $comment;
                $this->post_date = $post_date;
                $this->created_at = $created_at;
                $this->updated_at = $updated_at;
            }
        }

        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @param mixed $id
         */
        public function setId($id)
        {
            $this->id = $id;
        }

        /**
         * @return mixed
         */
        public function getUserId()
        {
            return $this->user_id;
        }

        /**
         * @param mixed $user_id
         */
        public function setUserId($user_id)
        {
            $this->user_id = $user_id;
        }

        /**
         * @return mixed
         */
        public function getUrl()
        {
            return $this->url;
        }

        /**
         * @param mixed $url
         */
        public function setUrl($url)
        {
            $this->url = $url;
        }

        /**
         * @return mixed
         */
        public function getLikes()
        {
            return $this->likes;
        }

        /**
         * @param mixed $likes
         */
        public function setLikes($likes)
        {
            $this->likes = $likes;
        }

        /**
         * @return mixed
         */
        public function getComment()
        {
            return $this->comment;
        }

        /**
         * @param mixed $comment
         */
        public function setComment($comment)
        {
            $this->comment = $comment;
        }

        /**
         * @return mixed
         */
        public function getPostDate()
        {
            return $this->post_date;
        }

        /**
         * @param mixed $post_date
         */
        public function setPostDate($post_date)
        {
            $this->post_date = $post_date;
        }

        /**
         * @return mixed
         */
        public function getCreatedAt()
        {
            return $this->created_at;
        }

        /**
         * @param mixed $created_at
         */
        public function setCreatedAt($created_at)
        {
            $this->created_at = $created_at;
        }

        /**
         * @return mixed
         */
        public function getUpdatedAt()
        {
            return $this->updated_at;
        }

        /**
         * @param mixed $updated_at
         */
        public function setUpdatedAt($updated_at)
        {
            $this->updated_at = $updated_at;
        }


    }