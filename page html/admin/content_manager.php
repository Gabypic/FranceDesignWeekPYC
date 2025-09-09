<?php
require_once 'db.php';

class ContentManager {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function addContent(int $model, array $data): bool {
        try {
            switch ($model) {
                case 1: return $this->addArticleWithTwoImages($data);
                case 2: return $this->addArticleWithImageAndVideo($data);
                case 3: return $this->addArticleOnly($data);
                case 4: return $this->addArticleWithVideo($data);
                default: throw new InvalidArgumentException("Modèle non valide");
            }
        } catch (Exception $e) {
            error_log("Erreur ajout contenu : " . $e->getMessage());
            return false;
        }
    }

    public function deleteContent(int $contentId): bool {
        try {
            $stmt = $this->db->prepare("SELECT image1, image2 FROM article WHERE id = ?");
            $stmt->execute([$contentId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                foreach (['image1', 'image2'] as $img) {
                    if (!empty($row[$img])) {
                        $path = __DIR__ . '../public/images' . $row[$img];
                        if (file_exists($path)) unlink($path);
                    }
                }
            }
            $stmt = $this->db->prepare("DELETE FROM article WHERE id = ?");
            return $stmt->execute([$contentId]);
        } catch (Exception $e) {
            error_log("Erreur suppression contenu : " . $e->getMessage());
            return false;
        }
    }

    private function addArticleWithTwoImages(array $data): bool {
        if (!$this->validateData($data, ['titre', 'article', 'image1', 'image2', 'auteur'])) return false;
        $stmt = $this->db->prepare("INSERT INTO article (titre, article, image1, image2, auteur, modele) VALUES (?, ?, ?, ?, ?, 1)");
        return $stmt->execute([
            $this->sanitize($data['titre']),
            $this->sanitize($data['article']),
            $this->sanitize($data['image1']),
            $this->sanitize($data['image2']),
            $this->sanitize($data['auteur'])
        ]);
    }

    private function addArticleWithImageAndVideo(array $data): bool {
        if (!$this->validateData($data, ['titre', 'article', 'image1', 'video', 'auteur'])) return false;
        $stmt = $this->db->prepare("INSERT INTO article (titre, article, image1, video, auteur, modele) VALUES (?, ?, ?, ?, ?, 2)");
        return $stmt->execute([
            $this->sanitize($data['titre']),
            $this->sanitize($data['article']),
            $this->sanitize($data['image1']),
            $this->sanitize($data['video']),
            $this->sanitize($data['auteur'])
        ]);
    }

    private function addArticleOnly(array $data): bool {
        if (!$this->validateData($data, ['titre', 'article', 'auteur'])) return false;
        $stmt = $this->db->prepare("INSERT INTO article (titre, article, auteur, modele) VALUES (?, ?, ?, 3)");
        return $stmt->execute([
            $this->sanitize($data['titre']),
            $this->sanitize($data['article']),
            $this->sanitize($data['auteur'])
        ]);
    }

    private function addArticleWithVideo(array $data): bool {
        if (!$this->validateData($data, ['titre', 'article', 'video', 'auteur'])) return false;
        $stmt = $this->db->prepare("INSERT INTO article (titre, article, video, auteur, modele) VALUES (?, ?, ?, ?, 4)");
        return $stmt->execute([
            $this->sanitize($data['titre']),
            $this->sanitize($data['article']),
            $this->sanitize($data['video']),
            $this->sanitize($data['auteur'])
        ]);
    }

    public function getAllContents(): array {
        try {
            $stmt = $this->db->query("SELECT * FROM article ORDER BY id DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (Exception $e) {
            error_log("Erreur récupération contenus : " . $e->getMessage());
            return [];
        }
    }

    public function getContent(int $contentId): ?array {
        try {
            $stmt = $this->db->prepare("SELECT * FROM article WHERE id = ?");
            $stmt->execute([$contentId]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (Exception $e) {
            error_log("Erreur récupération contenu : " . $e->getMessage());
            return null;
        }
    }

    private function validateData(array $data, array $requiredFields): bool {
        foreach ($requiredFields as $field) {
            if (empty($data[$field]) || !is_string($data[$field])) return false;
        }
        return true;
    }

    private function sanitize(string $value): string {
        return trim(strip_tags($value));
    }
}
?>
