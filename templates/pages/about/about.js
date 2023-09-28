import { MAPBOX_API_KEY } from '../../../config/config.local.js';
// Uncomment this line to use the production API key:
// import { MAPBOX_API_KEY } from '../../config/config.js';

var slideDelay = 5;
var slideDuration = 1;

var slides = document.querySelectorAll('.slide');

for (var i = 0; i < slides.length; i++) {
	TweenLite.set(slides[i], {
		backgroundImage: `url(https://source.unsplash.com/300x330/?nature,water,${i})`,
		xPercent: i * 100,
	});
}

var wrap = wrapPartial(-100, (slides.length - 1) * 100);
var timer = TweenLite.delayedCall(slideDelay, autoPlay);
var animation = null;

function animateSlides(delta) {
	animation = TweenMax.to(slides, slideDuration, {
		xPercent: function (i, target) {
			return Math.round(target._gsTransform.xPercent / 100) * 100 + delta;
		},
		modifiers: {
			xPercent: wrap,
		},
		onComplete: restartTimer,
	});
}

function autoPlay() {
	if (!animation) {
		animateSlides(-100);
	}
}

function restartTimer() {
	if (animation === this) {
		animation = null;
		timer.restart(true);
	}
}

function wrapPartial(min, max) {
	var r = max - min;
	return function (value) {
		var v = value - min;
		return ((r + (v % r)) % r) + min;
	};
}

mapboxgl.accessToken = MAPBOX_API_KEY;
var map = new mapboxgl.Map({
	container: 'map',
	style: 'mapbox://styles/mapbox/streets-v12',
	zoom: 2.5,
	center: [3, 52.5],
});

map.addControl(new mapboxgl.NavigationControl());

map.on('load', function () {
	map.addSource('route', {
		type: 'geojson',
		data: {
			type: 'Feature',
			properties: {
				color: '#44a0e7',
			},
			geometry: {
				type: 'LineString',
				coordinates: [
					[1.261105, 45.835649],
					[18.068581, 59.329323],
				],
			},
		},
	});

	map.addLayer({
		id: 'route',
		type: 'line',
		source: 'route',
		layout: {
			'line-join': 'round',
			'line-cap': 'round',
		},
		paint: {
			'line-color': '#44a0e7',
			'line-width': 6,
		},
	});
});
