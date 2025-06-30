# FormAgent.ai WordPress Plugin Publishing Guide

## 📋 Pre-Publishing Checklist

### ✅ Files Prepared
- [x] `formagent-wp.php` - Main plugin file with complete headers
- [x] `readme.txt` - WordPress.org compatible readme file
- [x] `uninstall.php` - Clean uninstall script
- [x] `languages/` - Translation files (en_US, zh_CN, ja)
- [x] `assets/` - Directory for icons and banners
- [x] `build.sh` - Automated packaging script
- [x] `.gitignore` - Version control exclusions

### 🎨 Assets Needed (Create These)

Create the following images in the `assets/` directory:

1. **Plugin Icon** (`icon-128x128.png`, `icon-256x256.png`)
   - Square images representing your plugin
   - Clean, professional design
   - FormAgent.ai branding

2. **Plugin Banner** (`banner-772x250.png`, `banner-1544x500.png`)
   - Horizontal banner for plugin directory
   - Include plugin name and key features

3. **Screenshots** (`screenshot-1.png`, `screenshot-2.png`)
   - Settings page screenshot
   - Frontend widget screenshot
   - Name them descriptively in readme.txt

## 🚀 WordPress.org Submission Process

### Step 1: Create WordPress.org Account
1. Go to https://wordpress.org/support/register.php
2. Create an account (use a professional email)
3. Complete your profile

### Step 2: Submit Plugin for Review
1. Go to https://wordpress.org/plugins/developers/add/
2. Fill out the submission form:
   - **Plugin Name**: FormAgent.ai Integration
   - **Plugin Description**: Brief description of functionality
   - **Plugin ZIP File**: Upload your complete plugin package

### Step 3: Required Information
```
Plugin Name: FormAgent.ai Integration
Description: Integrate FormAgent.ai chat widget into WordPress websites
Plugin ZIP: formagent-wp.zip (containing all plugin files)
```

### Step 4: Wait for Review
- Initial review takes 2-14 days
- WordPress team will check for:
  - Security issues
  - Code quality
  - Compliance with guidelines
  - Trademark violations

## 📦 Creating the Submission Package

### Automated Build Process
Simply run the build script to create a clean WordPress.org submission package:

```bash
# Run the automated build script
./build.sh
```

This script will:
- ✅ Create a clean build directory
- ✅ Copy only required files (no development files)
- ✅ Generate `formagent-wp.zip` ready for submission
- ✅ Show package contents and size
- ✅ Clean up temporary files

### Manual Build (Alternative)
If you prefer manual control:
```bash
# Create a clean directory
mkdir build
mkdir build/formagent-wp

# Copy only required files
cp formagent-wp.php build/formagent-wp/
cp readme.txt build/formagent-wp/
cp uninstall.php build/formagent-wp/
cp -r languages build/formagent-wp/
cp -r assets build/formagent-wp/  # if assets exist

# Create ZIP file
cd build
zip -r ../formagent-wp.zip formagent-wp/
cd ..
rm -rf build
```

### Final Directory Structure
```
formagent-wp/                 # Development directory
├── formagent-wp.php          # Main plugin file
├── readme.txt                # WordPress.org readme
├── uninstall.php             # Uninstall script
├── build.sh                  # Automated packaging script
├── .gitignore               # Version control exclusions
├── PUBLISHING_GUIDE.md      # This guide (dev only)
├── assets/                   # Icons and banners
│   ├── icon-128x128.png
│   ├── icon-256x256.png
│   ├── banner-772x250.png
│   ├── banner-1544x500.png
│   ├── screenshot-1.png
│   └── screenshot-2.png
└── languages/                # Translation files
    ├── formagent-wp-en_US.po
    ├── formagent-wp-en_US.mo
    ├── formagent-wp-zh_CN.po
    ├── formagent-wp-zh_CN.mo
    ├── formagent-wp-ja.po
    └── formagent-wp-ja.mo

formagent-wp.zip             # Generated package (WordPress.org ready)
├── formagent-wp/
│   ├── formagent-wp.php     # Only production files
│   ├── readme.txt           # No dev files included
│   ├── uninstall.php
│   ├── assets/
│   └── languages/
```

## 📝 Important Notes

### Before Submitting
1. **Update Author Information**:
   - Replace "Your Name" with actual author name
   - Update "yourwordpressusername" in readme.txt
   - Add your real contact information

2. **Test Thoroughly**:
   - Test on fresh WordPress installation
   - Test plugin activation/deactivation
   - Test uninstall process
   - Test with different themes

3. **Security Review**:
   - All user input is properly escaped
   - No SQL injection vulnerabilities
   - Proper nonce verification for forms

### WordPress Guidelines Compliance
- ✅ GPL-compatible license
- ✅ No premium features in free plugin
- ✅ Proper data sanitization
- ✅ WordPress coding standards
- ✅ No external dependencies
- ✅ Clean uninstall process

### After Approval
1. **SVN Repository Access**: You'll get access to SVN repository
2. **Regular Updates**: Keep plugin updated and secure
3. **Support Forum**: Monitor WordPress.org support forum
4. **Version Management**: Follow semantic versioning

## 🔄 Post-Approval Process

### Using SVN Repository
```bash
# Checkout your plugin's SVN repository
svn co https://plugins.svn.wordpress.org/formagent-ai-integration/

# Add your files to trunk/
cp -r formagent-wp/* formagent-ai-integration/trunk/

# Add files to SVN
cd formagent-ai-integration
svn add trunk/*

# Commit to trunk
svn ci -m "Initial plugin submission"

# Create tags for releases
svn cp trunk tags/1.1
svn ci -m "Tagging version 1.1"
```

### Assets Upload
```bash
# Add assets to SVN
svn add assets/*
svn ci -m "Adding plugin assets"
```

## 🎯 Success Tips

1. **Clear Documentation**: Comprehensive readme.txt file
2. **Professional Assets**: High-quality icons and banners
3. **Security First**: Follow WordPress security best practices
4. **User Experience**: Intuitive interface and clear instructions
5. **Regular Updates**: Keep plugin current with WordPress versions
6. **Automated Building**: Use `./build.sh` for consistent, clean packages

## 🛠️ Build Script Features

The `build.sh` script provides:
- **Clean Packaging**: Only includes WordPress.org required files
- **Automatic Validation**: Shows package contents and size
- **Error Handling**: Stops on errors with clear messages
- **Asset Detection**: Warns if icons/banners are missing
- **Size Optimization**: Excludes development files for smaller packages

```bash
# Make the script executable (first time only)
chmod +x build.sh

# Create WordPress.org package
./build.sh

# The script will generate formagent-wp.zip ready for submission
```

## 📞 Support Resources

- **WordPress Plugin Developer Handbook**: https://developer.wordpress.org/plugins/
- **Plugin Review Guidelines**: https://developer.wordpress.org/plugins/wordpress-org/detailed-plugin-guidelines/
- **WordPress SVN Tutorial**: https://developer.wordpress.org/plugins/wordpress-org/how-to-use-subversion/
- **Support Forum**: https://wordpress.org/support/forum/plugins-and-hacks/

---

**Good luck with your plugin submission! 🚀** 