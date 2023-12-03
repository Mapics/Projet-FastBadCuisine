<?php

class Ingredient  {
    private $ingredient_id;
    private $name;
    private $image;

    public function __construct($ingredient_id, $name, $image) {
        $this->ingredient_id = $ingredient_id;
        $this->name = $name;
        $this->image = $image;
    }

    // getter
    public function getIngredientId() {
        return $this->ingredient_id;
    }
    public function getName() {
        return $this->name;
    }

    // setter
    public function setIngredientId($ingredient_id) {
        $this->ingredient_id = $ingredient_id;
    }
    public function setName($name) {
        $this->name = $name;
    }
}