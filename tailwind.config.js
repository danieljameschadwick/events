module.exports = {
    future: {
        // removeDeprecatedGapUtilities: true,
        // purgeLayersByDefault: true,
        // defaultLineHeights: true,
        // standardFontWeights: true
    },
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
                    dark: '#2a2a2a',
                    darkest: '#000000',
                },
                theme: {
                    primary: '#FF7D12',
                    dark: '#b35708'
                },
            },
            height: {
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
                '300': '300px',
                '400': '400px'
            },
            maxHeight: {
                '300': '300px',
                '400': '400px',
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
