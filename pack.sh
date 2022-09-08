#! /bin/bash
export COPY_EXTENDED_ATTRIBUTES_DISABLE=true
export COPYFILE_DISABLE=true
/Applications/MAMP/Library/bin/mysqldump -uroot -hlocalhost -p1 liberum2 > $(date +%Y-%m-%d).sql
tar -cf $(date +%Y-%m-%d).tar * .htaccess
gzip $(date +%Y-%m-%d).tar
rm $(date +%Y-%m-%d).sql