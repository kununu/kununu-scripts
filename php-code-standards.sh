#!/bin/sh

REPO_PATH=$(git rev-parse --show-toplevel)

if [ -d $REPO_PATH ]
then
    BASEDIR=$(dirname "$0")
    chmod a+x "$BASEDIR/gitHooks/PHP/pre-commit"
    cp "$BASEDIR/gitHooks/PHP/pre-commit" "$REPO_PATH/.git/hooks/pre-commit"
    cp "$BASEDIR/PHP/codeStandards/.php_cs" "$REPO_PATH/.git/hooks/.php_cs"
fi
