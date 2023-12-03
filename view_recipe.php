<!DOCTYPE html>
<html>
<head>
    <title>View Recipe</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
    <?php 
    require_once("./inc/classes/Recipe.php");
    require_once("inc/classes/RecipeManager.php");

    require_once("./inc/classes/RecipeIngredient.php");
    require_once("inc/classes/RecipeIngredientManager.php");

    require_once './inc/connect_db.php';
        $recipeManager = new RecipeManager($pdo);
        $recipeIngredientManager = new RecipeIngredientManager($pdo);
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
        $recipe = $recipeManager->getRecipe($id);
        $ingredients = $recipeIngredientManager->getAllIngredientFromRecipe($id);
    ?>

    <div class="recipe">
        <h2 class="recipe-title"><?php echo $recipe->getTitle(); ?></h2>
        <img src="<?php echo $recipe->getImage(); ?>" class="recipe-image" />
        
        <div class="recipe-details">
            <p class="recipe-creator">By: <?php echo $recipe->getCreatorName(); ?></p>
            <p class="recipe-instructions"><?php echo $recipe->getInstructions(); ?></p>

            <h3 class="recipe-ingredients">Ingredients</h3>
            <?php foreach($ingredients as $ingredient) : ?>
                <div>
                    <a class="recipe-ingredient"><?php echo $recipeIngredientManager->getNameFromIngredientId($ingredient->getIngredientId()); ?></a>
                    <a class="quantity-ingredient"><?php echo $recipeIngredientManager->getQuantityFromIngredientId($id, $ingredient->getIngredientId()); ?></a>
                </div>
            <?php endforeach; ?>
        </div>

        <a href="edit_recipe.php?id=<?php echo $recipe->getRecipeId(); ?>" class="edit-link">Edit recipe</a>
        <a href="index.php" class="home-link">Return to Home</a>
    </div>
</body>
</html>