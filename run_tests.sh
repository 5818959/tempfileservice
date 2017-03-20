#!/bin/sh

 #Colours
red="\033[00;31m"
RED="\033[01;31m"

green="\033[00;32m"
GREEN="\033[01;32m"

yellow="\033[00;33m"
YELLOW="\033[01;33m"

blue="\033[00;34m"
BLUE="\033[01;34m"

purple="\033[00;35m"
PURPLE="\033[01;35m"

cyan="\033[00;36m"
CYAN="\033[01;36m"

white="\033[00;37m"
WHITE="\033[01;37m"

NC="\033[00m"

PROJECT=`php -r "echo dirname(realpath('$0'));"`
STAGED_FILES_CMD=`git diff --cached --name-only --diff-filter=ACMR HEAD | grep \\\\.php`


# echo "${WHITE}******************************************************************************"
# echo "${WHITE}**                                                                          **"
# echo "${WHITE}**                    Run tests                                             **"
# echo "${WHITE}**                                                                          **"
# echo "${WHITE}******************************************************************************"


# Determine if a file list is passed
if [ "$#" -eq 1 ]
then
    oIFS=$IFS
    IFS='
    '
    SFILES="$1"
    IFS=$oIFS
fi
SFILES=${SFILES:-$STAGED_FILES_CMD}
 
if [ "$SFILES" == "" ]
then
    echo "${YELLOW}No changes."
    exit 0
fi

# Run php lint

echo "${BLUE}Checking PHP Lint..."
echo "${BLUE}-------------------------------${NC}"
for FILE in $SFILES
do
    php -l -d display_errors=0 $PROJECT/$FILE
    if [ $? != 0 ]
    then
        echo "${RED}Fix the error before commit."
        exit 1
    fi
    FILES="$FILES $PROJECT/$FILE"
done

echo ""


echo "${FILES}"

# Run phpspec

if [ "$FILES" != "" ]
then
    echo "${BLUE}Running PHPSpec..."
    echo "${BLUE}-------------------------------${NC}"
    ./vendor/bin/phpspec run
    if [ $? != 0 ]
    then
        echo "${RED}**********************************"
        echo "${RED}*  Fix the error before commit.  *"
        echo "${RED}**********************************"
        exit 1
    fi
fi

echo ""

# Run php-cs-fixer

if [ "$FILES" != "" ]
then
    echo "${BLUE}Running php-cs-fixer..."
    echo "${BLUE}-------------------------------${NC}"
    ./vendor/bin/php-cs-fixer fix --verbose
    git add $FILES
fi

echo ""

# Run PHP Code Sniffer

if [ "$FILES" != "" ]
then
    echo "${BLUE}Running Code Sniffer..."
    echo "${BLUE}-------------------------------${NC}"
    ./vendor/bin/phpcs
    if [ $? != 0 ]
    then
        echo "${RED}**********************************"
        echo "${RED}*  Fix the error before commit.  *"
        echo "${RED}**********************************"
        exit 1
        # echo "Coding standards errors have been detected. Running phpcbf..."
        # ./bin/phpcbf --standard=PSR2 --encoding=utf-8 -n -p $FILES
        # git add $FILES
        # echo "Running Code Sniffer again..."
        # ./bin/phpcs --standard=PSR2 --encoding=utf-8 -n -p $FILES
        # echo "Coding standards errors have been detected. Running php-cs-fixer..."
        # ./vendor/bin/php-cs-fixer fix --verbose $FILES
        # git add $FILES
        # echo "Running Code Sniffer again..."
        # ./vendor/bin/phpcs $FILES
        # if [ $? != 0 ]
        # then
        #    echo "${RED}Errors found not fixable automatically."
        #    exit 1
        # fi
    fi
fi

echo ""

# Run PHPCPD

if [ "$FILES" != "" ]
then
    echo "${BLUE}Running PHPCPD..."
    echo "${BLUE}-------------------------------${NC}"
    ./vendor/bin/phpcpd --exclude=vendor/ --progress ./
    if [ $? != 0 ]
    then
        echo "${RED}**********************************"
        echo "${RED}*  Fix the error before commit.  *"
        echo "${RED}**********************************"
        exit 1
    fi
fi

echo ""

# Run PHPMD
  
if [ "$FILES" != "" ]
then
    echo "${BLUE}Running PHPMD..."
    echo "${BLUE}-------------------------------"
    ./vendor/bin/phpmd ./ text phpmd.xml.dist
    if [ $? != 0 ]
    then
        echo "${RED}**********************************"
        echo "${RED}*  Fix the error before commit.  *"
        echo "${RED}**********************************"
        exit 1
    fi
fi

echo ""

echo "${GREEN}****************"
echo "${GREEN}*  Well done.  *"
echo "${GREEN}****************"
echo "${NC}"

exit 0
