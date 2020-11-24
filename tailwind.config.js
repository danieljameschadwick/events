module.exports = {
    darkMode: 'class',
    purge: [],
    theme: {
        extend: {
            borderRadius: {
                xl: '0.9rem',
            },
            colors: {
                gray: {
                    lightest: '#efefef',
                    lighter: '#E0E0E0',
                    light: '#BBBBBB',
                    dark: '#2D2D2D',
                },
                black: {
                    base: '#000000',
                    darkest: '#000000',
                    dark: '#2a2a2a',
                },
                theme: {
                    primary: '#FF7D12',
                    dark: '#b35708'
                },
            },
            height: {
                100: '100px',
                200: '200px',
                250: '250px',
                300: '300px',
                400: '400px',
            },
            screens: {
                xs: '420px',
                lg: '1100px',
                xl: '1100px',
            },
            margin: {
                '60': '60px',
                '75': '75px',
            },
            minHeight: {
                '25': '25px',
                '60': '60px',
                '175': '175px',
                '200': '200px',
                '300': '300px',
                '400': '400px',
                '500': '500px'
            },
            maxHeight: {
                '300': '300px',
                '400': '400px',
            },
            maxWidth: {
                'page': '2000px',
            },
            zIndex: {
                base: 0,
                content: 5,
                overlay: 100,
            }
        },
    },
    variants: {},
    plugins: []
}
