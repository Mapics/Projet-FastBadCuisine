<?php
use PHPUnit\Framework\TestCase;
require_once("./inc/classes/RecipeIngredient.php");
require_once("./inc/classes/RecipeIngredientManager.php");

require_once("./inc/classes/Ingredient.php");
require_once("./inc/classes/IngredientManager.php");

class RecipeIngredientManagerTest extends TestCase {
    private $pdo;
    private $recipeIngredientManager;
    private $ingredientManager;

    protected function setup(): void {
        $this->pdo = new PDO("sqlite::memory:");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $this->pdo->exec("CREATE TABLE RecipeIngredients (
                recipe_id INTEGER NOT NULL,
                ingredient_id INTEGER NOT NULL,
                quantity VARCHAR(50) NOT NULL
            )");
        $this->recipeIngredientManager = new RecipeIngredientManager($this->pdo);
        $this->ingredientManager = new IngredientManager($this->pdo);
    }

    public function testCreateRecipeIngredient() {
        $this->recipeIngredientManager->createRecipeIngredient(1, 2, '2 tasses');
        
        $stmt = $this->pdo->query('SELECT * FROM RecipeIngredients WHERE recipe_id = 1 AND ingredient_id = 2');
        $recipeIngredient = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('2 tasses', $recipeIngredient['quantity']);
    }

    public function testGetRecipeIngredient() {
        $this->recipeIngredientManager->createRecipeIngredient(2, 3, '3 cas');

        $recipeIngredient = $this->recipeIngredientManager->getRecipeIngredient(2, 3);

        $this->assertInstanceOf(RecipeIngredient::class, $recipeIngredient);
        $this->assertEquals('3 cas', $recipeIngredient->getQuantity());
    }
    
    public function testUpdateRecipeIngredient() {
        $this->recipeIngredientManager->createRecipeIngredient(3, 4, 'une pince');

        $this->recipeIngredientManager->updateRecipeIngredient(3, 4, 'deux pince');

        $stmt = $this->pdo->query('SELECT * FROM RecipeIngredients WHERE recipe_id = 3 AND ingredient_id = 4');
        $recipeIngredient = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('deux pince', $recipeIngredient['quantity']);
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