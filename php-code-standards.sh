#!/bin/sh

REPO_PATH=$(git rev-parse --show-toplevel)

if [ -d $REPO_PATH ]
then
    PATH=$(pwd)
    chmod a+x "$PATH/gitHooks/PHP/pre-commit"
    cp "$PATH/gitHooks/PHP/pre-commit" "$REPO_PATH/.git/hooks/pre-commit"
    cp "$PATH/PHP/codeStandards/.php_cs" "$REPO_PATH/.git/hooks/.php_cs"
fi
