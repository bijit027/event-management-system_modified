let mix = require("laravel-mix");

mix.setPublicPath("assets");
mix.setResourceRoot('../');
mix
  .js("src/main.js", "assets/admin/admin.js")
  // .js('src/frontend/ems_frontend.js', 'assets/frontend/js/ems_frontend.js')
  // .js('src/frontend/bootstrap.min.js', 'assets/Bootstrap/bootstrap.min.js')
  // .css('src/frontend/bootstrap.min.css', 'assets/Bootstrap/bootstrap.min.css')
  // .css('src/frontend/frontend.css', 'assets/frontend/css/frontend.css')
  // .css("src/css/index.css", "assets/elementPlus/index.css")
  .vue({ version: 3 })
  .sourceMaps(false);