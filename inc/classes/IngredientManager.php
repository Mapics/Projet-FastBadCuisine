<?php 

class IngredientManager {
    private $pdo;
    private $table_name = 'Ingredients';

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function createIngredient($name) {
        $query = "INSERT INTO " . $this->table_name . " (name) VALUES (:name)";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function getIngredient($ingredient_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE ingredient_id = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(1, $ingredient_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return new Ingredient($result['ingredient_id'], $result['name']);
    }

    public function updateIngredient($ingredient_id, $name) {
        $query = "UPDATE " . $this->table_name . " SET name = :name WHERE ingredient_id = :ingredient_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':ingredient_id', $ingredient_id, PDO::PARAM_INT);

        $stmt->execute();
        $stmt->closeCursor();
    }

    public function deleteIngredient($ingredient_id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE ingredient_id = :ingredient_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':ingredient_id', $ingredient_id, PDO::PARAM_INT);

        $stmt->execute();
        $stmt->closeCursor();
    }
}