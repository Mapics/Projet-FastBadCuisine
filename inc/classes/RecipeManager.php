<?php

class RecipeManager {
    private $pdo;
    private $table_name = 'Recipes';

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function createRecipe($title, $instructions, $creator_name, $image_url, $categorie) {
        $query = "INSERT INTO " . $this->table_name . " (title, instructions, creator_name, image, categorie) VALUES (:title, :instructions, :creator_name, :image_url, :categorie)";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':instructions', $instructions, PDO::PARAM_STR);
        $stmt->bindParam(':creator_name', $creator_name, PDO::PARAM_STR);
        $stmt->bindParam(':image_url', $image_url, PDO::PARAM_STR);
        $stmt->bindParam(':categorie', $categorie, PDO::PARAM_STR);

        $stmt->execute();
        // $stmt->closeCursor();  // Pas nécessaire ici pour une requête d'insertion
    }

    public function getRecipe($recipe_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE recipe_id = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(1, $recipe_id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return new Recipe($result['recipe_id'], $result['title'], $result['instructions'], $result['creator_name'], $result['image'], $result['likes'], $result['categorie']);
    }

    public function updateRecipe($recipe_id,$title, $instructions, $creator_name, $image_url, $categorie) {
        $query = "UPDATE " . $this->table_name . " SET title = :title, instructions = :instructions, creator_name = :creator_name, image = :image, categorie = :categorie WHERE recipe_id = :recipe_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':instructions', $instructions, PDO::PARAM_STR);
        $stmt->bindParam(':creator_name', $creator_name, PDO::PARAM_STR);
        $stmt->bindParam(':image', $image_url, PDO::PARAM_STR);
        $stmt->bindParam(':categorie', $categorie, PDO::PARAM_STR);
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

    public function getRandomRecipes($amount) {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY RAND() LIMIT :amount";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        $recipes = [];
        foreach ($results as $result) {
            $recipes[] = new Recipe($result['recipe_id'], $result['title'], $result['instructions'], $result['creator_name'], $result['image'], $result['likes'], $result['categorie']);
        }
        return $recipes;
    }
    
    public function getBestRecipes($amount) {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY likes DESC LIMIT :amount";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        $recipes = [];
        foreach ($results as $result) {
            $recipes[] = new Recipe($result['recipe_id'], $result['title'], $result['instructions'], $result['creator_name'], $result['image'], $result['likes'], $result['categorie']);
        }
        return $recipes;
    }

    public function getRecipesByCategorie($categorie) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE categorie = :categorie";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':categorie', $categorie, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        $recipes = [];
        foreach ($results as $result) {
            $recipes[] = new Recipe($result['recipe_id'], $result['title'], $result['instructions'], $result['creator_name'], $result['image'], $result['likes'], $result['categorie']);
        }
        return $recipes;
    }

    public function searchRecipes($search) {
        // Votre requête SQL pour rechercher des recettes
        $query = "SELECT * FROM " . $this->table_name . " WHERE title LIKE :search";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':search', '%'.$search.'%');
        $stmt->execute();
    
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
    
        $recipes = [];
        foreach ($results as $result) {
            $recipes[] = new Recipe($result['recipe_id'], $result['title'], $result['instructions'], $result['creator_name'], $result['image'], $result['likes'], $result['categorie']);
        }
    
        return $recipes;
    }
}