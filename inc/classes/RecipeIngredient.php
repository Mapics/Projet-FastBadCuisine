<?php
class RecipeIngredient {
    private $recipe_id;
    private $ingredient_id;
    private $quantity;

    public function __construct($recipe_id, $ingredient_id, $quantity) {
        $this->recipe_id = $recipe_id;
        $this->ingredient_id = $ingredient_id;
        $this->quantity = $quantity;
    }

    // getter
    public function getRecipeId() {
        return $this->recipe_id;
    }
    public function getIngredientId() {
        return $this->ingredient_id;
    }
    public function getQuantity() {
        return $this->quantity;
    }

    // setter
    public function setRecipeId($recipe_id) {
        $this->recipe_id = $recipe_id;
    }
    public function setIngredientId($ingredient_id) {
        $this->ingredient_id = $ingredient_id;
    }
    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }
}