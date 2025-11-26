(function (global) {
    const translations = global.i18n || {};

    function get(obj, path) {
        return path
            .split(".")
            .reduce(
                (o, k) => (o && o[k] !== undefined ? o[k] : undefined),
                obj
            );
    }

    function replacePlaceholders(str, replacements) {
        if (!replacements) return str;
        return str.replace(/:([a-zA-Z0-9_]+)/g, (m, key) => {
            return replacements[key] !== undefined ? replacements[key] : m;
        });
    }

    window.__ = function (key, replacements) {
        let val = get(translations, key);

        if (val === undefined && translations.__json) {
            val = translations.__json[key];
        }

        if (val === undefined) {
            return key;
        }

        if (typeof val === "string") {
            return replacePlaceholders(val, replacements);
        }

        return JSON.stringify(val);
    };
})(window);
