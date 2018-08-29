<?php

class MealCommander extends AbstractCommander
{
    private $cook;

    public function __construct(AbstractReceiver $cook)
    {
        $this->cook = $cook;
    }

    public function execute()
    {
        $this->cook->meal();
    }
}