<?php
require_once './inc/connect_db.php';
require_once("./inc/classes/Ingredient.php");
require_once("./inc/classes/IngredientManager.php");



$ingredientManager = new IngredientManager($pdo);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Add Recipe</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
    <div class="add-recipe">
        <h2>Add New Recipe</h2>
        <form action="inc/submit_recipe.php" method="post" class="add-recipe-form">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="creator_name">Name of Creator:</label>
            <input type="text" id="creator_name" name="creator_name">

            <label for="instructions">Instructions:</label>
            <textarea id="instructions" name="instructions" required></textarea>

            <label for="image_url">Image URL:</label>
            <input type="text" id="image_url" name="image_url">

            <label for="categorie">Category:</label>
            <select id="categorie" name="categorie">
                <option value="Petit-Dejeuner">Petit-Dejeuner</option>
                <option value="Repas">Repas</option>
                <option value="Dinner">Dinner</option>
                <!-- Ajoute d'autres catégories au besoin -->
            </select>
            
            <label for="ingredients">Ingredients:</label>
            <?php 
            $ingredients = $ingredientManager->getAllIngredients();
            foreach($ingredients as $ingredient) : ?>
                <div>
                    <input type="checkbox" id="ingredient<?php echo $ingredient->getIngredientId(); ?>" name="ingredients[]" value="<?php echo $ingredient->getIngredientId(); ?>">
                    <label for="ingredient<?php echo $ingredient->getIngredientId(); ?>"><?php echo $ingredient->getName(); ?></label>
                    <input type="text" id="amount<?php echo $ingredient->getIngredientId(); ?>" name="amounts[]">
                    <label for="amount<?php echo $ingredient->getIngredientId(); ?>">Quantity</label>
                </div>
            <?php endforeach; ?>
                
            <button type="submit" class="submit-btn">Add Recipe</button>
        </form>
    </div>
</body>
</html>