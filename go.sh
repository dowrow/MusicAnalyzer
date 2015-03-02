#!/bin/bash
echo Subiendo a heroku...
git add .
git commit -m "$1"
git push heroku master
git push origin master
	