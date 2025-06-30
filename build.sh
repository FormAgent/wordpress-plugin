#!/bin/bash

# FormAgent.ai WordPress Plugin Build Script
# This script creates a clean package for WordPress.org submission

echo "🚀 Building FormAgent.ai WordPress Plugin Package..."

# Configuration
PLUGIN_NAME="formagent-wp"
BUILD_DIR="build"
PACKAGE_DIR="${BUILD_DIR}/${PLUGIN_NAME}"
ZIP_FILE="${PLUGIN_NAME}.zip"

# Clean previous build
if [ -d "$BUILD_DIR" ]; then
    echo "🧹 Cleaning previous build..."
    rm -rf "$BUILD_DIR"
fi

if [ -f "$ZIP_FILE" ]; then
    echo "🗑️  Removing old zip file..."
    rm -f "$ZIP_FILE"
fi

# Create build directory
echo "📁 Creating build directory..."
mkdir -p "$PACKAGE_DIR"

# Copy required files
echo "📋 Copying plugin files..."

# Main plugin file
cp formagent-wp.php "$PACKAGE_DIR/"
echo "   ✅ formagent-wp.php"

# WordPress.org readme
cp readme.txt "$PACKAGE_DIR/"
echo "   ✅ readme.txt"

# Uninstall script
cp uninstall.php "$PACKAGE_DIR/"
echo "   ✅ uninstall.php"

# Languages directory
if [ -d "languages" ]; then
    cp -r languages "$PACKAGE_DIR/"
    echo "   ✅ languages/ ($(ls languages/ | wc -l | tr -d ' ') files)"
fi

# Assets directory (if exists)
if [ -d "assets" ]; then
    cp -r assets "$PACKAGE_DIR/"
    echo "   ✅ assets/ ($(ls assets/ | wc -l | tr -d ' ') files)"
else
    echo "   ⚠️  assets/ directory not found (create icons and banners)"
fi

# Create ZIP package
echo "📦 Creating ZIP package..."
cd "$BUILD_DIR"
zip -r "../$ZIP_FILE" "$PLUGIN_NAME/" -q

if [ $? -eq 0 ]; then
    cd ..
    echo "✅ Package created successfully: $ZIP_FILE"
    echo "📊 Package size: $(du -h $ZIP_FILE | cut -f1)"
    echo ""
    echo "📋 Package contents:"
    unzip -l "$ZIP_FILE" | grep -E "^\s*[0-9]" | awk '{print "   " $4}'
    echo ""
    echo "🎉 Ready for WordPress.org submission!"
    echo "📍 Upload file: $(pwd)/$ZIP_FILE"
else
    echo "❌ Error creating package"
    exit 1
fi

# Cleanup build directory
echo "🧹 Cleaning up build directory..."
rm -rf "$BUILD_DIR"

echo ""
echo "🔍 Next steps:"
echo "   1. Test the plugin package on a fresh WordPress installation"
echo "   2. Create assets (icons, banners, screenshots) if not done yet"
echo "   3. Submit to https://wordpress.org/plugins/developers/add/"
echo "" 