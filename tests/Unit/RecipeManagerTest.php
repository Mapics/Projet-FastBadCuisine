<?php
use PHPUnit\Framework\TestCase;
require_once("./inc/classes/Recipe.php");
require_once("./inc/classes/RecipeManager.php");

class RecipeManagerTest extends TestCase {
    private $pdo;
    private $recipeManager;

    protected function setup(): void {
        $this->pdo = new PDO("sqlite::memory:");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec("CREATE TABLE Recipes (
                recipe_id INTEGER PRIMARY KEY AUTOINCREMENT,
                title VARCHAR(255) NOT NULL,
                creator_name VARCHAR(100),
                instructions TEXT NOT NULL,
                image VARCHAR(255), 
                categorie VARCHAR(50)
            )");
        $this->recipeManager = new RecipeManager($this->pdo);
    }

    public function testCreateRecipe() {
        $this->recipeManager->createRecipe('Delicious Pancakes', 'Mix ingredients and cook them', 'John Doe', 'url', 'image');
        
        $stmt = $this->pdo->query('SELECT * FROM Recipes WHERE title = "Delicious Pancakes"');
        $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('Delicious Pancakes', $recipe['title']);
        $this->assertEquals('John Doe', $recipe['creator_name']);
        $this->assertEquals('Mix ingredients and cook them', $recipe['instructions']);
    }

    public function testGetRecipeById() {
        $this->recipeManager->createRecipe('Delicious Pancakes', 'Mix ingredients and cook them', 'John Doe', 'url', 'image');

        $recipe = $this->recipeManager->getRecipe(1);

        $this->assertInstanceOf(Recipe::class, $recipe);
        $this->assertEquals('Delicious Pancakes', $recipe->getTitle());
    }
    
    public function testUpdateRecipe() {
        $this->recipeManager->createRecipe('Delicious Pancakes', 'Mix ingredients and cook them', 'John Doe', 'url', 'image');

        $this->recipeManager->updateRecipe(1, 'Even More Delicious Pancakes', 'Mix ingredients, add chocolate and cook them', 'John Doe', 'url', 'categ');

        $stmt = $this->pdo->query('SELECT * FROM Recipes WHERE recipe_id = 1');
        $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('Even More Delicious Pancakes', $recipe['title']);
        $this->assertEquals('Mix ingredients, add chocolate and cook them', $recipe['instructions']);
    }

    public function testDeleteRecipe() {
        $this->recipeManager->deleteRecipe(1);

        $stmt = $this->pdo->query('SELECT * FROM Recipes WHERE recipe_id = 1');
        $recipe = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$recipe) {
            $recipe = null;
        }

        $this->assertNull($recipe);
    }

    public function testGetRandomRecipes() {
        // Insert some recipes first
        $this->recipeManager->createRecipe('Delicious Pancakes', 'Mix ingredients and cook them', 'John Doe', 'url', 'Repas');
        $this->recipeManager->createRecipe('Tasty Omelette', 'Mix ingredients and cook them', 'Jane Doe', 'url', 'Repas');
    
        $recipes = $this->recipeManager->getRandomRecipes(1);
    
        $this->assertCount(1, $recipes);
        $this->assertTrue(is_array($recipes));
        $this->assertInstanceOf(Recipe::class, $recipes[0]);
    }
    
    public function testGetBestRecipes() {
        $this->recipeManager->createRecipe('Delicious Pancakes', 'Mix ingredients and cook them', 'John Doe', 'url', 'Repas');
    
        $recipes = $this->recipeManager->getBestRecipes(1);
    
        $this->assertCount(1, $recipes);
        $this->assertTrue(is_array($recipes));
        $this->assertInstanceOf(Recipe::class, $recipes[0]);
    }
    
    public function testGetRecipesByCategorie() {
        $this->recipeManager->createRecipe('Delicious Pancakes', 'Mix ingredients and cook them', 'John Doe', 'url', 'Repas');

        $recipes = $this->recipeManager->getRecipesByCategorie('Breakfast');
    
        $this->assertTrue(is_array($recipes));
        $this->assertInstanceOf(Recipe::class, $recipes[0]);
        $this->assertEquals('Repas', $recipes[0]->getCategorie());
    }
    
    public function testSearchRecipes() {
        // Insert some recipes first.
        // Make sure you insert some recipes with a name that contain 'Egg'.
        $this->recipeManager->createRecipe('Delicious Pancakes', 'Mix ingredients and cook them', 'John Doe', 'url', 'Repas');
    
        $recipes = $this->recipeManager->searchRecipes('Delicious Pancakes');
    
        $this->assertTrue(is_array($recipes));
        $this->assertInstanceOf(Recipe::class, $recipes[0]);
        $this->assertStringContainsString('Delicious Pancakes', $recipes[0]->getTitle());
    }
}