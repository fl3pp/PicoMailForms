# Set up test website and install PicoMailFormsPlugin

$appDirectory = 'TestApp';

$appDirectory = "$PSScriptRoot\..\..\$appDirectory";

if (Test-Path $appDirectory) {
    Remove-Item -Recurse -Force $appDirectory;
}
New-Item -ItemType Directory $appDirectory;

cd $appDirectory;

composer create-project picocms/pico-composer .
composer require jflepp/picomailformsplugin 0.0.14

Copy-Item $PSScriptRoot\TestData\* $appDirectory -Recurse -Force

php -S localhost:80
