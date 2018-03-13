#!/bin/sh

BASE_DIR=$(dirname $(readlink -f "$0"))
if [ "$1" != "test" ]
then
    psql -h localhost -U phergeon -d phergeon < $BASE_DIR/phergeon.sql
fi
psql -h localhost -U phergeon -d phergeon_test < $BASE_DIR/phergeon.sql
