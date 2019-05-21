#!/bin/sh

REPO_PATH=$(git rev-parse --show-toplevel)

if [ -d $REPO_PATH ]
then
    PWD=`pwd`
    chmod a+x "$PWD/gitHooks/PHP/pre-commit"
    cp "$PWD/gitHooks/PHP/pre-commit" "$REPO_PATH/.git/hooks/pre-commit"
    cp "$PWD/PHP/codeStandards/.php_cs" "$REPO_PATH/.git/hooks/.php_cs"
fi
