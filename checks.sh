composer update
./vendor/bin/phpcs -ns --report=summary --extensions=php --standard=PSR12 src
./vendor/bin/phpcs src --standard=Squiz --sniffs=Squiz.Commenting.FunctionComment,Squiz.Commenting.FunctionCommentThrowTag,Squiz.Commenting.ClassComment,Squiz.Commenting.VariableComment
./vendor/bin/pest --coverage --min=95
./vendor/bin/phpcs -p src --standard=PHPCompatibility --runtime-set testVersion 7.4-