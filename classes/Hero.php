<?php

abstract class Hero {
    private int $id;
    private string $name;
    private int $health_point;
    private string $avatar;
    private int $energy;
    

    public function __construct(string $name = null, string $avatar = null) {
        $this->name = $name;
        $this->avatar = $avatar;
        $this->energy = 100; // Initial energy set to 100
    }

    public function getEnergy(): int {
        return $this->energy;
    }

    public function decreaseEnergy(int $amount) {
        $this->energy -= $amount;
        if ($this->energy < 0) {
            $this->energy = 0;
        }
    }

    public function increaseEnergy(int $amount) {
        $this->energy += $amount;
        if ($this->energy > 100) {
            $this->energy = 100;
        }
    }

    abstract public function specialAttack(Monster $target): int;
    abstract public function getSpecialAttackName(): string;
    abstract public function specialAttackDamage(Monster $target): int;

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
    public function getAvatar(): string
    {
        return $this->avatar;
    }

    /**
     * Set the value of avatar
     */
    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;
        return $this;
    }

    public function hit(Monster $target): int {
        $targetHealth = $target->getHealthPoint();
        $damage = rand(10, 20);
        $targetHealth -= $damage;
        $target->setHealthPoint($targetHealth);
        return $damage;
    }
}
