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
                    lighter: '#E0E0E0',
                    light: '#BBBBBB',
                    dark: '#2D2D2D',
                },
                black: {
                    dark: '#000000',
                },
                theme: {
                    primary: '#FF7D12',
                    dark: '#b35708'
                },
            },
            screens: {
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
            },
            maxHeight: {
                '300': '300px',
                '400': '400px',
            },
            zIndex: {
                overlay: 100,
            }
        },
    },
    variants: {},
    plugins: []
}
