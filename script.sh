#!/bin/bash

set -e

BRANCH="$1"
TAG="$2"
NEW_BRANCH="${BRANCH}-new"

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


# auto resolve conflict (HATI-HATI)
if git diff --name-only --diff-filter=U | grep .; then
  git checkout --theirs .
  git add .
  git commit -m "Auto resolve conflict from repoA:$BRANCH"
fi

git push -u origin "$NEW_BRANCH"

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
git tag "$TAG"
git push origin "$TAG"

echo "✅ Deploy & tagging selesai"