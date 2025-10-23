// tailwind.config.js
module.exports = {
  content: [
    // ✅ ALLE HTML/JS/PHP Dateien im gesamten Projekt scannen
    "./**/*.html",
    "./**/*.php", 
    "./**/*.js",
    "./pages/**/*.html",
    "./pages/**/*.php",
    "./**/*.{html,js,php}"  // Catch-all
  ],
  
  // ✅ SAFELIST - Damit Farben nicht entfernt werden
  safelist: [
    // Background Colors
    'bg-red-100',
    'bg-blue-100', 
    'bg-blue-300',
    'bg-red-500',
    'bg-green-500',
    
    // Text Colors
    'text-white',
    'text-gray-400',
    'text-green-500',
    
    // Hover Colors
    'hover:bg-blue-300',
    'hover:text-green-500',
    
    // Transition
    'transition-colors',
    'duration-300',
    
    // Flexbox
    'flex',
    'flex-col',
    'items-center', 
    'justify-center'
  ],
  
  theme: {
    extend: {},
  },
  
  plugins: [],
}