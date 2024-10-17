#!/bin/bash

# Cek apakah parameter sudah diberikan
if [ $# -lt 1 ]; then
  echo "Usage: $0 <NamaFile>"
  exit 1
fi

# Mengambil parameter pertama sebagai nama file yang akan dibuat
fileName=$1

# Membuat model
echo "Creating model: $fileName"
php artisan make:model $fileName

# Membuat controller
echo "Creating controller: ${fileName}Controller"
php artisan make:controller ${fileName}Controller

# Membuat seeder
echo "Creating seeder: ${fileName}Seeder"
php artisan make:seeder ${fileName}Seeder

# Membuat migration
echo "Creating migration for: $fileName"
php artisan make:migration ${fileName}

echo "All files created successfully!"
