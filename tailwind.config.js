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
            borderRadius: {
                xl: '0.9rem',
            }
        },
    },
    variants: {},
    plugins: []
}
