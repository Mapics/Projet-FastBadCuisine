<?php
require_once("connect_db.php");

require_once("classes/Recipe.php");
require_once("classes/RecipeManager.php");

require_once("classes/Ingredient.php");
require_once("classes/IngredientManager.php");

require_once("classes/RecipeIngredient.php");
require_once("classes/RecipeIngredientManager.php");

$recipeIngredientManager = new RecipeIngredientManager($pdo);
$recipeManager = new RecipeManager($pdo);

// Vérifiez que le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'] ?? '';
    $creator_name = $_POST['creator_name'] ?? '';
    $instructions = $_POST['instructions'] ?? '';
    $image_url = $_POST['image_url'] ?? '';
    $categorie = $_POST['categorie'] ?? '';
    $recipe_id= $_POST['recipe_id'] ?? '';
    $amounts = $_POST['amounts'] ?? [];
    
    $recipeManager->updateRecipe($recipe_id, $title, $instructions, $creator_name, $image_url, $categorie);

    
    $ingredientIds = $_POST['ingredients'] ?? [];
    $amounts = $_POST['amounts'] ?? [];

    for ($i = 0; $i < count($ingredientIds); $i++) {
        $ingredientId = $ingredientIds[$i];
        $amount = isset($amounts[$ingredientId]) ? $amounts[$ingredientId] : null; 

        if (!is_null($amount)) {
            $recipeIngredientManager->addIngredientToRecipe($recipe_id, $ingredientId, $amount);
        }
        $recipeIngredientManager->updateRecipeIngredient($recipe_id, $ingredientId, $amount);
    }
    
    // Redirige vers la page d'accueil après l'ajout de la recette
    header("Location: ../view_recipe.php?id=$recipe_id");
} else {
    // Si le formulaire n'a pas été soumis, redirigez vers la page d'ajout de recette
    header("Location: add_recipe.php");
}