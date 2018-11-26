module.exports = {
    parserOptions: {
        parser: 'babel-eslint'
    },
    extends: [
        'plugin:vue/recommended',
        'standard'
    ],
    plugins: [
        'vue'
    ],
    rules: {
        'semi': 'off',
        'no-new': 'off',
        'eol-last': 'off',
        'spaced-comment': 'off',
        'object-curly-spacing' : 'off',
        'indent': ['off', 4],
        'vue/script-indent': [
            'error',
            4,
            { 'baseIndent': 1 }
        ],
        'vue/html-indent': [
            'error',
            4
        ],
    }
};