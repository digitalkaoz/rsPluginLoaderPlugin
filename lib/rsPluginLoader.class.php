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
    $plugins = self::getConfiguration();

    $env = sfConfig::get('sf_environment','cli');

    $pluginsAll = isset($plugins['all']) ? $plugins['all'] : array();
    $pluginsEnv = isset($plugins[$env]) ? $plugins[$env] : array();

    return $config->enablePlugins(array_merge($pluginsAll,$pluginsEnv));
  }

  /**
   * reads the plugins configuration either from cache or creates a cache
   * @return <type>
   */
  protected static function getConfiguration()
  {
    $cacheFile = sfConfig::get('sf_cache_dir').'/plugins.cache';
    $yamlFile = sfConfig::get('sf_config_dir').'/plugins.yml';

    if(file_exists($cacheFile))
    {
      return unserialize(file_get_contents($cacheFile));
    }
    else
    {
      if(!file_exists($yamlFile))
      {
        throw new Exception('no plugins.yml found in config dir!');
      }

      $plugins = sfYaml::load($yamlFile);

      $handle = fopen($cacheFile, 'w');
      fwrite($handle, serialize($plugins));
      fclose($handle);

      return $plugins;
    }
  }
}