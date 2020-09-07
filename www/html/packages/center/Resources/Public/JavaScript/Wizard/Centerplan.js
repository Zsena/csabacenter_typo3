/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Module: TYPO3/CMS/Center/Wizard/Centerplan
 * Centerplan JavaScript
 */
define(['jquery'], function ($) {
	'use strict';

	/**
	 *
	 * @type {{options: {}}}
	 * @exports TYPO3/CMS/Center/Wizard/Centerplan
	 */
	var Centerplan = {
		options: {}
	};

	/**
	 *
	 * @param {Object} options
	 */
	Centerplan.setFieldChangeFunctions = function(options) {
		Centerplan.options = options;
	};

	/**
	 *
	 */
	Centerplan.initializeEvents = function() {

        if(Centerplan.options.usedPositions !== undefined) {
            Centerplan.options.usedPositions.forEach(function (item, index) {
                $("#" + item).attr('data-enabled', 0);
				$("#" + item).attr('data-blocked', 1);
            })
        }

		if(Centerplan.options.currentValue !== undefined) {
			$("path[id='" + Centerplan.options.currentValue + "']").attr('data-selected', "selected");
			$("path[id='" + Centerplan.options.currentValue + "']").css("fill", "#009900");

            $("*[data-blocked='1']").each(function(e){
                if($(this).attr('id') !== Centerplan.options.currentValue) {
                    $(this).css("fill", "#b27300");
                }
            });
		}

		// Set color value
        $("*[data-enabled='1']").hover(function(){
            if($(this).attr('data-selected') !== "selected"
                && $(this).attr('data-blocked') != "1" ) {
                this.style.fill = "#009900";
            }
        });
        $("*[data-enabled='1']").mouseleave(function(){
        	if($(this).attr('data-selected') !== "selected"
				&& $(this).attr('data-blocked') != "1" ) {
                this.style.fill = "";
			}
        });

        // Handle the transfer of the color value and closing of popup
       $("*[data-enabled='1']").on('click', function(e) {
            e.preventDefault();
            if(Centerplan.options.itemName !== undefined) {
                var theField = parent.opener.$("input[data-formengine-input-name='" + Centerplan.options.itemName + "']").get(0);
                if (theField) {
                    var $svg = $('svg'),
                        x = parseFloat((e.pageX - $svg.offset().left) / $svg.width()).toFixed(4),
                        y = parseFloat((e.pageY - $svg.offset().top) / $svg.height()).toFixed(4);


                	var position = x + ':' + y;

                	var newValue = $(this).attr('id') + '-' + position;

                    theField.value = newValue;

                    if (typeof Centerplan.options.fieldChangeFunctions === 'function') {
                        Centerplan.options.fieldChangeFunctions();
                    }
                }
            }
            parent.close();
            return false;
        });
	};

	$(Centerplan.initializeEvents);

	return Centerplan;
});
