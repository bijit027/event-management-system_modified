let mix = require("laravel-mix");

mix.setPublicPath("assets");
mix.setResourceRoot('../');
mix
  .js("src/main.js", "assets/Admin/admin.js")
  .css("src/css/index.css", "assets/ElementPlus/index.css")
  .vue({ version: 3 })
  .sourceMaps(false);