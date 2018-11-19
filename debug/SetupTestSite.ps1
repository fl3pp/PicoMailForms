# Set up test website and install PicoMailFormsPlugin

$appDirectory = 'TestApp';

$appDirectory = "$PSScriptRoot\..\..\$appDirectory";

if (Test-Path $appDirectory) {
    Remove-Item -Recurse -Force $appDirectory;
}
New-Item -ItemType Directory $appDirectory;
Copy-Item $PSScriptRoot\debug\index.md $appDirectory\content\index.md

cd $appDirectory;


composer create-project picocms/pico-composer .
composer require jflepp/picomailformsplugin

php -S localhost:80
