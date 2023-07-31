<?php
class HeroesManager {
    private $db;

    public function setDb(PDO $db){
        $this->db = $db;
    }

    public function __construct(PDO $db){
        $this->setDb($db);
    }

    public function add(Hero $hero) {
        $query = $this->db->prepare('INSERT INTO heroes(name, avatar, health_point) VALUES (:name, :avatar, :health_point)');
        $query->bindValue(':name', $hero->getName());
        $query->bindValue(':avatar', $hero->getAvatar());
        $query->bindValue(':health_point', 100);
        $query->execute();
        $id = $this->db->lastInsertId();
        $hero->setId($id);
        $hero->setHealthPoint(100);
    }

    public function findAllAlive() {
        $query = $this->db->query('SELECT * FROM heroes WHERE health_point > 0');
        $heroesAlive = $query->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Hero");
        return $heroesAlive;
    }

    public function find($heroId) {
        $stmt = $this->db->prepare("SELECT * FROM heroes WHERE id = :id");
        $stmt->bindParam(':id', $heroId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $hero = new Hero($result['name'], $result['avatar']);
            $hero->setId($result['id']);
            $hero->setHealthPoint($result['health_point']);
            return $hero;
        } else {
            return null;
        }
    }

    public function update(Hero $hero) {
        $query = $this->db->prepare('UPDATE heroes SET health_point = :health_point WHERE id = :id');
        $query->bindValue(':health_point', $hero->getHealthPoint());
        $query->bindValue(':id', $hero->getId());
        $query->execute();
    }
}
