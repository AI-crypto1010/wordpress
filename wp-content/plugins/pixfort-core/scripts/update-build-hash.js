/**
 * Build Hash Update Script (Production Only)
 * 
 * This script generates a random hash for cache busting and updates:
 * 1. webpack.config.prod.js
 * 2. includes/options/main.php (only the production hash variable)
 * 
 * Development builds use a static 'bundle-6.js' filename to avoid
 * unnecessary git changes during development.
 * 
 * Run: npm run build:prod (automatically runs this script)
 * Or manually: npm run update-hash
 */

const fs = require('fs');
const path = require('path');
const crypto = require('crypto');

// Generate a short random hash (8 characters)
function generateHash() {
    return crypto.randomBytes(4).toString('hex');
}

// Read current hash from webpack prod config
function getCurrentHash(configPath) {
    const content = fs.readFileSync(configPath, 'utf8');
    const match = content.match(/\[name\]\.bundle-([a-f0-9]+)\.js/);
    return match ? match[1] : null;
}

// Update webpack.config.prod.js
function updateWebpackProd(filePath, oldHash, newHash) {
    if (!fs.existsSync(filePath)) {
        console.error(`File not found: ${filePath}`);
        return false;
    }
    
    let content = fs.readFileSync(filePath, 'utf8');
    const regex = new RegExp(`\\[name\\]\\.bundle-${oldHash}\\.js`, 'g');
    const newContent = content.replace(regex, `[name].bundle-${newHash}.js`);
    
    if (content !== newContent) {
        fs.writeFileSync(filePath, newContent, 'utf8');
        console.log(`✓ Updated webpack.config.prod.js: bundle-${oldHash}.js → bundle-${newHash}.js`);
        return true;
    } else {
        console.log(`- No changes needed in webpack.config.prod.js`);
        return false;
    }
}

// Update main.php (only the production hash variable)
function updateMainPhp(filePath, oldHash, newHash) {
    if (!fs.existsSync(filePath)) {
        console.error(`File not found: ${filePath}`);
        return false;
    }
    
    let content = fs.readFileSync(filePath, 'utf8');
    // Only update the $bundleHash = 'xxx' line (production hash)
    const regex = new RegExp(`\\$bundleHash = '${oldHash}'`, 'g');
    const newContent = content.replace(regex, `$bundleHash = '${newHash}'`);
    
    if (content !== newContent) {
        fs.writeFileSync(filePath, newContent, 'utf8');
        console.log(`✓ Updated includes/options/main.php: $bundleHash = '${oldHash}' → '${newHash}'`);
        return true;
    } else {
        console.log(`- No changes needed in includes/options/main.php`);
        return false;
    }
}

// Update icons-elementor.config.js
function updateIconsConfig(filePath, oldHash, newHash) {
    if (!fs.existsSync(filePath)) {
        console.error(`File not found: ${filePath}`);
        return false;
    }
    
    let content = fs.readFileSync(filePath, 'utf8');
    const regex = new RegExp(`index\\.bundle-${oldHash}\\.js`, 'g');
    const newContent = content.replace(regex, `index.bundle-${newHash}.js`);
    
    if (content !== newContent) {
        fs.writeFileSync(filePath, newContent, 'utf8');
        console.log(`✓ Updated icons-elementor.config.js: bundle-${oldHash}.js → bundle-${newHash}.js`);
        return true;
    } else {
        console.log(`- No changes needed in icons-elementor.config.js`);
        return false;
    }
}

// Main execution
function main() {
    const rootDir = path.resolve(__dirname, '..');
    
    const files = {
        webpackProd: path.join(rootDir, 'webpack.config.prod.js'),
        mainPhp: path.join(rootDir, 'includes/options/main.php'),
        iconsConfig: path.join(rootDir, 'dev/main/icons/icons-elementor.config.js')
    };
    
    // Get current hash from webpack prod config
    const currentHash = getCurrentHash(files.webpackProd);
    if (!currentHash) {
        console.error('Could not find current hash in webpack.config.prod.js');
        process.exit(1);
    }
    
    // Generate new hash
    const newHash = generateHash();
    
    console.log('\n🔄 Updating production build hash...\n');
    console.log(`   Old hash: ${currentHash}`);
    console.log(`   New hash: ${newHash}\n`);
    
    // Update production files only
    updateWebpackProd(files.webpackProd, currentHash, newHash);
    updateMainPhp(files.mainPhp, currentHash, newHash);
    updateIconsConfig(files.iconsConfig, currentHash, newHash);
    
    // Save hash to a file for reference
    const hashFile = path.join(rootDir, 'dist', 'build-hash.txt');
    const distDir = path.join(rootDir, 'dist');
    if (!fs.existsSync(distDir)) {
        fs.mkdirSync(distDir, { recursive: true });
    }
    fs.writeFileSync(hashFile, newHash, 'utf8');
    console.log(`\n✓ Hash saved to dist/build-hash.txt`);
    
    console.log('\n✅ Production build hash update complete!\n');
    console.log('Note: Development builds (grunt react) use static bundle-6.js\n');
}

main();
