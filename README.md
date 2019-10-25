# kununu-scripts
- This is a package that has some useful kununu scripts.
- Coding standards git pre-hook check and PHP coding standards check.

## Pre-Requisites
- If you commit inside docker machine there are no pre-requisites,
otherwise you have to have PHP cli installed on your local machine (this is needed because php-cs-fixer is a PHP binary).

## GIT
- When you commit PHP code pre-commit hook will check that your code follows the kununu standards, if not it will apply all
the necessary changes to make it compliant.
- You will need to add the files that were not compliant again to the git staging area and commit again.
- In all this process you will be warn about the steps to take.
- In case you do not want to apply the changes on the code you can always use _--no-verify_ option.

## Installation
## Pre-commit hook
- To use coding standards in our PHP projects we need to include this project on composer.json.
- To do so just add on repositories option kununu-scripts VCS repo, see below.

```
  "repositories": [
        ...,
        {
          "type": "vcs",
          "url": "https://github.com/kununu/kununu-scripts.git",
          "no-api": true
        }
    ]
```
And run on your machine on inside docker container the following CMD:
```
composer --dev require kununu/scripts:*
```

- Since this project is a _composer-plugin_ and with the configuration that is done on install or update
this composer _Command_ `kununu:cs-fixer-git-hook` is applied.
- You can run this _Command_ with composer also.
What the Command does is add _pre_commit_ hook on _.git/hooks/_ folder, and creates on .git a folder with the
kununu coding-standards configuration. This was done like this so the hook works on docker and local machine.

## Help on rules
- PHP-CS-FiXER rules can be found [here](https://mlocati.github.io/php-cs-fixer-configurator).
kununu coding standards rules can be found [here](src/PHPCodeStandards/php_cs).

## Commands Usage
### kununu:cs-fixer-git-hook
- Installs kununu pre-commit git hook coding standards. Just run `composer kununu:cs-fixer-git-hook`

### kununu:cs-fixer-code
- Runs PHP-CS-FIXER on a list of files and directories. Ex: `composer kununu:cs-fixer-code ./src ./src/file.php ....`

## Contributing
- Fell free to contribute.
- When you add a rule or change the code don't forget to create a new tag of this project.
```
git tag -a v1.0 -m "Version 1.0"
git push --tags
```

## Future work
- Make this package to be self update.
- Run the php-cs-fixer cmd inside docker so there is no need to install php cli.

## Extra
- If you want to install locally php-cs-fixer just:

```bash
wget https://cs.symfony.com/download/php-cs-fixer-v2.phar -O php-cs-fixer
chmod a+x php-cs-fixer
php-cs-fixer self-update
sudo mv php-cs-fixer /usr/local/bin/php-cs-fixer
```
