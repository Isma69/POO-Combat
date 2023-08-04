<?php

class SonGokuHero extends Hero {

    public function specialAttack(Monster $target): int {
        $this->decreaseEnergy(25); // Consume 25 energy points for the special attack
        $damage = $this->specialAttackDamage($target);
        $targetHealth = $target->getHealthPoint();
        $targetHealth -= $damage;
        $target->setHealthPoint($targetHealth);

        // Play the sound effect for the special attack
        echo '<audio autoplay><source src="' . __DIR__ . '../sounds/KamehamehaSound.mp3" type="audio/mpeg"></audio>';

        return $damage;
    }

    public function getSpecialAttackName(): string {
        return "Kamehamehaaaaaaaaaa";
    }

    public function specialAttackDamage(Monster $target): int {
        $damage = rand(15, 30); // Inflict 2 times more damage than regular attack
        return $damage;
    }
}