<?php

class action
{
    public static function run()
    {
        $cooker = new Cook();
        $mealCommander = new MealCommander($cooker);
        $drinkCommander = new DrinkCommander($cooker);
        $invoker = new CookController();
        $invoker->addCommander($mealCommander, $drinkCommander);
        $invoker->callDrink();
        $invoker->callMeal();
    }
}

action::run();