<?php

namespace App\Libraries;

use App\Libraries\HttpLibrary;


/**
 * 
 */
class DateLibrary
{

	//'Y-m-d\\TH:i:s.vp'

	public function getDateTime()
	{
		try {
			$httpLibrary = new HttpLibrary();

			$url = 'http://worldtimeapi.org/api/ip';

			$body = $httpLibrary->retrieve($url);
			return json_decode($body->getContents());
		} catch (\Throwable $exception) {
			\Sentry\captureException($exception);
		}
	}

	public function getUtc(): string
	{
		$utc = new \DateTime('now', new \DateTimeZone('UTC'));
		return $utc->format('Y-m-d\\TH:i:s.vp');
	}

	public static function getZoneDateTime()
	{
		// date_default_timezone_get() is set in BaseController
		$utc = new \DateTime('now', new \DateTimeZone(date_default_timezone_get()));
		return $utc->format('Y-m-d\\TH:i:s.vp');
	}

	public static function getFormat($utc)
	{
		if (!is_null($utc)) {
			$dateTime = new \DateTime($utc);
			return $dateTime->format('l, d F Y H:i A');
		}
	}

	public static function formatTimestamp($timestamp)
	{
		if (!is_null($timestamp)) {
			$dateTime = new \DateTime();
			$dateTime->setTimestamp($timestamp);
			return $dateTime->format('l, d F Y H:i A');
		}
	}

	public static function toTimestamp($utc)
	{
		if (!is_null($utc)) {
			return strtotime($utc);
		}
	}

	public static function getDate($utc)
	{
		if (!is_null($utc)) {
			$dateTime = new \DateTime($utc);
			return $dateTime->format('l, d F Y');
		}

	}

	public static function getMysqlDate($utc)
	{
		if (!is_null($utc)) {
			$dateTime = new \DateTime($utc);
			return $dateTime->format('Y-m-d');
		}

	}

}