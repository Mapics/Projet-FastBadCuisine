<?php
    require_once("./inc/classes/Recipe.php");
    require_once("inc/classes/RecipeManager.php");
    require_once './inc/connect_db.php';

    $recipeManager = new RecipeManager($pdo);

    $id = isset($_GET['categorie']) ? $_GET['categorie'] : die('ERROR: missing ID.');
    // Get the recipe from the database using its id
    // $recipe = $recipeManager->getRecipe($id);
    
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Recipe</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
    <?php $categorieRecipes = $recipeManager->getRecipesByCategorie($_GET['categorie']);
    foreach ($categorieRecipes as $recipe) : ?>
    <a href="view_recipe.php?id=<?php echo $recipe->getRecipeId(); ?>" class="category-link">
        <div class="recipe" style="background-image: url('<?php echo $recipe->getImage(); ?>')">
            <?php echo $recipe->getTitle(); ?>
        </div>
    </a>
    <?php endforeach; ?>
</body>