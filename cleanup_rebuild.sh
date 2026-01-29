#!/bin/bash
echo "🚨 FULL CLEANUP & REBUILD STARTED..."

echo "🛑 Stopping all containers..."
docker stop $(docker ps -aq) 2>/dev/null

echo "❌ Removing all containers..."
docker rm -f $(docker ps -aq) 2>/dev/null

echo "🗑️ Removing all images..."
docker rmi -f $(docker images -q) 2>/dev/null

echo "📦 Removing all volumes..."
docker volume rm $(docker volume ls -q) 2>/dev/null

echo "🧹 Pruning system..."
docker system prune -a --volumes -f

echo "♻️ Rebuilding 63SatsVulnBank..."
docker compose up --build -d

echo "✅ DONE! Your lab is fully refreshed and rebuilt."
