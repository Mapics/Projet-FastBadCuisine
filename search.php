<?php
require_once './inc/connect_db.php';
require_once("./inc/classes/Recipe.php");
require_once("inc/classes/RecipeManager.php");

$recipeManager = new RecipeManager($pdo);

$search = isset($_GET['search']) ? $_GET['search'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Fast Bad Cuisine - Results for "<?php echo $search; ?>"</title>
</head>
<body>
    <header>
        <a href="index.php">Return Home</a>
        <img src="img/a6b49e47-304f-4815-8b1b-a45245dd8f44.svg" alt="logo" class="logo">
        <h1>Fast Bad Cuisine</h1>
    </header>

    <main>
        <section class="search">
            <form action="search.php" method="get">
                <input type="search" name="search" value="<?php echo $search; ?>" placeholder="Search...">
                <button type="submit">Search</button>
            </form>
        </section>

        <section class="search-results">
            <h2>Search Results for "<?php echo $search; ?>"</h2>

            <?php 
            $searchResults = $recipeManager->searchRecipes($search);
            foreach ($searchResults as $recipe) : ?>
                <a href="view_recipe.php?id=<?php echo $recipe->getRecipeId(); ?>" class="category-link">
                    <div class="category" style="background-image: url('<?php echo $recipe->getImage(); ?>')">
                        <?php echo $recipe->getTitle(); ?>
                    </div>
                </a>
            <?php endforeach; ?>

        </section>

    </main>
</body>
</html>