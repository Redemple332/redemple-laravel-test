const { defineConfig } = require("@vue/cli-service");
module.exports = defineConfig({
    transpileDependencies: true,
    css: {
        loaderOptions: {
            less: {
                lessOptions: {
                    modifyVars: {
                        "primary-color": "#F69A22",
                        "link-color": "#F69A22",
                        "text-color": "#2E384D",
                        "error-color": "#F04723",
                        "border-radius-base": "10px",
                        "layout-body-background": "#EBF1F4",
                        "layout-header-background": "#FFF",
                        "layout-sider-background": "#00aed3",
                        "menu-dark-bg": "#00aed3",
                        "menu-dark-item-active-bg": "rgba(255, 255, 255, 0.25)",
                        "menu-dark-inline-submenu-bg": "#00698C",
                        "label-color": "#8798AD",
                        "form-item-label-font-size": "12px",
                        "layout-header-color": "#3E3E40",
                    },
                    javascriptEnabled: true,
                },
            },
        },
    },
});
