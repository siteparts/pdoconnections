<?php

declare(strict_types=1);

namespace SiteParts\Database\Pdo;

class ConfigProvider
{
	/**
	 * @return array{
	 *     dependencies: array{
	 *         factories: array<string, string>,
	 *     },
	 * }
	 */
	public function __invoke() : array
	{
		return [
			'dependencies' => $this->getDependencies(),
		];
	}

	/**
	 * @return array{
	 *     factories: array<string, string>,
	 * }
	 */
	public function getDependencies() : array
	{
		return [
			'factories' => [
				Connections::class => ConnectionsFactory::class,
			],
		];
	}
}
