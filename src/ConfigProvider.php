<?php

declare(strict_types=1);

namespace SiteParts\Database\Pdo;

class ConfigProvider
{
	public function __invoke() : array
	{
		return [
			'dependencies' => $this->getDependencies(),
		];
	}

	public function getDependencies() : array
	{
		return [
			'factories' => [
				Connections::class => ConnectionsFactory::class,
			],
		];
	}
}
