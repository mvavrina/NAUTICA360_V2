import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/flowbite/**/*.js'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                montserrat: ['Montserrat', 'sans-serif'],
                lato: ['Lato', 'sans-serif'],
                'font-awesome': ['Font Awesome 5 Free', 'sans-serif'],
                'font-awesome-brands': ['Font Awesome 5 Brands', 'sans-serif'],
            },
            backgroundColor:{
                'primary' : 'rgb(37, 99, 235)',
                'blue-dark' : '#2A9D9F',
                'blue-light' : '#01AFB4',
            },
            colors: {
                whites: {
                    solid: 'rgba(255, 255, 255, 1)',
                    'white-20': 'rgba(255, 255, 255, 0.20)', // Custom white with 20% opacity
                },
                grey: {
                    '13': 'rgba(34, 34, 34, 1)',
                    '77': 'rgba(197, 197, 197, 1)',
                    '67': 'rgba(170, 170, 170, 1)',
                    '96': 'rgba(244, 244, 244, 1)',
                    '60': 'rgba(153, 153, 153, 1)',
                    '12': 'rgba(31, 31, 31, 1)',
                    '40': 'rgba(102, 102, 102, 1)',
                    '87': 'rgba(221, 221, 221, 1)',
                    '33': 'rgba(85, 85, 85, 1)',
                    '46': 'rgba(108, 117, 125, 1)',
                    '93': 'rgba(237, 237, 237, 1)',
                    '17': 'rgba(42, 46, 47, 1)',
                    '68': 'rgba(169, 174, 179, 1)',
                },
                yellow: {
                    '70': 'rgba(228, 209, 131, 1)',
                    '63': 'rgba(207, 188, 112, 1)',
                },
                azure: {
                    '20': 'rgba(37, 50, 65, 1)',
                    '51': 'rgba(48, 168, 213, 1)',
                    '71': 'rgba(131, 203, 230, 1)',
                },
                cyan: {
                    '43': 'rgba(14, 205, 194, 1)',
                },
                red: {
                    '60': 'rgba(221, 84, 84, 1)',
                },
                violet: {
                    '56': 'rgba(143, 56, 232, 1)',
                },
                black: {
                    solid: 'rgba(0, 0, 0, 1)',
                },
            },
            fontSize: {
                '18': '1.125em', // 18px
                '68': '4.25em', // 68px
                '24': '1.5em', // 24px
                '40': '2.5em', // 40px
                '15': '0.9375em', // 15px
                '16': '1em', // 16px
                '14': '0.875em', // 14px
                '22': '1.375em', // 22px
                '17': '1.0625em', // 17px
                '20': '1.25em', // 20px
                '12': '0.75em', // 12px
            },
            lineHeight: {
                '66': '4.125em', // 66px
                '38_4': '2.4em', // 38.4px
                '44': '2.75em', // 44px
                '25_6': '1.6em', // 25.6px
                '25_5': '1.59em', // 25.5px
                '28_5': '1.78em', // 28.5px
                '28_8': '1.8em', // 28.8px
                '48': '3em', // 48px
                '54_6': '3.41em', // 54.6px
                '28_35': '1.77em', // 28.35px
                '44_5': '2.78em', // 44.5px
                '36': '2.25em', // 36px
                '58': '3.625em', // 58px
                '21_6': '1.35em', // 21.6px
                '22_5': '1.41em', // 22.5px
            },
            letterSpacing: {
                '4': '0.25em',
                '-2_75': '-0.171875em', // -2.75px
                '-0_6': '-0.0375em', // -0.6px
                '0_45': '0.028125em', // 0.45px
                '-0_12': '-0.0075em', // -0.12px
            },
        },
    },

    plugins: [
        forms,
        require('flowbite/plugin'),
        function({ addComponents }) {
            addComponents({
                'p': {
                    fontSize: '1.125em', // 18px
                    lineHeight: '1.6em', // 24px
                    color: '#5E6666', // grey-13
                    '@media (max-width: 1400px)': {
                        fontSize: '1.1em', // 40px on smaller screens
                    },
                },
                'a' : {
                    fontSize: '1.125em', // 18px
                    lineHeight: '1.6em',
                    '@media (max-width: 1400px)': {
                        fontSize: '1.1em', // 40px on smaller screens
                    },
                },
                'h1': {
                    fontSize: '4.25em', // 68px
                    fontWeight: '600',
                    color: 'rgba(37, 50, 65, 1)', // azure-20
                    '@media (max-width: 1600px)': {
                        fontSize: '3em', // 48px on medium screens
                    },
                    '@media (max-width: 1400px)': {
                        fontSize: '2.5em', // 40px on smaller screens
                    },
                },
                'h2': {
                    fontSize: '2.5em', // 40px
                    fontWeight: '600',
                    color: 'rgba(37, 50, 65, 1)', // azure-20
                    '@media (max-width: 1600px)': {
                        fontSize: '2em', // 32px on medium screens
                    },
                    '@media (max-width: 1400px)': {
                        fontSize: '1.5em', // 24px on smaller screens
                    },
                },
                'h3': {
                    fontSize: '1.375em', // 22px
                    fontWeight: '600',
                    color: 'rgba(34, 34, 34, 1)', // grey-13
                },
                'h4': {
                    fontSize: '1.125em', // 18px
                    fontWeight: '500',
                    color: 'rgba(34, 34, 34, 1)', // grey-13
                },
                'a': {
                    color: 'rgba(34, 34, 34, 1)', // azure-51
                    textDecoration: 'none',
                },
                'ul': {
                    paddingLeft: '2em',
                },
                'ol': {
                    paddingLeft: '2em',
                },
                'li': {
                    marginBottom: '0.75em',
                },
                '.h1': {
                    fontSize: '4.25em', // 68px
                    fontWeight: '600',
                    color: 'rgba(37, 50, 65, 1)', // azure-20
                    '@media (max-width: 1600px)': {
                        fontSize: '3em', // 48px on medium screens
                    },
                    '@media (max-width: 1400px)': {
                        fontSize: '2.5em', // 40px on smaller screens
                    },
                },
                '.h2': {
                    fontSize: '2.5em', // 40px
                    fontWeight: '600',
                    color: 'rgba(37, 50, 65, 1)', // azure-20
                    '@media (max-width: 1600px)': {
                        fontSize: '2em', // 32px on medium screens
                    },
                    '@media (max-width: 1400px)': {
                        fontSize: '1.5em', // 24px on smaller screens
                    },
                },
                '.post-content h2': {
                    fontSize: '2em', // 40px
                    fontWeight: '600',
                    color: 'rgba(37, 50, 65, 1)', // azure-20
                    '@media (max-width: 1600px)': {
                        fontSize: '2em', // 32px on medium screens
                    },
                    '@media (max-width: 1400px)': {
                        fontSize: '1.5em', // 24px on smaller screens
                    },
                },
                '.h3': {
                    fontSize: '1.375em', // 22px
                    fontWeight: '600',
                    color: 'rgba(34, 34, 34, 1)', // grey-13
                },
                '.h4': {
                    fontSize: '1.125em', // 18px
                    fontWeight: '500',
                    color: 'rgba(34, 34, 34, 1)', // grey-13
                },
            });
        }
    ],

    corePlugins: {
        preflight: false, // Disable Tailwind's default styles (optional)
    },
};
