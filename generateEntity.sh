#! /bin/bash
php vendor/doctrine/doctrine-module/bin/doctrine-module.php orm:convert-mapping --namespace="Application\\Entity\\" -f --from-database annotation ./module/Application/src/
php vendor/doctrine/doctrine-module/bin/doctrine-module.php orm:generate-entities ./module/Application/src/ --generate-annotations=true
