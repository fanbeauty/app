<?php

class CookController
{
    private $mealCommander;
    private $drinkCommander;

    public function addCommander(AbstractCommander $mealCommander, AbstractCommander $drinkCommander)
    {
        $this->mealCommander = $mealCommander;
        $this->drinkCommander = $drinkCommander;
    }

    public function callMeal()
    {
        $this->mealCommander->execute();
    }

    public function callDrink()
    {
        $this->drinkCommander->execute();
    }
}