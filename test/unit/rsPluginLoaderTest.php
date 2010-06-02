<?php

require_once dirname(__FILE__).'/../bootstrap/unit.php';

class testProjectConfiguration
{
  public function enablePlugins($plugins){
    return $plugins;
  }
  
}

$t = new lime_test(4);
$cfg = sfYaml::load(dirname(__FILE__).'/../fixtures/project/config/plugins.yml');
$cliCfg = array_merge($cfg['all'],isset($cfg['cli']) ? $cfg['cli']: array());
$devCfg = array_merge($cfg['all'],isset($cfg['dev']) ? $cfg['dev']: array());
$config = new testProjectConfiguration();

$t->is(class_exists('rsPluginLoader'), true, 'plugin loader loaded');
$t->is(is_array(rsPluginloader::load($config)),true,'plugin is an array after parsing');

sfConfig::set('sf_environment',null);
$t->is(rsPluginloader::load($config), $cliCfg,' no environment set, so use "all" and "cli"');
sfConfig::set('sf_environment','dev');
$t->is(rsPluginloader::load($config), $devCfg,' dev environment set, so use "all" and "dev"');
