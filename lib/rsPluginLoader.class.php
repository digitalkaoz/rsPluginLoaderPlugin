<?php

class rsPluginLoader
{
  /**
   * activates the nesserary plugins
   *
   * @param sfProjectConfiguration $config
   */
  public static function load(sfProjectConfiguration $config)
  {
    $plugins = self::getConfiguration();

    $config->getEventDispatcher()->connect('task.cache.clear', array('rsPluginLoader','rebuildCacheFile'));

    $env = sfConfig::get('sf_environment','cli');

    $pluginsAll = isset($plugins['all']) ? $plugins['all'] : array();
    $pluginsEnv = isset($plugins[$env]) ? $plugins[$env] : array();

    return $config->enablePlugins(array_merge($pluginsAll,$pluginsEnv));
  }

  /**
   * reads the plugins configuration either from cache or creates a cache
   * @return array
   */
  protected static function getConfiguration()
  {
    $cacheFile = sfConfig::get('sf_cache_dir').'/plugins.cache';
    $yamlFile = sfConfig::get('sf_config_dir').'/plugins.yml';

    if(is_readable($cacheFile))
    {
      return unserialize(file_get_contents($cacheFile));
    }
    else
    {
      if(!file_exists($yamlFile))
      {
        throw new FileNotFoundException('no plugins.yml found in config dir!');
      }

      $plugins = sfYaml::load($yamlFile);

      file_put_contents($cacheFile, serialize($plugins));

      return $plugins;
    }
  }

  /**
   * rebuilds the cache file (if the cache was cleared by a task)
   *
   * @param sfEvent $event
   */
  public static function rebuildCacheFile(sfEvent $event)
  {
    self::getConfiguration();
  }
}