<?php
namespace AscentCreative\Offer\Registries;

class Discountables {

    public $registry = [];

    public function __construct() {
        // dump("created registry");
    }

    public function register($class) {
        // dump("register " . $class);
        $this->registry[] = $class;
        // dump($this->registry);
    }   

    public function getRegistry() {
        return $this->registry;
    }

}