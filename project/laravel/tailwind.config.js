const { width } = require("tailwindcss/defaultTheme");
const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    mode: "jit",
    purge: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        placeholderColor: {
            primary: "#A6A6A6",
            focus: "#3E3E3E",
            disabled: "#A6A6A6",
            danger: "#e3342f",
        },

        extend: {
            colors: {
                primary: {
                    primarygreen: "#40C173",
                    secondarygrey: "#646F79",
                    secondarydisabled: "rgba(100,111,121,0.5)",
                    circleone: "rgba(2, 131, 53, 0.11)",
                    circletwo: "rgba(60, 168, 103, 0.57)",
                    circlethree: "rgba(255, 255, 255, 0.22)",
                    othersignin: "#F8F9FA",
                    othersignintext: "#505D6F",
                    disabledbutton: "rgba(100, 111, 121, 0.25)",
                    disabledbuttontext: "rgba(100, 111, 121, 0.5)",
                    pressedbutton: "rgba(60, 168, 103, 1)",
                    DEFAULT: "#1B8FFF",
                    dark: "#0B7FEF",
                    disabled: "#DDDDDD",
                    disabledText: "#A6A6A6",
                    text: "rgba(89, 89, 89, 0.7)",
                    textDark: "#3E3E3E",
                    error: "#FF392B",
                    sidepanelbg: "rgba(244, 244, 245, 0.5)",
                    logoutofothersessions: "#353D3D",
                },

                error: "#FF392B",

                white: "#ffffff",

                secondary: {
                    DEFAULT: "#595959",
                },
            },

            fontFamily: {
                sans: ["Mulish", ...defaultTheme.fontFamily.sans],
            },

            fontSize: {
                body: "14px",
                account: "12px",
                "small-subtitle": "18px",
                subtitle: "16px",
                title: "24px",
            },

            borderRadius: {
                DEFAULT: "12px",
            },

            borderWidth: {
                DEFAULT: "1px",
                0: "0",
                2: "2px",
                3: "3px",
                4: "4px",
                6: "6px",
                8: "8px",
            },

            borderRadius: {
                none: "0",
                sm: "8px",
                DEFAULT: "12px",
                large: "16px",
            },
            height: {
                circleheight: "100vh",
                input: "46px",
            },
            width: {
                circlewidth: "100vh",
            },            
        },
    },

    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
    ],
};
