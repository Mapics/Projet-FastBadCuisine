<?php 

class RecipeIngredientManager {
    private $pdo;
    private $table_name = 'RecipeIngredients';

    public function __construct($db) {
        $this->pdo = $db;
    }
    

    public function getNameFromIngredientId($ingredient_id) {
        $query = "SELECT name FROM Ingredients WHERE ingredient_id = :ingredient_id";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':ingredient_id', $ingredient_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result['name'];
    }

    public function createRecipeIngredient($recipe_id, $ingredient_id, $quantity) {
        $query = "INSERT INTO " . $this->table_name . " (recipe_id, ingredient_id, quantity) VALUES (:recipe_id, :ingredient_id, :quantity)";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
        $stmt->bindParam(':ingredient_id', $ingredient_id, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_STR);

        $stmt->execute();
    }

    public function getQuantityFromIngredientId($recipe_id, $ingredient_id) {
        $query = "SELECT quantity FROM " . $this->table_name . " WHERE recipe_id = :recipe_id AND ingredient_id = :ingredient_id";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
        $stmt->bindParam(':ingredient_id', $ingredient_id, PDO::PARAM_INT);
        
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $result[0]['quantity'];
    }

    public function getRecipeIngredient($recipe_id, $ingredient_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE recipe_id = :recipe_id AND ingredient_id = :ingredient_id";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
        $stmt->bindParam(':ingredient_id', $ingredient_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        if ($result) {
            return new RecipeIngredient($result['recipe_id'], $result['ingredient_id'], $result['quantity']);
        } else {
            return false;
        }
    }

    public function getAllIngredientFromRecipe($recipe_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE recipe_id = :recipe_id";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        $recipeIngredients = [];
        foreach ($results as $result) {
            $recipeIngredients[] = new RecipeIngredient($result['recipe_id'], $result['ingredient_id'], $result['quantity']);
        }
        return $recipeIngredients;
    }

    public function updateRecipeIngredient($recipe_id, $ingredient_id, $quantity) {
        $query = "UPDATE " . $this->table_name . " SET quantity = :quantity WHERE recipe_id = :recipe_id AND ingredient_id = :ingredient_id";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_STR);
        $stmt->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
        $stmt->bindParam(':ingredient_id', $ingredient_id, PDO::PARAM_INT);

        $stmt->execute();
        $stmt->closeCursor();
    }

    public function deleteRecipeIngredient($recipe_id, $ingredient_id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE recipe_id = :recipe_id AND ingredient_id = :ingredient_id";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
        $stmt->bindParam(':ingredient_id', $ingredient_id, PDO::PARAM_INT);

        $stmt->execute();
        $stmt->closeCursor();
    }

    public function addIngredientToRecipe($recipe_id, $ingredientId, $amount) {
        $recipeIngredient = $this->getRecipeIngredient($recipe_id, $ingredientId);
        if ($recipeIngredient) {
            $this->updateRecipeIngredient($recipe_id, $ingredientId, $amount);
        } else {
            $this->createRecipeIngredient($recipe_id, $ingredientId, $amount);
        }
    }
}