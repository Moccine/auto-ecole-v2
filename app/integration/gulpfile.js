let gulp;
gulp = require('gulp');
const mjml = require('gulp-mjml');


let plugins = require('gulp-load-plugins')({
  'config': require('./package.json'),
  'pattern': ['*'],
  'scope': ['dependencies','devDependencies']
});

// Optional
gulp.task('iconfont', require('./tasks/iconfont')(gulp, plugins));

gulp.task('mjml', function () {
  return gulp.src('./mail/mail.mjml')
    .pipe(mjml())
    .pipe(gulp.dest('./mail/html'))
});

gulp.task('watch:iconfont', function () {
  gulp.watch('./fonts/iconfont/*.svg', gulp.series('iconfont'));
});

gulp.task('watch:mail', function() {
    gulp.watch('./mail/mail.mjml', gulp.series('mjml'));
});


gulp.task('watch', gulp.parallel( 'watch:iconfont'));

gulp.task('default', gulp.parallel('iconfont'));
