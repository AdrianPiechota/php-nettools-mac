<!doctype html>
<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<title>Ponury\NetTools\Mac</title>
		<style>
			body {
				width: 50%;
				min-width: 640px;
				margin: 1em auto;
			}
		</style>
	</head>
	<body>

		<h1>AdrianPiechota\NetTools\Mac</h1>
		<pre>
<?PHP

use AdrianPiechota\NetTools\Mac;

require_once(realpath('../src/AdrianPiechota/NetTools/Mac.php'));

$mac = new Mac('01-23-45-67-89-ab');

echo PHP_EOL;
echo 'HEX: ' . $mac . PHP_EOL;
echo 'HEX: ' . $mac->toString('-') . PHP_EOL;
echo 'DOT: ' . $mac->toDotFormat() . PHP_EOL;
echo 'BIN: ' . $mac->toBin() . PHP_EOL;
echo 'DEC: ' . $mac->toDec() . PHP_EOL;

echo 'is Multicast: ' . ($mac->isMulticast() ? 'true' : 'false') . PHP_EOL;
echo 'is Locally Administrated: ' . ($mac->isLocallyAdministrated() ? 'true' : 'false') . PHP_EOL;

echo 'TYPE: EUI-' . $mac->getType(). PHP_EOL;

?>
		</pre>
	</body>
</html>