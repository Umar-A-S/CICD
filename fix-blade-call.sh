#!/usr/bin/env bash
set -e

echo "=== STEP 1: Rename Blade component calls in kota/ and provinsi/ ==="

# target folder
TARGETS=("resources/views/kota" "resources/views/provinsi")

for DIR in "${TARGETS[@]}"; do
    if [ -d "$DIR" ]; then
        FILES=$(find "$DIR" -type f -name "*.blade.php")
        for f in $FILES; do
            # replace opening tags <x-foo_bar ...> -> <x-foo-bar ...>
            sed -i -E 's/<x-([a-zA-Z0-9]+)_([a-zA-Z0-9_-]+)/<x-\1-\2/g' "$f"
            # replace closing tags </x-foo_bar> -> </x-foo-bar>
            sed -i -E 's/<\/x-([a-zA-Z0-9]+)_([a-zA-Z0-9_-]+)>/<\/x-\1-\2>/g' "$f"
        done
    else
        echo "Folder $DIR tidak ditemukan, dilewati"
    fi
done

echo ""
echo "✔ DONE — Semua pemanggilan Blade di kota/ dan provinsi/ sudah diganti ke kebab-case"
