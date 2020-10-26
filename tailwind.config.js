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
                },
            },
            screens: {
                lg: '1100px',
                xl: '1100px',
            },
        },
    },
    variants: {},
    plugins: []
}
