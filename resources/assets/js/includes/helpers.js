/**
 * Created by webdev on 6/2/2017.
 */
((context) => {
    context.keys().forEach((key) => {
        const imp = context(key);
        exports[key.replace(/^.*\/([^.]+)\.js/,'$1')] = imp.default && imp.__esModule ? imp.default : imp;
    });
})(require.context('./../helpers', true, /^(.*\.(js))[^.]*$/igm));