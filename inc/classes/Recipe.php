<?php
class Recipe {
    private $recipe_id;
    private $title;
    private $instructions;
    private $creator_name;

    public function __construct($recipe_id, $title, $instructions, $creator_name) {
        $this->title = $title;
        $this->instructions = $instructions;
        $this->creator_name = $creator_name;
    }

    // getter
    public function getRecipeId() {
        return $this->recipe_id;
    }
    public function getTitle() {
        return $this->title;
    }
    public function getInstructions() {
        return $this->instructions;
    }
    public function getCreatorName(){
        return $this->creator_name;
    }

    // setter
    public function setRecipeId($recipe_id) {
        $this->recipe_id = $recipe_id;
    }
    public function setTitle($title) {
        $this->title = $title;
    }
    public function setInstructions($instructions) {
        $this->instructions = $instructions;
    }
    public function setCreatorName($creator_name) {
        $this->creator_name = $creator_name;
    }

}