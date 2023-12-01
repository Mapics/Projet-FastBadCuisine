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
                instructions TEXT NOT NULL
            )");
        $this->recipeManager = new RecipeManager($this->pdo);
    }

    public function testCreateRecipe() {
        $this->recipeManager->createRecipe('Delicious Pancakes', 'Mix ingredients and cook them', 'John Doe');
        
        $stmt = $this->pdo->query('SELECT * FROM Recipes WHERE title = "Delicious Pancakes"');
        $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('Delicious Pancakes', $recipe['title']);
        $this->assertEquals('John Doe', $recipe['creator_name']);
    }

    public function testGetRecipeById() {
        $this->recipeManager->createRecipe('Delicious Pancakes', 'Mix ingredients and cook them', 'John Doe');

        $recipe = $this->recipeManager->getRecipe(1);

        $this->assertInstanceOf(Recipe::class, $recipe);
        $this->assertEquals('Delicious Pancakes', $recipe->getTitle());
    }
    
    public function testUpdateRecipe() {
        $this->recipeManager->createRecipe('Delicious Pancakes', 'Mix ingredients and cook them', 'John Doe');

        $this->recipeManager->updateRecipe(1, 'Even More Delicious Pancakes', 'Mix ingredients, add chocolate and cook them', 'John Doe');

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
}