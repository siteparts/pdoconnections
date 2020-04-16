<?php

declare(strict_types=1);

namespace SiteParts\Database\Pdo;

use Psr\Container\ContainerInterface;

class ConnectionsFactory
{
	public function __invoke(ContainerInterface $container) : Connections
	{
		$config = $container->get('config');

		return new Connections($config['db']);
	}
}
