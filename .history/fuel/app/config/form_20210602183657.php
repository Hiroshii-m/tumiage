<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.8.2
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2019 Fuel Development Team
 * @link       https://fuelphp.com
 */

/**
 * -----------------------------------------------------------------------------
 *  [!] NOTICE
 * -----------------------------------------------------------------------------
 *
 *  If you need to make modifications to the default configuration,
 *  copy this file to your 'app/config' folder, and make them in there.
 *
 *  This will allow you to upgrade FuelPHP without losing your custom config.
 *
 */

return array(
	/**
	 * -------------------------------------------------------------------------
	 *  Regular
	 * -------------------------------------------------------------------------
	 *
	 *  Regular form definitions.
	 *
	 */

	'prep_value'           => true,
	'auto_id'              => true,
	'auto_id_prefix'       => 'form_',
	'form_method'          => 'post',
	'form_template'        => "{open}{fields}{close}",
	'fieldset_template'    => "{open}{fields}{close}",
	'field_template'       => "\t\t<div>\n\t\t\t<label class=\"{error_class}\">{label}{required}</label>\n\t\t\t<span class=\"{error_class}\">{field} <span>{description}</span> {error_msg}</span>\n\t\t</div>\n",
	'multi_field_template' => "\t\t<div>\n\t\t\t<td class=\"{error_class}\">{group_label}{required}</td>\n\t\t\t<td class=\"{error_class}\">{fields}\n\t\t\t\t{field} {label}<br />\n{fields}<span>{description}</span>\t\t\t{error_msg}\n\t\t\t</td>\n\t\t</div>\n",
	'error_template'       => '<span>{error_msg}</span>',
	'group_label'          => '<span>{label}</span>',
	'required_mark'        => '*',
	'inline_errors'        => false,
	'error_class'          => null,
	'label_class'          => null,

	/**
	 * -------------------------------------------------------------------------
	 *  Tabular
	 * -------------------------------------------------------------------------
	 *
	 *  Tabular form definitions.
	 *
	 */

	'tabular_form_template'      => "<table>{fields}</table>\n",
	'tabular_field_template'     => "{field}",
	'tabular_row_template'       => "<tr>{fields}</tr>\n",
	'tabular_row_field_template' => "\t\t\t<td>{label}{required}&nbsp;{field} {error_msg}</td>\n",
	'tabular_delete_label'       => "Delete?",
);
