<?php

namespace Example\Weather;

use PhpOption\Option;

class WeatherClient
{
	public function currentWeather(): Option
	{
		return Option::fromValue(null);
	}
}
