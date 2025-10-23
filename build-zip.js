const fs = require("fs");
const archiver = require("archiver");

if(!fs.existsSync("dist")){
  fs.mkdirSync("dist");
}

const output = fs.createWriteStream("dist/woo-product-table.zip");
const archive = archiver("zip", { zlib: { level: 9 } });

archive.pipe(output);

archive.glob("**/*", {
  ignore: [
    "node_modules/**",
    "dist/**",
    "composer.json",
    "composer.lock",
    ".github/**",
    ".git/**",
    ".gitignore",
    "build-zip.js",
    "readme.md",
    "README.md",
    "README.MD",
    "package.json",
    "package-lock.json",
    "editorconfig.json",
    "editorconfig",
    "webpack.config.js",
    ".ftpconfig",
    ".vscode/**",
    ".ftpignore"
  ]
});

archive.finalize();
