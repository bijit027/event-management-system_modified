let mix = require("laravel-mix");

mix.setPublicPath("assets");
mix.setResourceRoot('../');
mix
  .js("src/main.js", "assets/admin/admin.js")
  // .js("src/public/bootstrap/bootstrap.min.js", "assets/bootstrap/bootstrap.min.js")
  .css("src/public/bootstrap/bootstrap.min.css", "assets/bootstrap/bootstrap.min.css")
  .css("src/public/elementPlus/index.css", "assets/elementPlus/index.css")
  // .css("src/public/fontawesome/all.min.css", "assets/fontawesome/all.min.css")
  .css("src/public/frontend/css/frontend.css", "assets/frontend/css/frontend.css")
  .js("src/public/frontend/js/ems_frontend.js", "assets/frontend/js/ems_frontend.js")
  .vue({ version: 3 })
  .sourceMaps(false);