#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd $DIR

php5 -S 'localhost:8000' & 

echo $! > php_server.pid
