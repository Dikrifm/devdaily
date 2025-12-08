#!/bin/bash

OUTPUT="FULL_CODE_AUDIT.txt"
echo "--- LAPORAN AUDIT PROJECT: idawidiawati.shop ---" > $OUTPUT
date >> $OUTPUT
echo "------------------------------------------------" >> $OUTPUT

# Cari file .php, .js, .css, .sql di folder app, public, dan root
# TAPI abaikan folder 'vendor', 'writable', 'tests', dan '.git'
find app public -type f \( -name "*.php" -o -name "*.js" -o -name "*.css" -o -name "*.sql" -o -name "*.env" \) \
| grep -v "vendor/" \
| grep -v "writable/" \
| grep -v "tests/" \
| while read file; do
    echo "" >> $OUTPUT
    echo "##########################################################" >> $OUTPUT
    echo "FILE PATH: $file" >> $OUTPUT
    echo "##########################################################" >> $OUTPUT
    cat "$file" >> $OUTPUT
    echo -e "\n\n" >> $OUTPUT
done

echo "AUDIT SELESAI. File tersimpan di: $OUTPUT"
