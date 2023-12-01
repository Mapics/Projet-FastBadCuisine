<?php

class RecipeManager  {
    private $pdo;
    private $table_name = 'Recipes';

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function createRecipe($title, $instructions, $creator_name) {
        $query = "INSERT INTO " . $this->table_name . " (title, instructions, creator_name) VALUES (:title, :instructions, :creator_name)";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':instructions', $instructions, PDO::PARAM_STR);
        $stmt->bindParam(':creator_name', $creator_name, PDO::PARAM_STR);

        $stmt->execute();
        // $stmt->closeCursor();  // Pas nécessaire ici pour une requête d'insertion
    }

    public function getRecipe($recipe_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE recipe_id = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(1, $recipe_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return new Recipe($result['recipe_id'], $result['title'], $result['instructions'], $result['creator_name']);
    }

    public function updateRecipe($recipe_id, $title, $instructions, $creator_name) {
        $query = "UPDATE " . $this->table_name . " SET title = :title, instructions = :instructions, creator_name = :creator_name WHERE recipe_id = :recipe_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':instructions', $instructions, PDO::PARAM_STR);
        $stmt->bindParam(':creator_name', $creator_name, PDO::PARAM_STR);
        $stmt->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function deleteRecipe($recipe_id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE recipe_id = :recipe_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }
}