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
        $this->ingredientManager->createIngredient('Eggs');
        
        $stmt = $this->pdo->query('SELECT * FROM Ingredients WHERE name = "Eggs"');
        $ingredient = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('Eggs', $ingredient['name']);
    }

    public function testGetIngredientById() {
        $this->ingredientManager->createIngredient('Milk');

        $ingredient = $this->ingredientManager->getIngredient(1);

        $this->assertInstanceOf(Ingredient::class, $ingredient);
        $this->assertEquals('Milk', $ingredient->getName());
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
}