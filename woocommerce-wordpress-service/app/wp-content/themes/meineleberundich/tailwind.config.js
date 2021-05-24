const defaultTheme = require('tailwindcss/defaultTheme')

const fontFamily = defaultTheme.fontFamily;
fontFamily['sans'] = [
    'Proxima Nova W02 Regular',
    'sans-serif',
    // <-- you may provide more font fallbacks here
];

module.exports = {
    future : {
        // removeDeprecatedGapUtilities: true,
        // purgeLayersByDefault: true,
    },
    purge : [
        './*.php',
        './**/*.php',
        './src/**/*.js',
        './src/**/*.scss',
    ],
    theme : {
        fontFamily : fontFamily,
        extend : {padding: { "fluid-video": "56.25%" } },
    },
    variants : {},
    plugins : [
        require('tailwindcss-rtl'),
    ],
}
