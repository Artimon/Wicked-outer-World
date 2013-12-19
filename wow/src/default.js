/*jslint evil: true, sloppy: true, plusplus: true, newcap: true, browser: true */
/*global jQuery: true, angular: true, translations: true, $: true, alert: true, escape: true, ActiveXObject: true */


Math.sign = function (value) {
	if (value === 0) {
		return 0;
	}

	if (value > 0) {
		return 1;
	}

	return -1;
};


function ConfirmBox(initCallback, confirmCallback) {
	this.show = function (title, html) {
		var self = this,
			$html;

		$html = $(
			"<div id='infoLayer' class='null'>" +
				"<div class='shade'></div>" +
				"<div class='container small box'>" +
					"<h3 class='header'>" +
						title +
						"<a href='javascript:;' class='close'>X</a>" +
					"</h3>" +
					"<div class='content'>" +
						html +
						"<div class='clear'></div>" +
					"</div>" +
				"</div>" +
			"</div>"
		);

		if (typeof confirmCallback === 'function') {
			$html
				.find('.content')
				.append(
					"<div class='buttons'>" +
						"<a href='javascript:;' class='button confirm'>Ok</a>" +
					"</div>" +
					"<div class='clear'></div>"
				);
		}

		this.remove();

		$('body').append($html);
		$html.fadeIn(
			'fast',
			function () {
				$html.find('.shade').click(function () {
					self.remove();
				});
				$html.find('a.confirm').click(function () {
					confirmCallback();
					self.remove();
				});
				$html.find('a.close').click(function (event) {
					self.remove();
					event.preventDefault();
				});

				$(document).keyup(function (event) {
					if (event.which === 27) {
						self.remove();
					}
				});
			}
		);

		if (typeof initCallback === 'function') {
			initCallback();
		}
	};

	this.remove = function () {
		var $infoLayer = $('#infoLayer');
		$infoLayer.fadeOut(
			'fast',
			function () {
				$(document).unbind('keyup');
				$infoLayer.find('.shade').unbind();
				$infoLayer.find('a').unbind();
				$infoLayer.remove();
			}
		);
	};

	this.content = function (html) {
		$('#infoLayer')
			.find('.container')
			.find('.content')
			.html(html);
	};
}

(function ($) {
	$.progressBar = function (duration, callback) {
		$('.progressBar').find('span').animate(
			{width: '100%'},
			duration,
			'linear',
			callback
		);
	};

	/**
	 * @param {{maskedId: {string}, unmaskedId: {string}}} options
	 */
	$.fn.password = function (options) {
		var $checkbox = $(this),
			$masked,
			$unmasked,
			defaults = {
				maskedId: 'password',
				unmaskedId: 'passwordUnmasked'
			};

		options = $.extend({}, defaults, options);
		$masked = $('#' + options.maskedId);
		$unmasked = $('#' + options.unmaskedId);

		$checkbox.change(function () {console.log('jop');
			$masked.attr('name', null);
			$unmasked.attr('name', null);

			if ($checkbox.is(':checked')) {
				$unmasked.attr('value', $masked.attr('value'));
				$unmasked.attr('name', options.maskedId);
			}
			else {
				$masked.attr('value', $unmasked.attr('value'));
				$masked.attr('name', options.maskedId);
			}

			$masked.toggle();
			$unmasked.toggle();
		});

		return $checkbox;
	};
}(jQuery));


var wowApp = angular.module('wowApp', []);

(function ($, angular, wowApp, translations) {
	wowApp.filter('i18n', function () {
		return function (translationKey) {
			var result = translationKey,
				args;

			if (translations[translationKey]) {
				result = translations[translationKey];
			}

			if (arguments.length > 1) {
				args = Array.prototype.slice.call(arguments, 1);

				result = result.replace(/%(\d+)/g, function(unused, index) {
					return args[--index];
				});
			}

			return result;
		};
	});

	wowApp.filter('round', function () {
		return function (value) {
			return Math.round(value);
		};
	});

	wowApp.directive('ngStatusBar', function() {
		return {
			restrict: 'E',
			template:
				'<div class="statusBar" title="{{current|round}} / {{max|round}}">' +
					'<div class="display" ng-style="{ width: progress }"></div>' +
				'</div>',
			scope: {
				current: '=',
				max: '='
			},
			link: function($scope) {
				$scope.progress = 0;

				if ($scope.current > 0) {
					$scope.progress = 99 * ($scope.current / $scope.max);
					$scope.progress = Math.round($scope.progress);
				}
			}
		};
	});


	/**
	 * Layer Controller
	 */
	wowApp.controller('LayerCtrl', ['$scope', '$rootScope', function ($scope, $rootScope) {
		$scope.visible = false;
		$scope.title = '';
		$scope.type = '';
		$scope.data = [];

		$rootScope.on('show', function (data) {
			$scope.visible = true;
			$scope.type = data.type;
		});

		$scope.show = function (type) {
			$scope.visible = true;
		};

		$scope.hide = function () {
			$scope.visible = false;
		};
	}]);

	/**
	 * Profile Controller
	 */
	wowApp.controller('ProfileCtrl', ['$scope', function ($scope) {
		$scope.stats = [];

		/**
		 * @param {[]} stats
		 */
		$scope.setup = function (stats) {
			$scope.stats = stats;
		};
	}]);

	wowApp.controller('AcademyTrainingCtrl', ['$scope', '$filter', function ($scope, $filter) {
		$scope.started = false;
		$scope.disciplines = [];

		/**
		 * @param {object[]} disciplines
		 */
		$scope.setup = function (disciplines) {
			$scope.disciplines = disciplines;
		};

		/**
		 * @param {object} discipline
		 */
		$scope.info = function (discipline) {
			var infoBox = new ConfirmBox(),
				title = $filter('i18n')('info'),
				headline = $filter('i18n')(discipline.name),
				text = $filter('i18n')(discipline.name + 'Help');

			infoBox.show(
				title,
				'<h2 class="ceil">' + headline + '</h2>' + text
			);
		};

		/**
		 * @param {object} discipline
		 */
		$scope.start = function (discipline) {
			if (!discipline.canStart || $scope.started) {
				return;
			}

			$scope.started = true;

			$('.trainingOverview').fadeOut('default', function () {
				$('.progressBar').fadeIn('default', function () {
					$.progressBar(3000, function () {
						window.location.href = discipline.url;
					});
				});
			});
		};
	}]);

	/**
	 * Jump Gate Controller
	 */
	wowApp.controller('JumpGateCtrl', ['$scope', '$filter', '$http', function ($scope, $filter, $http) {
		$scope.travelPrice = 0;
		$scope.currentSector = {};
		$scope.money = 0;
		$scope.sector = {};
		$scope.sectors = [];

		/**
		 * @param {object[]} sectors
		 * @param {number} sectorId
		 * @param {number} money
		 */
		$scope.setup = function (sectors, sectorId, money) {
			$scope.money = money;
			$scope.sectors = sectors;
			$scope.currentSector = sectors[sectorId];
			$scope.showInfo($scope.currentSector);
		};

		/**
		 * @param {object} sector
		 */
		$scope.showInfo = function (sector) {
			var result = 0,
				x = sector.x - $scope.currentSector.x,
				y = sector.y - $scope.currentSector.y;

			if (sector.key !== $scope.currentSector.key) {
				result = Math.sqrt((x * x) + (y * y));
				result = 0.015 * (result * result) + 1.75 * result + 4;
				result = Math.round(result);
			}

			$scope.sector = sector;
			$scope.travelPrice = result;
		};

		/**
		 * @param {string} key
		 * @returns {boolean}
		 */
		$scope.isSelected = function (key) {
			return ($scope.sector.key === key);
		};

		/**
		 * @param {object[]} sectors
		 */
		$scope.updateSector = function (sectors) {
			$.each(sectors, function (key, sector) {
				if (sector.key === $scope.sector.key) {
					$scope.sector = sector;
					return false;
				}
				return true;
			});
		};

		/**
		 * @param {object} sector
		 */
		$scope.unlockSector = function (sector) {
			if (sector.isAvailable || !sector.canAfford || !sector.hasLevelRequirement) {
				return;
			}

			$http.post('?page=unlockSector', { sectorId: sector.key })
				.success(function (json) {
					$scope.sectors = json.sectors;
					$scope.updateSector(json.sectors);

					$('.premiumCoins').text(json.premiumCoins);
				});
		};

		/**
		 * @param {object} sector
		 */
		$scope.travelTo = function (sector) {
			if ($scope.travelPrice > $scope.money) {
				return;
			}

			$http.post('?page=travelTo', { sectorId: sector.key })
				.success(function () {
					var animationBox = new ConfirmBox();
					animationBox.show(
						$filter('i18n')('movingToNewSector'),
						"<canvas id='jumpGateTravel' width='380' height='80'></canvas>"
					);

					$('#infoLayer').find('.container').removeClass('small');
					$('#jumpGateTravel').engine2d(function (engine2d) {
						var stop = false;

						engine2d.appendFunction('moveFighter', function (entity) {
							if (stop) {
								return;
							}

							entity.position.add(vector(5, 0));
							if (entity.position.x > 420) {
								stop = true;
								window.location.href = '?page=jumpGate';
							}
						});

						engine2d.appendFunction('fighterBooster', function (entity) {
							entity.layer = entity.parentEntity.layer + 1;
							entity.position.x = -entity.parentEntity.size.x / 2;
							entity.position.y = 0;
							entity.position
								.rotate(entity.parentEntity.angle)
								.add(entity.parentEntity.position);

							entity.scale.normalize(
								1.2 + 0.2 * Math.sin(entity.animationOffset + engine2d.totalTime / 10)
							);
						});

						engine2d.appendFunction('createFighter', function () {
							var fighter, flare;

							fighter = engine2d.entityCreate(
								'./wow/img/default_fighter.png',
								engine2d.functions.moveFighter,
								vector(-20, 40)
							);

							fighter.angle = 0;
							flare = engine2d.entityCreate(
								'./wow/img/white_flare.png',
								engine2d.functions.fighterBooster,
								vector()
							);

							flare.parentEntity = fighter;
							flare.animationOffset = Math.random() * 360;

							return fighter;
						});

						engine2d.appendFunction('moveBackground', function (entity) {
							entity.position.add(vector(-0.25, 0));
						});

						engine2d.appendFunction('createBackground', function () {
							engine2d.entityCreate(
								'./wow/img/space_earth.jpg',
								engine2d.functions.moveBackground,
								vector(240, 40)
							);
						});

						engine2d.functions.createBackground();
						engine2d.functions.createFighter();
					});
				});
		};
	}]);

	/**
	 * Starship Selector Controller
	 */
	wowApp.controller('StarshipSelectorCtrl', ['$scope', '$filter', function ($scope, $filter) {
		$scope.starships = [];

		/**
		 * @param {[]} starships
		 */
		$scope.setup = function (starships) {
			$scope.starships = starships;
		};

		/**
		 * @param {object} starship
		 * @returns {string}
		 */
		$scope.starshipName = function (starship) {
			return (starship.name || 'empty');
		};

		/**
		 * @param starship
		 * @returns {string}
		 */
		$scope.actionText = function (starship) {
			return starship.current ? 'selected' : 'select';
		};

		/**
		 * @param $event
		 * @param {object} starship
		 */
		$scope.scrap = function ($event, starship) {
			var message = $filter('i18n')('confirmScrapStarship');

			if (!starship.name || starship.current || !window.confirm(message)) {
				$event.preventDefault();
			}
		};
	}]);
}(jQuery, angular, wowApp, translations));

(function ($) {
	$.fn.moreGames = function () {
		var $select = this.find('.selectGames'),
			$box = this.find('.gamesBoard');

		$box.click(function (event) {
			event.stopPropagation();
		});

		$select.click(function (event) {
			if ($box.is(':visible')) {
				$box.fadeOut();
			}
			else {
				$box.fadeIn();
			}

			event.stopPropagation();
		});

		$('body').click(function () {
			if ($box.is(':visible')) {
				$box.fadeOut();
			}
		});
	};
}(jQuery));

(function ($) {
	$.fn.messageOverview = function () {
		this.find('.showHideMessage').click(function () {
			var $this = $(this);

			if (!$this.data('seen')) {
				$this.data('seen', 1);
				$this.closest('tr').removeClass('bold');

				$.get($this.data('url'));
			}

			$this
				.toggleClass('entypo-down-open')
				.toggleClass('entypo-up-open');

			$this.parent().parent().next().toggle();
		});
	};

	$.fn.deleteMessage = function (message) {
		this.click(function () {
			return window.confirm(message);
		});
	};
}(jQuery));


/**
 * Wrapped function closure to event box.
 */
(function ($) {
	$.fn.eventBox = function () {
		var $this = this,
			duration = 1000,
			handle;

		if ($this.text().length > 50) {
			duration = 2000;
		}

		function setTimeout() {
			handle = window.setTimeout(
				function () {
					$this.fadeOut(2000);
				},
				duration
			);
		}

		$this.mouseenter(function () {
			if ($this.is(':animated')) {
				$this.stop(true).css('opacity', 1);
			}

			window.clearTimeout(handle);
		});

		$this.mouseleave(setTimeout);

		setTimeout();
	};
}(jQuery));


/**
 * Wrapped function closure for designer.
 */
(function ($) {
	$.fn.moveItem = function (title) {
		$(this).click(function (event) {
			var $this = $(this),
				$parent = $this.parent(),
				$amount = $parent.find('input.amount'),
				amountPossible = $parent.find('input.possible').val(),
				amountSelect,
				initCallback,
				confirmCallback,
				html;

			if ($this.hasClass('disabled')) {
				event.preventDefault();

				return;
			}

			if (amountPossible > 1) {
				initCallback = function () {
					$('#amountSlider').slider({
						range: 'min',
						value: 1,
						min: 1,
						max: amountPossible,
						slide: function (event, ui) {
							$('#amountInput').val(ui.value);
						}
					});
				};

				confirmCallback = function () {
					$amount.val(
						$('#amountInput').val()
					);
					$parent.submit();
				};

				html =
					"<div id='amountSlider'></div>" +
					"<div id='labelSlider'>" +
						"<input type='text' id='amountInput' value='1' class='small'>" +
					"</div>";

				amountSelect = new ConfirmBox(initCallback, confirmCallback);
				amountSelect.show(title, html);

				event.preventDefault();
			}
			else {
				$parent.submit();
			}
		});
	};
}(jQuery));

/**
 * Wrapped function closure for tech info.
 */
(function ($) {
	$.openTechInfo = function (techId) {
		var url = "?page=techInfo&techId=" + techId,
			techInfo = new ConfirmBox(),
			$layer;

		techInfo.show('', '');
		$layer = $('#infoLayer');
		$layer.find('.container').removeClass('small');

		$.ajax({
			url: url,
			success: function (html) {
				var $html = $(html),
					$title = $html.filter('h2'),
					$header = $layer.find('.header'),
					$content = $layer.find('.content');

				$header.append(
					$title.text()
				);

				$title.remove();

				$content.html($html);
			}
		});
	};

	$.fn.techInfo = function () {
		$(this).click(function () {
			var techId = $(this).attr('data-techId');

			$.openTechInfo(techId);
		});

		this.content = function (html) {
			var $infoLayer = $('#infoLayer'),
				$html = $(html),
				$headline = $html.find('h2');

			$infoLayer
				.find('.headerTitle')
				.text($html.html());

			$headline.remove();

			$infoLayer
				.find('.container')
				.find('.content')
				.html($html);
		};
	};
}(jQuery));

/**
 * Wrapped function closure for fiddling.
 */
(function ($) {
	function startIncrement($form, amount) {
		$.progressBar(
			2000 + (500 * amount),
			function () {
				$form.submit();
			}
		);
	}

	$.fn.fiddle = function () {
		var $this = this,
			$fiddlingContainer = $('.fiddlingContainer'),
			$ingredientAmounts = $('.ingredientAmount'),
			amount;

		function updateAmount() {
			var value;

			amount = 0;

			$.each($ingredientAmounts, function (id, input) {
				value = $(input).val();
				if (!isNaN(value)) {
					amount += parseInt($(input).val(), 10);
				}
			});

			if (amount > 0) {
				$this.removeClass('disabled');
			}
			else {
				$this.addClass('disabled');
			}
		}

		$ingredientAmounts.keypress(function (event) {
			if (event.which === 13) {
				$this.triggerClick();
				event.preventDefault();
			}
		});

		$this.click(function (event) {
			event.preventDefault();
			$this.addClass('disabled');

			updateAmount();



			$this.parent().fadeOut(
				'default',
				function () {
					$fiddlingContainer.fadeIn(
						'default',
						function () {
							startIncrement(
								$this.parent(),
								amount
							);
						}
					);
				}
			);
		});

		$('.ingredient').find('a').click(function () {
			var $jumper		= $(this),
				$input		= $jumper.parent().find('input'),
				value		= parseInt($input.val(), 10),
				difference	= 1;

			if (isNaN(value)) {
				value = 0;
			}

			if ($jumper.hasClass('left')) {
				difference = -1;
			}

			value = Math.max(0, value + difference);

			if (value === 0) {
				value = '-';
			}

			$input.val(value);

			updateAmount();
		});
	};

	$.fn.craft = function () {
		var $this = this;

		$this.click(function (event) {
			var $button = $(this);

			event.preventDefault();

			if ($button.hasClass('disabled')) {
				return;
			}

			$('#recipeList').fadeOut(
				'default',
				function () {
					$('.craftingContainer').fadeIn(
						'default',
						function () {
							startIncrement(
								$button.parent(),
								$button.data('n')
							);
						}
					);
				}
			);
		});
	};
}(jQuery));

/**
 * Animates mission results.
 */
(function ($) {
	$.fn.missionBox = function (json) {
		var $this = $(this),
			delay = -500;

		json = jQuery.parseJSON(json);

		function show(message) {
			$this.append("<div class='h2 variable null'>" + message + "</div>");
			$this.find('div').last().slideToggle();
		}

		function increment() {
			delay += 1500 + Math.random() * 1000;

			return delay;
		}

		$.each(json, function (key, message) {
			window.setTimeout(
				function () {
					show(message);
				},
				increment()
			);
		});
	}
}(jQuery));



function init(engine2d, duration) {
	var background, entityHandles = {};

	engine2d.appendFunction('hoverName', function (entity) {
		engine2d.addText(
			entity.name,
			'Arial',
			'10px',
			'white',
			'center',
			entity.position.x - engine2d.camera.position.x,
			entity.position.y - engine2d.camera.position.y + .5 * entity.size.y + 10
		);
	});

	engine2d.appendFunction('clickObject', function (entity) {
		if (engine2d.player !== entity) {
			engine2d.player.targetEntity = entity;
		}
	});

	engine2d.appendFunction('deleteActor', function (entity) {
		engine2d.functions.resetTarget(entity, true);

		delete entityHandles[entity.handleObject];
		engine2d.entityDelete(entity);
	});

	engine2d.appendFunction('resetTarget', function (entity, removeHandler) {
		if (entity !== engine2d.player.targetEntity) {
			return;
		}

		engine2d.player.targetEntity = null;

		if (removeHandler) {
			entity.setClickHandler(undefined);
			entity.setHoverHandler(undefined);
		}
	});

	/*
	 * Fighter
	 */
	engine2d.appendFunction('fighterBooster', function (entity) {
		entity.layer = entity.parentEntity.layer + 1;
		entity.position.x = -entity.parentEntity.size.x / 2;
		entity.position.y = 0;
		entity.position
			.rotate(entity.parentEntity.angle)
			.add(entity.parentEntity.position);

		entity.scale.normalize(
			1.2 + 0.2 * Math.sin(entity.animationOffset + engine2d.totalTime / 10)
		);
	});

	engine2d.appendFunction('hullBar', function (entity) {
		entity.position.x = entity.parentEntity.position.x;
		entity.position.y = entity.parentEntity.position.y + .5 * entity.size.y + 45;
	});

	engine2d.appendFunction('shieldBar', function (entity) {
		entity.position.x = entity.parentEntity.position.x;
		entity.position.y = entity.parentEntity.position.y + .5 * entity.size.y + 49;
		entity.size.x = 45;
	});

	engine2d.appendFunction('moveFighter', function (entity) {
		var temp = vector(),
			factor,
			distance = temp.diff(entity.moveTo, entity.position).length(),
			$space;

		if (distance > 1) {
			distance = Math.min(2 * engine2d.time, distance);
			entity.move(temp.normalize(distance), vector());

			temp.rotate(-entity.angle).normalize(1);
			if (temp.x < 0.999) {
				factor = 20 * Math.sign(temp.y);
				factor *= temp.x < 0
					? 1
					: Math.abs(temp.y);

				entity.angle += factor;
			}
		}

		if (engine2d.player === entity) {
			engine2d.camera.position.set(
				entity.position
			).sub(vector(200, 200));

			temp = engine2d.totalTime / 1000;
			temp = duration - temp;
			temp = Math.round(100 * temp);
			temp /= 100;

			if (temp < -1) {
				$space = $('#space');

				$space.fadeOut(
					'slow',
					function () {
						$space.next().fadeIn();
					}
				);
			}

			engine2d.addText(
				Math.max(0, temp),
				'Arial',
				'48px',
				'red',
				'left',
				50,
				50
			);
		}

		engine2d.functions.hoverName(entity);
	});

	engine2d.appendFunction('createFighter', function (position, target) {
		var fighter, flare, hullBar, shieldBar, targetRing;

		fighter = engine2d.entityCreate(
			'./wow/img/default_fighter.png',
			engine2d.functions.moveFighter,
			position
		);

		fighter.moveTo = vector().set(target);
		fighter.type = 'fighter';
		fighter.setClickHandler(engine2d.functions.clickObject);
		fighter.removeOffScreen = true;
		fighter.angle = Math.random() * 360;
		fighter.targetEntity = null;


		flare = engine2d.entityCreate(
			'./wow/img/white_flare.png',
			engine2d.functions.fighterBooster,
			vector()
		);

		flare.parentEntity = fighter;
		flare.animationOffset = Math.random() * 360;


/*		hullBar = engine2d.entityCreate(
			'./wow/img/bars.png',
			engine2d.functions.hullBar,
			vector(),
			vector(60, 4)
		);

		hullBar.parentEntity = fighter;


		shieldBar = engine2d.entityCreate(
			'./wow/img/bars.png',
			engine2d.functions.shieldBar,
			vector(),
			vector(60, 4)
		);

		shieldBar.parentEntity = fighter;
		shieldBar.pane = vector(0, 4);*/

		return fighter;
	});

	/*
	 * Items
	 */
	engine2d.appendFunction('animateItem', function (entity) {
		if (entity.command !== 'fade') {
			return;
		}

		if (engine2d.player.targetEntity === entity) {
			engine2d.functions.resetTarget(entity, true);
			var snd = new Audio('./snd/plug.wav');
			snd.play();
		}

		entity.scale.scale(1 - 0.01 * engine2d.time);
		entity.alpha -= 2 * engine2d.time;

		if (entity.alpha <= 0) {
			engine2d.functions.deleteActor(entity);
		}
	});

	engine2d.appendFunction('createItem', function (position) {
		var item;

		item = engine2d.entityCreate(
			'./wow/img/item.png',
			engine2d.functions.animateItem,
			position
		);

		item.layer = 2;
		item.removeOffScreen = true;
		item.setClickHandler(engine2d.functions.clickObject);
		item.setHoverHandler(engine2d.functions.hoverName);

		return item;
	});

	/*
	 * Asteroids
	 */
	engine2d.appendFunction('createAsteroid', function (position) {
		var asteroid;

		asteroid = engine2d.entityCreate(
			'./wow/img/asteroid.png',
			undefined,
			position
		);

		asteroid.angle = Math.random() * 360;
		asteroid.removeOffScreen = true;

		return asteroid;
	});

	/*
	 * Target rings
	 *
	 * The inner ring is the master ring. Set it's targetEntity attribute
	 * to the player's target, to set the ring to the target.
	 *
	 * The outer ring has a reference to the inner ring and will follow
	 * it's actions.
	 */
	engine2d.appendFunction('animateInnerRing', function (entity) {
		if (
			!entity.attachTo.targetEntity ||
			!entity.attachTo.targetEntity.isAlive() ||
			!entity.attachTo.targetEntity.visible
		) {
			entity.visible = false;
			return;
		}

		entity.position.set(entity.attachTo.targetEntity.position);
		entity.visible = true;
		entity.angle -= engine2d.time;
	});

	engine2d.appendFunction('animateOuterRing', function (entity) {
		entity.visible = entity.attachTo.visible;

		if (entity.visible) {
			entity.position.set(entity.attachTo.position);
			entity.angle += .75 * engine2d.time;
		}
	});

	engine2d.appendFunction('createTargetRing', function (player) {
		var innerRing, outerRing;

		innerRing = engine2d.entityCreate(
			'./wow/img/inner_ring.png',
			engine2d.functions.animateInnerRing,
			vector()
		);
		innerRing.attachTo = player;
		innerRing.layer = 1;

		outerRing = engine2d.entityCreate(
			'./wow/img/outer_ring.png',
			engine2d.functions.animateOuterRing,
			vector()
		);
		outerRing.attachTo = innerRing;
		outerRing.layer = 1;

		return innerRing;
	});

	/*
	 * Background
	 */
	engine2d.appendFunction('moveBackground', function (entity) {
		entity.position.set(
			engine2d.camera.position
		).add(vector(200, 200));
		entity.pane.set(
			entity.position
		).scale(0.5);
	});

	engine2d.appendFunction('createBackground', function (size) {
		engine2d.entityCreate(
			'./wow/img/space_earth.jpg',
			engine2d.functions.moveBackground,
			vector(),
			size
		);
	});

	/*
	 * Stardust
	 */
	engine2d.appendFunction('moveStardust', function (entity) {
		entity.idleOffset += entity.idleSpeed;
		entity.pane.set(engine2d.camera.position).inverse().scale(2);
		entity.pane.x += entity.idleOffset;
	});

	engine2d.appendFunction('createStardust', function (image, speed) {
		var stardust;

		stardust = engine2d.entityCreate(
			'./wow/img/' + image,
			engine2d.functions.moveStardust,
			vector()
		);

		stardust.idleSpeed = speed;
		stardust.idleOffset = 0;

		return stardust;
	});

	/*
	 * Create actors
	 */
	engine2d.appendFunction('createActor', function (entityData) {
		var entity,
			position = vector(entityData.positionX, entityData.positionY),
			target = vector(entityData.targetX, entityData.targetY);

		switch (entityData.type) {
			case 1:
				entity = engine2d.functions.createFighter(
					position,
					target
				);
				entity.layer = 10;

				if (entityData.isPlayer) {
					engine2d.player = entity;
					entity.layer = 12;

					engine2d.functions.createTargetRing(entity);
				}
				break;

			case 2:
				entity = engine2d.functions.createItem(
					position,
					position
				);
				break;

			default:
				console.warn('unknown actor type');
				break;
		}

		entity.handleObject = entityData.handleObject;	// Primary key
		entity.command = undefined;	// Action response
		entity.name = entityData.name;	// Well... it's name

		return entity;
	});



	engine2d.functions.createBackground(vector(400, 400));

	engine2d.functions.createStardust('stardust_slow.png', 0.5).repeat = true;
	engine2d.functions.createStardust('stardust_fast.png', 0.33).repeat = true;

//	engine2d.functions.createFighter(Vector(450, 250)).angle = 235;
//	engine2d.functions.createFighter(Vector(350, 450)).angle = 180;
//	engine2d.player = engine2d.functions.createFighter(Vector(400, 400));

//	engine2d.functions.createAsteroid(Vector(450, 0));
//	engine2d.functions.createAsteroid(Vector(350, 0));

	engine2d.click(function (absolute, relative, entity) {
		if (!entity || !entity.type || entity.type !== 'fighter') {
			engine2d.player.moveTo.set(relative);
		}

//		console.log(absolute.x + ' / ' + absolute.y);
//		console.log(Math.round(relative.x) + ' / ' + Math.round(relative.y));
	});

	window.setInterval(function () {
		var difference = vector();
		$.each(engine2d.entities(), function (entityId, entity) {
			if (entity === engine2d.player) {
				return;
			}

			if (entity.removeOffScreen) {
				difference.diff(entity.position, engine2d.player.position);

				if (
					(Math.abs(difference.x) > engine2d.size.x * 0.75) ||
					(Math.abs(difference.y) > engine2d.size.y * 0.75)
				) {
					engine2d.functions.deleteActor(entity);
				}
			}
		});

		$('#fps').text('frames: ' + engine2d.fps);
	}, 2000);

	function requestEntities () {
		var entity, url = 'index.php?page=entities';
		if (engine2d.player) {
			url += '&myX=' + Math.round(engine2d.player.position.x);
			url += '&myY=' + Math.round(engine2d.player.position.y);
			url += '&toX=' + Math.round(engine2d.player.moveTo.x);
			url += '&toY=' + Math.round(engine2d.player.moveTo.y);
			if (engine2d.player.targetEntity) {
				url += '&target=' + engine2d.player.targetEntity.handleObject;
			}
		}

		$.getJSON(url, function (data) {
			$.each(data, function (key, entityData) {
				if (entityHandles[entityData.handleObject]) {
					entity = engine2d.entity(entityHandles[entityData.handleObject]);

					if (entity.moveTo && !entityData.isPlayer) {
						entity.moveTo.x = entityData.targetX;
						entity.moveTo.y = entityData.targetY;
					}
				} else {
					entity = engine2d.functions.createActor(entityData);
					entityHandles[entity.handleObject] = entity.id;
				}

				if (entityData.command) {
					entity.command = entityData.command;
//					console.log(entityData.command);
				}
			});
		});
	}

	requestEntities();
	window.setInterval(function () {
		requestEntities();
	}, 1000);
}

/**
 * Common stuff.
 */
(function ($) {
	$('.accordion').click(function () {
		$(this).next().slideToggle();
	});

	$('.button').click(function (event) {
		if ($(this).hasClass('disabled')) {
			event.preventDefault();
		}
	});
}(jQuery));

(function ($) {
	$.fn.mail = function () {
		this.click(function () {
			$(this).attr(
				'href',
				'ma' + 'ilto:' + 'in' + 'fo@wi' + 'cked-outer' + '-world' + '.com'
			);
		});
	};
}(jQuery));

/*
var lastGameCycleTime = 0;
var gameCycleDelay = 1000 / 30; // aim for 30 fps for game logic

function gameCycle() {
	var now = new Date().getTime();
	// time since last game logic
	var timeDelta = now - lastGameCycleTime;
	move(timeDelta);

	var cycleDelay = gameCycleDelay;
	// the timer will likely not run that fast due to the rendering cycle hogging the cpu
	// so figure out how much time was lost since last cycle
	if (timeDelta > cycleDelay) {
		cycleDelay = Math.max(1, cycleDelay - (timeDelta - cycleDelay))
	}

	lastGameCycleTime = now;
	setTimeout(gameCycle, cycleDelay);
}
*/

(function ($) {
	$.fn.barScale = function (name, percentage, set) {
		var width = Math.round(99 * (percentage / 100)) + 'px',
			$bar = this.find('.statusBar').find('.' + name);

		$bar.stop();

		if (set) {
			$bar.css('width', width);
		}
		else {
			$bar.animate({width: width});
		}
	};

	$.fn.setMoney = function (value) {
		var parts = this.text().split(' ');

		this.text(value + ' ' + parts[1]);
	};
}(jQuery));

(function ($) {
	$.fn.animateFight = function (
		jsonActions,
		jsonTranslations,
		initialCondition,
		initialMoney
	) {
		var $self = this,
			actions = JSON.parse(jsonActions),
			translations = JSON.parse(jsonTranslations),
			$sides = {},
			$status,
			$money,
			message,
			object,
			key = 0;

		if (initialCondition) {
			$status = $('#status');
			$status.barScale('condition', initialCondition, true);
		}

		if (initialMoney) {
			$money = $('.money');
			$money.setMoney(initialMoney);
		}

		/**
		 * @param side string
		 * @return {*}
		 */
		function fighterContainer(side) {
			if (!$sides[side]) {
				$sides[side] = $self.find('.' + side);
			}

			return $sides[side];
		}

		function animate(object, value, color) {
			var $container,
				$event;

			$container = fighterContainer(object.s).find('.actionContainer');

			$event = $("<div class='event'>" + value + "</div>");
			$container.append($event);

			$event.css({
				left: (100 + Math.random() * 50) + 'px',
				top: (Math.random() * 30 - 50) + 'px',
				color: color,
				textShadow: '0 0 4px ' + color
			});

			$event.animate(
				{top: '-=50px', left: '+=15px'},
				1000,
				function () {
					$event.fadeOut(
						'fast',
						function () {
							$event.remove();
						}
					);
				}
			);
		}

		function cycle() {
			object = actions[key];
			message = translations[object.m];

			switch (object.a) {
				case 'r':
					animate(
						object,
						message + ' +' + object.v,
						'#BBF24E'
					);
					break;

				case 'su':
					animate(object, message, '#CE79DD');
					break;

				case 'sp':
					animate(
						object,
						message + ' +' + object.v,
						'#CE79DD'
					);
					break;

				case 'sd':
					animate(object, message, '#CE79DD');
					break;

				case 'd':

					animate(
						object,
						message + ' -' + object.v,
						'#B7502B'
					);
					break;

				case 'm':
					animate(
						object,
						message + ' ' + translations.missed,
						'#A5E396'
					);
					break;
			}

			fighterContainer('aggressor').barScale('condition', object.ag.c);
			fighterContainer('aggressor').barScale('shield', object.ag.s);
			fighterContainer('aggressor').barScale('energy', object.ag.e);

			fighterContainer('victim').barScale('condition', object.vi.c);
			fighterContainer('victim').barScale('shield', object.vi.s);
			fighterContainer('victim').barScale('energy', object.vi.e);

			if (initialCondition) {
				$status = $('#status');
				$status.barScale('condition', object.ag.c);
			}

			key++;

			if (key < actions.length) {
				window.setTimeout(cycle, object.d);
			}
			else {
				$self.find('.fightResult').fadeIn();
			}
		}

		cycle();
	};
}(jQuery));