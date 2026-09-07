/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                background: '#070D18', // Regulatory Slate 900 (Main Background)
                panel: '#0F2038',      // Primary Command Slate
                workspace: '#0B1526',  // Regulatory Slate 800
                accent: {
                    DEFAULT: '#0D7A5F',
                    bright: '#10B981',
                },
                safety: {
                    emerald: '#0D7A5F',
                    bright: '#10B981',
                },
                caution: {
                    amber: '#D97706',
                    bright: '#F59E0B',
                },
                regulatory: {
                    900: '#070D18',
                    800: '#0B1526',
                    700: '#0F2038',
                },
                'border-grid': {
                    DEFAULT: '#1E324E',
                    subtle: '#142338',
                },
                'text-primary': '#F1F5F9',
                'text-secondary': '#94A3B8',
                'text-tertiary': '#64748B',
                whatsapp: {
                    DEFAULT: '#25D366',
                    direct: '#25D366',
                },
                surface: {
                    DEFAULT: '#0d131f',
                    dim: '#0d131f',
                    bright: '#333946',
                    container: '#1a202b',
                    'container-lowest': '#080e19',
                    'container-low': '#161c27',
                    'container-high': '#242a36',
                    'container-highest': '#2f3541',
                },
            },
            fontFamily: {
                space: ['"Space Grotesk"', 'sans-serif'],
                display: ['"Space Grotesk"', 'sans-serif'],
                heading: ['"Space Grotesk"', 'sans-serif'],
                sans: ['"IBM Plex Sans"', 'sans-serif'],
                body: ['"IBM Plex Sans"', 'sans-serif'],
            },
            borderRadius: {
                none: '0px',
                sm: '0px',
                DEFAULT: '0px',
                md: '0px',
                lg: '0px',
                xl: '0px',
                '2xl': '0px',
                '3xl': '0px',
                full: '0px',
            },
            boxShadow: {
                none: 'none',
                DEFAULT: 'none',
                sm: 'none',
                md: 'none',
                lg: 'none',
                xl: 'none',
                '2xl': 'none',
                inner: 'none',
            },
        },
    },
    plugins: [],
};
