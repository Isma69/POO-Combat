<?php

class VegetaHero extends Hero {

    public function specialAttack(Monster $target): int {
        $this->decreaseEnergy(25); // Consume 25 energy points for the special attack
        $damage = rand(15, 30); // Inflict 2 times more damage than regular attack
        $targetHealth = $target->getHealthPoint();
        $targetHealth -= $damage;
        $target->setHealthPoint($targetHealth);
        return $damage;
    }

    public function getSpecialAttackName(): string {
        return "Final Flash";
    }

    public function specialAttackDamage(Monster $target): int {
        $damage = rand(15, 30); // Inflict 2 times more damage than regular attack
        return $damage;
    }
}
