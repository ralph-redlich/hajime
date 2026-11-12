const colors = require('tailwindcss/colors')
const preset = require('./vendor/filament/support/tailwind.config.preset')

module.exports = {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './app/Livewire/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    ],
    safelist: [
        'text-danger-600',
        'bg-danger-600',
        'hover:bg-danger-500',
        'focus:ring-danger-500',
        'fi-color-danger',
    ],
  darkMode: 'class', // never follow OS dark mode (false == 'media' in Tailwind 3); app UI is light-only
  theme: {
    extend: {
        colors: {
            lightjudo: {
                '50':  '#fafbf7',
                '100': '#f6fae3',
                '200': '#e9f5aa',
                '300': '#d3ea64',
                '400': '#97d524',
                '500': '#56bc0b',
                '600': '#399d06',
                '700': '#317c09',
                '800': '#285c0d',
                '900': '#1f470e',
            },
            judo: {
                '50': '#A4EAA5',
                '100': '#8FE591',
                '200': '#66DB68',
                '300': '#3DD13F',
                '400': '#2AB22B',
                '500': '#019903',
                '600': '#0A850C',
                '700': '#065507',
                '800': '#032603',
                '900': '#000000',
            },
            amber: colors.amber,
        }
    },
  },
  variants: {
    extend: {},
  },
  plugins: [
      require('@tailwindcss/typography'),
  ],
}
