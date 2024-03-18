<?php
declare(strict_types=1);

namespace Developion\CodingStandards;

use PhpCsFixer\Utils;

class Util
{
	public static function getName(string $className): string
	{
		$nameParts = explode('\\', $className);
		$name = substr(end($nameParts), 0, -\strlen('Fixer'));

		return Utils::camelCaseToUnderscore($name);
	}
}
