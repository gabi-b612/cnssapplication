import defaultTheme from 'tailwindcss/defaultTheme';

export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
  ],

  theme: {
    extend: {
      colors: {
        // Brand Colors
        primary: {
          50: '#eaf5f0',
          100: '#d4eae0',
          200: '#a9d5c1',
          300: '#7ec0a2',
          400: '#53ab83',
          500: '#35b675', // Main brand color
          600: '#2a9361',
          700: '#1f704d',
          800: '#144d39',
          900: '#0a2a25',
        },
        dark: {
          50: '#f0f1f4',
          100: '#e0e2e8',
          200: '#c1c5d1',
          300: '#a2a8ba',
          400: '#838ba3',
          500: '#242c4d', // Main dark color
          600: '#1a203d',
          700: '#12172d',
          800: '#0a0e1d',
          900: '#050810',
        },
        // Accent Colors for states
        success: {
          50: '#ecfdf5',
          100: '#d1fae5',
          200: '#a7f3d0',
          300: '#6ee7b7',
          400: '#34d399',
          500: '#10b981',
          600: '#059669',
          700: '#047857',
          800: '#065f46',
          900: '#064e3b',
        },
        warning: {
          50: '#fffbeb',
          100: '#fef3c7',
          200: '#fde68a',
          300: '#fcd34d',
          400: '#fbbf24',
          500: '#f59e0b',
          600: '#d97706',
          700: '#b45309',
          800: '#92400e',
          900: '#78350f',
        },
        danger: {
          50: '#fef2f2',
          100: '#fee2e2',
          200: '#fecaca',
          300: '#fca5a5',
          400: '#f87171',
          500: '#ef4444',
          600: '#dc2626',
          700: '#b91c1c',
          800: '#991b1b',
          900: '#7f1d1d',
        },
        info: {
          50: '#eff6ff',
          100: '#dbeafe',
          200: '#bfdbfe',
          300: '#93c5fd',
          400: '#60a5fa',
          500: '#3b82f6',
          600: '#2563eb',
          700: '#1d4ed8',
          800: '#1e40af',
          900: '#1e3a8a',
        },
        neutral: {
          50: '#f9fafb',
          100: '#f3f4f6',
          200: '#e5e7eb',
          300: '#d1d5db',
          400: '#9ca3af',
          500: '#6b7280',
          600: '#4b5563',
          700: '#374151',
          800: '#1f2937',
          900: '#111827',
        },
        'my-green': '#35b675',
        'black-blue': '#242c4d',
      },
      fontFamily: {
        sans: ['Poppins', ...defaultTheme.fontFamily.sans],
      },
    },
  },

  plugins: [],
};
