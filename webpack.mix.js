let mix = require("laravel-mix");

mix.setPublicPath("assets");
mix.setResourceRoot('../');
mix
  .js("src/main.js", "assets/Admin/admin.js")
  .js('src/frontend/ems_frontend.js', 'assets/js/ems_frontend.js')
  // .js('src/frontend/bootstrap.min.js', 'assets/Bootstrap/bootstrap.min.js')
  .css('src/frontend/bootstrap.min.css', 'assets/Bootstrap/bootstrap.min.css')
  .css("src/css/index.css", "assets/ElementPlus/index.css")
  .vue({ version: 3 })
  .sourceMaps(false);