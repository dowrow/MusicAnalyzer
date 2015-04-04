#!/bin/bash
echo Subiendo a Heroku...
git add .
git commit -m "$1"
git push heroku master

echo Subiendo a Github...
git push origin master
