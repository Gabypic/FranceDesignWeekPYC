<?php
require_once 'db.php';

class ContentManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Ajouter un contenu selon le modèle spécifié
    public function addContent($model, $data) {
        try {
            switch ($model) {
                case 1: // Article + 2 images
                    return $this->addArticleWithTwoImages($data);
                case 2: // Article + image + vidéo
                    return $this->addArticleWithImageAndVideo($data);
                case 3: // Article seul
                    return $this->addArticleOnly($data);
                case 4: // Article + vidéo
                    return $this->addArticleWithVideo($data);
                default:
                    throw new Exception("Modèle non valide");
            }
        } catch (Exception $e) {
            error_log("Erreur lors de l'ajout du contenu: " . $e->getMessage());
            return false;
        }
    }

    // Supprimer un contenu
    public function deleteContent($contentId) {
        try {
            $stmt = $this->db->prepare("DELETE FROM article WHERE id = ?");
            return $stmt->execute([$contentId]);
        } catch (Exception $e) {
            error_log("Erreur lors de la suppression du contenu: " . $e->getMessage());
            return false;
        }
    }

    // Modèle 1: Article + 2 images
    private function addArticleWithTwoImages($data) {
        $stmt = $this->db->prepare("
            INSERT INTO article (titre, article, image1, image2, auteur, model)
            VALUES (?, ?, ?, ?, ?, 1)
        ");
        return $stmt->execute([
            $data['titre'],
            $data['article'],
            $data['image1'],
            $data['image2'],
            $data['auteur']
        ]);
    }

    // Modèle 2: Article + image + vidéo
    private function addArticleWithImageAndVideo($data) {
        $stmt = $this->db->prepare("
            INSERT INTO article (titre, article, image1, video, auteur, model)
            VALUES (?, ?, ?, ?, ?, 2)
        ");
        return $stmt->execute([
            $data['titre'],
            $data['article'],
            $data['image1'],
            $data['video'],
            $data['auteur']
        ]);
    }

    // Modèle 3: Article seul
    private function addArticleOnly($data) {
        $stmt = $this->db->prepare("
            INSERT INTO article (titre, article, auteur, model)
            VALUES (?, ?, ?, 3)
        ");
        return $stmt->execute([
            $data['titre'],
            $data['article'],
            $data['auteur']
        ]);
    }

    // Modèle 4: Article + vidéo
    private function addArticleWithVideo($data) {
        $stmt = $this->db->prepare("
            INSERT INTO article (titre, article, video, auteur, model)
            VALUES (?, ?, ?, ?, 4)
        ");
        return $stmt->execute([
            $data['titre'],
            $data['article'],
            $data['video'],
            $data['auteur']
        ]);
    }

    // Récupérer tous les contenus
    public function getAllContents() {
        $stmt = $this->db->query("SELECT * FROM article ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un contenu spécifique
    public function getContent($contentId) {
        $stmt = $this->db->prepare("SELECT * FROM article WHERE id = ?");
        $stmt->execute([$contentId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?> 