#!/bin/bash

set -e

DRY_RUN=true
BRANCH="$1"
TAG="$2"
NEW_BRANCH="${BRANCH}-new"

run() {
  if [ "$DRY_RUN" = true ]; then
    echo "[DRY-RUN] $*"
  else
    "$@"
  fi
}

if [ -z "$BRANCH" ]; then
  read -p "Masukkan nama branch: " BRANCH
fi

if [ -z "$TAG" ]; then
  read -p "Masukkan tag: " TAG
fi

#=======================================#

if [ -n "$(git status --porcelain)" ]; then
  echo "❌ Working tree tidak bersih"
  exit 1
fi


# ===================================== #

git fetch repoA

if git show-ref --verify --quiet "refs/heads/$NEW_BRANCH"; then
  git checkout "$NEW_BRANCH"
else
  git checkout -b "$NEW_BRANCH"
fi

git config pull.rebase false

git pull --no-edit repoA "$BRANCH"

if git diff --name-only --diff-filter=U | grep .; then
  echo "❌ Conflict ditemukan"
  exit 1
fi

git push -u origin "$NEW_BRANCH"

read -p "YAKIN push ke STAGING & MAIN? (yes/no): " CONFIRM
[ "$CONFIRM" != "yes" ] && exit 1


# merge ke staging
git switch stagging
git pull --no-edit origin stagging
git merge --no-ff --no-edit "$NEW_BRANCH"
git push origin stagging

# merge ke main
git switch main
git pull --no-edit origin main
git merge --no-ff --no-edit stagging
git push origin main

# tag
if git rev-parse "$TAG" >/dev/null 2>&1; then
  echo "❌ Tag $TAG sudah ada"
  exit 1
fi

git tag "$TAG"
git push origin "$TAG"

echo "✅ Deploy & tagging selesai"