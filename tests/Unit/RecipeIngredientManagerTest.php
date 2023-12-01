<?php
use PHPUnit\Framework\TestCase;
require_once("./inc/classes/RecipeIngredient.php");
require_once("./inc/classes/RecipeIngredientManager.php");

class RecipeIngredientManagerTest extends TestCase {
    private $pdo;
    private $recipeIngredientManager;

    protected function setup(): void {
        $this->pdo = new PDO("sqlite::memory:");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $this->pdo->exec("CREATE TABLE RecipeIngredients (
                recipe_id INTEGER NOT NULL,
                ingredient_id INTEGER NOT NULL,
                quantity VARCHAR(50) NOT NULL
            )");
        $this->recipeIngredientManager = new RecipeIngredientManager($this->pdo);
    }

    public function testCreateRecipeIngredient() {
        $this->recipeIngredientManager->createRecipeIngredient(1, 2, '2 cups');
        
        $stmt = $this->pdo->query('SELECT * FROM RecipeIngredients WHERE recipe_id = 1 AND ingredient_id = 2');
        $recipeIngredient = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('2 cups', $recipeIngredient['quantity']);
    }

    public function testGetRecipeIngredient() {
        $this->recipeIngredientManager->createRecipeIngredient(2, 3, '3 spoons');

        $recipeIngredient = $this->recipeIngredientManager->getRecipeIngredient(2, 3);

        $this->assertInstanceOf(RecipeIngredient::class, $recipeIngredient);
        $this->assertEquals('3 spoons', $recipeIngredient->getQuantity());
    }
    
    public function testUpdateRecipeIngredient() {
        $this->recipeIngredientManager->createRecipeIngredient(3, 4, 'One pinch');

        $this->recipeIngredientManager->updateRecipeIngredient(3, 4, 'Two pinches');

        $stmt = $this->pdo->query('SELECT * FROM RecipeIngredients WHERE recipe_id = 3 AND ingredient_id = 4');
        $recipeIngredient = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('Two pinches', $recipeIngredient['quantity']);
    }

    public function testDeleteRecipeIngredient() {
        $this->recipeIngredientManager->createRecipeIngredient(4, 5, '4 cups');

        $this->recipeIngredientManager->deleteRecipeIngredient(4, 5);

        $stmt = $this->pdo->query('SELECT * FROM RecipeIngredients WHERE recipe_id = 4 AND ingredient_id = 5');
        $recipeIngredient = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$recipeIngredient) {
            $recipeIngredient = null;
        }

        $this->assertNull($recipeIngredient);
    }
}