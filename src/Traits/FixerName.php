<?php

namespace Developion\CodingStandards\Traits;

use Developion\CodingStandards\Util;

trait FixerName
{
	public static function name(): string
	{
		return 'Developion/' . Util::getName(__CLASS__);
	}

	public function getName(): string
	{
		return static::name();
	}
}
