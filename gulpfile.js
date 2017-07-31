var gulp        	= require('gulp')
,   appData 		= require('./package')
,   imagemin 		= require('gulp-imagemin')
, 	sourcemaps  	= require('gulp-sourcemaps')
,	uglify      	= require('gulp-uglify')
,	rename      	= require('gulp-rename')
,	cleanCSS 		= require('gulp-clean-css')
// ,   scss            = require('gulp-sass')
,   autoPrefixer    = require('gulp-autoprefixer')
,   sourcemaps      = require('gulp-sourcemaps')
// ,   concat          = require('gulp-concat')
,   pxtorem         = require('gulp-pxtorem')
,	gulpUtil 		= require('gulp-util');


gulp.task('default', [
	'js',
	// 'css',
	'watch'
	]);

gulp.task('js', ()=>{
	gulp.src(appData.workPath + '/js/core/**/*.js')
		.pipe(sourcemaps.init())
		.pipe(uglify().on('error', gulpUtil.log))
		.pipe(rename({
	      suffix: '.min'
	    }))
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest(appData.workPath + '/js/_build/'));
});

gulp.task('images', () => {    
    gulp.src(appData.workPath + '/img-full/**/*')
        .pipe(imagemin())
        .pipe(gulp.dest(appData.workPath + '/img/'));
});

gulp.task('css', function() {
  	gulp.src(appData.workPath + '/css/*.css')
  		.pipe(sourcemaps.init())        
	    .pipe(cleanCSS()) 
	    .pipe(autoPrefixer())
	    .pipe(rename({
	      suffix: '.min'
	    }))
	    .pipe(sourcemaps.write('./'))
	    .pipe(gulp.dest(appData.workPath + '/css/'));
});

gulp.task('watch', function(){
    gulp.watch(appData.workPath + '/js/core/**/*.js',['js']);
});