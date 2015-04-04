#!/bin/bash
echo Subiendo a Heroku...
git add .
git commit -m "$1"
git push heroku master

echo Subiendo a Github...
git remote set-url origin https://dowrow:hacker6!!@github.com/MusicAnalyzer.git
git push origin master
