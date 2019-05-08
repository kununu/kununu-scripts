#!/bin/sh

echo 'ola'
pwd

REPO_PATH=$(git rev-parse --show-toplevel)

if [ -d $REPO_PATH ]
then
     chmod a+x ./gitHooks/PHP/pre-commit
     mv ./gitHooks/PHP/pre-commit "$REPO_PATH/.git/hooks/pre-commit"
     mv ./PHP/codeStandards/.php_cs "$REPO_PATH/.git/hooks/.php_cs"
else
   echo 'Git not found ...'
fi
