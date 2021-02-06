#!/bin/bash
FILES=/home/assandra/Projects/web-scraping/downloaded-images/*
for f in $FILES
do

	fileProperties=`file $f`
       printf '%s\n' "$fileProperties"

  # take action on each file. $f store current file name
  
done
