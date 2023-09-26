const cards = document.querySelectorAll('.card');

function getDominantColor(imgEl) {
	var blockSize = 5, // only visit every 5 pixels
		defaultRGB = { r: 0, g: 0, b: 0 }, // for non-supporting envs
		canvas = document.createElement('canvas'),
		context = canvas.getContext && canvas.getContext('2d'),
		data,
		width,
		height,
		i = -4,
		length,
		rgb = { r: 0, g: 0, b: 0 },
		count = 0;

	if (!context) {
		return defaultRGB;
	}

	height = canvas.height = imgEl.naturalHeight || imgEl.offsetHeight || imgEl.height;
	width = canvas.width = imgEl.naturalWidth || imgEl.offsetWidth || imgEl.width;

	context.drawImage(imgEl, 0, 0);

	try {
		data = context.getImageData(0, 0, width, height);
	} catch (e) {
		/* security error, img on diff domain */
		return defaultRGB;
	}

	length = data.data.length;

	while ((i += blockSize * 4) < length) {
		++count;
		rgb.r += data.data[i];
		rgb.g += data.data[i + 1];
		rgb.b += data.data[i + 2];
	}

	// ~~ used to floor values
	rgb.r = ~~(rgb.r / count);
	rgb.g = ~~(rgb.g / count);
	rgb.b = ~~(rgb.b / count);

	return rgb;
}

cards.forEach((card) => {
	const tempImg = new Image();
	const bgImg = card.style.backgroundImage.slice(4, -1).replace(/"/g, '');
	tempImg.src = bgImg;
	tempImg.addEventListener('load', function () {
		const color = getDominantColor(tempImg);
		const cardFilter = card.querySelector('.card__filter');
		cardFilter.style.background = `linear-gradient(180deg, 
			rgba(${color.r}, ${color.g}, ${color.b}, 0) 0%, 
			rgba(${color.r}, ${color.g}, ${color.b}, 0) 50%, 
			rgba(${color.r}, ${color.g}, ${color.b}, 0.9) 60%, 
			rgba(${color.r}, ${color.g}, ${color.b}, 1) 100%)`;
		// Base on the color, we can change the text color to white or black
		const cardProjectType = card.querySelector('.project__type'),
			cardProjectTitle = card.querySelector('.project__title'),
			cardProjectDescription = card.querySelector('.project__description'),
			cardContentKeywords = card.querySelector('p');

		if (color.r + color.g + color.b > 400) {
			cardProjectType.style.color = '#000';
			cardProjectTitle.style.color = '#000';
			cardProjectDescription.style.color = '#000';
			cardContentTitle.style.color = '#000';
			cardContentKeywords.style.color = '#000';
		}
	});
});
