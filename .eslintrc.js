module.exports = {
  root: true,
  env: {
    browser: true,
    es6: true,
    node: true,
  },
  extends: [
    "airbnb-base",
    "plugin:vue/recommended"
  ],
  parserOptions: {
    parser: 'babel-eslint',
  },
};
