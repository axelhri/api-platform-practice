<?php

namespace App\Enum;

class OaFormats
{
	/**
	 * Floating-point numbers.
	 */
	public const NUMBER_FLOAT = 'float';

	/**
	 * Floating-point numbers with double precision.
	 */
	public const NUMBER_DOUBLE = 'double';

	/**
	 * Signed 32-bit integers (commonly used integer type).
	 */
	public const INTEGER_32BIT = 'int32';

	/**
	 * Signed 64-bit integers (long type).
	 */
	public const INTEGER_64BIT = 'int64';

	/**
	 * full-date notation as defined by RFC 3339, section 5.6, for example, 2017-07-21.
	 */
	public const STRING_DATE = 'date';

	/**
	 * the date-time notation as defined by RFC 3339, section 5.6, for example, 2017-07-21T17:32:28Z.
	 */
	public const STRING_DATETIME = 'date-time';

	/**
	 * a hint to UIs to mask the input.
	 */
	public const STRING_PASSWORD = 'password';

	/**
	 * base64-encoded characters, for example, U3dhZ2dlciByb2Nrcw==.
	 */
	public const STRING_BYTE = 'byte';

	/**
	 * binary data, used to describe files (see Files below).
	 */
	public const STRING_BINARY = 'binary';

	public const EMAIL = 'email';
	public const UUID = 'uuid';
	public const URI = 'uri';
	public const HOSTNAME = 'hostname';
	public const IPV4 = 'ipv4';
	public const IPV6 = 'ipv6';
}
