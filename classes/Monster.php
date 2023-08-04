<?php

class Monster {
    private $name;
    private $health;

    public function __construct($name) {
        $this->name = $name;
        $this->health = 100;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getHealthPoint(): int {
        return $this->health;
    }

    public function setHealthPoint(int $health): void {
        $this->health = $health;
    }
}