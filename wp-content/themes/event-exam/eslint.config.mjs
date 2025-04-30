import js from "@eslint/js";
import css from "@eslint/css";
import globals from "globals";
import { defineConfig } from "eslint/config";

export default defineConfig([
  {
    files: ["**/*.{js,mjs,cjs}"],
    languageOptions: {
      ecmaVersion: 2022,
      sourceType: "module",
      globals: globals.browser,
    },
    plugins: {
      js,
    },
    rules: {
      ...js.configs.recommended.rules,
      "semi": ["error", "always"], // Require semicolons
      "no-multiple-empty-lines": ["warn", { "max": 1 }], // Limit empty lines to 1
      "eqeqeq": ["error", "always"], // Enforce `===` instead of `==`
      "no-console": ["warn", { "allow": ["warn", "error"] }], // Warn on console.log, allow console.warn/error
      "no-unused-vars": ["warn", { "argsIgnorePattern": "^_" }], // Warn about unused vars, but allow `_` prefix
      "no-var": "error", // Disallow `var`, enforce `let` or `const`
      "prefer-const": "error", // Require `const` when a variable is never reassigned
      "no-undef": "off", // ✅ Fix false "console is not defined" error
      "no-redeclare": "error", // Prevent redeclaring variables
      "no-extra-semi": "error", // Disallow unnecessary semicolons
      "prefer-template": "warn", // Suggest using template literals instead of string concatenation
      "arrow-body-style": ["warn", "as-needed"], // Enforce concise arrow function bodies
      "no-duplicate-imports": "error", // Prevent duplicate imports
    },
  },
  {
    files: ["**/*.css"],
    languageOptions: {
      parser: "css",
    },
    plugins: {
      css,
    },
    rules: {
      ...css.configs.recommended.rules,
    },
  },
]);
