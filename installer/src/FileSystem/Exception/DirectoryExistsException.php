<?php

namespace Mothership\Install\FileSystem\Exception;

/**
 * Class DirectoryExistsException
 * @package Mothership\Install\FileSystem\Exception
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Exception to flag that a directory already exists and therefore cannot be created
 */
class DirectoryExistsException extends \LogicException
{

}