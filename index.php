<?php
require_once("./inc/classes/Ingredient.php");
require_once("./inc/classes/IngredientManager.php");

require_once("./inc/classes/Recipe.php");
require_once("inc/classes/RecipeManager.php");

require_once './inc/connect_db.php';

$recipeManager = new RecipeManager($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Fast Bad Cuisine</title>
</head>
<body>
    <header>
        <img src="img/a6b49e47-304f-4815-8b1b-a45245dd8f44.svg" alt="logo" class="logo">
        <h1>Fast Bad Cuisine</h1>
    </header>

    <main>
        <section class="search">
            <form action="search.php" method="get">
                    <input type="search" name="search" placeholder="Search...">
                    <button type="submit">Search</button>
                </form>
        </section>

        <section class="categories">

            <h2>L'envie</h2>

            <?php $randomRecipes = $recipeManager->getRandomRecipes(3);
            foreach ($randomRecipes as $recipe) : ?>
            <a href="view_recipe.php?id=<?php echo $recipe->getRecipeId(); ?>" class="category-link">
                <div class="category" style="background-image: url('<?php echo $recipe->getImage(); ?>')">
                    <?php echo $recipe->getTitle(); ?>
                </div>
            </a>
            <?php endforeach; ?>

        </section>

        <section class="top-recipes">
            <h2>Top tiers</h2>
            <?php $bestRecipes = $recipeManager->getBestRecipes(3);
            foreach ($bestRecipes as $recipe) : ?>
                <a href="view_recipe.php?id=<?php echo $recipe->getRecipeId(); ?>" class="category-link">
                    <div class="recipe" style="background-image: url('<?php echo $recipe->getImage(); ?>')">
                        <?php echo $recipe->getTitle(); ?>
                    </div>
                </a>
            <?php endforeach; ?>
            <!-- Repeat for other recipes -->
        </section>

        <section class="fridge-recipes">
            <h2>Quel genre ?</h2>
            <a href="recipe_categorie.php?categorie=Petit-Dejeuner" class="category-link">
                <div class="recipe" style="background-image: url('img/pancakes.jpg')">
                    Petit-Dejeuner
                </div>
            </a>
            <a href="recipe_categorie.php?categorie=Repas" class="category-link">
                <div class="recipe" style="background-image: url('img/repas.jpg')">
                    Repas
                </div>
            </a>
            <a href="recipe_categorie.php?categorie=Dinner" class="category-link">
                <div class="recipe" style="background-image: url('img/dinner.jpg')">
                    Dinner
                </div>
            </a>
        </section>

        <section class="submit-recipe">
            <h2>Une recette à proposer ?</h2>
            <a href="add_recipe.php" >Propose a Recipe</a>
        </section>
    </main>
</body>
</html>