rsPluginLoaderPlugin
============

this symfony plugin lets you manage your plugins in a yaml file.

you can define different plugins for each enviroment.

Installation
------------
**Git:** [http://github.com/digitalkaoz/rsPluginLoaderPlugin][1]

**Svn:** [https://svn.github.com/digitalkaoz/rsPluginLoaderPlugin.git][2]

Usage
-----
edit your ProjectConfiguration file first:

    require_once dirname(__FILE__).'/../plugins/rsPluginLoaderPlugin/lib/rsPluginLoader.class.php';

create a *plugins.yml* file in your *config* folder:

    all:
      - sfPropelPlugin
      - sfGuardPlugin

    cli:
      - sfTaskExtraPlugin
      - sfPhpUnit2Plugin
    dev:
      - fooPlugin

define the plugins you want to load for every environment.
section *all* will be loaded everytime
section *dev* will be loaded only in sf_environment dev
section *cli* is active on console

the last step is to use the loader in your *ProjectConfiguration*:

    //instead of using
    //$this->enablePlugins(array(
    //  'sfPropelPlugin',
    //  'sfGuardPlugin'
    //  ...
    //));

    //use this:
    rsPluginLoader::load($this);

the rest is handled by the plugin loader!
Done.

  [1]: http://github.com/digitalkaoz/rsPluginLoaderPlugin "official git repository"
  [2]: https://svn.github.com/digitalkaoz/rsPluginLoaderPlugin.git "git-svn repository"


