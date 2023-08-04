<?php
require_once 'Monster.php';
require_once 'Hero.php';

class FightsManager {
    private Hero $hero;
    private Monster $monster;

    public function createMonster($name) {
        $monster = new Monster($name);
        return $monster;
    }

    public function setHero(Hero $hero) {
        $this->hero = $hero;
    }

    public function setMonster(Monster $monster) {
        $this->monster = $monster;
    }

    public function fight() {
        $result = array();
    
        while ($this->hero->getHealthPoint() > 0 && $this->monster->getHealthPoint() > 0) {
            // Check if the hero has enough energy to perform a special attack
            if ($this->hero->getEnergy() >= 75 || $this->hero->getEnergy() <= 25 && $this->hero->getEnergy() > 0 ) {
                // Use the special attack
                $specialAttackDamage = $this->hero->specialAttack($this->monster);
                $this->hero->decreaseEnergy(25); // Consume 25 energy points for the special attack
                $result[] = $this->hero->getName() . " uses " . $this->hero->getSpecialAttackName() . " on " . $this->monster->getName() . " for " . $specialAttackDamage . " damage.";
    
                // Check if the monster is still alive
                if ($this->monster->getHealthPoint() <= 0) {
                    $result[] = $this->monster->getName() . " has been defeated.";
                    break;
                }
            } else {
                // The hero does not have enough energy to perform a special attack
                // Use the regular attack or a small attack
                if ($this->hero->getEnergy() == 0) {
                    $damage = rand(5, 8); // Small attack with damage between 5 and 8
                } else {
                    $damage = rand(10, 20); // Regular attack with damage between 10 and 20
                    $this->hero->decreaseEnergy(10); // Decrease energy by 10 points for a regular attack
                }
    
                $this->monster->setHealthPoint($this->monster->getHealthPoint() - $damage);
                $result[] = $this->hero->getName() . " hits " . $this->monster->getName() . " for " . $damage . " damage.";
    
                // Check if the monster is still alive
                if ($this->monster->getHealthPoint() <= 0) {
                    $result[] = $this->monster->getName() . " has been defeated.";
                    break;
                }
            }

            // Monster hits the hero
            $monsterDamage = rand(5, 15);

            // Apply the damage multiplier only to the monster
            // Check if the monster's name is "Cell" and the hero's class is "SonGoku"
            if ($this->monster->getName() === "Cell" && $this->hero instanceof SonGokuHero) {
                $monsterDamage *= 2; // Apply the damage multiplier of 2 to the monster
            }

            // Check if the monster's name is "Babidi" and the hero's class is "Vegeta"
            if ($this->monster->getName() === "Babidi" && $this->hero instanceof VegetaHero) {
                $monsterDamage *= 2; // Apply the damage multiplier of 2 to the monster
            }

            // Check if the monster's name is "Buu" and the hero's class is "Yajirobe"
            if ($this->monster->getName() === "Buu" && $this->hero instanceof YajirobeHero) {
                $monsterDamage *= 2; // Apply the damage multiplier of 2 to the monster
            }

            $this->hero->setHealthPoint($this->hero->getHealthPoint() - $monsterDamage);
            $result[] = $this->monster->getName() . " hits " . $this->hero->getName() . " for " . $monsterDamage . " damage.";

            // Check if the hero is still alive and has enough energy for another turn
            if ($this->hero->getHealthPoint() <= 0) {
                $result[] = $this->hero->getName() . " has been defeated.";
                break;
            }
        }

        return $result;
    }
}
