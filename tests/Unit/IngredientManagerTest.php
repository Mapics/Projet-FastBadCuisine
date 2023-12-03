<?php
use PHPUnit\Framework\TestCase;
require_once("./inc/classes/Ingredient.php");
require_once("./inc/classes/IngredientManager.php");

class IngredientManagerTest extends TestCase {
    private $pdo;
    private $ingredientManager;

    protected function setup(): void {
        $this->pdo = new PDO("sqlite::memory:");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $this->pdo->exec("CREATE TABLE Ingredients (
                ingredient_id INTEGER PRIMARY KEY AUTOINCREMENT,
                name VARCHAR(255) NOT NULL
            )");
        $this->ingredientManager = new IngredientManager($this->pdo);
    }

    public function testCreateIngredient() {
        $this->ingredientManager->createIngredient('test');
        
        $stmt = $this->pdo->query('SELECT * FROM Ingredients WHERE name = "test"');
        $ingredient = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('test', $ingredient['name']);
    }

    public function testGetIngredientById() {
        $this->ingredientManager->createIngredient('lait');

        $ingredient = $this->ingredientManager->getIngredient(1);

        $this->assertInstanceOf(Ingredient::class, $ingredient);
        $this->assertEquals('lait', $ingredient->getName());
    }
    
    public function testUpdateIngredient() {
        $this->ingredientManager->createIngredient('Sugar');

        $this->ingredientManager->updateIngredient(1, 'Brown Sugar');

        $stmt = $this->pdo->query('SELECT * FROM Ingredients WHERE ingredient_id = 1');
        $ingredient = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('Brown Sugar', $ingredient['name']);
    }

    public function testDeleteIngredient() {
        $this->ingredientManager->deleteIngredient(1);

        $stmt = $this->pdo->query('SELECT * FROM Ingredients WHERE ingredient_id = 1');
        $ingredient = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$ingredient) {
            $ingredient = null;
        }
        
        $this->assertNull($ingredient);
    }

    public function testGetAllIngredients() {
        $this->ingredientManager->createIngredient('test');
        $this->ingredientManager->createIngredient('test2');
    
        $ingredients = $this->ingredientManager->getAllIngredients();
    
        $this->assertCount(2, $ingredients);
        $this->assertTrue(is_array($ingredients));
        $this->assertInstanceOf(Ingredient::class, $ingredients[0]);
        $this->assertInstanceOf(Ingredient::class, $ingredients[1]);
    }
}