<?php
require_once './inc/connect_db.php';
require_once("./inc/classes/Ingredient.php");
require_once("./inc/classes/IngredientManager.php");

require_once("./inc/classes/Recipe.php");
require_once("./inc/classes/RecipeManager.php");

require_once("./inc/classes/RecipeIngredient.php");
require_once("./inc/classes/RecipeIngredientManager.php");

$ingredientManager = new IngredientManager($pdo);
$recipeManager = new RecipeManager($pdo);
$recipeIngredientManager = new RecipeIngredientManager($pdo);

$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
$recipeIngredients = $recipeIngredientManager->getAllIngredientFromRecipe($id);
$recipe = $recipeManager->getRecipe($id);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Edit Recipe</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
    <div class="edit-recipe">
        <h2>Edit Recipe</h2>
        <form action="inc/update_recipe.php" method="post" class="add-recipe-form">
            <input type="hidden" id="recipe_id" name="recipe_id" value="<?php echo $id; ?>">

            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo $recipe->getTitle(); ?>" required>

            <label for="creator_name">Name of Creator:</label>
            <input type="text" id="creator_name" name="creator_name" value="<?php echo $recipe->getCreatorName(); ?>">

            <label for="instructions">Instructions:</label>
            <textarea id="instructions" name="instructions" ><?php echo $recipe->getInstructions(); ?></textarea>

            <label for="image_url">Image URL:</label>
            <input type="text" id="image_url" name="image_url" value="<?php echo $recipe->getImage(); ?>">

            <label for="categorie">Category:</label>
            <select id="categorie" name="categorie">
                <option value="Petit-Dejeuner">Petit-Dejeuner</option>
                <option value="Repas">Repas</option>
                <option value="Dinner">Dinner</option>
                <!-- Ajoute d'autres catégories au besoin -->
            </select>
            
            <label for="ingredients">Ingredients:</label>
            <?php $ingredients = $ingredientManager->getAllIngredients();
            foreach($ingredients as $ingredient) {
                $isChecked = false;
                $quantity = '';
                    
                foreach($recipeIngredients as $recipeIngredient) {
                    if ($recipeIngredient->getIngredientId() == $ingredient->getIngredientId()) {
                        $isChecked = true;
                        $quantity = $recipeIngredient->getQuantity();
                        break;
                    }
                }
                echo '<div>';
                echo '<input type="checkbox" id="ingredient' . $ingredient->getIngredientId() . '" name="ingredients[]" value="' . $ingredient->getIngredientId() . '"' . ($isChecked ? ' checked' : '') . '>';
                echo '<label for="ingredient' . $ingredient->getIngredientId() . '"> ' . $ingredient->getName() . '</label>';
                echo '<input type="text" id="amount' . $ingredient->getIngredientId() . '" name="amounts[' . $ingredient->getIngredientId() . ']" value="' . $quantity . '">';
                echo '<label for="amount' . $ingredient->getIngredientId() . '">Quantity</label>';
                echo '</div>';
            } ?>
                
            <button type="submit" class="submit-btn">Update Recipe</button>
        </form>
    </div>
</body>
</html>