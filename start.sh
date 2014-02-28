#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

php5 -S 'localhost:8000' -t $DIR
