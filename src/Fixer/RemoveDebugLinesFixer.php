<?php
declare(strict_types=1);

namespace Developion\CodingStandards\Fixer;

use Developion\CodingStandards\Traits\FixerName;
use PhpCsFixer\AbstractFunctionReferenceFixer;
use PhpCsFixer\FixerDefinition\{
	CodeSample,
	FixerDefinition,
};
use PhpCsFixer\Tokenizer\Tokens;

final class RemoveDebugLinesFixer extends AbstractFunctionReferenceFixer
{
	use FixerName;

	private $functions = array('dump', 'var_dump', 'dd');

	public function isCandidate(Tokens $tokens): bool
	{
		return $tokens->isTokenKindFound(T_STRING);
	}

	public function getDefinition(): FixerDefinition
	{
		return new FixerDefinition(
			'Removes dump/var_dump statements, which shouldn\'t be in production ever.',
			array(new CodeSample("<?php\nvar_dump(false);"))
		);
	}

	protected function applyFix(\SplFileInfo $file, Tokens $tokens): void
	{
		foreach ($this->functions as $function) {
			$currIndex = 0;
			while (null !== $currIndex) {
				$matches = $this->find($function, $tokens, $currIndex);

				if (null === $matches) {
					break;
				}

				$funcStart = $tokens->getPrevNonWhitespace($matches[0]);

				if ($tokens[$funcStart]->isGivenKind(T_NEW) || $tokens[$funcStart]->isGivenKind(T_FUNCTION)) {
					break;
				}

				$funcEnd = $tokens->getNextTokenOfKind($matches[1], array(';'));

				$tokens->clearRange($funcStart + 1, $funcEnd);
			}
		}
	}
}