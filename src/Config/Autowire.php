<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Arknet\LineReracer\Trait\Registrator\Catalog;

return static function (ContainerConfigurator $container): void {
	(new class { use Catalog; })->setup($container);
};