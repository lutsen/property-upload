<?php

namespace Lagan\Property;

use \Sirius\Upload\Handler as UploadHandler;

/**
 * Controller for the Lagan upload property.
 * Lets the user upload a file. Uses https://github.com/siriusphp/upload
 *
 * A property type controller can contain a set, read, delete and options method. All methods are optional.
 * To be used with Lagan: https://github.com/lutsen/lagan
 */

class Upload {

	/**
	 * The set method is executed each time a property with this type is set.
	 *
	 * @param bean		$bean		The Redbean bean object with the property.
	 * @param array		$property	Lagan model property arrray.
	 * @param string	$new_value
	 *
	 * @return string	If a new file is uploaded it returns the new file path relative to APP_PATH. For validation pusposes, if a new file is not uploaded, it returns the current value.
	 */
	public function set($bean, $property, $new_value) {

		if ( isset( $_FILES[ $property['name'] ] ) && $_FILES[ $property['name'] ]['size'] > 0 ) {

			$uploadHandler = new UploadHandler( APP_PATH.$property['directory'] );

			// Validation
			if ( isset( $property['validate'] ) ) {
				foreach ($property['validate'] as $rule) {
					$uploadHandler->addRule( $rule[0], $rule[1] );
				}
			}

			$result = $uploadHandler->process( $_FILES[ $property['name'] ] );

			if ($result->isValid()) {
				try {

					$result->confirm(); // this will remove the .lock file
					$this->delete($bean, $property); // Delete old file
					return $property['directory'] . '/' . $result->name;

				} catch (\Exception $e) {

					// something wrong happened, we don't need the uploaded files anymore
					$result->clear();
					throw $e;

				}
			} else {

				// File was not moved to the container, where are error messages
				throw new \Exception( 'Upload error. ' . implode( ', ', $result->getMessages() ) );

			}

		} else if ( $bean->{ $property['name'] } ) {

			return $bean->{ $property['name'] };

		}

	}

	/**
	 * The delete method is executed each time a an object with a property with this type is deleted.
	 *
	 * @param bean		$bean		The Redbean bean object with the property.
	 * @param array		$property	Lagan model property arrray.
	 */
	public function delete($bean, $property) {

		// Delete file
		$path = APP_PATH . $property['directory']; // Prevent deleting files outside the upload path
		$file = APP_PATH . $bean->{ $property['name'] };
		if ( file_exists( $file ) && substr( $file, 0, strlen($path) ) == $path ) {
			unlink( $file );
		}

	}

}

?>