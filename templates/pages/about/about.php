<?php

require_once __DIR__ . '/../../../config/config.local.php';

$curl = curl_init();


curl_setopt_array($curl, [
	CURLOPT_URL => "https://ipgeolocation.abstractapi.com/v1/?api_key=" . IPGEOLOC_API_KEY,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
]);

// We store the response in a variable

$response = curl_exec($curl);
$response = json_decode($response);
$city = $response->city;
$region = $response->region;
$country = $response->country;
$err = curl_error($curl);


// We now can request weatherapi.com with the city we got from the previous request

curl_setopt_array($curl, [
	CURLOPT_URL => "http://api.weatherapi.com/v1/forecast.json?key=" . WEATHERAPI_API_KEY .  "&q=$city&days=7&aqi=no&alerts=no",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
]);

$weatherApiResponse = curl_exec($curl);
$weatherApiResponse = json_decode($weatherApiResponse);
$err = curl_error($curl);

curl_close($curl);

// We store the response in a variable

$today = $weatherApiResponse->current;
$todayTemp = $today->temp_c;
$todayWeather = $today->condition->text;
$todayWeatherIcon = $today->condition->icon;
$todayHigh = $today->temp_c;
$todayLow = $today->temp_c;

// We store the forecast in a variable

$forecast = $weatherApiResponse->forecast;

?>

<section class="about__container">
	<div class="top"></div>
	<main>
		<div class="first_row">
			<div class="music card">
				<iframe allow="autoplay *; encrypted-media *;" frameborder="0""
					sandbox=" allow-forms allow-popups allow-same-origin allow-scripts allow-storage-access-by-user-activation allow-top-navigation-by-user-activation" src="https://embed.music.apple.com/us/playlist/replay-2023/pl.rp-nWWEH6yxkJGv"></iframe>
			</div>
			<div id="map" class="map card">
				<img src="../../src/lib/imgs/map_directions.webp" alt="Directions from Limoges to Stockholm" />
			</div>
			<div class="infos card">
				<h2>Sébastien P.</h2>
				<h3>Junior Full-Stack Developer</h3>
				<br />
				<p>Hi, I'm Sébastien, a junior full-stack developer based in France but planning to relocate
					inStockholm, Sweden. I enjoy creating things that live on the internet, whether that be websites,
					applications, or anything in between. My goal is to always build products that provide
					pixel-perfect, performant experiences.</p>
				<div class="social">
					<ul>
						<li><a href="https://github.com/Anoerak" target=”_blank”><img src="../../../src/lib/imgs/github.webp" alt="Letter F in white on blue background" />Github</a></li>
						<li><a href="https://gitlab.com/Anoerak" target=”_blank”><img src="../../../src/lib/imgs/gitlab.webp" alt="White minimal camera logo on Reddish rainbow background" />GitLab</a></li>
						<li><a href="https://www.linkedin.com/in/s%C3%A9bastien-p-48717074/" target=”_blank”><img src="../../../src/lib/imgs/Linkedin_logo.webp" alt="White X letter on dirty black background" />Linkedin</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="second_row">
			<div class="photos card">
				<div class="slide"></div>
				<div class="slide"></div>
				<div class="slide"></div>
				<div class="slide"></div>
				<div class="slide"></div>
				<div class="slide"></div>
				<div class="slide"></div>
				<div class="slide"></div>
				<div class="slide"></div>
				<div class="slide"></div>
				<div class="slide"></div>
			</div>
			<div class="education card">
				<div class="title">
					<img src="../../src/lib/imgs/education.webp" alt="Student hat on yellowish background">
					<h2>Education</h2>
				</div>

				<div class="education__subcontainer">
					<div class="education__subcontainer__item">
						<h3>CLEF - Cambridge University</h3>
						<p>TOEIC English</p>
						<span>990/990 (C1)</span>
						<p>2023</p>
					</div>
					<div class="education__subcontainer__item">
						<h3>OpenClassrooms</h3>
						<p>Bachelor's degree in Computer Science</p>
						<span>PHP & Symfony</span>
						<p>2023</p>
					</div>
					<div class="education__subcontainer__item">
						<h3>OpenClassrooms</h3>
						<p>Bachelor's degree in Computer Science</p>
						<span>JS & React</span>
						<p>2022</p>
					</div>
					<div class="education__subcontainer__item">
						<h3>OpenClassrooms</h3>
						<p>University's degree in Computer Science</p>
						<span>HTML5 - CSS3 - JS - Node - Express <br /> MongoDB - MySQL - Vue</span>
						<p>2021</p>
					</div>
				</div>
			</div>

			<div class="weather card">
				<div class="top">
					<div class="left">
						<div class="left__city">
							<?php if ($city) {
								echo $city;
							} else {
								echo "error";
							} ?>
						</div>
						<div class="left__today__temp">
							<?php if ($todayTemp) {
								echo $todayTemp;
							} else {
								echo "error";
							} ?>°C
						</div>
					</div>
					<div class="right">
						<div class="right__today__weather__icon">
							<img src="<?php if ($todayWeatherIcon) {
											echo $todayWeatherIcon;
										} else {
											echo "error";
										} ?>" alt="Weather icon" />
						</div>
						<div class="right__today__weather">
							<?php if ($todayWeather) {
								echo $todayWeather;
							} else {
								echo "error";
							} ?>
						</div>
						<div class="right__today__max__min">
							<div class="right__max">H:<span class="today__high">
									<?php if ($todayHigh) {
										echo $todayHigh;
									} else {
										echo "error";
									} ?>
								</span>
							</div>
							<div class="right__min">L:<span class="today__low">
									<?php if ($todayLow) {
										echo $todayLow;
									} else {
										echo "error";
									} ?>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="bottom">
					<!-- We get the forecast for the next 5hours -->
					<?php
					// We get the timezone from the response
					$timezone = $weatherApiResponse->location->tz_id;
					// We set the timezone
					date_default_timezone_set($timezone);
					// We get the current hour + 1
					$now = date("H") + 1;
					// We get the forecast for the next 5 hours
					$forecastHour = array_slice($forecast->forecastday[0]->hour, $now, 5);
					// We check how many hours we have
					$forecastHourCount = count($forecastHour);
					// If we have less than 5 hours, we get the missing hours from the next day
					if ($forecastHourCount < 5) {
						$forecastHour = array_merge($forecastHour, $forecast->forecastday[1]->hour);
						$forecastHour = array_slice($forecastHour, 0, 5);
					}

					?>
					<?php foreach ($forecastHour as $hour) : ?>
						<div class="bottom__hour">
							<div class="bottom__hour__time">
								<?=
								substr($hour->time, 11, 2);
								?>
							</div>
							<div class="bottom__hour__icon">
								<img src="<?= $hour->condition->icon ?>" alt="Weather icon" />
							</div>
							<div class="bottom__hour__temp">
								<?=
								round($hour->temp_c);
								?>°C
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<div class="third__row">
			<img src="https://streak-stats.demolab.com?user=Anoerak&theme=light&mode=weekly&hide_border=true" />
			<img src="https://github-readme-stats-git-main-anoerak.vercel.app/api?username=Anoerak&count_private=true&show_icons=true&border_radius=11&hide_border=true" />
		</div>
	</main>
	<div class="bottom"></div>
</section>
