#!/bin/sh

if [ ! -f "package.json" ]; then
    echo "Initialisation du projet React..."
    npm create vite@latest . -- --template react-ts
    npm install
    npm install -D tailwindcss postcss autoprefixer
    
    echo 'module.exports = {
  content: ["./index.html", "./src/**/*.{js,ts,jsx,tsx}"],
  theme: {
    extend: {},
  },
  plugins: [],
}' > tailwind.config.js

    echo 'module.exports = {
  plugins: {
    tailwindcss: {},
    autoprefixer: {},
  },
}' > postcss.config.js

    if [ -f "src/index.css" ]; then
        echo '@tailwind base;
@tailwind components;
@tailwind utilities;' > src/index.css.new
        cat src/index.css >> src/index.css.new
        mv src/index.css.new src/index.css
    else
        echo '@tailwind base;
@tailwind components;
@tailwind utilities;' > src/index.css
    fi
fi

npm install
npm run dev -- --host 0.0.0.0