<?php
declare(strict_types=1);

namespace Developion\CodingStandards\Fixer;

use PhpCsFixer\Tokenizer\{
	Token,
	Tokens,
};

Trait StrictTypesFixer
{
	/**
	 * Generates: "declare(strict_types=1);"
	 *
	 * @var Token[]
	 */
	protected $declareStrictTypeTokens = [];

	public function __construct()
	{
		parent::__construct();

		$this->declareStrictTypeTokens = [
			new Token([\T_DECLARE, 'declare']),
			new Token('('),
			new Token([\T_STRING, 'strict_types']),
			new Token('='),
			new Token([\T_LNUMBER, '1']),
			new Token(')'),
			new Token(';'),
		];
	}

	public function isCandidate(Tokens $tokens): bool
	{
		return $tokens->isMonolithicPhp() && $tokens->isTokenKindFound(T_DECLARE);
	}

	public function isRisky(): bool
	{
		return false;
	}

	public function getPriority(): int
	{
		// Should run after the DeclareEqualNormalizeFixer
		return -10;
	}
}