<?php

require_once dirname(__FILE__).'/../bootstrap/unit.php';
require_once $_SERVER['SYMFONY'].'/vendor/lime/lime.php';

class testProjectConfiguration
{
  public function enablePlugins($plugins){
    return $plugins;
  }
  
}

$t = new lime_test(1);

$config = new testProjectConfiguration();

$t->is(class_exists('rsPluginLoader'), true, 'plugin loader loaded');
