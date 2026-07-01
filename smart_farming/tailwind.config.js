import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                'caption': ['12px', { lineHeight: '1.5', fontWeight: '400' }],
                'label':   ['13px', { lineHeight: '1.4', fontWeight: '500' }],
                'body':    ['14px', { lineHeight: '1.6', fontWeight: '400' }],
                'h2':      ['18px', { lineHeight: '1.4', fontWeight: '500' }],
                'h1':      ['24px', { lineHeight: '1.3', fontWeight: '600' }],
                'hero':    ['32px', { lineHeight: '1.2', fontWeight: '600' }],
            },
            colors: {
                green: {
                    50:  '#D8F3DC',
                    100: '#B7E4C7',
                    200: '#95D5B2',
                    400: '#52B788',
                    600: '#40916C',
                    800: '#2D6A4F',
                    900: '#1B4332',
                },
                gray: {
                    50:  '#F9FAFB',
                    100: '#F3F4F6',
                    200: '#E5E7EB',
                    300: '#D1D5DB',
                    400: '#9CA3AF',
                    500: '#6B7280',
                    600: '#4B5563',
                    700: '#374151',
                    800: '#1F2937',
                    900: '#111827',
                },
            },
            boxShadow: {
                'card': '0 1px 3px rgba(0,0,0,0.06)',
                'card-hover': '0 2px 6px rgba(0,0,0,0.08)',
            },
            borderRadius: {
                'card': '12px',
            },
        },
    },

    plugins: [forms],
};
