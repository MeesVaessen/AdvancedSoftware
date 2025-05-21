#!/bin/bash

# Define the base directory for your project
BASE_DIR="./"

# Apply Authentication Service
echo "Applying authentication service deployment..."
kubectl apply -f "$BASE_DIR/authentication-service/authentication-service-deployment.yaml"
kubectl apply -f "$BASE_DIR/authentication-service/authentication-service-hpa.yaml"
kubectl apply -f "$BASE_DIR/authentication-service/authDB-deployment.yaml"

# Apply Post Service
echo "Applying post service deployment..."
kubectl apply -f "$BASE_DIR/post-service/post-service-deployment.yaml"
kubectl apply -f "$BASE_DIR/post-service/post-service-hpa.yaml"
kubectl apply -f "$BASE_DIR/post-service/postDB-deployment.yaml"

# Apply Nginx Deployment and Gateway Service
echo "Applying Nginx deployment and gateway service..."
kubectl apply -f "$BASE_DIR/nginx/nginx-deployment.yaml"
kubectl apply -f "$BASE_DIR/nginx/nginx-configmap.yaml"

# Finished
echo "All Kubernetes resources have been applied successfully!"
