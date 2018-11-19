# Set up test website and install PicoMailFormsPlugin

$appDirectory = 'TestApp';

$appDirectory = "$PSScriptRoot\..\..\$appDirectory";

if (Test-Path $appDirectory) {
    Remove-Item -Recurse -Force $appDirectory;
}
New-Item -ItemType Directory $appDirectory;

cd $appDirectory;

composer create-project picocms/pico-composer .
Remove-Item -Recurse -Force "C:\Users\flja\AppData\Local\Composer\vcs\https---github.com-jflepp-PicoMailForms.git"
composer require jflepp/picomailformsplugin dev-master

Copy-Item $PSScriptRoot\index.md $appDirectory\content\index.md

php -S localhost:80
