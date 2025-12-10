#!/bin/bash

OUTPUT="FULL_CODE_SNAPSHOT.txt"

# 1. HEADER LAPORAN
echo "--- LAPORAN FORENSIK PROYEK: IDA WIDIAWATI SHOP ---" > $OUTPUT
date >> $OUTPUT
echo "------------------------------------------------" >> $OUTPUT

# 2. DEFINISI TARGET OPERASI
# Kita cari semua file PHP, JS, CSS, dan ENV di folder vital
echo "Memindai seluruh arsitektur (Cells, Entities, Views, Config)..."

find app public -type f \( -name "*.php" -o -name "*.js" -o -name "*.css" -o -name ".env" \) \
| grep -v "vendor/" \
| grep -v "system/" \
| grep -v "writable/" \
| grep -v "node_modules/" \
| grep -v "public/index.php" \
| sort \
| while read file; do
    
    echo "Processing: $file"
    echo -e "\n\n##########################################################" >> $OUTPUT
    echo "FILE PATH: $file" >> $OUTPUT
    echo "##########################################################" >> $OUTPUT
    
    # 3. FITUR KEAMANAN (DATA MASKING)
    # Sensor password database dan API Key
    if [[ "$file" == *".env"* ]] || [[ "$file" == *"Database.php"* ]]; then
        cat "$file" | sed -E 's/(password|key|secret|token|pass)\s*=\s*(.*)/\1 = [SENSOR_AMAN]/Ig' >> $OUTPUT
    else
        cat "$file" >> $OUTPUT
    fi

done

echo "------------------------------------------------"
echo "AUDIT SELESAI. File tersimpan di: $OUTPUT"
echo "Silakan upload file ini untuk analisa."
