<?php
declare(strict_types=1);

namespace Developion\CodingStandards\Fixer;

use Developion\CodingStandards\Traits\FixerName;
use PhpCsFixer\AbstractFixer;
use PhpCsFixer\Fixer\WhitespacesAwareFixerInterface;
use PhpCsFixer\Tokenizer\Tokens;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use SplFileInfo;

final class BlankLineAfterStrictTypesFixer extends AbstractFixer implements WhitespacesAwareFixerInterface
{
	use StrictTypesFixer;
	use FixerName;

	public function getDefinition(): FixerDefinition
	{
		return new FixerDefinition(
			'Ensure there is an empty line after the "declare (strict_types=1);" statement.',
			[]
		);
	}

	protected function applyFix(SplFileInfo $file, Tokens $tokens): void
	{
		$sequenceLocation = $tokens->findSequence($this->declareStrictTypeTokens);
		if ($sequenceLocation === null) {
			return;
		}
		\end($sequenceLocation);
		$semicolonPosition = \key($sequenceLocation);
		if (!isset($tokens[$semicolonPosition + 2])) {
			return;
		}
		$lineEnding = $this->whitespacesConfig->getLineEnding();
		$tokens->ensureWhitespaceAtIndex($semicolonPosition + 1, 0, $lineEnding . $lineEnding);
	}
}