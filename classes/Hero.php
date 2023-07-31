<?php
    class Hero {
        private int $id;
        private $name;
        private int $health_point;
        private $avatar;

        public function __construct($name = null, $avatar = null){
                $this->name = $name;
                $this->avatar = $avatar;
        }

        /**
         * Set the value of id
         */
        public function setId(int $id): self
        {
                $this->id = $id;

                return $this;
        }
        public function getId(): int
        {
                return $this->id;
        }

        /**
         * Get the value of name
         */
        public function getName(): string
        {
                return $this->name;
        }

        /**
         * Set the value of name
         */
        public function setName(string $name): self
        {
                $this->name = $name;

                return $this;
        }

                /**
         * Get the value of health_point
         */
        public function getHealthPoint(): int
        {
                return $this->health_point;
        }

        /**
         * Set the value of health_point
         */
        public function setHealthPoint(int $health_point): self
        {
                $this->health_point = $health_point;

                return $this;
        }

        /**
         * Get the value of avatar
         */
        public function getAvatar()
        {
                return $this->avatar;
        }

        public function hit(){
            
        }
    }