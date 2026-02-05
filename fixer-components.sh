cat << 'EOF' > fix-blade-components.sh
#!/usr/bin/env bash
set -e

echo "=== STEP 1: Rename component files ==="

cd resources/views/components

find . -type f -name "*_*\.blade.php" | while read file; do
    new=$(echo "$file" | sed 's/_/-/g')
    if [ "$file" != "$new" ]; then
        echo "rename: $file -> $new"
        git mv "$file" "$new" 2>/dev/null || mv "$file" "$new"
    fi
done

cd ../../..

echo ""
echo "=== STEP 2: Fix blade usage <x-...> ==="

# hanya file blade
FILES=$(find resources/views -type f -name "*.blade.php")

for f in $FILES; do
    sed -i -E 's/<x-([a-zA-Z0-9]+)_([a-zA-Z0-9_-]+)/<x-\1-\2/g' "$f"
    sed -i -E 's/<\/x-([a-zA-Z0-9]+)_([a-zA-Z0-9_-]+)>/<\/x-\1-\2>/g' "$f"
done

echo ""
echo "=== STEP 3: Clear Laravel cache ==="
php artisan optimize:clear || true
composer dump-autoload || true

echo ""
echo "✔ DONE — All components converted to kebab-case"
EOF
