const gulp          = require('gulp');
const rename        = require('gulp-rename');
const uglify        = require('gulp-uglify');
const sass          = require('gulp-sass');
const autoprefixer  = require('gulp-autoprefixer');
const plumber       = require('gulp-plumber');
const sourcemaps    = require('gulp-sourcemaps');
const colors        = require('ansi-colors');
const wait          = require('gulp-wait');
const notify        = require("gulp-notify");
const babel         = require("gulp-babel");
const concat        = require("gulp-concat");
const browserify    = require('browserify');
const babelify      = require('babelify');
const watchify      = require('watchify');
const buffer        = require('vinyl-buffer');
const source        = require('vinyl-source-stream');
const path          = require('path');
const through2      = require('through2');

function showError(err) {

    notify.onError({
        title: "Gulp error in " + err.plugin,
        message:  err.message
    })(err);

    //console.log(colors.red(err.toString())  );
    this.emit('end');
}

function compile(watch) {
    var bundler = watchify(browserify('js/app.js', {debug: true}).transform(babelify, {
        // Use all of the ES2015 spec
        presets: ["@babel/env"],
        sourceMaps: true
    }));

    function rebundle() {
        return bundler
            .bundle()
            .on('error', function (err) {
                console.error(err);
                this.emit('end');
            })
            .pipe(source('js/app.js'))
            .pipe(buffer())
            .pipe(rename('app.min.js'))
            .pipe(sourcemaps.init({loadMaps: true}))
            .pipe(uglify())
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest('../wp-content/themes/taurus/assets/js'));
    }

    if (watch) {
        bundler.on('update', function () {
            console.log('-> bundling...');
            rebundle();
        });

        rebundle();
    } else {
        rebundle().pipe(exit());
    }
}

gulp.task('sass', function () {
    return gulp.src('./sass/style.scss')
        .pipe(wait(500))
        .pipe(plumber({
            errorHandler : showError
        }))
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle : 'compressed'
        }))
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
        }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('../wp-content/themes/taurus'));
});

gulp.task('sass-components', function () {
    return gulp.src('./sass/blocks/*.scss')
        .pipe(plumber({
            errorHandler: showError
        }))
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
        }))
        .pipe(rename(function(file) {
            let filename = file.basename; // get the filename without extension
            file.dirname = path.join('blocks', filename);
            file.basename = filename;  // use the original filename instead of 'style'
        }))
        .pipe(sourcemaps.write('.', {
            includeContent: false,
            sourceRoot: '.'
        }))
        .pipe(gulp.dest('../wp-content/themes/taurus'));
});

function watch() {
    return compile(true);
}

gulp.task('build', function () {
    return compile();
});

gulp.task('watch', function () {
    gulp.watch('./sass/**/*.scss', ['sass']);
    gulp.watch('./sass/blocks/*.scss', ['sass-components']);
    return watch();
    // gulp.watch('./js/*.js', ['js']);
});

gulp.task('default', function () {
    console.log(colors.bold(colors.yellow('----- rozpoczyam pracę ------')));
    gulp.start(['watch']);
});
