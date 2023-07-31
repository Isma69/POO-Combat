<?php
require_once 'Monster.php';

class FightsManager {
    private $monster;
    private $hero;

    public function __construct() {
        $this->monster = $this->createMonster("Goblin");
    }

    public function createMonster($name) {
        $monster = new Monster($name);
        return $monster;
    }

    public function fight(Hero $hero, Monster $monster) {
        $this->hero = $hero;
        $this->monster = $monster;

        $result = array();

        while ($this->hero->getHealthPoint() > 0 && $this->monster->getHealthPoint() > 0) {
            // Hero hits the monster
            $monsterHealth = $this->monster->getHealthPoint();
            $damage = rand(10, 20);
            $monsterHealth -= $damage;
            $this->monster->setHealthPoint($monsterHealth);
            $result[] = $this->hero->getName() . " hits " . $this->monster->getName() . " for " . $damage . " damage.";

            // Check if monster is still alive
            if ($this->monster->getHealthPoint() <= 0) {
                $result[] = $this->monster->getName() . " has been defeated.";
                break;
            }

            // Monster hits the hero
            $heroHealth = $this->hero->getHealthPoint();
            $damage = rand(5, 15);
            $heroHealth -= $damage;
            $this->hero->setHealthPoint($heroHealth);
            $result[] = $this->monster->getName() . " hits " . $this->hero->getName() . " for " . $damage . " damage.";

            // Check if hero is still alive
            if ($this->hero->getHealthPoint() <= 0) {
                $result[] = $this->hero->getName() . " has been defeated.";
                break;
            }
        }

        return $result;
    }
}







