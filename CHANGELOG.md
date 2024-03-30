### 1.1.3
Fixed sort order for OrderedImportsFixer
Removed `GroupImportFixer`, added modified version as `SingleImportPerLineInGroupImportFixer`

### 1.1.2
Added multiple affirmative and negating fixers to the default sets.\
The current set is based on `PSR12` standard with following differences:
#### Negating fixers
- BlankLineAfterOpeningTagFixer
- SingleImportPerStatementFixer
#### Affirmative fixers
- BlankLineAfterNamespaceFixer
- BlankLineBetweenImportGroupsFixer
- DeclareStrictTypesFixer
- GroupImportFixer
- IndentationTypeFixer
- LinebreakAfterOpeningTagFixer
- MethodChainingIndentationFixer
- ModernizeStrposFixer
- NoExtraBlankLinesFixer, configured for tokens `extra` and `use`
- NoUnusedImportsFixer
- NumericLiteralSeparatorFixer
- OrderedImportsFixer
- ReturnTypeDeclarationFixer
- SingleLineAfterImportsFixer
- StatementIndentationFixer
- TernaryOperatorSpacesFixer
- TrailingCommaInMultilineFixer
- VisibilityRequiredFixer
#### ~~Custom negating fixers~~
#### Custom affirmative fixers
- BlankLineAfterStrictTypesFixer
- NoEmptyLineBeforeDeclareStrictTypesFixer