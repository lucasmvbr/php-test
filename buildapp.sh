#!/bin/bash
cd /root/myphpapp/app
docker build -t repository.lab.local:5000/php:1.0 .
docker push repository.lab.local:5000/php:1.0
