<?php
class Recipe {
    private $recipe_id;
    private $title;
    private $instructions;
    private $creator_name;
    private $image;
    private $likes;
    private $categorie;

    public function __construct($recipe_id, $title, $instructions, $creator_name, $image, $likes, $categorie) {
        $this->recipe_id = $recipe_id;
        $this->title = $title;
        $this->instructions = $instructions;
        $this->creator_name = $creator_name;
        $this->image = $image;
        $this->likes = $likes;
        $this->categorie = $categorie;
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
    public function getCreatorName() {
        return $this->creator_name;
    }
    public function getImage() {
        return $this->image;
    }
    public function getLikes(){
        return $this->likes;
    }
    public function getCategorie(){
        return $this->categorie;
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
    public function setImage($image) {
        $this->image = $image;
    }
    public function setLikes($likes){
        $this->likes = $likes;
    }
    public function setCategorie($categorie){
        $this->categorie = $categorie;
    }
}