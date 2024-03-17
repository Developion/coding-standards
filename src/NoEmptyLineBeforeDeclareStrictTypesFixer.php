<?php
declare(strict_types=1);

namespace Developion\CodingStandards\Fixer;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\Fixer\WhitespacesAwareFixerInterface;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\Tokenizer\CT;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;

final class NoEmptyLineBeforeDeclareStrictTypesFixer extends AbstractFixer implements WhitespacesAwareFixerInterface
{
	use StrictTypesFixer;

	public function getDefinition(): FixerDefinition
	{
		return new FixerDefinition(
			'Ensure there is no empty line between the opening PHP tag and the strict_types declaration.',
			[]
		);
	}

	protected function applyFix(\SplFileInfo $file, Tokens $tokens): void
	{
		$openTagIndex = 0;
		$sequenceLocation = $tokens->findSequence($this->declareStrictTypeTokens, $openTagIndex, null, \false);
		if ($sequenceLocation && array_keys($sequenceLocation)[0] - $openTagIndex < 2) {
			return;
		}
		$tokens->removeTrailingWhitespace($openTagIndex);
	}
}
