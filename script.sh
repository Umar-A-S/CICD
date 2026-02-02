#!/bin/bash
set -e

# ================= CONFIG =================
DRY_RUN=${DRY_RUN:-true}            # set false untuk eksekusi beneran
STAGING_BRANCH="stagging"
MAIN_BRANCH="main"
# =========================================

BRANCH="$1"
TAG="$2"

run() {
  if [ "$DRY_RUN" = true ]; then
    echo "[DRY-RUN] $*"
  else
    "$@"
  fi
}

# ================= INPUT ==================
if [ -z "$BRANCH" ]; then
  read -p "Masukkan nama branch sumber (dev): " BRANCH
fi

if [ -z "$TAG" ]; then
  read -p "Masukkan tag release: " TAG
fi

NEW_BRANCH="${BRANCH}-new"

# ================= SAFETY =================
if [ "$BRANCH" = "$MAIN_BRANCH" ]; then
  echo "❌ Tidak boleh deploy langsung dari branch main"
  exit 1
fi

if [ -n "$(git status --porcelain)" ]; then
  echo "❌ Working tree tidak bersih"
  exit 1
fi

if git rev-parse "$TAG" >/dev/null 2>&1; then
  echo "❌ Tag $TAG sudah ada"
  exit 1
fi
# =========================================

echo "🚀 Mulai deploy dari branch: $BRANCH"

# ================= DEV → NEW BRANCH =======
run git fetch repoA

if git show-ref --verify --quiet "refs/heads/$NEW_BRANCH"; then
  run git checkout "$NEW_BRANCH"
else
  run git checkout -b "$NEW_BRANCH"
fi

run git pull --no-edit repoA "$BRANCH"

if git diff --name-only --diff-filter=U | grep .; then
  echo "❌ Conflict ditemukan, deploy dibatalkan"
  exit 1
fi

run git push -u origin "$NEW_BRANCH"

# ================= CONFIRM =================
read -p "YAKIN merge ke STAGGING & MAIN? (yes/no): " CONFIRM
[ "$CONFIRM" != "yes" ] && exit 1

# ================= NEW → STAGGING =========
run git switch "$STAGING_BRANCH"
run git pull --no-edit origin "$STAGING_BRANCH"
run git merge --no-ff --no-edit "$NEW_BRANCH"
run git push origin "$STAGING_BRANCH"

echo "⏸️  Perubahan sudah di-push ke $STAGING_BRANCH"
echo "👉 Cek workflow CI (GitHub Actions / GitLab CI)"
read -p "CI sudah HIJAU? lanjut ke MAIN? (yes/no): " CI_CONFIRM
[ "$CI_CONFIRM" != "yes" ] && exit 1

# ================= STAGGING → MAIN ========
run git switch "$MAIN_BRANCH"
run git pull --no-edit origin "$MAIN_BRANCH"
run git merge --no-ff --no-edit "$STAGING_BRANCH"
run git push origin "$MAIN_BRANCH"

# ================= TAG ====================
run git tag "$TAG"
run git push origin "$TAG"

echo "✅ Deploy selesai (stagging → main) + tag $TAG"
