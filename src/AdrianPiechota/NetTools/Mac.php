<?php

namespace AdrianPiechota\NetTools;

/**
 * A simple class for converting MAC addresses to integers and back (eg. for
 * storage purposes etc.)
 *
 * @author Adrian Piechota <adrian.piechota@yahoo.com>
 * @version 1.0
 * @copyright Copyright (c) 2016, Adrian Piechota
 * @license MIT License (see LICENSE file)
 */
class Mac
{
	
	// MAC is EUI-48 or MAC-48 format
	const EUI48 = 48;
	
	// MAC id EUI-64 format
	const EUI64 = 64;

	// Mask for muslitcast bit switch
	const MULTICAST   = 0b00000001;
	
	// Mask for locally administrated bit switch
	const LOCALLY_ADM = 0b00000010;

	
	/**
	 * Storeg MAC address
	 * @var int
	 */
	protected $mac;
	
	/**
	 * Address length, either 48 or 64 bits
	 * @var int
	 */
	protected $type;
	

	/**
	 * Constructs class
	 * @param  string|int $mac  MAC address either as string or integer
	 * @params int        $type Address length, either EUI48 or EUI48
	 */
	public function __construct($mac, $type = Mac::EUI48)
	{
		// If MAC is integer or numeric string
		if (is_int($mac) || is_numeric($mac)) {
			$this->mac = (int) $mac;
		
		// If mac is string
		} else {			
			$this->mac = $this->mac2long($mac);
		}
		
		$this->type = $type;
	}


	public function __toString()
	{
		return $this->toString();
	}


	/**
	 * Returns MAC format type
	 * @returns int
	 */
	public function getType()
	{
		return $this->type;
	}


	/**
	 * Returns MAC as string (eg. 01:23:45:67:89:ab or 01-23-45-67-89-ab)
	 * @param  string $separator Group separator
	 * @returns string
	 */
	public function toString($separator = ':')
	{
		return $this->long2mac($this->mac, $this->type, $separator);
	}


	/**
	 * Returns MAC in dot format (e.g. 0123.4567.89ab)
	 * @returns string
	 */
    public function toDotFormat()
    {
		$mac = $this->long2mac($this->mac, $this->type, '');
		return implode('.', str_split($mac, 4));
    }


	/**
	 * Retuns MAC as binary string
	 * @return string
	 */
	public function toBin()
	{
		return sprintf('%0'. $this->type .'b', $this->mac);
	}


	/**
	 * Returns MAC as decimal number
	 * @returns int
	 */
	public function toDec()
	{
		return $this->mac;
	}


	/**
	 * Converts MAC to integer
	 * @param string $mac
	 * @returns int
	 */
	public function mac2long($mac)
	{
		$parts = str_split(str_replace([':', '-', '.'], '', $mac), 2);
		$mac = 0;
		foreach ($parts as $part) {
			$mac = $mac << 8 | hexdec($part);
		}
		return $mac;
	}


    /**
     * Converts integer to MAC address
     * @param string $long
     * @param int    $type
     * @returns string
     */
	public function long2mac($long, $type = Mac::EUI48, $separator = ':')
	{
		$mac = [];
		$bytes = $type / 8;
		while ($bytes--) {
			$part = ord(chr($long >> (8 * $bytes)));
			$mac[] = sprintf('%02x', $part);
		}
		return implode($separator, $mac);
	}


	/**
	 * Returns if MAC is multicast (true) or unicast (false)
	 * @returns bool
	 */
	public function isMulticast()
	{
		return ($this->getMostSignificantByte() & static::MULTICAST) === static::MULTICAST;
	}


	/**
	 * Returns if MAC is locally administrated (true) or OUI enforced (false)
	 * @returns bool
	 */
	public function isLocallyAdministrated()
	{
		return ($this->getMostSignificantByte() & static::LOCALLY_ADM) === static::LOCALLY_ADM;
	}


	protected function getMostSignificantByte()
	{
		return $this->mac >> ($this->type - 8);
	}

}
