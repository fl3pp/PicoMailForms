@echo off
IF [%1] == [] GOTO error

git tag -a %1 -m %1
git push --tags
GOTO eof

:error
echo specify version as first argument
GOTO eof

:eof