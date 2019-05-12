#!/bin/sh

echo 'ola' >> /tmp/test
pwd >> /tmp/test

REPO_PATH=$(git rev-parse --show-toplevel)
echo $REPO_PATH >> /tmp/test

if [ -d $REPO_PATH ]
then
     chmod a+x ./gitHooks/PHP/pre-commit >> /tmp/teste 2>&1
     cp ./gitHooks/PHP/pre-commit "$REPO_PATH/.git/hooks/pre-commit"
     cp ./PHP/codeStandards/.php_cs "$REPO_PATH/.git/hooks/.php_cs"
else
   echo 'Git not found ...'
fi
