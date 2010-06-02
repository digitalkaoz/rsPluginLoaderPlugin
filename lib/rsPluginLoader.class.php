<?php

class rsPluginLoader
{
  /**
   * activates the nesserary plugins
   *
   * @param mixed $config
   */
  public static function load($config)
  {
    $file = sfConfig::get('sf_config_dir').'/plugins.yml';

    if(!file_exists($file)){
      throw new Exception('no plugins.yml found in config dir!');
    }
    
    $plugins = sfYaml::load($file);
    $env = sfConfig::get('sf_environment','cli');

    $pluginsAll = isset($plugins['all']) ?$plugins['all'] : array();
    $pluginsEnv = isset($plugins[$env]) ?$plugins[$env] : array();

    $config->enablePlugins(array_merge($pluginsAll,$pluginsEnv));
  }
}
