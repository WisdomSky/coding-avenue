/**
 * Auto-mapping of all Vue components added inside the ./components directory
 */

((context) => {
    context.keys().forEach((key) => {
        exports[key.replace(/^.*\/([^.]+)\.vue/,'$1')] = context(key)
    });
})(require.context('./../components', true, /^(.*\.(vue))[^.]*$/igm));