<?php

declare(strict_types=1);

namespace SiteParts\Database\Pdo;

use PDO;
use PDOException;

class Connections
{
	/**
	 * Array of connection configuration.
	 * @var array
	 */
	private $config;

	/**
	 * Array of PDO handles.
	 * @var array
	 */
	private $handles;

	/**
	 * Use the following configuration format:
	 * [
	 *   'default' => [
	 *     'dsn' => 'mysql:dbname=foo;host=server1;charset=utf8',
	 *     'username' => 'john',
	 *     'password' => 'secret1',
	 *   ],
	 *   'bar' => [
	 *     'dsn' => 'mysql:dbname=bar;host=server2;charset=utf8',
	 *     'username' => 'jack',
	 *     'password' => 'secret2',
	 *     'options' => [ ... options for PDO ... ],
	 *     'attributes' => [
	 *       PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	 *     ],
	 *   ],
	 * ]
	 *
	 * @param array $config Configuration of database connections
	 */
	public function __construct(array $config)
	{
		$this->config = $config;
		$this->handles = [];
	}

	/**
	 * Returns PDO database connection
	 *
	 * @param string $name Connection name
	 * @return PDO
	 */
	public function getConnection(string $name = "default") : PDO
	{
		if (!isset($this->handles[$name])) {
			$this->handles[$name] = $this->connect($name);
		}

		return $this->handles[$name];
	}

	private function connect(string $name) : PDO
	{
		if (!isset($this->config[$name])) {
			throw new Exception\ConfigurationException(
				'Connection `' . $name . '` is not configured'
			);
		}

		$config = $this->config[$name];

		if (!isset($config["dsn"])) {
			throw new Exception\ConfigurationException(
				'Connection `' . $name . '` parameter `dsn` is not configured'
			);
		}

		$handle = $this->createHandle($name, $config);

		$this->setHandleAttributes(
			$name,
			$handle,
			$config["attributes"] ?? []
		);

		return $handle;
	}

	private function createHandle(string $name, array $config) : PDO
	{
		$handle = null;

		try {
			$handle = new PDO(
				$config["dsn"],
				$config["username"] ?? "",
				$config["password"] ?? "",
				$config["options"] ?? []
			);
		} catch (PDOException $e) {
			throw new Exception\ConnectionException(
				'Failed creating connection `' . $name . '`'
			);
		}

		return $handle;
	}

	private function setHandleAttributes(string $name, PDO $handle, array $attributes)
	{
		foreach ($attributes as $attribute => $value) {
			if (!$handle->setAttribute($attribute, $value)) {
				throw new Exception\ConfigurationException(
					'Failed setting connection `' . $name . '` attribute `'. $attribute . '`'
				);
			}
		}
	}
}
