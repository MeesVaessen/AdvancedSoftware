#!/bin/bash

set -e

if helm list -n kube-system | grep -q 'traefik'; then
  echo "✅ Traefik is already installed. Skipping installation."
  exit 0
fi

echo "🚀 Installing Traefik..."

helm repo add traefik https://traefik.github.io/charts
helm repo update

helm install traefik traefik/traefik --namespace kube-system --create-namespace

echo "✅ Traefik installation completed!"
