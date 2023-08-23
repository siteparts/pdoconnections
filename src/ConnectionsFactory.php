<?php

declare(strict_types=1);

namespace SiteParts\Database\Pdo;

use Psr\Container\ContainerInterface;

class ConnectionsFactory
{
	public function __invoke(ContainerInterface $container) : Connections
	{
		/**
		 * @var array{
		 *     db?: array<string, array{
		 *         dsn?: string,
		 *         username?: string,
		 *         password?: string,
		 *         options?: mixed[],
		 *         attributes?: array<int, mixed>,
		 *     }>,
		 * } $config
		 */
		$config = $container->get('config');
		$dbConfig = $config['db'] ?? [];

		return new Connections($dbConfig);
	}
}
