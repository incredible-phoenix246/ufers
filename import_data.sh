#!/usr/bin/env bash

# Set variables
CONTAINER_NAME="postgres_db"  # Replace with your actual PostgreSQL container name
SQL_FILE="ufers_postgres.sql" # Replace with your actual SQL file name
DB_NAME="ufers"               # Replace with your actual PostgreSQL database name
DB_USER="postgres"            # Replace with your actual PostgreSQL user
DB_PASSWORD="your_password"   # Replace with your actual PostgreSQL password

# Check if SQL file exists
if [ ! -f "$SQL_FILE" ]; then
  echo "SQL file $SQL_FILE not found!"
  exit 1
fi

# Copy the SQL file to the container
if ! sudo docker cp "$SQL_FILE" "$CONTAINER_NAME:/tmp/$SQL_FILE"; then
  echo "Failed to copy SQL file to container!"
  exit 1
fi

# Execute the SQL file inside the container
if ! sudo docker exec -e PGPASSWORD="$DB_PASSWORD" "$CONTAINER_NAME" psql -U "$DB_USER" -d "$DB_NAME" -f /tmp/"$SQL_FILE"; then
  echo "Failed to execute SQL file inside the container!"
  exit 1
fi

# Optional: Clean up by removing the SQL file from the container
if ! sudo docker exec "$CONTAINER_NAME" rm /tmp/"$SQL_FILE"; then
  echo "Failed to remove SQL file from container!"
  exit 1
fi

echo "Data import complete!"
