# Set up test website and install PicoMailFormsPlugin

$appDirectory = 'TestApp';

$appDirectory = "$PSScriptRoot\..\..\$appDirectory";

if (Test-Path $appDirectory) {
    Remove-Item -Recurse -Force $appDirectory;
}
New-Item -ItemType Directory $appDirectory;

cd $appDirectory;

composer clearcache
composer create-project picocms/pico-composer .
composer require jflepp/picomailformsplugin dev-master

Copy-Item $PSScriptRoot\index.md $appDirectory\content\index.md

php -S localhost:80
