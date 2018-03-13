#!/bin/sh

if [ "$1" = "travis" ]
then
    psql -U postgres -c "CREATE DATABASE phergeon_test;"
    psql -U postgres -c "CREATE USER phergeon PASSWORD 'phergeon' SUPERUSER;"
else
    [ "$1" != "test" ] && sudo -u postgres dropdb --if-exists phergeon
    [ "$1" != "test" ] && sudo -u postgres dropdb --if-exists phergeon_test
    [ "$1" != "test" ] && sudo -u postgres dropuser --if-exists phergeon
    sudo -u postgres psql -c "CREATE USER phergeon PASSWORD 'phergeon' SUPERUSER;"
    [ "$1" != "test" ] && sudo -u postgres createdb -O phergeon phergeon
    sudo -u postgres createdb -O phergeon phergeon_test
    LINE="localhost:5432:*:phergeon:phergeon"
    FILE=~/.pgpass
    if [ ! -f $FILE ]
    then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE
    then
        echo "$LINE" >> $FILE
    fi
fi
