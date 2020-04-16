# PDO connections

*Create PDO database connections when needed.*

## Installation

Via Composer:

```bash
$ composer require siteparts/pdoconnections
```

## Usage


```php
use PDO;
use SiteParts\Database\Pdo\Connections;

$dbConfig = [
	'default' => [
		'dsn' => 'mysql:dbname=foo;host=server1;charset=utf8',
		'username' => 'john',
		'password' => 'secret1',
		'attributes' => [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		],
	],
	'bar' => [
		'dsn' => 'mysql:dbname=bar;host=server2;charset=utf8',
		'username' => 'jack',
		'password' => 'secret2',
	],
];

$connections = new Connections($dbConfig);

$defaultDb = $connections->getConnection();  // $defaultDb is PDO
$barDb = $connections->getConnection("bar"); // $barDb is PDO

// Subsequent calls return already existing connection
$db = $connections->getConnection("bar"); // $db is the same as $barDb
```
