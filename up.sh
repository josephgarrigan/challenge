#!/bin/bash
set -e

read -p "Is mysql running on this machine? Y/n"  ISSERVERUP

if [ -z "$(which docker)" ];then
  MYSQL="docker run --name challenge -p 3306:3306 -e MYSQL_ROOT_PASSWORD=password -d mysql:8"
