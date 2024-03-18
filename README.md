# PHP Coding Standards in Developion / ContentReactor projects
Based on PSR12, a few targeted tweaks and fixers are aimed to general consistency of the code.
## Installation
```console
composer require --dev developion/coding-standards
```

### ECS
Add `${ecs.php}` to the root of your project, and set the content to:

```php
use Developion\CodingStandards\SetList;

$config = require SetList::DEVELOPION;

return $config->withPaths([
		__DIR__ . '<PATH>',
		__FILE__,
	]);
```
The line `__DIR__ . '<PATH>'` deserves special attention, as it needs to be configured to point to the code of the project that needs to be checked. If necessary, it can be duplicated as many times as necessary.