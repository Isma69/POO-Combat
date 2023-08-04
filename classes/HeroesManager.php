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
        $heroesData = $query->fetchAll(PDO::FETCH_ASSOC);
    
        $heroes = array();
    
        foreach ($heroesData as $data) {
            // Utiliser l'avatar pour déterminer le type de héros
            $avatar = $data['avatar'];
    
            switch ($avatar) {
                case 'goku.png':
                    $hero = new SonGokuHero($data['name'], $data['avatar']);
                    break;
                case 'vegeta.png':
                    $hero = new VegetaHero($data['name'], $data['avatar']);
                    break;
                    case 'yajirobe.png':
                        $hero = new YajirobeHero($data['name'], $data['avatar']);
                        break;
                // Ajouter les autres cas pour les autres types de héros
                default:
                    $hero = new SonGokuHero($data['name'], $data['avatar']); // Par défaut, on crée un objet de type Hero
                    break;
            }
    
            // Configurer les autres propriétés du héros
            $hero->setId($data['id']);
            $hero->setHealthPoint($data['health_point']);
            $heroes[] = $hero;
        }
    
        return $heroes;
    }

    public function find($heroId) {
        $stmt = $this->db->prepare("SELECT * FROM heroes WHERE id = :id");
        $stmt->bindParam(':id', $heroId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $hero = null;
            if ($result['avatar'] === 'images/goku.png') {
                $hero = new SonGokuHero($result['name'], $result['avatar']);
            } elseif ($result['avatar'] === 'images/vegeta.png') {
                $hero = new VegetaHero($result['name'], $result['avatar']);
            } elseif ($result['avatar'] === 'images/yajirobe.png') {
                $hero = new YajirobeHero($result['name'], $result['avatar']);
            }
            
            if ($hero) {
                $hero->setId($result['id']);
                $hero->setHealthPoint($result['health_point']);
            }
            
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